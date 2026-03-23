<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\State;
use App\Models\City;
use App\Models\Country;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FixUserGeoData extends Command
{
    protected $signature = 'fix:user-geo-data';
    protected $description = 'Migra los IDs viejos de birth_state/birth_city a los nuevos IDs oficiales y normaliza state/city.';

    public function handle()
    {
        $this->info('🚀 Iniciando proceso de migración y normalización de usuarios...');

        $mapFile = 'legacy_geo_map.json';
        if (!Storage::exists($mapFile)) {
            $this->error('❌ No se encontró el archivo de mapeo legacy_geo_map.json.');
            return;
        }

        $legacyMap = json_decode(Storage::get($mapFile), true);
        $oldStates = $legacyMap['states'] ?? [];
        $oldCities = $legacyMap['cities'] ?? [];

        $this->info('✅ Mapa de legado cargado.');

        // Construir catálogo de búsqueda tolerante a acentos
        // Map: 'NOMBRE_CON_ACENTO' => ID (Prioridad 1)
        // Map: 'NOMBRE_SIN_ACENTO' => ID (Prioridad 2)
        
        $newStatesMap = [];
        foreach (State::all() as $state) {
            $upper = mb_strtoupper($state->name, 'UTF-8');
            $newStatesMap[$upper] = $state->id;
            $newStatesMap[$this->sanitize($upper)] = $state->id;
        }

        $newCitiesMap = [];
        // Para ciudades, agrupamos por estado si es posible, o globalmente
        // Mapa global: 'NOMBRE_CIUDAD' => [StateId => CityId]
        // Esto permite desambiguar si hay 'ACAMBARO' en dos estados diferentes
        foreach (City::all() as $city) {
            $upper = mb_strtoupper($city->name, 'UTF-8');
            $sanitized = $this->sanitize($upper);
            
            // Guardamos ID por Estado para búsqueda contextual
            if (!isset($newCitiesMap[$upper])) $newCitiesMap[$upper] = [];
            $newCitiesMap[$upper][$city->state_id] = $city->id;

            if (!isset($newCitiesMap[$sanitized])) $newCitiesMap[$sanitized] = [];
            $newCitiesMap[$sanitized][$city->state_id] = $city->id;
        }

        $mexico = Country::where('name', 'Mexico')->orWhere('name', 'MÉXICO')->first();
        $mexicoId = $mexico ? $mexico->id : 142;

        $this->info('✅ Nuevo catálogo indexado (tolerancia a acentos activada).');

        $users = User::all();
        $bar = $this->output->createProgressBar($users->count());
        $updatedCount = 0;
        $errors = [];

        foreach ($users as $user) {
            $needsUpdate = false;
            
            // --- A. Normalizar Dirección Actual ---
            if ($user->state) {
                $upperState = mb_strtoupper($user->state, 'UTF-8');
                if ($user->state !== $upperState) {
                    $user->state = $upperState;
                    $needsUpdate = true;
                }
            }
            if ($user->city) {
                $upperCity = mb_strtoupper($user->city, 'UTF-8');
                if ($user->city !== $upperCity) {
                    $user->city = $upperCity;
                    $needsUpdate = true;
                }
            }

            // --- B. Migrar IDs de Nacimiento ---

            // 1. Birth State
            if ($user->birth_state && is_numeric($user->birth_state)) {
                $oldStateId = (int)$user->birth_state;
                $stateName = $oldStates[$oldStateId] ?? null;
                
                if ($stateName) {
                    $searchName = mb_strtoupper($stateName, 'UTF-8');
                    // Buscar exacto o sanitizado
                    $newStateId = $newStatesMap[$searchName] ?? $newStatesMap[$this->sanitize($searchName)] ?? null;
                    
                    if ($newStateId && $newStateId != $oldStateId) {
                        $user->birth_state = $newStateId;
                        $needsUpdate = true;
                    } elseif (!$newStateId) {
                        $errors[] = "Usuario {$user->id}: Estado '$stateName' (ID $oldStateId) no encontrado.";
                    }
                }
            }

            // 2. Birth City
            if ($user->birth_city && is_numeric($user->birth_city)) {
                $oldCityId = (int)$user->birth_city;
                $cityName = $oldCities[$oldCityId] ?? null;
                
                if ($cityName) {
                    $searchName = mb_strtoupper($cityName, 'UTF-8');
                    $sanitizedName = $this->sanitize($searchName);

                    // Intentar buscar ID de ciudad
                    $candidates = $newCitiesMap[$searchName] ?? $newCitiesMap[$sanitizedName] ?? [];
                    
                    $newCityId = null;

                    // Si ya tenemos el ID del estado NUEVO (calculado arriba o existente), filtramos por ahí
                    $currentStateId = is_numeric($user->birth_state) ? $user->birth_state : null;
                    
                    if ($currentStateId && isset($candidates[$currentStateId])) {
                        // Coincidencia perfecta: Nombre + Estado
                        $newCityId = $candidates[$currentStateId];
                    } elseif (count($candidates) === 1) {
                        // Solo hay una ciudad con ese nombre en todo el país (suerte)
                        $newCityId = reset($candidates);
                    } elseif (count($candidates) > 1) {
                        $errors[] = "Usuario {$user->id}: Ciudad '$cityName' es ambigua (existe en varios estados).";
                    }

                    if ($newCityId && $newCityId != $oldCityId) {
                        $user->birth_city = $newCityId;
                        $needsUpdate = true;
                    } elseif (!$newCityId && empty($candidates)) {
                        $errors[] = "Usuario {$user->id}: Ciudad '$cityName' (ID $oldCityId) no encontrada.";
                    }
                }
            }
            
            // 3. Birth Country
            if ($user->birth_country == '142' && $mexicoId != 142) {
                $user->birth_country = $mexicoId;
                $needsUpdate = true;
            }

            if ($needsUpdate) {
                $user->saveQuietly();
                $updatedCount++;
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ Proceso completado. Se migraron {$updatedCount} usuarios.");

        if (count($errors) > 0) {
            $this->warn("⚠️ Se encontraron " . count($errors) . " inconsistencias:");
            foreach ($errors as $error) $this->warn($error);
            Storage::put('migration_errors.log', implode("\n", $errors));
        }
    }

    private function sanitize($string)
    {
        $string = str_replace(
            ['Á', 'É', 'Í', 'Ó', 'Ú', 'Ü'],
            ['A', 'E', 'I', 'O', 'U', 'U'],
            $string
        );
        return $string;
    }
}
