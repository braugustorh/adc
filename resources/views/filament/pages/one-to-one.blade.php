<x-filament-panels::page xmlns:x-filament="http://www.w3.org/1999/html">
    <x-filament::section>
    <div class="fi-section-content-ctn">
        <div class="fi-section-content p-2">
            <div class="grid gap-2 grid-cols-1 sm:grid-cols-3 xl:grid-cols-3">
                <div>
                    <label for="_user">Selecciona el colaborador a evaluar</label>
                    <x-filament::input.wrapper class="mt-2">
                        <x-filament::input.select
                            id="_user"
                            wire:model.change="user">
                            <option value="" hidden="true">Selecciona un colaborador</option>
                            @foreach($users as $us)
                                <option value="{{$us->id}}">{{$us->name.' '.$us->first_name.' '.$us->last_name}}</option>
                            @endforeach
                        </x-filament::input.select>

                    </x-filament::input.wrapper>


                </div>
                <div class="content-center gap-4">
                    <div>
                        <x-filament::loading-indicator class="h-7 w-7 invisible" wire:loading.class.remove="invisible " wire:target="user"/>
                    </div>
                </div>
                <div>
                    @if($show)
                        <div class="flex items-center gap-x-3">
                            <div class="shrink-0">
                                <x-filament::avatar
                                    src="{{ $userToEvaluated->profile_photo ? url('storage/'.$userToEvaluated->profile_photo) : asset('path/to/default-avatar.png') }}"
                                    alt="{{ $userToEvaluated->name }}"
                                    size="h-16"/>
                            </div>

                            <div class="grow">
                                <h1 class="text-lg font-medium text-gray-800 dark:text-neutral-200">
                                    {{$userToEvaluated->name.' '.$userToEvaluated->first_name.' '.$userToEvaluated->last_name}}
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-neutral-400">
                                    {{$userToEvaluated->position->name}}
                                </p>
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
    </x-filament::section>

    @if($show)
        <div class="grid grid-cols-6 gap-4"> <!-- Contenedor grid con 6 columnas -->
            <div class="col-span-5">
                <x-filament::section collapsible
                                     id="inicio"
                                     collapsed> <!-- Sección abarcando 5/6 -->
                    <x-slot name="heading">
                        <strong>Tipo de Evaluación</strong>
                    </x-slot>
                    <x-slot name="description">
                        Selecciona si es una evaluación inicial, una evaluación de seguimiento o una evaluación de cierre.
                        {{-- Content --}}
                    </x-slot>
                    <x-slot name="headerEnd">

                    </x-slot>

                    @if($themes->count()>0)


                    @else
                        <div class="p-4 sm:p-10 text-center overflow-y-auto">
                            <!-- Icon -->
                            <span class="mb-4 inline-flex justify-center items-center size-[46px] rounded-full border-4 border-green-50 bg-green-100 text-green-500 dark:bg-green-700 dark:border-green-600 dark:text-green-100">
                              <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z"/>
                              </svg>
                            </span>
                            <!-- End Icon -->

                            <h3 id="hs-task-created-alert-label" class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">
                                No se han encontrado evaluaciones
                            </h3>
                            <p class="text-gray-500 dark:text-neutral-500">
                                Deseas crear una evaluación para este colaborador?
                            </p>

                            <div class="mt-6 flex justify-center gap-x-4">
                                <x-filament::button
                                    wire:click="createOneToOneEvaluation"
                                    tag="a"
                                    class="cursor-pointer"
                                    icon="heroicon-m-sparkles">
                                    {{ __('Crear Evaluación') }}
                                </x-filament::button>
                            </div>
                        </div>
                    @endif

                </x-filament::section>
            </div>
        </div>
    @endif
    @if($showEvaluation)
        <div class="grid grid-cols-6 gap-4"> <!-- Contenedor grid con 6 columnas -->
            <div class="col-span-5">
                <x-filament::section collapsible
                                     id="ficha"
                                     collapsed> <!-- Sección abarcando 5/6 -->
                    <x-slot name="heading">
                        <strong>Cultura</strong>
                    </x-slot>
                    <x-slot name="description">
                        Es una conversación en donde el jefe retroalimenta a su colaborador acerca de su comportamiento en la organización y su impacto positivo o negativo en los resultados.
                        {{-- Content --}}
                    </x-slot>
                    <x-slot name="headerEnd">

                    </x-slot>

                    @if($themes->count()>0)
                        @dump($themes)

                    @else
                        <div class="p-4 sm:p-10 text-center overflow-y-auto">
                            {{$this->formCultura}}
                        </div>
                    @endif

                </x-filament::section>
            </div>
            <div class="col-span-1">
                <x-filament::section id="desempeno" collapsible collapsed>
                    <x-slot name="heading">
                        <strong>Desempeño</strong>
                    </x-slot>
                    <x-slot name="description">
                        Es una revisión sobre el desempeño del colaborador.
                        {{-- Content --}}
                    </x-slot>
                    <div class="grid gap-2 grid-cols-1 sm:grid-cols-3 xl:grid-cols-3 mb-6 mx-20">
                        <div>
                            <div class="mt-3 text-lg/6 font-medium sm:text-sm/6 text-center">Evaluación 360</div>
                            @if($evaluation360)
                                <div class="mt-3 text-3xl/8 font-semibold sm:text-2xl/8 text-center">{{$evaluation360}}</div>
                                <div class="mt-3 text-sm/6 sm:text-xs/6 text-center">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        +4.5% campaña pasada
                                    </span>
                                </div>
                            @else
                                <div class="mt-3 text-sm/6 sm:text-xs/6 text-center">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        No existe evaluación
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="mt-3 text-lg/6 font-medium sm:text-sm/6 text-center">Pontencial</div>
                            @if($evaluationPotential)
                                <div class="mt-3 text-3xl/8 font-semibold sm:text-2xl/8 text-center">{{$evaluationPotential}}</div>
                                <div class="mt-3 text-sm/6 sm:text-xs/6 text-center">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                Última evaluación cargada
                            </span>

                                </div>
                            @else
                                <div class="mt-3 text-sm/6 sm:text-xs/6 text-center">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                No existe psicometría
                            </span>

                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="mt-3 text-lg/6 font-medium sm:text-sm/6 text-center">Resultado 9 box</div>
                            @if($quadrant)
                                <div class="mt-3 text-3xl/8 font-semibold sm:text-2xl/8 text-center">Caja: {{$quadrant}}</div> <!-- Aquí va el resultado de la evaluación -->
                                <div class="mt-3 text-sm/6 sm:text-xs/6 text-center">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{$titles[$quadrant]}}
                            </span>

                                </div>
                            @else
                                <div class="mt-3 text-sm/6 sm:text-xs/6 text-center">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                No existe resultado 9 box
                            </span>

                                </div>
                            @endif

                        </div>
                    </div>
                    <hr/>

                    <div class="p-4 sm:p-10 text-center overflow-y-auto">
                        {{ $this->formDesempeno }}
                    </div>

                </x-filament::section>
            </div>
            <x-filament::section id="desarrollo" collapsible collapsed>
                <x-slot name="heading">
                    <strong>Desarrollo</strong>
                </x-slot>
                <x-slot name="description">
                    Es una revisión sobre las competencias y conocimientos que el colaborador necesita para el cumplimiento de sus FC´s.
                    Es importante que se establezca el compromiso recíproco en los planes de desarrollo individuales que se puedan generar de esta conversación y realizar los ajustes pertinentes y necesarios.
                </x-slot>
                <div class="p-4 sm:p-10 text-center overflow-y-auto">
                    {{ $this->formDesarrollo }}
                </div>

            </x-filament::section>
            <x-filament::section id="topics" collapsible collapsed>
                <x-slot name="heading">
                    <strong>Asuntos Varios</strong>
                </x-slot>
                <x-slot name="description">
                    Es una conversación en donde se revisan temas de motivación, satisfacción, calidad de vida, ambiente, preocupaciones y retroalimentación del desempeño del jefe como líder de equipo
                </x-slot>
                <div class="p-4 sm:p-10 text-center overflow-y-auto">
                    {{ $this->formAsuntos }}
                </div>

            </x-filament::section>
        </div>
    @endif

    <x-filament::modal id="add-theme-modal"  width="2xl">

            <x-slot name="heading">

            </x-slot>

        <x-filament::section>



        </x-filament::section>

    </x-filament::modal>





</x-filament-panels::page>
