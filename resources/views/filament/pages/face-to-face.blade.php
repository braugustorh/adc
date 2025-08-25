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
                                <option value="" hidden="">Selecciona un colaborador</option>
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
                                    @if($userToEvaluated->profile_photo)
                                    <x-filament::avatar
                                        src="{{ $userToEvaluated->profile_photo ? url('storage/'.$userToEvaluated->profile_photo) : asset('path/to/default-avatar.png') }}"
                                        alt="{{ $userToEvaluated->name }}"
                                        size="h-16"/>
                                    @else
                                        <x-filament-panels::avatar.user size="lg" :user="$userToEvaluated" />
                                    @endif
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

    @if($showResults)
        <div class="grid grid-cols-6 gap-4" wire:loading.remove> <!-- Contenedor grid con 6 columnas -->
            <div class="col-span-5">
                    @if($existEvaluations)
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
                        <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                            <tr>
                                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                    Año
                                </th>
                                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                    Última Evaluación
                                </th>
                                <th class="px-3 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                    Estatus
                                </th>
                                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                    Inicial
                                </th>
                                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                    Seguimiento
                                </th>

                                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                    Cierre
                                </th>

                                <th class="px-3 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                    Acciones
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($evaluations as $eval)
                                <tr>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <span class="text-sm font-bold text-gray-800 dark:text-neutral-200">
                                            {{date_format( $eval->updated_at, 'Y')}}
                                        </span>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <span class="text-sm font-bold text-gray-800 dark:text-neutral-200">
                                            {{date_format( $eval->updated_at, 'd/m/Y')}}
                                        </span>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <x-filament::badge
                                            color="{{$eval->status == 'in_progress' ? 'warning' : 'success'}}"
                                            class="text-xs">
                                            {{$eval->status == 'in_progress' ? 'En Proceso' : 'Finalizada'}}
                                        </x-filament::badge>
                                    </td>
                                    <td class="p-2 my-16 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <div class="flex flex-col justify-center px-3">

                                            @if(!$eval->initial)
                                                <x-heroicon-m-document-minus class="w-8 h-8 justify-center opacity-70 cursor-pointer" color="gray" />
                                            @else
                                                <x-heroicon-m-document-check class="w-8 h-8 align-items-center cursor-pointer
                                            " style="color:green" color="success" />
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-2 my-16 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <div class="flex flex-col justify-center px-3">

                                            @if(!$eval->follow_up)
                                                <x-heroicon-m-document-minus class="w-8 h-8 justify-center opacity-70" color="gray" />
                                            @else
                                                <x-heroicon-m-document-check class="w-8 h-8 align-items-center
                                            " style="color:green" color="success" />
                                            @endif
                                        </div>
                                    </td>

                                    <td class="p-2 my-16 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <div class="flex flex-col justify-center px-3">

                                        @if(!$eval->final)
                                            <x-heroicon-m-document-minus class="w-8 h-8 justify-center opacity-70" color="gray" />
                                        @else
                                            <x-heroicon-m-document-check class="w-8 h-8 align-items-center
                                            " style="color:green" color="success" />
                                        @endif
                                        </div>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <x-filament::button
                                            wire:click="editEvaluation({{$eval->id}})"
                                            tag="a"
                                            class="cursor-pointer"
                                            icon="heroicon-s-arrow-right-start-on-rectangle"
                                            icon-position="after"
                                            disabled="{{!($eval->status==='in_progress')}}"
                                        >
                                            {{ __('Registrar') }}
                                        </x-filament::button>
                                    </td>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="mt-6 flex justify-center gap-x-4">
                            <x-filament::button

                                wire:click="clearResults"

                                color="gray"
                            >
                                {{ __('Cancelar') }}
                            </x-filament::button>
                            <x-filament::button
                                wire:click="addTheme"
                                tag="a"
                                class="cursor-pointer"
                                icon="heroicon-c-calendar-date-range">
                                {{ __('Años Anteriores') }}
                            </x-filament::button>
                        </div>
                    </x-filament::section>
                    @elseif(!$hideCreate)
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
                    </x-filament::section>
                    @endif


            </div>
        </div>
    @endif
    @if($showEvaluation)
        <!-- Contenedor grid con 6 columnas -->
            <div class="col-span-5">
                <x-filament::section id="ficha" collapsed> <!-- Sección abarcando 5/6 -->
                    <x-slot name="heading">
                        <strong>Cultura</strong>
                    </x-slot>
                    <x-slot name="description">
                        Es una conversación en donde el jefe retroalimenta a su colaborador acerca de su comportamiento en la organización y su impacto positivo o negativo en los resultados.
                        {{-- Content --}}
                    </x-slot>
                    <x-slot name="headerEnd">

                    </x-slot>
                        <div class="p-4 sm:p-10 text-center overflow-y-auto">
                            {{$this->formCultura}}
                        </div>

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
                            <div class="mt-3 text-lg/6 font-medium sm:text-sm/6 text-center">
                                Evaluación 360
                            </div>
                            @if($evaluation360)
                                <div class="mt-3 text-3xl/8 font-semibold sm:text-2xl/8 text-center">
                                    {{$evaluation360}}
                                </div>
                                <div class="mt-3 text-sm/6 sm:text-xs/6 text-center">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        {{$campaignName}}
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
                            <div class="mt-3 text-lg/6 font-medium sm:text-sm/6 text-center">
                                Potencial
                            </div>
                            @if($evaluationPotential)
                                <div class="mt-3 text-3xl/8 font-semibold sm:text-2xl/8 text-center">
                                    {{$evaluationPotential}}
                                </div>
                                <div class="mt-3 text-sm/6 sm:text-xs/6 text-center">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        Vencimiento:{{$this->vencimiento??'No existe'}}
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
                        {{-- $this->formDesempeno --}}
                        <h2 class="py-3 font-bold uppercase">Seguimiento a indicadores</h2>
                        <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                            <tr>
                                <th class="px-3 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Indicadores</th>
                                @foreach (['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] as $month)
                                    <th class="px-3 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        {{ $month }}
                                    </th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($indicatorProgresses as $indicator)
                                <tr>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <div class="flex px-2 py-1">
                                            <div class="flex flex-col justify-center px-3">
                                                <h6 class="mb-0 text-sm leading-normal"> {{ $indicator->name }}</h6> <!-- Usa el nombre del indicador -->
                                            </div>
                                        </div>
                                    </td>
                                    @php
                                        $months = array_fill(1, 12, 0); // Inicializa un arreglo con 12 meses
                                        foreach ($indicator->progresses as $progress) {
                                            $months[$progress->month] = $progress->progress_value; // Llena el mes con su valor
                                        }
                                    @endphp
                                    @foreach ($months as $progressValue)
                                        <td class="px-3 py-3 font-bold text-center align-middle bg-transparent border-b border-gray-200 shadow-none text-xs border-b-solid tracking-none whitespace-nowrap text-slate-500">
                                            @if($progressValue > 0)
                                                @php
                                                    $rangeCategory = $this->evaluateProgressRange($progressValue, $indicator->indicatorRanges);
                                                    $badgeClass = [
                                                                    'excellent' => 'success',
                                                                    'satisfactory' => 'info',
                                                                    'unsatisfactory' => 'warning'
                                                                ][$rangeCategory];

                                                @endphp
                                                <x-filament::badge color="{{$badgeClass}}">
                                                    {{ $progressValue }}
                                                </x-filament::badge>
                                            @else
                                                {{ $progressValue }}
                                            @endif

                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>

                    <div class="p-4 sm:p-10 text-center overflow-y-auto">
                        {{$this->formDesempeno}}
                    </div>

                </x-filament::section>
            </div>
            <x-filament::section id="desarrollo" collapsible collapsed>
                <x-slot name="heading">
                    <strong>Desarrollo</strong>
                </x-slot>
                <x-slot name="description">
                    Es una revisión sobre las competencias y conocimientos que el colaborador necesita para el cumplimiento de sus objetivos.
                    Es importante que se establezca el compromiso recíproco en los planes de desarrollo individuales que se puedan generar de esta conversación y realizar los ajustes pertinentes y necesarios.
                </x-slot>
                <div class="p-4 sm:p-10 text-center overflow-y-auto">
                    {{$this->formRetroalimentacion}}
                <br>
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
            <x-filament::section>
                <x-filament::button
                    wire:click="clearResults"
                    color="gray">
                    {{ __('Regresar') }}
                </x-filament::button>

                    <x-filament::button
                        icon="heroicon-m-sparkles"
                        wire:click="saveEvaluation"
                        icon-position="after">
                     {{ __(' Guardar Avance') }}

                    </x-filament::button>
                <x-filament::button
                    icon="heroicon-s-document-magnifying-glass"
                    color="info"
                    wire:click="generatePdf"
                    icon-position="after">
                    {{ __('Generar Formato') }}

                </x-filament::button>
                <x-filament::button
                    icon="heroicon-c-check-circle"
                    color="success"
                    wire:click="finishEvaluation"
                    icon-position="after">
                    {{ __('Terminar Face to Face') }}
                </x-filament::button>


            </x-filament::section>


    @endif

    <x-filament::modal id="add-theme-modal"  width="2xl">

            <x-slot name="heading">
                <h2 class="text-lg font-bold text-gray-800 dark:text-neutral-200">
                    {{ __('Registros de Años Anteriores') }}
                </h2>
            </x-slot>

        <x-filament::section>


            <div class="p-4 sm:p-10 text-center overflow-y-auto">
                <!-- Icon -->
                <span class="mb-4 inline-flex justify-center items-center size-[46px] rounded-full border-4 border-green-50 bg-green-100 text-green-500 dark:bg-green-700 dark:border-green-600 dark:text-green-100">
                  <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z"/>
                  </svg>
                </span>
                <!-- End Icon -->

                <h3 id="hs-task-created-alert-label" class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">
                    No se han encontrado registros de años anteriores para este usuario
                </h3>
            </div>
        </x-filament::section>

    </x-filament::modal>

</x-filament-panels::page>
