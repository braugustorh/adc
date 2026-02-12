<div class="space-y-6">

    {{-- ========================================================= --}}
    {{-- 0. LÓGICA DE PREPARACIÓN (PHP)                            --}}
    {{-- ========================================================= --}}
    @php
        // 1. Helper de Colores (Estilos inline para máxima compatibilidad)
        $getColorHex = function($range) {
            $range = strtolower($range ?? '');
            // Verdes
            if (str_contains($range, 'excelente') || str_contains($range, 'muy superior'))
                return ['bg' => '#10b981', 'border' => '#059669', 'text' => '#064e3b', 'light' => '#d1fae5'];
            if (str_contains($range, 'superior') || str_contains($range, 'buena'))
                return ['bg' => '#34d399', 'border' => '#10b981', 'text' => '#065f46', 'light' => '#ecfdf5'];
            // Azules
            if (str_contains($range, 'término medio') || str_contains($range, 'promedio') || str_contains($range, 'tiende a buena'))
                return ['bg' => '#3b82f6', 'border' => '#2563eb', 'text' => '#1e3a8a', 'light' => '#dbeafe'];
            // Naranjas
            if (str_contains($range, 'inferior') || str_contains($range, 'bajo') || str_contains($range, 'mala'))
                return ['bg' => '#f59e0b', 'border' => '#d97706', 'text' => '#78350f', 'light' => '#fef3c7'];
            // Rojos
            if (str_contains($range, 'deficiente') || str_contains($range, 'deficitaria'))
                return ['bg' => '#ef4444', 'border' => '#dc2626', 'text' => '#7f1d1d', 'light' => '#fee2e2'];

            // Default Gris
            return ['bg' => '#6b7280', 'border' => '#4b5563', 'text' => '#1f2937', 'light' => '#f3f4f6'];
        };

        // 2. Datos Globales
        $globalRange = $results['range'] ?? 'N/A';
        $globalColors = $getColorHex($globalRange);

        // 3. Fuentes de datos (AQUÍ ESTABA EL ERROR: Definimos $dimensions explícitamente)
        $dimensions = $results['dimensions'] ?? ($results['scores'] ?? []);
        $subscales = $results['subscales'] ?? [];

        // 4. MAPA DE RELACIÓN (Para anidar visualmente las subescalas dentro de las dimensiones)
        // Usamos los keys del JSON para agrupar
        $relationsMap = [
            'Relaciones' => ['IM', 'CO', 'AP'],
            'Auto-realización' => ['AU', 'OR', 'PR'],
            'Estabilidad/Cambio' => ['CL', 'CN', 'IN', 'CF']
        ];
    @endphp

    {{-- ========================================================= --}}
    {{-- 1. HEADER: SCORECARD EJECUTIVO                           --}}
    {{-- ========================================================= --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-gray-200 shadow-sm">
        <div class="absolute left-0 top-0 bottom-0 w-2" style="background-color: {{ $globalColors['bg'] }};"></div>

        <div class="p-5 pl-7 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900 tracking-tight">{{ $results['test_name'] }}</h3>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $results['summary'] ?? 'Informe de resultados.' }}
                </p>
            </div>

            <div class="flex flex-col items-end text-right">
                <span class="text-[10px] uppercase tracking-wider font-bold text-gray-400">Rango Global</span>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-sm font-bold shadow-sm"
                          style="background-color: {{ $globalColors['light'] }}; color: {{ $globalColors['text'] }}; border: 1px solid {{ $globalColors['border'] }};">
                        {{ $globalRange }}
                    </span>
                    @if(isset($results['percentile']) && $results['percentile'] > 0)
                        <div class="flex flex-col items-center justify-center w-10 h-10 rounded-full bg-gray-50 border border-gray-200" title="Percentil">
                            <span class="text-[8px] text-gray-400 leading-none">Pctl</span>
                            <span class="text-xs font-bold text-gray-700 leading-none">{{ $results['percentile'] }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- 2. LISTADO DE DIMENSIONES (CON SUBESCALAS ANIDADAS)      --}}
    {{-- ========================================================= --}}
    @if(count($dimensions) > 0 && isset($results['chart_type']) && $results['chart_type'] != 'radar')
        <div class="grid grid-cols-1 gap-6">

            @foreach($dimensions as $dimKey => $dimData)
                @php
                    $isRich = is_array($dimData);
                    $dimLabel = $isRich ? ($dimData['completeName'] ?? $dimKey) : $dimKey;
                    $dimVal = $isRich ? ($dimData['percentage'] ?? 0) : ($dimData['score'] ?? 0);
                    $dimRange = $isRich ? ($dimData['category'] ?? ($dimData['range'] ?? 'N/A')) : 'N/A';

                    // Extraemos la descripción de la dimensión (si existe)
                    $dimDescription = $isRich ? ($dimData['description'] ?? null) : null;

                    $dimColors = $getColorHex($dimRange);
                    $childSubscales = $relationsMap[$dimKey] ?? [];
                @endphp

                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">

                    {{-- A. ENCABEZADO DE LA DIMENSIÓN --}}
                    <div class="p-4 border-b border-gray-100" style="background: linear-gradient(to right, #ffffff, {{ $dimColors['light'] }}33);">
                        <div class="flex justify-between items-start mb-2 gap-4">
                            <div>
                                <h4 class="text-base font-bold text-gray-800">{{ $dimLabel }}</h4>

                                {{-- Descripción de la Dimensión --}}
                                @if($dimDescription)
                                    <p class="text-xs text-gray-500 mt-1 font-normal leading-snug">
                                        {{ $dimDescription }}
                                    </p>
                                @endif
                            </div>

                            <span class="shrink-0 text-xs font-bold px-2 py-1 rounded border"
                                  style="color: {{ $dimColors['text'] }}; background-color: white; border-color: {{ $dimColors['border'] }};">
                                {{ $dimRange }}
                            </span>
                        </div>

                        {{-- Barra de Progreso Dimensión --}}
                        <div class="w-full bg-gray-100 rounded-full h-2 mt-2">
                            <div class="h-2 rounded-full transition-all duration-500"
                                 style="width: {{ $dimVal }}%; background-color: {{ $dimColors['bg'] }};"></div>
                        </div>
                    </div>

                    {{-- B. GRID DE SUBESCALAS (Micro-indicadores) --}}
                    @if(count($childSubscales) > 0 && count($subscales) > 0)
                        <div class="px-4 py-3 bg-gray-50/50 border-b border-gray-100">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Detalle de Subescalas</p>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($childSubscales as $subCode)
                                    @if(isset($subscales[$subCode]))
                                        @php
                                            $sub = $subscales[$subCode];
                                            $subColors = $getColorHex($sub['category']);
                                            $subPercent = min(($sub['raw_score'] ?? 0) * 11, 100);
                                            $subDescription = $sub['description'] ?? null;
                                        @endphp
                                        <div class="bg-white p-2.5 rounded border border-gray-200 flex items-start gap-3 shadow-sm h-full">
                                            {{-- Círculo con Score --}}
                                            <div class="flex flex-col items-center justify-center w-8 h-8 rounded-full shrink-0 font-bold text-xs mt-1"
                                                 style="background-color: {{ $subColors['light'] }}; color: {{ $subColors['text'] }};">
                                                {{ $sub['raw_score'] }}
                                            </div>

                                            <div class="flex-1 min-w-0">
                                                <div class="flex justify-between items-baseline mb-0.5">
                                                    <span class="text-xs font-semibold text-gray-800 truncate block" title="{{ $sub['name'] }}">{{ $sub['name'] }}</span>
                                                    <span class="text-[9px] uppercase font-bold" style="color: {{ $subColors['text'] }}">{{ $sub['category'] }}</span>
                                                </div>

                                                {{-- Descripción de la Subescala --}}
                                                @if($subDescription)
                                                    <p class="text-[9px] text-gray-600 leading-tight mb-2 line-clamp-2" title="{{ $subDescription }}">
                                                        {{ $subDescription }}
                                                    </p>
                                                @endif

                                                <div class="w-full bg-gray-100 h-1 rounded-full mt-auto">
                                                    <div class="h-1 rounded-full" style="width: {{ $subPercent }}%; background-color: {{ $subColors['bg'] }}"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- C. INTERPRETACIÓN Y RECOMENDACIÓN --}}
                    @if(isset($dimData['interpretation']) || isset($dimData['recommendation']))
                        <div class="p-4 bg-white grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            @if(isset($dimData['interpretation']))
                                <div class="flex gap-3">
                                    <div class="shrink-0 mt-0.5 text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Interpretación</span>
                                        <p class="text-gray-600 leading-snug">{{ $dimData['interpretation'] }}</p>
                                    </div>
                                </div>
                            @endif

                            @if(isset($dimData['recommendation']))
                                <div class="flex gap-3">
                                    <div class="shrink-0 mt-0.5 text-indigo-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-bold text-indigo-400 uppercase tracking-wide mb-1">Recomendación</span>
                                        <div class="bg-indigo-50 border border-indigo-100 text-gray-700 p-2 rounded text-xs leading-snug">
                                            {{ $dimData['recommendation'] }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    {{-- ========================================================= --}}
    {{-- 3. FALLBACK PARA KOSTICK (RADAR / LISTA SIMPLE)          --}}
    {{-- ========================================================= --}}
    @if(isset($results['chart_type']) && $results['chart_type'] == 'radar')
        <div class="grid grid-cols-4 md:grid-cols-5 gap-2 text-center">
            @foreach($results['scores'] as $letter => $val)
                <div class="p-2 bg-white border border-gray-200 rounded hover:border-indigo-400 transition-colors">
                    <div class="text-[10px] text-gray-400 font-bold uppercase">{{ $letter }}</div>
                    <div class="text-lg font-bold text-indigo-600">{{ $val }}</div>
                </div>
            @endforeach
        </div>
        <div class="p-3 bg-blue-50 text-blue-700 text-xs rounded border border-blue-100 flex items-center gap-2 justify-center">
            <span>ℹ️</span> Descarga el PDF para visualizar el diagrama de Radar completo.
        </div>
    @endif

</div>
