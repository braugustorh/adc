<x-filament-panels::page>

    @if($showWelcome)
        {{-- PANTALLA DE BIENVENIDA --}}
        <div class="max-w-4xl mx-auto">
            <x-filament::section>
                <div class="text-center py-6">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-3xl mb-4">
                        {{ $testName }}
                    </h2>
                    <div class="prose dark:prose-invert max-w-none text-left mb-8 bg-gray-50 dark:bg-gray-800 p-6 rounded-lg">
                        <p class="font-semibold mb-2">Instrucciones:</p>
                        <div class="whitespace-pre-line text-gray-600 dark:text-gray-300">
                            {!! nl2br(e($instructions)) !!}
                        </div>
                    </div>
                    <x-filament::button wire:click="startTest" size="xl">
                        Comenzar Evaluación
                    </x-filament::button>
                </div>
            </x-filament::section>
        </div>

    @elseif($question)
        {{-- PANTALLA DE PREGUNTA --}}
        <div class="max-w-4xl mx-auto space-y-6">

            {{-- Barra de Progreso --}}
            <div class="space-y-2">
                <div class="flex justify-between items-center text-sm font-medium text-gray-500 dark:text-gray-400">
                    <span>Pregunta {{ $currentQuestionIndex + 1 }} de {{ $totalQuestions }}</span>
                    <div class="flex items-center gap-4">
                        <button
                            x-data
                            x-on:click="$dispatch('open-modal', { id: 'instructions-modal' })"
                            type="button"
                            class="inline-flex items-center text-primary-600 hover:text-primary-800 bg-primary-50 hover:bg-primary-100 px-3 py-1 rounded-full text-xs transition-colors">
                            Ver instrucciones
                        </button>
                        <span class="font-bold text-gray-700 dark:text-gray-300">
                            {{ round(($currentQuestionIndex / $totalQuestions) * 100) }}%
                        </span>
                    </div>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 overflow-hidden">
                    <div class="bg-primary-500 h-2.5 rounded-full transition-all duration-500 ease-out"
                         x-data
                         x-bind:style="'width: ' + ($wire.currentQuestionIndex / {{ $totalQuestions }}) * 100 + '%'">
                    </div>
                </div>
            </div>

            {{-- TARJETA DE PREGUNTA --}}
            <x-filament::section>
                {{-- Encabezado de la pregunta --}}
                <div wire:key="question-header-{{ $currentQuestionIndex }}" class="mb-6">
                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold text-primary-600 bg-primary-50 dark:bg-primary-900/30 uppercase tracking-wide mb-4">
                        Pregunta {{ $currentQuestionIndex + 1 }}
                    </span>
                    <h3 class="text-xl leading-7 font-semibold text-gray-900 dark:text-white">
                        {{ $question->question }}
                    </h3>
                </div>

                {{-- Mensajes de error --}}
                @if ($errors->any())
                    <div class="mb-6 bg-danger-50 dark:bg-danger-900/20 border-l-4 border-danger-500 p-4 rounded-r-md">
                        <p class="text-sm text-danger-700 dark:text-danger-400 font-medium">
                            Debe seleccionar una respuesta para continuar.
                        </p>
                    </div>
                @endif

                {{-- OPCIONES DE RESPUESTA según tipo --}}
                <div wire:key="question-answers-{{ $currentQuestionIndex }}">
                    @switch($question->answer_type_id)

                        {{-- TIPO 2: Radio con tarjetas --}}
                        @case(2)
                            {{-- Test de Moss y Kostik --}}
                            <div class="space-y-3 mt-6" wire:key="q-group-{{ $question->id }}">
                                @foreach($question->answers as $ans)
                                    <label wire:key="ans-{{ $currentQuestionIndex }}-{{ $ans->id }}"
                                           class="flex items-start p-4 border rounded-lg cursor-pointer transition-all
                                                  border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800
                                                  has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50 dark:has-[:checked]:bg-primary-900/20 has-[:checked]:ring-1 has-[:checked]:ring-primary-500">

                                        <div class="me-3 flex items-center h-5 mt-0.5">
                                            <input type="radio"
                                                   wire:model="answers.{{ $question->id }}"
                                                   value="{{ $ans->id }}"
                                                   class="h-4 w-4 text-primary-600 border-gray-300 focus:ring-primary-500">
                                        </div>

                                        <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{ $ans->text }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            @break

                        {{-- TIPO 4: Botones en línea --}}
                        @case(4)
                            {{-- Test de Moss Wess--}}
                            <div class="flex flex-wrap gap-3 justify-center mt-6"
                                 wire:key="q-group-{{ $question->id }}"
                                 x-data="{ selected: @entangle('answers.' . $question->id).live }">

                                @foreach($question->answers as $ans)
                                    <label wire:key="ans-{{ $currentQuestionIndex }}-{{ $ans->id }}" class="cursor-pointer">
                                        <input type="radio"
                                               name="q_{{ $question->id }}"
                                               x-model="selected"
                                               wire:model="answers.{{ $question->id }}"
                                               value="{{ $ans->id }}"
                                               class="sr-only">

                                        <span class="px-6 py-3 rounded-lg border text-sm font-medium transition-all block"
                                              :class="selected == '{{ $ans->id }}'
                                                  ? 'bg-primary-600 text-white border-primary-600 shadow-md'
                                                  : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700'">
                                            {{ $ans->text }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            @error("answers.{$question->id}")
                                <p class="mt-2 text-center text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                            @break

                        {{-- TIPO 5: Cleaver MÁS / MENOS --}}
                        @case(5)
                            {{-- Test de Cleaver --}}
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Palabra</th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-success-600 uppercase tracking-wider">Más (+)</th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-danger-600 uppercase tracking-wider">Menos (-)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($question->answers as $ans)
                                            <tr wire:key="cleaver-{{ $currentQuestionIndex }}-{{ $ans->id }}">
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $ans->text }}
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <input type="radio"
                                                           wire:model="answers.{{ $question->id }}.most"
                                                           value="{{ $ans->id }}"
                                                           class="h-4 w-4 text-success-600 border-gray-300 focus:ring-success-500">
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <input type="radio"
                                                           wire:model="answers.{{ $question->id }}.least"
                                                           value="{{ $ans->id }}"
                                                           class="h-4 w-4 text-danger-600 border-gray-300 focus:ring-danger-500">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-2 text-center space-y-1">
                                    @error("answers.{$question->id}.most")
                                        <p class="text-sm text-danger-600">{{ $message }}</p>
                                    @enderror
                                    @error("answers.{$question->id}.least")
                                        <p class="text-sm text-danger-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            @break

                    @endswitch
                </div>

                {{-- Botón Siguiente --}}
                <div class="mt-6 flex justify-end">
                    <x-filament::button
                        wire:click="nextQuestion"
                        wire:loading.attr="disabled"
                        size="lg">
                        <span wire:loading.remove>
                            {{ $currentQuestionIndex < $totalQuestions - 1 ? 'Siguiente Pregunta' : 'Finalizar Evaluación' }}
                        </span>
                        <span wire:loading>Procesando...</span>
                    </x-filament::button>
                </div>
            </x-filament::section>

        </div>

        {{-- Modal de Instrucciones --}}
        <x-filament::modal id="instructions-modal" width="lg">
            <x-slot name="heading">Instrucciones</x-slot>
            <div class="whitespace-pre-line text-gray-600 dark:text-gray-300 text-sm leading-relaxed">
                {!! nl2br(e($instructions)) !!}
            </div>
        </x-filament::modal>

    @endif

</x-filament-panels::page>
