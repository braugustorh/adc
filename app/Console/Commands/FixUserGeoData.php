<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FixUserGeoData extends Command
{
    protected $signature = 'fix:user-geo-data';
    protected $description = 'Corrige los IDs de estado y ciudad de los usuarios basándose en mapas estáticos con soporte robusto de acentos.';

    public function handle()
    {
        $this->info('🚀 Iniciando proceso de migración y normalización de usuarios (Modo Acentos)...');

        // 1. Cargar el NUEVO catálogo de ESTADOS (Con y Sin Acentos)
        $newStatesMap = [];
        $states = State::all();
        foreach ($states as $state) {
            $upperName = mb_strtoupper($state->name, 'UTF-8');
            $sanitizedName = $this->sanitize($upperName);
            
            // Guardar ambas versiones para asegurar el match
            $newStatesMap[$upperName] = $state->id;
            $newStatesMap[$sanitizedName] = $state->id;
        }

        // 2. Cargar el NUEVO catálogo de CIUDADES
        $newCitiesMap = [];
        // Optimización: Traer solo lo necesario
        City::select('id', 'state_id', 'name')->chunk(5000, function ($cities) use (&$newCitiesMap) {
            foreach ($cities as $city) {
                $upperName = mb_strtoupper($city->name, 'UTF-8');
                $sanitizedName = $this->sanitize($upperName);

                // Indexar por nombre y estado
                $newCitiesMap[$upperName][$city->state_id] = $city->id;
                if ($sanitizedName !== $upperName) {
                    $newCitiesMap[$sanitizedName][$city->state_id] = $city->id;
                }
            }
        });

        $this->info('✅ Catálogos indexados correctamente.');

        // --- MAPEO DE CORRECCIÓN DE ID LEGACY (USUARIO -> ID VIEJO -> NOMBRE REAL) ---
        // Usamos nombres SIN ACENTOS aquí para facilitar la escritura, el sanitizer hará el match.
        $legacyIdToStateName = [
            1 => 'AGUASCALIENTES',
            2 => 'BAJA CALIFORNIA',
            3 => 'BAJA CALIFORNIA SUR',
            4 => 'CAMPECHE',
            5 => 'COAHUILA DE ZARAGOZA',
            6 => 'COLIMA',
            7 => 'CHIAPAS',
            8 => 'CHIHUAHUA',
            9 => 'CIUDAD DE MEXICO',
            10 => 'DURANGO',
            11 => 'GUANAJUATO',
            12 => 'GUERRERO',
            13 => 'HIDALGO',
            14 => 'JALISCO',
            15 => 'MEXICO', // O Estado de México
            16 => 'MICHOACAN DE OCAMPO',
            17 => 'MORELOS',
            18 => 'NAYARIT',
            19 => 'NUEVO LEON',
            20 => 'OAXACA',
            21 => 'PUEBLA',
            22 => 'QUERETARO',
            23 => 'QUINTANA ROO',
            24 => 'SAN LUIS POTOSI',
            25 => 'SINALOA',
            26 => 'SONORA',
            27 => 'TABASCO',
            28 => 'TAMAULIPAS',
            29 => 'TLAXCALA',
            30 => 'VERACRUZ DE IGNACIO DE LA LLAVE',
            31 => 'YUCATAN',
            32 => 'ZACATECAS'
        ];

        // --- MAPEO DE CIUDADES FRECUENTES (ID VIEJO -> NOMBRE REAL) ---
        $legacyIdToCityName = [
            348 => 'LEON',
            336 => 'CELAYA',
            345 => 'IRAPUATO',
            343 => 'GUANAJUATO',
            584 => 'ZAPOPAN',
            1861 => 'SAN LUIS POTOSI',
            // Agrega más si encuentras errores recurrentes
        ];

        // 3. Procesar Usuarios
        $users = User::all();
        $bar = $this->output->createProgressBar(count($users));
        $bar->start();

        $updatedCount = 0;
        $errors = [];

        foreach ($users as $user) {
            $needsUpdate = false;
            
            // --- PASO 1: CORREGIR ESTADO ---
            if ($user->birth_state && is_numeric($user->birth_state)) {
                $oldStateId = (int)$user->birth_state;
                
                // Buscar nombre en nuestro mapa manual
                $searchName = $legacyIdToStateName[$oldStateId] ?? null;

                if ($searchName) {
                    // Sanitizar el nombre de búsqueda para asegurar match
                    $searchNameSanitized = $this->sanitize($searchName);
                    
                    // Buscar en el mapa de estados (que ya tiene claves sanitizadas)
                    $newStateId = $newStatesMap[$searchName] ?? $newStatesMap[$searchNameSanitized] ?? null;

                    if ($newStateId) {
                        $user->birth_state = $newStateId;
                        if ($newStateId != $oldStateId) $needsUpdate = true;
                    } else {
                        $errors[] = "Usuario {$user->id}: Estado '$searchName' (ID $oldStateId) no encontrado. (Revisar acentos/nombres oficiales)";
                    }
                }
            }

            // --- PASO 2: CORREGIR CIUDAD ---
            if ($user->birth_city && is_numeric($user->birth_city)) {
                $oldCityId = (int)$user->birth_city;
                $searchCityName = $legacyIdToCityName[$oldCityId] ?? null;

                if ($searchCityName) {
                    $searchCitySanitized = $this->sanitize($searchCityName);
                    $currentStateId = $user->birth_state; // Usar el ID de estado ya corregido
                    
                    $foundCityId = null;

                    // Buscar primero por estado exacto
                    if (isset($newCitiesMap[$searchCityName][$currentStateId])) {
                        $foundCityId = $newCitiesMap[$searchCityName][$currentStateId];
                    } 
                    // Buscar por nombre sanitizado en estado exacto
                    elseif (isset($newCitiesMap[$searchCitySanitized][$currentStateId])) {
                        $foundCityId = $newCitiesMap[$searchCitySanitized][$currentStateId];
                    }
                    // Búsqueda laxa (en cualquier estado) SOLO si no se encontró en el estado correcto
                    elseif (isset($newCitiesMap[$searchCitySanitized])) {
                        // Tomamos el primer match, o tratamos de ser inteligentes...
                        // Por ahora tomamos el primero para rescatar datos perdidos
                        $foundCityId = reset($newCitiesMap[$searchCitySanitized]);
                    }

                    if ($foundCityId) {
                        $user->birth_city = $foundCityId;
                        if ($foundCityId != $oldCityId) $needsUpdate = true;
                    } else {
                        // Solo reportar si estábamos intentando mapear algo conocido
                        $errors[] = "Usuario {$user->id}: Ciudad '$searchCityName' (ID $oldCityId) no encontrada en Estado $currentStateId.";
                    }
                }
            }

            if ($needsUpdate) {
                $user->save();
                $updatedCount++;
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ Proceso completado. Se actualizaron {$updatedCount} usuarios.");

        if (count($errors) > 0) {
            $this->warn("⚠️ Se encontraron " . count($errors) . " errores finales:");
            foreach (array_slice($errors, 0, 20) as $err) $this->line($err);
        } else {
            $this->info("✨ ¡Limpieza perfecta!");
        }
    }

    private function sanitize($string)
    {
        $string = mb_strtoupper($string, 'UTF-8');
        // Reemplazo manual de acentos
        $string = str_replace(
            ['Á', 'É', 'Í', 'Ó', 'Ú', 'Ü', 'Ñ'],
            ['A', 'E', 'I', 'O', 'U', 'U', 'N'],
            $string
        );
        return $string;
    }
}
