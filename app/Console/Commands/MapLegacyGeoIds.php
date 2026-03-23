<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Facades\Storage;

class MapLegacyGeoIds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'map:geo-ids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un backup JSON (mapeo ID => Nombre) de los estados y ciudades actuales antes de limpiar la BD.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🗺️ Iniciando mapeo de IDs geográficos actuales...');

        try {
            // Mapear Estados (ID => Nombre)
            $statesMap = State::pluck('name', 'id')->map(function ($name) {
                return mb_strtoupper($name, 'UTF-8');
            })->toArray();
            
            $this->info('✅ Estados mapeados: ' . count($statesMap));

            // Mapear Ciudades (ID => Nombre) - Usamos chunk para evitar memory limit si son muchas
            $citiesMap = [];
            City::chunk(1000, function ($cities) use (&$citiesMap) {
                foreach ($cities as $city) {
                    $citiesMap[$city->id] = mb_strtoupper($city->name, 'UTF-8');
                }
            });
            
            $this->info('✅ Ciudades mapeadas: ' . count($citiesMap));

            // Guardar en JSON
            $mapping = [
                'states' => $statesMap,
                'cities' => $citiesMap,
                'generated_at' => now()->toIso8601String(),
            ];

            Storage::put('legacy_geo_map.json', json_encode($mapping, JSON_PRETTY_PRINT));
            
            $this->info('💾 Archivo guardado en: ' . storage_path('app/legacy_geo_map.json'));
            $this->warn('⚠️ IMPORTANTE: No borres este archivo hasta terminar la migración.');

        } catch (\Exception $e) {
            $this->error('❌ Error al generar el mapa: ' . $e->getMessage());
        }
    }
}
