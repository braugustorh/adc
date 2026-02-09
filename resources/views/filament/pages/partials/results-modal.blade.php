<div class="space-y-6">

    {{-- LÓGICA DE COLORES Y DATOS --}}
    @php
        // Helper para determinar colores según el texto del rango (retorna hex colors para inline styles)
        $getColorHex = function($range) {
            $range = strtolower($range ?? '');
            if (str_contains($range, 'excelente') || str_contains($range, 'muy superior')) {
                return ['bg' => '#10b981', 'border' => '#059669', 'text' => '#065f46', 'light' => '#d1fae5'];
            }
            if (str_contains($range, 'superior')) {
                return ['bg' => '#34d399', 'border' => '#10b981', 'text' => '#065f46', 'light' => '#d1fae5'];
            }
            if (str_contains($range, 'término medio') || str_contains($range, 'promedio')) {
                return ['bg' => '#3b82f6', 'border' => '#2563eb', 'text' => '#1e3a8a', 'light' => '#dbeafe'];
            }
            if (str_contains($range, 'inferior') || str_contains($range, 'bajo')) {
                return ['bg' => '#f59e0b', 'border' => '#d97706', 'text' => '#92400e', 'light' => '#fef3c7'];
            }
            if (str_contains($range, 'deficiente') || str_contains($range, 'mala')) {
                return ['bg' => '#ef4444', 'border' => '#dc2626', 'text' => '#991b1b', 'light' => '#fee2e2'];
            }
            return ['bg' => '#6b7280', 'border' => '#4b5563', 'text' => '#1f2937', 'light' => '#e5e7eb']; // Gray por defecto
        };

        // Datos Globales
        $globalRange = $results['range'] ?? 'N/A';
        $globalColors = $getColorHex($globalRange);

        // Unificamos la fuente de datos: Usamos 'scores' o 'dimensions' si scores no existe
        $dataSource = $results['scores'] ?? ($results['dimensions'] ?? []);
    @endphp

    {{-- ========================================== --}}
    {{-- 1. HEADER: SCORECARD EJECUTIVO           --}}
    {{-- ========================================== --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-gray-200 shadow-sm">
        {{-- Banda lateral de color --}}
        <div class="absolute left-0 top-0 bottom-0 w-2" style="background-color: {{ $globalColors['bg'] }};"></div>

        <div class="p-5 pl-7 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900 tracking-tight">{{ $results['test_name'] }}</h3>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $results['summary'] ?? 'Resultados de la evaluación psicométrica.' }}
                </p>
            </div>

            <div class="flex flex-col items-end text-right">
                <span class="text-[10px] uppercase tracking-wider font-bold text-gray-400">Rango Global</span>
                <div class="flex items-center gap-2">
                    {{-- Badge del Rango --}}
                    <span class="px-3 py-1 rounded-full text-sm font-bold" style="background-color: {{ $globalColors['light'] }}; color: {{ $globalColors['text'] }}; border: 1px solid {{ $globalColors['border'] }};">
                        {{ $globalRange }}
                    </span>

                    {{-- Círculo de Percentil (si existe) --}}
                    @if(isset($results['percentile']) && $results['percentile'] > 0)
                        <div class="flex flex-col items-center justify-center w-10 h-10 rounded-full bg-gray-50 border border-gray-200 shadow-sm" title="Percentil">
                            <span class="text-[8px] text-gray-400 leading-none">Pctl</span>
                            <span class="text-xs font-bold text-gray-700 leading-none">{{ $results['percentile'] }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 2. CUERPO: BARRAS Y DETALLES (MOSS)      --}}
    {{-- ========================================== --}}
    @if(isset($results['chart_type']) && ($results['chart_type'] == 'bar' || $results['chart_type'] == 'bar_qualitative' || $results['chart_type'] == 'bar_grouped'))

        <div class="grid grid-cols-1 gap-5">
            @foreach($dataSource as $key => $data)
                @php
                    // Determinamos si es un dato complejo (Moss) o simple (Cleaver)
                    $isRich = is_array($data) && (isset($data['completeName']) || isset($data['interpretation']));

                    // Extracción de datos segura
                    $label = $isRich ? ($data['completeName'] ?? $key) : $key;
                    $val   = $isRich ? ($data['percentage'] ?? 0) : ($data['score'] ?? $data);

                    // Si es simple, multiplicamos por un factor (ej 5 para Cleaver) o usamos directo
                    // Si es Moss ($isRich), usamos el porcentaje directo
                    $percentWidth = $isRich ? $val : (is_numeric($val) ? min($val * 5, 100) : 0);

                    $rangeText = $isRich ? ($data['range'] ?? 'N/A') : ($data['category'] ?? $val);
                    $dimColors = $getColorHex($rangeText);

                    // Datos extra
                    $description = $isRich ? ($data['description'] ?? null) : null;
                    $interp      = $isRich ? ($data['interpretation'] ?? null) : null;
                    $rec         = $isRich ? ($data['recommendation'] ?? null) : null;
                @endphp

                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-300 mb-4">

                    {{-- Encabezado de la Dimensión --}}
                    <div class="p-4 bg-gray-50/50 border-b border-gray-100">
                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <h4 class="text-sm font-bold text-gray-800">{{ $label }}</h4>
                                @if($description)
                                    <p class="text-xs text-gray-500 italic mt-1">{{ $description }}</p>
                                @endif
                            </div>
                            <span class="shrink-0 inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-white shadow-sm" style="border: 1px solid {{ $dimColors['border'] }}; color: {{ $dimColors['text'] }};">
                                {{ $rangeText }}
                                @if($isRich) <span class="ml-1 text-gray-400 font-normal">({{ $val }}%)</span> @endif
                            </span>
                        </div>

                        {{-- Barra de Progreso --}}
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                            <div class="h-2 rounded-full transition-all duration-500" style="width: {{ $percentWidth }}%; background-color: {{ $dimColors['bg'] }};"></div>
                        </div>
                    </div>

                    {{-- Interpretación y Recomendación (Solo si existen) --}}
                    @if($interp || $rec)
                        <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4 bg-white text-sm">

                            {{-- Columna Izquierda: Interpretación --}}
                            @if($interp)
                                <div class="flex gap-3">
                                    <div class="shrink-0 mt-0.5 text-gray-400">
                                        {{-- Icono Ojo --}}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Interpretación</span>
                                        <p class="text-gray-700">{{ $interp }}</p>
                                    </div>
                                </div>
                            @endif

                            {{-- Columna Derecha: Recomendación --}}
                            @if($rec)
                                <div class="flex gap-3">
                                    <div class="shrink-0 mt-0.5 text-indigo-500">
                                        {{-- Icono Foco --}}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-bold text-indigo-400 uppercase tracking-wide mb-1">Recomendación</span>
                                        <p class="text-gray-700 bg-indigo-50 p-2 rounded border border-indigo-100">{{ $rec }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            @endforeach
        </div>
    @endif

    {{-- ========================================== --}}
    {{-- 3. CASO KOSTICK / RADAR (Simple)         --}}
    {{-- ========================================== --}}
    @if(isset($results['chart_type']) && $results['chart_type'] == 'radar')
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3 text-center">
            @foreach($results['scores'] as $letter => $val)
                <div class="p-3 bg-white border border-gray-200 rounded-lg hover:border-indigo-300 transition-colors">
                    <div class="text-xs text-gray-400 font-bold uppercase mb-1">{{ $letter }}</div>
                    <div class="text-xl font-bold text-indigo-600">{{ $val }}</div>
                </div>
            @endforeach
        </div>
        <div class="p-4 bg-blue-50 text-blue-700 text-sm rounded-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Para ver el diagrama de Radar completo, por favor descarga el reporte en PDF.
        </div>
    @endif

</div>
