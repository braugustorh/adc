<x-filament-panels::page>
    @if($page === 'welcome')
        <x-filament::section>
            <div class="mb-4">
                <p class="text-xl font-bold text-gray-900 dark:text-white">
                    Bienvenido(a) a la Encuesta de Clima Laboral
                </p>
                <br>
                <p><strong>Estimado(a) colaborador(a),</strong></p>
                <br>
                <p>
                    En nuestra organización nos interesa conocer tu percepción sobre el clima laboral.
                    Esta encuesta nos ayudará a identificar áreas de oportunidad y mejorar el ambiente de trabajo.
                </p>
                <br>
                <p>
                    <strong>¿Qué debes saber antes de responder?</strong>
                </p>

                <ul class="list-disc list-inside mt-2">
                    <li>Tus respuestas son confidenciales y anónimas.</li>
                    <li>No hay respuestas correctas o incorrectas, lo importante es tu opinión sincera.</li>
                    <li>La encuesta te tomará aproximadamente 15-20 minutos.</li>
                    <li>Lee cuidadosamente cada pregunta y selecciona la respuesta que mejor refleje tu opinión.</li>
                </ul>

                <br>
                <p>
                    <strong>Instrucciones:</strong>
                </p>

                <ul class="list-disc list-inside mt-2">
                    <li>Cada pregunta debe ser contestada en una escala del 1 al 5.</li>
                    <li>1 = Nunca, 2 = Casi nunca, 3 = Algunas veces, 4 = Casi siempre, 5 = Siempre</li>
                    <li>Debes responder todas las preguntas de cada sección para continuar.</li>
                </ul>
            </div>
            <div class="flex justify-end">
                <x-filament::button
                    color="primary"
                    class="mt-4"
                    wire:click="startSurvey"
                >
                    Comenzar Encuesta
                </x-filament::button>
            </div>
        </x-filament::section>
    @elseif($page === 'survey')
        <x-filament::section>
            <x-slot name="heading">
                {{ $sections[$currentSection]['title'] }} ({{ $currentSection }}/{{ $totalSections }})
            </x-slot>
            <x-slot name="description">
                {{$sections[$currentSection]['description'] ?? ''}}
            </x-slot>

            <div class="space-y-6">
                @foreach($sectionQuestions[$currentSection] ?? [] as $question)
                    @if($sections[$currentSection]['type'] === 'likert')
                        {{-- Preguntas tipo Likert --}}

                            <div class="border-b pb-4">
                                <div class="flex items-center">
                                    <span class="mb-4">{{$question['order'].'.-'}}</span>
                                    <h3 class="font-semibold text-base mb-4">

                                        {!!$question['question'] !!}

                                    </h3>
                                </div>
                                <div class="flex items-center space-x-7">
                                    @foreach($likertOptionsDisplay as $key => $label)
                                        <label class="flex flex-col items-center mx-3">
                                            <span class="text-sm mb-2">{{ $label }}</span>
                                            <br>
                                            <x-filament::input.radio
                                                wire:model.live="responses.{{ $question['id'] }}"
                                                value="{{ in_array($question['order'], $itemScoreMappings['inverse'])
                                                                          ? $likertOptionsValues['inverse'][$key]
                                                                          : $likertOptionsValues['normal'][$key] }}"
                                            />
                                        </label>
                                    @endforeach
                                </div>

                                @error("responses.{$question['id']}")
                                    <span class="text-danger-600 text-sm block mt-1">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                    @elseif($sections[$currentSection]['type'] === 'yes_no')
                        {{-- Preguntas tipo SI/NO --}}
                        @if($currentSection === '7-preview')
                            <div class="border-b pb-4">
                                <h3 class="font-semibold text-base mb-4">
                                    {!! $question['question'] !!}
                                </h3>

                                <div class="flex space-x-6 mt-3">
                                    @foreach($yesNoOptions as $value => $label)
                                        <label class="flex items-center mx-3">
                                            <x-filament::input.radio
                                                wire:model.live="section6Preview"
                                                value="{{ $value }}"
                                            />
                                            <span>{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>

                                @error('section6Preview')
                                <span class="text-danger-600 text-sm block mt-1">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        @elseif($currentSection === '8-preview')
                            <div class="border-b pb-4">
                                <h3 class="font-semibold text-base mb-4">
                                    {!! $question['question'] !!}
                                </h3>

                                <div class="flex space-x-6 mt-3">
                                    @foreach($yesNoOptions as $value => $label)
                                        <label class="flex items-center mx-3">
                                            <x-filament::input.radio
                                                wire:model.live="section7Preview"
                                                value="{{ $value }}"
                                            />
                                            <span>{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>

                                @error('section7Preview')
                                    <span class="text-danger-600 text-sm block mt-1">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>

            <div class="flex justify-between mt-6">
                <x-filament::button
                    color="gray"
                    wire:click="previousSection"
                >
                    Anterior
                </x-filament::button>

                <x-filament::button
                    color="primary"
                    wire:click="nextSection"
                >
                    Siguiente
                </x-filament::button>
            </div>
        </x-filament::section>
    @elseif($page === 'finish')
        <x-filament::section>
            <div class="mb-4">
                <p class="text-xl font-bold text-gray-900 dark:text-white">
                    ¡Gracias por completar la encuesta!
                </p>
                <br>
                <p>
                    {{ $finishMessage }}
                </p>
                <br>
                <p>
                    Tus respuestas son valiosas para nosotros y nos ayudarán a tomar acciones para mejorar.
                </p>
            </div>
            <div class="flex justify-end">
                <x-filament::button
                    color="primary"
                    class="mt-4"
                    icon="fas-check"
                    wire:loading.attr="disabled"
                    wire:target="finish"
                    wire:click="finish">
                    <div class="flex items-center space-x-4">
                        <x-filament::icon
                            icon="fas-spinner"
                            wire:loading.class="animate-spin"
                            class="h-4 w-4 hidden display-inline"
                            wire:loading.remove.class="hidden"
                            wire:target="finish"/>
                        <span> Finalizar </span>
                    </div>
                </x-filament::button>
            </div>
        </x-filament::section>
    @endif

</x-filament-panels::page>
