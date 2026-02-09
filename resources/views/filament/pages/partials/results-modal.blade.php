<div class="space-y-4">
    {{-- ENCABEZADO: Nombre de la Prueba y Resumen --}}
    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
        <h3 class="text-lg font-bold text-primary-600">{{ $results['test_name'] }}</h3>
        <p class="text-sm text-gray-600 mt-1">{{ $results['summary'] ?? 'Sin resumen disponible' }}</p>

        @if(isset($results['range']))
            <div class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                Rango: {{ $results['range'] }}
            </div>
        @endif
    </div>

    {{-- CUERPO: Dependiendo del tipo de gráfica/datos --}}

    {{-- CASO 1: BARRAS O CATEGORÍAS (Moss Wess, Cleaver) --}}
    @if(isset($results['chart_type']) && ($results['chart_type'] == 'bar' || $results['chart_type'] == 'bar_qualitative' || $results['chart_type'] == 'bar_grouped'))
        <div class="grid grid-cols-1 gap-4">
            {{-- Si tiene dimensiones complejas (Moss Wess) --}}
            @if(isset($results['dimensions']))
                @foreach($results['dimensions'] as $dimName => $data)
                    <div class="flex items-center justify-between p-2 border-b border-gray-100 last:border-0">
                        <span class="font-medium text-gray-700 w-1/3">{{ $dimName }}</span>

                        {{-- Barra Visual --}}
                        <div class="flex-1 mx-4 h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-{{ $data['color'] ?? 'primary' }}-500"
                                 style="width: {{ min($data['score'] * 3, 100) }}%"></div> {{-- Multiplicador x3 solo visual --}}
                        </div>

                        <div class="text-right w-1/4">
                            <span class="block text-xs text-gray-500">Puntos: {{ $data['score'] }}</span>
                            <span class="block text-sm font-bold text-{{ $data['color'] ?? 'gray' }}-600">
                                {{ $data['category'] }}
                            </span>
                        </div>
                    </div>
                @endforeach

                {{-- Si son scores simples (Cleaver D,I,S,C o Moss Dimensiones) --}}
            @elseif(isset($results['scores']))
                @foreach($results['scores'] as $label => $val)
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600 w-8">{{ $label }}</span>
                        <div class="flex-1 mx-2">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                {{-- Si es array (Moss con %) o valor directo --}}
                                @php $pct = is_array($val) ? $val['percent'] : ($val * 5); @endphp
                                <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ min($pct, 100) }}%"></div>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-gray-900">{{ is_array($val) ? $val['score'] : $val }}</span>
                    </div>
                @endforeach
            @endif
        </div>
    @endif

    {{-- CASO 2: RADAR / KOSTICK (Solo mostramos lista por ahora, la gráfica va en PDF) --}}
    @if(isset($results['chart_type']) && $results['chart_type'] == 'radar')
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-center">
            @foreach($results['scores'] as $letter => $val)
                <div class="p-2 bg-white border rounded shadow-sm">
                    <div class="text-xs text-gray-500 font-bold">{{ $letter }}</div>
                    <div class="text-lg font-bold text-indigo-600">{{ $val }}</div>
                </div>
            @endforeach
        </div>
        <p class="text-xs text-gray-400 text-center mt-2">
            * Descarga el PDF para ver la Gráfica de Radar completa.
        </p>
    @endif
</div>
