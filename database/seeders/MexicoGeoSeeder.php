<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\State;
use App\Models\City;
use App\Models\Country;

class MexicoGeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('⏳ Descargando catálogo oficial de Municipios de México...');

        // URL del JSON limpio de Estados y Municipios (Fuente: cisnerosnow/GitHub)
        $url = 'https://raw.githubusercontent.com/cisnerosnow/json-estados-municipios-mexico/master/estados-municipios.json';

        try {
            $response = Http::get($url);

            if ($response->failed()) {
                $this->command->error('❌ Error al descargar el catálogo. Verifica tu conexión a internet.');
                return;
            }

            $data = $response->json();

            if (empty($data)) {
                $this->command->error('❌ El JSON descargado está vacío o es inválido.');
                return;
            }

        } catch (\Exception $e) {
            $this->command->error('❌ Excepción al descargar: ' . $e->getMessage());
            return;
        }

        // 1. Limpiar tablas existentes (sin borrar IDs si es posible, pero aquí vamos a reiniciar para limpiar basura)
        // Detección de driver para desactivar FKs correctamente
        $driver = DB::connection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        } elseif ($driver === 'pgsql') {
            DB::statement('SET CONSTRAINTS ALL DEFERRED;');
        } elseif ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        }

        City::truncate();
        State::truncate();

        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } elseif ($driver === 'pgsql') {
            DB::statement('SET CONSTRAINTS ALL IMMEDIATE;');
        } elseif ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        }

        $this->command->info('🧹 Tablas cities y states limpiadas.');

        DB::beginTransaction();

        try {

            // Asegurar que existe el país México
            $mexico = Country::firstOrCreate(
                ['name' => 'Mexico'], // Ojo: Ajusta si tu DB usa 'México' con acento
                ['sortname' => 'MX', 'phonecode' => 52]
            );

            $this->command->info('🇲🇽 Procesando estados y municipios...');

            foreach ($data as $estadoNombre => $municipios) {
                // Convertir estado a MAYÚSCULAS
                $estadoUpper = mb_strtoupper($estadoNombre, 'UTF-8');

                // Crear Estado
                $state = State::create([
                    'country_id' => $mexico->id,
                    'name' => $estadoUpper,
                    'status' => 'active' // En Postgres se requiere string explícito 'Active'
                ]);

                // Preparar array de municipios para inserción masiva (más rápido)
                $citiesData = [];
                foreach ($municipios as $municipioNombre) {
                    $citiesData[] = [
                        'state_id' => $state->id,
                        'name' => mb_strtoupper($municipioNombre, 'UTF-8'),
                        'status' => 'active', // También para ciudades
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // Insertar en lotes
                City::insert($citiesData);

                $this->command->info("✅ $estadoUpper cargado con " . count($citiesData) . " municipios.");
            }

            DB::commit();
            $this->command->info('🎉 ¡Carga completa! Base de datos geoespacial normalizada.');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('❌ Error crítico en la transacción: ' . $e->getMessage());
        }
    }
}
