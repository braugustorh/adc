<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class FixUserGeoData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:user-geo-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Corrige los IDs de estado y ciudad de los usuarios basándose en un mapa de legado y diccionarios de corrección.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Iniciando proceso de migración y normalización de usuarios...');

        // 1. Cargar el mapa de legado (ID viejo -> Nombre viejo/corrupto)
        $jsonPath = database_path('seeders/legacy_geo_map.json');
        if (!File::exists($jsonPath)) {
            $this->error('❌ No se encontró el archivo legacy_geo_map.json. Ejecuta primero map:legacy-geo-ids');
            return;
        }

        $legacyMap = json_decode(File::get($jsonPath), true);
        $oldStates = $legacyMap['states'] ?? [];
        $oldCities = $legacyMap['cities'] ?? [];

        $this->info('✅ Mapa de legado cargado.');

        // 2. Cargar los NUEVOS catálogos de SEPOMEX en memoria para búsqueda rápida
        // Estructura: [ 'NOMBRE_ESTADO' => id ]
        $newStatesMap = State::pluck('id', 'name')->mapWithKeys(function ($id, $name) {
            return [mb_strtoupper($name, 'UTF-8') => $id];
        })->toArray();

        // Estructura: [ 'NOMBRE_CIUDAD' => [ state_id => city_id ] ]
        // Esto permite buscar "Celaya" y saber a qué estado pertenece
        $newCitiesRaw = City::select('id', 'state_id', 'name')->get();
        $newCitiesMap = [];
        foreach ($newCitiesRaw as $city) {
            $nameUpper = mb_strtoupper($city->name, 'UTF-8');
            $newCitiesMap[$nameUpper][$city->state_id] = $city->id;
            
            // También guardar versión sanitizada (sin acentos)
            $sanitized = $this->sanitize($nameUpper);
            if ($sanitized !== $nameUpper) {
                $newCitiesMap[$sanitized][$city->state_id] = $city->id;
            }
        }

        $this->info('✅ Nuevo catálogo indexado (tolerancia a acentos activada).');

        // --- MAPEO DE CORRECCIÓN DE ID LEGACY (USUARIO -> ID VIEJO -> NOMBRE REAL) ---
        // Este mapa ignora los nombres corruptos (India) y usa los IDs originales (1-32)
        $legacyIdToStateName = [
            1 => 'AGUASCALIENTES',
            2 => 'BAJA CALIFORNIA',
            3 => 'BAJA CALIFORNIA SUR',
            4 => 'CAMPECHE',
            5 => 'COAHUILA DE ZARAGOZA', // Ajuste a nombre oficial
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
            16 => 'MICHOACAN DE OCAMPO', // Ajuste a nombre oficial
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
            30 => 'VERACRUZ DE IGNACIO DE LA LLAVE', // Ajuste a nombre oficial
            31 => 'YUCATAN',
            32 => 'ZACATECAS'
        ];

        // --- MAPEO DE CORRECCIÓN DE CIUDADES (ID VIEJO -> NOMBRE REAL) ---
        // Basado en el feedback del usuario
        $legacyIdToCityName = [
            348 => 'LEON',
            336 => 'CELAYA',
            345 => 'IRAPUATO',
            343 => 'GUANAJUATO',
            584 => 'ZAPOPAN',
            1861 => 'SAN LUIS POTOSI',
            // Puedes agregar más aquí si detectas patrones
        ];

        // --- DICCIONARIOS DE CORRECCIÓN MANUAL (Nombres de texto) ---
        $stateCorrections = [
            'ESTADO DE MEXICO' => 'MEXICO', 
            'VERACRUZ' => 'VERACRUZ DE IGNACIO DE LA LLAVE',
            'COAHUILA' => 'COAHUILA DE ZARAGOZA',
            'MICHOACAN' => 'MICHOACAN DE OCAMPO',
            'QUERETARO DE ARTEAGA' => 'QUERETARO',
        ];

        $cityCorrections = [
            'SILAO' => 'SILAO DE LA VICTORIA',
            'DOLORES HIDALGO' => 'DOLORES HIDALGO CUNA DE LA INDEPENDENCIA NACIONAL',
            // Agrega más si es necesario
        ];

        // 3. Procesar Usuarios
        $users = User::all();
        $bar = $this->output->createProgressBar(count($users));
        $bar->start();

        $updatedCount = 0;
        $errors = [];

        foreach ($users as $user) {
            $needsUpdate = false;
            $originalStateId = $user->birth_state;

            // --- PASO 1: CORREGIR ESTADO ---
            if ($user->birth_state && is_numeric($user->birth_state)) {
                $oldStateId = (int)$user->birth_state;
                $searchStateName = null;

                // A) Mapeo Directo ID -> Nombre Oficial (Prioridad)
                if (isset($legacyIdToStateName[$oldStateId])) {
                    $searchStateName = $legacyIdToStateName[$oldStateId];
                } 
                // B) Fallback a JSON Legacy (para IDs > 32 o desconocidos)
                else {
                    $legacyName = $oldStates[$oldStateId] ?? null;
                    if ($legacyName) {
                        $searchStateName = mb_strtoupper($legacyName, 'UTF-8');
                        if (isset($stateCorrections[$searchStateName])) {
                            $searchStateName = $stateCorrections[$searchStateName];
                        }
                    }
                }

                if ($searchStateName) {
                    $newStateId = $newStatesMap[$searchStateName] ?? $newStatesMap[$this->sanitize($searchStateName)] ?? null;

                    if ($newStateId) {
                        // Actualizar ID en memoria (y marcar para guardar si cambió)
                        // IMPORTANTE: Incluso si el ID es el mismo numéricamente, validamos que conceptualmente sea correcto.
                        // Pero solo guardamos si el número cambia para no saturar la DB.
                        // Sin embargo, para la búsqueda de ciudad abajo, necesitamos el $newStateId correcto.
                        $user->birth_state = $newStateId; 
                        if ($newStateId != $oldStateId) {
                            $needsUpdate = true;
                        }
                    } else {
                        $errors[] = "Usuario {$user->id}: Estado '$searchStateName' (ID Legacy $oldStateId) no encontrado en SEPOMEX.";
                    }
                }
            }

            // --- PASO 2: CORREGIR CIUDAD ---
            if ($user->birth_city && is_numeric($user->birth_city)) {
                $oldCityId = (int)$user->birth_city;
                $searchCityName = null;

                // A) Mapeo Directo ID -> Nombre Ciudad (Prioridad)
                if (isset($legacyIdToCityName[$oldCityId])) {
                    $searchCityName = $legacyIdToCityName[$oldCityId];
                }
                // B) Fallback a JSON Legacy
                else {
                    $legacyCityName = $oldCities[$oldCityId] ?? null;
                    if ($legacyCityName) {
                        $searchCityName = mb_strtoupper($legacyCityName, 'UTF-8');
                        if (isset($cityCorrections[$searchCityName])) {
                            $searchCityName = $cityCorrections[$searchCityName];
                        }
                    }
                }

                if ($searchCityName) {
                    // Buscar ID de ciudad en SEPOMEX
                    // Intentamos filtrar por el estado YA CORREGIDO del usuario
                    $currentStateId = $user->birth_state; // Este ya es el ID nuevo (o el viejo si no cambió)
                    
                    $foundCityId = null;

                    // 1. Buscar coincidencia exacta en el estado correcto
                    if (isset($newCitiesMap[$searchCityName][$currentStateId])) {
                        $foundCityId = $newCitiesMap[$searchCityName][$currentStateId];
                    }
                    // 2. Buscar coincidencia sanitizada en el estado correcto
                    elseif (isset($newCitiesMap[$this->sanitize($searchCityName)][$currentStateId])) {
                         $foundCityId = $newCitiesMap[$this->sanitize($searchCityName)][$currentStateId];
                    }
                    // 3. (Opcional) Buscar en cualquier estado si no se encuentra en el actual?
                    // Riesgoso, mejor reportar error si no coincide con el estado.
                    else {
                        // Intento desesperado: ¿Existe esa ciudad en algún otro estado?
                        if (isset($newCitiesMap[$searchCityName])) {
                            // Tomar el primero (solo para debug o si se acepta el riesgo)
                            // $foundCityId = reset($newCitiesMap[$searchCityName]);
                        }
                    }

                    if ($foundCityId) {
                        if ($foundCityId != $oldCityId) {
                            $user->birth_city = $foundCityId;
                            $needsUpdate = true;
                        }
                    } else {
                        // Si tenemos nombre pero no ID, es un error de "No encontrado"
                        // Ojo: Si searchCityName viene del JSON legacy corrupto (ej: "DHING") y no está en el mapa manual, fallará aquí.
                        // Esto es ESPERADO para ciudades indias no mapeadas.
                        $errors[] = "Usuario {$user->id}: Ciudad '$searchCityName' (ID Legacy $oldCityId) no encontrada en Estado ID $currentStateId.";
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
        $this->info("✅ Proceso completado. Se migraron {$updatedCount} usuarios.");

        if (count($errors) > 0) {
            $this->warn("⚠️ Se encontraron " . count($errors) . " inconsistencias:");
            foreach (array_slice($errors, 0, 50) as $error) { // Mostrar solo los primeros 50
                $this->line($error);
            }
            if (count($errors) > 50) {
                $this->line("... y " . (count($errors) - 50) . " más.");
            }
        } else {
            $this->info("✨ ¡Cero errores! La migración fue perfecta.");
        }
    }

    private function sanitize($string)
    {
        $string = mb_strtoupper($string, 'UTF-8');
        $string = str_replace(
            ['Á', 'É', 'Í', 'Ó', 'Ú', 'Ü', 'Ñ'],
            ['A', 'E', 'I', 'O', 'U', 'U', 'N'],
            $string
        );
        return $string;
    }
}
