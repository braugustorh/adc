<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Str;

class HomologateUserGeo extends Command
{
    protected $signature = 'geo:homologate {--dry-run : Ejecutar sin guardar cambios}';
    protected $description = 'Homologa state y city de usuarios contra el catálogo SEPOMEX (tablas states/cities).';

    // Diccionarios de corrección manual para casos difíciles
    protected $stateAliases = [
        'CDMX' => 'CIUDAD DE MEXICO',
        'DF' => 'CIUDAD DE MEXICO',
        'D.F.' => 'CIUDAD DE MEXICO',
        'EDO MEX' => 'MEXICO',
        'EDOMEX' => 'MEXICO',
        'ESTADO DE MEXICO' => 'MEXICO',
        'COAHUILA' => 'COAHUILA DE ZARAGOZA',
        'MICHOACAN' => 'MICHOACAN DE OCAMPO',
        'VERACRUZ' => 'VERACRUZ DE IGNACIO DE LA LLAVE',
        'QRO' => 'QUERETARO',
        'GTO' => 'GUANAJUATO',
    ];

    protected $cityAliases = [
        'DOLORES HIDALGO' => 'DOLORES HIDALGO CUNA DE LA INDEPENDENCIA NACIONAL',
        'SILAO' => 'SILAO DE LA VICTORIA',
        'SAN MIGUEL' => 'SAN MIGUEL DE ALLENDE',
        'SMA' => 'SAN MIGUEL DE ALLENDE',
        'TLAQUEPAQUE' => 'SAN PEDRO TLAQUEPAQUE',
        'SANTIAGO DE QUERETARO' => 'QUERÉTARO',
        'QUERETARO' => 'QUERÉTARO', // Por si acaso
        'CD GUZMAN' => 'CIUDAD GUZMÁN',
        'GUZMAN' => 'CIUDAD GUZMÁN',
        'CIUDAD DE MEXICO' => 'CIUDAD DE MÉXICO', // Intento forzar match si existe
        'CDMX' => 'CIUDAD DE MÉXICO',
    ];

    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $this->info("🚀 Iniciando homologación..." . ($dryRun ? " [MODO SIMULACIÓN]" : ""));

        // 1. Cargar Catálogos SEPOMEX (Fuente de la Verdad)
        $this->info("📚 Cargando catálogos SEPOMEX...");
        
        $sepomexStates = State::all(); // Colección de modelos State
        $sepomexCities = City::select('id', 'state_id', 'name')->get()->groupBy('state_id'); // Agrupadas por Estado

        $bar = $this->output->createProgressBar(User::count());
        $bar->start();

        $updated = 0;
        $unresolved = [];

        foreach (User::cursor() as $user) {
            $hasChanges = false;
            
            // --- 1. HOMOLOGAR ESTADO ---
            $inputState = trim($user->state);
            $officialState = null; // Modelo State encontrado

            if (!empty($inputState)) {
                // A. Búsqueda Directa / Alias
                $officialState = $this->findState($inputState, $sepomexStates);
                
                if ($officialState) {
                    // ¿El nombre actual difiere del oficial? (Ej: "Gto" vs "GUANAJUATO")
                    if ($user->state !== $officialState->name) {
                        $user->state = $officialState->name; // Guardamos el NOMBRE OFICIAL
                        $hasChanges = true;
                    }
                } else {
                    $unresolved[] = "Usuario {$user->id}: Estado '{$inputState}' no encontrado.";
                }
            }

            // --- 2. HOMOLOGAR CIUDAD (Solo si tenemos estado identificado) ---
            $inputCity = trim($user->city);
            
            if (!empty($inputCity) && $officialState) {
                // Obtener ciudades SOLO del estado correspondiente
                $stateCities = $sepomexCities->get($officialState->id) ?? collect();
                
                $officialCity = $this->findCity($inputCity, $stateCities);

                if ($officialCity) {
                    if ($user->city !== $officialCity->name) {
                        $user->city = $officialCity->name; // Guardamos el NOMBRE OFICIAL
                        $hasChanges = true;
                    }
                } else {
                    $unresolved[] = "Usuario {$user->id}: Ciudad '{$inputCity}' no encontrada en {$officialState->name}.";
                }
            } elseif (!empty($inputCity) && !$officialState) {
                $unresolved[] = "Usuario {$user->id}: No se puede buscar ciudad '{$inputCity}' sin Estado válido.";
            }

            // --- GUARDAR ---
            if ($hasChanges && !$dryRun) {
                $user->save();
                $updated++;
            }
            
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("✅ Proceso terminado.");
        $this->info("📝 Usuarios actualizados: {$updated}");
        
        if (count($unresolved) > 0) {
            $this->warn("⚠️  Casos no resueltos (" . count($unresolved) . "):");
            foreach (array_slice($unresolved, 0, 20) as $err) $this->line($err);
            if (count($unresolved) > 20) $this->line("... y más.");
        }
    }

    // --- FUNCIONES DE BÚSQUEDA ---

    private function findState($input, $collection)
    {
        $inputUpper = mb_strtoupper($input, 'UTF-8');
        $inputSanitized = $this->sanitize($inputUpper);

        // 1. Alias Manuales
        if (isset($this->stateAliases[$inputUpper])) {
            $aliasName = $this->stateAliases[$inputUpper];
            // Buscar el alias en la colección oficial
            return $collection->first(fn($s) => mb_strtoupper($s->name) === $aliasName);
        }

        // 2. Búsqueda Exacta y Sanitizada
        foreach ($collection as $state) {
            $officialUpper = mb_strtoupper($state->name, 'UTF-8');
            
            if ($officialUpper === $inputUpper) return $state;
            if ($this->sanitize($officialUpper) === $inputSanitized) return $state;
        }

        // 3. Fuzzy Search (Similitud > 85%)
        foreach ($collection as $state) {
            $officialUpper = mb_strtoupper($state->name, 'UTF-8');
            similar_text($inputUpper, $officialUpper, $percent);
            if ($percent > 85) return $state;
        }

        return null;
    }

    private function findCity($input, $collection)
    {
        $inputUpper = mb_strtoupper($input, 'UTF-8');
        $inputSanitized = $this->sanitize($inputUpper);

        // 1. Alias
        if (isset($this->cityAliases[$inputUpper])) {
            $aliasName = $this->cityAliases[$inputUpper];
            return $collection->first(fn($c) => mb_strtoupper($c->name) === $aliasName);
        }

        // 2. Exacta / Sanitizada
        foreach ($collection as $city) {
            $officialUpper = mb_strtoupper($city->name, 'UTF-8');
            
            if ($officialUpper === $inputUpper) return $city;
            if ($this->sanitize($officialUpper) === $inputSanitized) return $city;
        }

        // 3. Fuzzy Search (Más estricto para ciudades: > 90%)
        foreach ($collection as $city) {
            $officialUpper = mb_strtoupper($city->name, 'UTF-8');
            similar_text($inputUpper, $officialUpper, $percent);
            if ($percent > 90) return $city;
        }

        return null;
    }

    private function sanitize($string)
    {
        $string = mb_strtoupper($string, 'UTF-8');
        return str_replace(
            ['Á', 'É', 'Í', 'Ó', 'Ú', 'Ü', 'Ñ', '.'],
            ['A', 'E', 'I', 'O', 'U', 'U', 'N', ''],
            $string
        );
    }
}
