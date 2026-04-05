<div class="space-y-6">

    {{-- ========================================================= --}}
    {{-- 0. LÓGICA DE PREPARACIÓN (PHP)                            --}}
    {{-- ========================================================= --}}
    @php
        // 1. Helper de Colores Global
        $getColorHex = function($range) {
            $range = strtolower($range ?? '');
            if (str_contains($range, 'excelente') || str_contains($range, 'muy superior')) return ['bg' => '#10b981', 'border' => '#059669', 'text' => '#064e3b', 'light' => '#d1fae5'];
            if (str_contains($range, 'superior') || str_contains($range, 'buena')) return ['bg' => '#34d399', 'border' => '#10b981', 'text' => '#065f46', 'light' => '#ecfdf5'];
            if (str_contains($range, 'término medio') || str_contains($range, 'promedio') || str_contains($range, 'tiende a buena')) return ['bg' => '#3b82f6', 'border' => '#2563eb', 'text' => '#1e3a8a', 'light' => '#dbeafe'];
            if (str_contains($range, 'inferior') || str_contains($range, 'bajo') || str_contains($range, 'mala')) return ['bg' => '#f59e0b', 'border' => '#d97706', 'text' => '#78350f', 'light' => '#fef3c7'];
            if (str_contains($range, 'deficiente') || str_contains($range, 'deficitaria')) return ['bg' => '#ef4444', 'border' => '#dc2626', 'text' => '#7f1d1d', 'light' => '#fee2e2'];
            return ['bg' => '#6b7280', 'border' => '#4b5563', 'text' => '#1f2937', 'light' => '#f3f4f6'];
        };

        // 2. Identificar el tipo de prueba
        $testName = $results['test_name'] ?? '';
        $isCleaver = $testName === 'Cleaver (DISC)';
        $isKostick = str_contains($testName, 'Kostick');

        // Datos Globales
        $globalRange = $results['range'] ?? 'N/A';
        $globalColors = $getColorHex($globalRange);

        // Extracción de datos según la prueba
        if ($isCleaver) {
            $cleaverPercentiles = $results['percentiles'] ?? [];
            $cleaverRaw = $results['raw_scores'] ?? [];
            $cleaverSummary = $results['summary'] ?? '';
        } elseif ($isKostick) {
            $kostickScores = $results['scores'] ?? [];
            // Si no vienen las áreas del controlador, las definimos aquí por seguridad
            $kostickAreas = $results['areas'] ?? [
                'Grado de Energía' => ['N','G', 'A'],
                'Liderazgo y Dirección' => ['L', 'P', 'I'],
                'Modo de Vida' => ['T', 'V'],
                'Naturaleza Social' => ['X','S','B','O'],
                'Adaptación al Trabajo' => ['R', 'D','C'],
                'Naturaleza Emocional' => ['Z', 'E', 'K'],
                'Subordinación' => ['F', 'W'],
            ];
            // Orden oficial para el radar
            $kostickOrder = ['G','L','I','T','V','S','R','D','C','E','Z','K','F','W','N','A','P','X','B','O'];
        } else {
            $dimensions = $results['dimensions'] ?? ($results['scores'] ?? []);
            $subscales = $results['subscales'] ?? [];
            $relationsMap = [
                'Relaciones' => ['IM', 'CO', 'AP'],
                'Auto-realización' => ['AU', 'OR', 'PR'],
                'Estabilidad/Cambio' => ['CL', 'CN', 'IN', 'CF']
            ];
        }
    @endphp

    {{-- ========================================================= --}}
    {{-- 1. HEADER: SCORECARD EJECUTIVO                           --}}
    {{-- ========================================================= --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-gray-200 shadow-sm">
        <div class="absolute left-0 top-0 bottom-0 w-2" style="background-color: {{ $isKostick ? '#4f46e5' : $globalColors['bg'] }};"></div>

        <div class="p-5 pl-7 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900 tracking-tight">{{ $testName }}</h3>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $isCleaver ? 'Perfil DISC: Motivación, Presión y Normal' : ($results['summary'] ?? 'Informe de resultados.') }}
                </p>
            </div>

            @if($isCleaver)
                <div class="text-right">
                    <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">
                        {{ $cleaverSummary }}
                    </span>
                </div>
            @endif

            @if(!$isCleaver && !$isKostick)
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
            @endif
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- VISTA ESPECÍFICA PARA KOSTICK                             --}}
    {{-- ========================================================= --}}
    @if($isKostick && !empty($kostickScores))
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            {{-- A. GRÁFICA DE RADAR (Columna Izquierda, Ocupa 5/12) --}}
            <div class="lg:col-span-5 bg-white border border-gray-200 rounded-xl p-6 shadow-sm flex flex-col items-center justify-center">
                <h4 class="font-bold text-gray-800 mb-2 w-full text-center">Rueda de Perfil Kostick</h4>
                <p class="text-xs text-gray-500 text-center mb-6">Visualización de las 20 dimensiones</p>

                @php
                    $cx = 150; $cy = 150; $rMax = 110;
                    $numPoints = count($kostickOrder);
                    $angleStep = M_PI * 2 / $numPoints;

                    $radarHtml = '<div class="w-full max-w-[320px] aspect-square relative">';
                    $radarHtml .= '<svg viewBox="0 0 300 300" class="w-full h-full overflow-visible">';

                    // 1. Dibujar círculos concéntricos (Escala 0 al 9)
                    for ($i = 1; $i <= 9; $i++) {
                        $r = ($rMax / 9) * $i;
                        $stroke = ($i === 5) ? '#6366f1' : '#e5e7eb'; // Resaltar la línea del 5 (promedio)
                        $strokeW = ($i === 5) ? '1.5' : '1';
                        $radarHtml .= '<circle cx="'.$cx.'" cy="'.$cy.'" r="'.$r.'" fill="none" stroke="'.$stroke.'" stroke-width="'.$strokeW.'"/>';

                        // Etiquetas de números en el eje vertical
                        if (in_array($i, [3, 6, 9])) {
                            $radarHtml .= '<text x="'.$cx.'" y="'.($cy - $r - 3).'" font-size="8" fill="#9ca3af" text-anchor="middle">'.$i.'</text>';
                        }
                    }

                    // 2. Dibujar Ejes y Letras
                    $polyPoints = [];
                    foreach ($kostickOrder as $index => $let) {
                        $angle = $index * $angleStep - (M_PI / 2);

                        // Línea del eje
                        $xEnd = $cx + $rMax * cos($angle);
                        $yEnd = $cy + $rMax * sin($angle);
                        $radarHtml .= '<line x1="'.$cx.'" y1="'.$cy.'" x2="'.$xEnd.'" y2="'.$yEnd.'" stroke="#f3f4f6" stroke-width="1"/>';

                        // Letra
                        $labelR = $rMax + 16;
                        $lx = $cx + $labelR * cos($angle);
                        $ly = $cy + $labelR * sin($angle);
                        $align = $lx > $cx + 5 ? 'start' : ($lx < $cx - 5 ? 'end' : 'middle');
                        $radarHtml .= '<text x="'.$lx.'" y="'.($ly + 4).'" font-size="12" font-weight="bold" fill="#374151" text-anchor="'.$align.'">'.$let.'</text>';

                        // Calcular punto del polígono de resultados
                        $score = max(0, min(9, $kostickScores[$let] ?? 0));
                        $scoreR = ($rMax / 9) * $score;
                        $px = $cx + $scoreR * cos($angle);
                        $py = $cy + $scoreR * sin($angle);
                        $polyPoints[] = "{$px},{$py}";
                    }

                    // 3. Dibujar el Polígono y los Puntos
                    $radarHtml .= '<polygon points="'.implode(' ', $polyPoints).'" fill="rgba(99, 102, 241, 0.15)" stroke="#4f46e5" stroke-width="2" stroke-linejoin="round"/>';

                    foreach ($kostickOrder as $index => $let) {
                        $angle = $index * $angleStep - (M_PI / 2);
                        $score = max(0, min(9, $kostickScores[$let] ?? 0));
                        $scoreR = ($rMax / 9) * $score;
                        $px = $cx + $scoreR * cos($angle);
                        $py = $cy + $scoreR * sin($angle);

                        $radarHtml .= '<circle cx="'.$px.'" cy="'.$py.'" r="3.5" fill="#4f46e5" stroke="#ffffff" stroke-width="1.5"><title>Factor '.$let.': '.$score.'</title></circle>';
                    }

                    $radarHtml .= '</svg></div>';
                    echo $radarHtml;
                @endphp

                <div class="mt-4 flex items-center justify-center gap-4 text-[10px] text-gray-500 font-semibold">
                    <div class="flex items-center gap-1"><div class="w-3 h-0.5 bg-indigo-500"></div> Puntuación</div>
                    <div class="flex items-center gap-1"><div class="w-3 h-0.5 bg-gray-200"></div> Escala (0-9)</div>
                </div>
            </div>

            {{-- B. BARRAS POR ÁREAS DE DESEMPEÑO (Columna Derecha, Ocupa 7/12) --}}
            <div class="lg:col-span-7 bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <h4 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Puntuaciones por Áreas de Desempeño
                </h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    @foreach($kostickAreas as $areaName => $letters)
                        <div class="bg-gray-50 border border-gray-100 rounded-lg p-3">
                            <h5 class="text-xs font-bold text-gray-700 uppercase mb-3">{{ $areaName }}</h5>

                            <div class="space-y-3">
                                @foreach($letters as $let)
                                    @php
                                        $score = $kostickScores[$let] ?? 0;
                                        $percent = ($score / 9) * 100;

                                        // Solución infalible para Colores Dinámicos: Usar códigos HEX
                                        if($score >= 6) {
                                            $barColorHex = '#6366f1'; // Indigo 500
                                            $textColorHex = '#4f46e5'; // Indigo 600
                                        } elseif($score <= 3) {
                                            $barColorHex = '#fbbf24'; // Amber 400
                                            $textColorHex = '#d97706'; // Amber 600
                                        } else {
                                            $barColorHex = '#34d399'; // Emerald 400
                                            $textColorHex = '#059669'; // Emerald 600
                                        }
                                    @endphp
                                    <div>
                                        <div class="flex justify-between items-end mb-1">
                                            <span class="text-[11px] font-bold text-gray-600">Factor {{ $let }}</span>
                                            <span class="text-[10px] font-black" style="color: {{ $textColorHex }};">
                                                {{ $score }} / 9
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                                            {{-- Se aplica background-color inline --}}
                                            <div class="h-1.5 rounded-full transition-all duration-1000" style="width: {{ $percent }}%; background-color: {{ $barColorHex }};"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Leyenda de Colores para las Barras con HEX --}}
                <div class="mt-6 flex justify-center gap-4 text-[10px] text-gray-500 border-t pt-4">
                    <div class="flex items-center gap-1"><div class="w-2.5 h-2.5 rounded-sm" style="background-color: #6366f1;"></div> Alto (6-9)</div>
                    <div class="flex items-center gap-1"><div class="w-2.5 h-2.5 rounded-sm" style="background-color: #34d399;"></div> Promedio (4-5)</div>
                    <div class="flex items-center gap-1"><div class="w-2.5 h-2.5 rounded-sm" style="background-color: #fbbf24;"></div> Bajo (0-3)</div>
                </div>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- VISTA ESPECÍFICA PARA CLEAVER                             --}}
        {{-- ========================================================= --}}
    @elseif($isCleaver && !empty($cleaverPercentiles))

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">

            {{-- Helper para renderizar gráficas de Líneas en SVG --}}
            @php
                $renderDiscLineChart = function($title, $type, $data, $raw_data) {
                    $color = match($type) {
                        'M' => '#3b82f6', // Azul para Motivación
                        'L' => '#ef4444', // Rojo para Presión
                        'T' => '#10b981', // Verde para Normal/Diario
                        default => '#6b7280'
                    };

                    $html = '<div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 flex flex-col items-center h-full">';
                    $html .= '<h4 class="font-bold text-gray-800 mb-4 border-b w-full text-center pb-2">' . $title . '</h4>';

                    // Construcción del SVG
                    $html .= '<div class="w-full max-w-[250px] aspect-square relative">';
                    $html .= '<svg viewBox="0 -10 100 120" class="w-full h-full overflow-visible">';

                    // Líneas guía (Grid 0%, 25%, 50%, 75%, 100%)
                    foreach([0, 25, 50, 75, 100] as $gridY) {
                        $yPos = 100 - $gridY;
                        $html .= '<line x1="0" y1="'.$yPos.'" x2="100" y2="'.$yPos.'" stroke="#f3f4f6" stroke-width="0.5"/>';
                        $html .= '<text x="-5" y="'.$yPos.'" font-size="4" fill="#9ca3af" text-anchor="end" dominant-baseline="middle">'.$gridY.'</text>';
                    }
                    $html .= '<line x1="0" y1="50" x2="100" y2="50" stroke="#d1d5db" stroke-width="1" stroke-dasharray="2,2"/>'; // Línea media

                    // Cálculo de coordenadas
                    $pts = [];
                    $xPositions = ['D' => 10, 'I' => 36, 'S' => 63, 'C' => 90];

                    foreach(['D', 'I', 'S', 'C'] as $let) {
                        $percent = max(0, min(100, $data[$let] ?? 0));
                        $y = 100 - $percent; // Invertir Y para SVG (0 está arriba)
                        $x = $xPositions[$let];
                        $pts[] = "{$x},{$y}";
                    }
                    $pointsStr = implode(' ', $pts);

                    // Dibujar la línea que conecta los puntos
                    $html .= '<polyline points="'.$pointsStr.'" fill="none" stroke="'.$color.'" stroke-width="1.5" stroke-linejoin="round"/>';

                    // Dibujar los puntos y textos
                    foreach(['D', 'I', 'S', 'C'] as $let) {
                        $percent = max(0, min(100, $data[$let] ?? 0));
                        $raw = $raw_data[$let] ?? 0;
                        $y = 100 - $percent;
                        $x = $xPositions[$let];

                        // Círculo del punto
                        $html .= '<circle cx="'.$x.'" cy="'.$y.'" r="2.5" fill="'.$color.'" stroke="#ffffff" stroke-width="0.5"/>';

                        // Texto Percentil arriba del punto
                        $html .= '<text x="'.$x.'" y="'.($y - 4).'" font-size="5" fill="#374151" font-weight="bold" text-anchor="middle">'.$percent.'%</text>';

                        // Etiqueta de la letra (D, I, S, C) en la base
                        $html .= '<text x="'.$x.'" y="110" font-size="6" fill="#4b5563" font-weight="bold" text-anchor="middle">'.$let.'</text>';
                    }

                    $html .= '</svg></div></div>';
                    return $html;
                };
            @endphp

            {{-- Renderizar las 3 Gráficas de Líneas --}}
            {!! $renderDiscLineChart('Motivación (M)', 'M', $cleaverPercentiles['M'], $cleaverRaw['M']) !!}
            {!! $renderDiscLineChart('Bajo Presión (L)', 'L', $cleaverPercentiles['L'], $cleaverRaw['L']) !!}
            {!! $renderDiscLineChart('Diario / Normal (T)', 'T', $cleaverPercentiles['T'], $cleaverRaw['T']) !!}

        </div>

        {{-- ========================================================= --}}
        {{-- SECCIÓN DE INTERPRETACIÓN (D, I, S, C)                    --}}
        {{-- ========================================================= --}}
        <div class="mt-10 bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Interpretación por Dominios
            </h3>

            <div class="space-y-6">
                @php
                    $dominios = [
                        'D' => ['nombre' => 'Dominancia o Empuje', 'desc' => 'Capacidad de liderazgo, de lograr resultados, aceptar retos y tener iniciativa.'],
                        'I' => ['nombre' => 'Influencia o Relación', 'desc' => 'Habilidad para relacionarse con la gente y motivarla.'],
                        'S' => ['nombre' => 'Constancia o Permanencia', 'desc' => 'Capacidad para realizar trabajos de manera continua y rutinaria.'],
                        'C' => ['nombre' => 'Apego o Cumplimiento', 'desc' => 'Habilidad para desarrollar trabajos respetando normas y procedimientos establecidos.']
                    ];
                @endphp

                @foreach($dominios as $letra => $info)
                    @php
                        $valM = $cleaverPercentiles['M'][$letra] ?? 0;
                        $valL = $cleaverPercentiles['L'][$letra] ?? 0;
                        $valT = $cleaverPercentiles['T'][$letra] ?? 0;
                    @endphp

                    <div class="border border-gray-100 rounded-lg p-5 bg-gray-50/50 hover:bg-gray-50 transition-colors">
                        {{-- Cabecera del Dominio --}}
                        <div class="mb-4 pb-3 border-b border-gray-200">
                            <h4 class="text-base font-black text-gray-900">
                                <span class="bg-gray-800 text-white px-2 py-0.5 rounded mr-2">{{ $letra }}</span>
                                {{ $info['nombre'] }}
                            </h4>
                            <p class="text-sm text-gray-500 mt-1">{{ $info['desc'] }}</p>
                        </div>

                        {{-- Valores M y L y sus textos --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Motivación (M) --}}
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-bold uppercase text-blue-600 bg-blue-50 px-2 py-0.5 rounded">Motivación (M)</span>
                                    <span class="text-sm font-bold">{{ $valM }}%</span>
                                </div>
                                <div class="text-xs text-gray-600 bg-white p-3 rounded border border-gray-100 mt-2">
                                    {{-- Aquí entra tu lógica de negocio para M --}}
                                    @if($valM >= 50)
                                        <p><strong>Alta ({{$letra}}+):</strong> Muestra fuerte inclinación hacia esta característica cuando se siente motivado o proyecta su perfil ideal.</p>
                                    @else
                                        <p><strong>Baja ({{$letra}}-):</strong> Disminuye el uso de esta característica como motor principal para alcanzar sus objetivos.</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Bajo Presión (L) --}}
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-bold uppercase text-red-600 bg-red-50 px-2 py-0.5 rounded">Bajo Presión (L)</span>
                                    <span class="text-sm font-bold">{{ $valL }}%</span>
                                </div>
                                <div class="text-xs text-gray-600 bg-white p-3 rounded border border-gray-100 mt-2">
                                    {{-- Aquí entra tu lógica de negocio para L --}}
                                    @if($valL >= 50)
                                        <p><strong>Alta ({{$letra}}+):</strong> Bajo estrés o situaciones antagónicas, tiende a apoyarse marcadamente en esta conducta.</p>
                                    @else
                                        <p><strong>Baja ({{$letra}}-):</strong> Evita utilizar esta conducta cuando se encuentra ante problemas o bajo presión operativa.</p>
                                    @endif
                                </div>
                            </div>

                        </div>

                        {{-- Resumen de Diario (T) --}}
                        <div class="mt-4 pt-3 border-t border-gray-100 flex items-center gap-3">
                            <span class="text-xs font-bold text-gray-500 uppercase">Comportamiento Diario (T):</span>
                            <span class="text-sm font-black text-emerald-600">{{ $valT }}%</span>
                            <span class="text-xs text-gray-500 line-clamp-1 italic">Este es el comportamiento natural que exhibirá día a día en la oficina.</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- VISTA GENÉRICA PARA OTRAS PRUEBAS                         --}}
        {{-- ========================================================= --}}
    @elseif(count($dimensions ?? []) > 0 && isset($results['chart_type']) && $results['chart_type'] != 'radar')
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

</div>
