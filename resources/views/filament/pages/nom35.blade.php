
<x-filament-panels::page>
@push('style')
    <style>
        .card {
            /* Add shadows to create the "card" effect */
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
        }

        /* On mouse-over, add a deeper shadow */
        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }
    </style>

    @endpush
    <!-- Hero -->
    @if($stage==='welcome')
    <div class="relative overflow-hidden before:absolute before:top-0 before:start-1/2
    before:bg-no-repeat before:bg-top before:bg-cover before:size-full before:-z-1
    before:transform before:-translate-x-1/2"
             style="background: url('/img/polygon-bg-element.svg') center/cover no-repeat; position: relative; overflow: hidden;"
             onload="if(window.matchMedia('(prefers-color-scheme: dark)').matches){this.style.backgroundImage='url(/img/polygon-bg-element-dark.svg)';}"
             wire:loading.remove.delay.default="1" wire:target="createRecord"
        >
            <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-10">
                <!-- Announcement Banner -->
                <div class="flex justify-center py-6">
                    <a class="inline-flex items-center gap-x-2 bg-white border border-gray-200 text-sm text-gray-800 p-1 ps-3 rounded-full
                transition hover:border-gray-300 focus:outline-hidden focus:border-gray-300
                dark:bg-neutral-800 dark:border-neutral-700 dark:text-gray-700 dark:hover:border-neutral-600 dark:focus:border-neutral-600" href="#" wire:click="downloadNorma">
                        Norma Oficial Mexicana NOM-035-STPS-2018
                        <span class="py-1.5 px-2.5 inline-flex justify-center items-center gap-x-2 rounded-full bg-gray-200 font-semibold text-sm text-gray-600 dark:bg-neutral-700 dark:text-neutral-400">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </span>
                    </a>
                </div>
                <!-- End Announcement Banner -->

                <!-- Title -->
                <div class="mt-5 max-w-2xl text-center mx-auto py-2">
                    <h1 class="block font-bold text-gray-800 text-3xl md:text-xl-5 lg:text-6xl dark:text-neutral-200">
                        NOM -
                        <span class="bg-clip-text bg-linear-to-tl text-primary-600 text-transparent">035</span>
                    </h1>
                </div>
                <!-- End Title -->

                <div class="mt-5 max-w-3xl text-center mx-auto py-3.5">
                    <p class="text-lg text-gray-600 dark:text-neutral-400">
                        Estás a punto de iniciar un proceso fundamental para el bienestar de todos en nuestra organización y para dar cumplimiento a la NOM-035-STPS-2018. Esta norma tiene como objetivo principal establecer los elementos para identificar, analizar y prevenir los factores de riesgo psicosocial, así como para promover un entorno organizacional favorable en los centros de trabajo.
                    </p>
                </div>

                <!-- Buttons -->
                <div class="mt-8 gap-3 flex justify-center py-2.5">
                    <x-filament::button color="primary"
                                        wire:click="createRecord"
                                        icon="heroicon-o-arrow-small-right"
                                        icon-position="after">
                        Comenzar
                    </x-filament::button>
                    {{--
                    <button type="button" class="relative group p-2 ps-3 inline-flex items-center gap-x-2 text-sm font-mono rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                        $ npm i preline
                        <span class="flex justify-center items-center bg-gray-200 rounded-md size-7 dark:bg-neutral-700 dark:text-neutral-400">
                            <svg class="shrink-0 size-4 group-hover:rotate-6 transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/></svg>
                        </span>
                    </button>
                    --}}
                </div>
                <!-- End Buttons -->

                <div class="mt-5 flex flex-col sm:flex-row justify-center items-center gap-1.5 sm:gap-3">
                    <div class="flex flex-wrap gap-1 sm:gap-3">
                        <span class="text-sm text-gray-600 dark:text-neutral-400">
                            Antes de empezar revisa la</span>
                        <!-- span class="text-sm font-bold text-gray-900 dark:text-white">conoce la</span -->
                    </div>
                    <svg class="hidden sm:block size-5 text-gray-300 dark:text-neutral-600" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M6 13L10 3" stroke="currentColor" stroke-linecap="round"/>
                    </svg>
                    <a class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline focus:outline-hidden focus:underline font-medium dark:text-blue-500" href="#">
                        Guía NOM-035
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </a>
                </div>
            </div>
        </div>
        <div wire:loading.delay.default wire:target="createRecord">

            <x-filament::loading-indicator class="h-40 w-40" />
        </div>
    @endif

    @if($stage==='panel')
        <div class="grid gap-2 grid-cols-1 sm:grid-cols-3 xl:grid-cols-3">
            <div class="sm:col-span-2">
                <x-filament::section class="mb-4">
                    <x-slot name="heading">
                        Determinación
                    </x-slot>
                    <x-slot name="description">
                        Determinación.
                    </x-slot>
                    <div>
                        <p>
                            Actualmente en tu centro de trabajo están registrados <span class="font-semibold">{{ $colabs->count() }}</span> colaboradores, por lo que
                            deberás cumplir los siguientes puntos dentro de la plataforma:
                        </p>
                        @if($level===1)
                            <ul class="space-y-3 mt-2">
                                <li class="flex items-start">
                                    <span>
                                        <x-filament::icon class="h-5 w-5 text-primary-600 dark:text-gray-400" icon="heroicon-o-check-circle" />
                                    </span>
                                    <span class="mx-3">
                                         <strong>Establecer, implantar, mantener y difundir</strong> en el centro de trabajo una <strong>política de
                                            prevención de riesgos psicosociales </strong> que contemple: la prevención de los factores
                                            de riesgo psicosocial; la prevención de la violencia laboral y la promoción de un
                                            entorno organizacional favorable.
                                    </span>
                                </li>

                                <li class="flex items-start">
                                    <span>
                                        <x-filament::icon class="h-5 w-5 text-primary-600 dark:text-gray-400" icon="heroicon-o-check-circle" />
                                    </span>
                                    <span class="mx-3">
                                        Adoptar las medidas para prevenir los factores de riesgo psicosocial,<strong> promover el
                                        entorno organizacional favorable</strong>, así como para atender las prácticas opuestas al
                                        entorno organizacional favorable y los actos de violencia laboral.
                                    </span>
                                </li>

                                <li class="flex items-start">
                                    <span>
                                        <x-filament::icon class="h-5 w-5 text-primary-600 dark:text-gray-400" icon="heroicon-o-check-circle" />
                                    </span>
                                    <span class="mx-3">
                                        <strong>Identificar a los trabajadores</strong> que fueron sujetos a acontecimientos traumáticos
                                        severos durante o con motivo del trabajo y <strong>canalizarlos para su atención.</strong>
                                    </span>
                                </li>

                                <li class="flex items-start">
                                    <span>
                                        <x-filament::icon class="h-5 w-5 text-primary-600 dark:text-gray-400" icon="heroicon-o-check-circle" />
                                    </span>
                                    <span class="mx-3">
                                        Difundir y proporcionar información a los trabajadores
                                    </span>
                                </li>
                            </ul>
                        @elseif($level===2)
                            <ul class="space-y-3 mt-2">
                                <li class="flex items-start">
                                    <span>
                                        <x-filament::icon class="h-5 w-5 text-primary-600 dark:text-gray-400" icon="heroicon-o-check-circle" />
                                    </span>
                                    <span class="mx-3">
                                        Establecer, implantar, mantener y difundir en el centro de trabajo una <strong>política de
                                            prevención de riesgos psicosociales </strong> que contemple: la prevención de los factores
                                            de riesgo psicosocial; la prevención de la violencia laboral y la promoción de un
                                            entorno organizacional favorable.
                                    </span>
                                </li>
                                <li class="flex items-start">
                                    <span>
                                        <x-filament::icon class="h-5 w-5 text-primary-600 dark:text-gray-400" icon="heroicon-o-check-circle" />
                                    </span>
                                    <span class="mx-3">
                                        Identificar y analizar los factores de riesgo psicosocial.
                                    </span>
                                </li>

                                <li class="flex items-start">
                                    <span>
                                        <x-filament::icon class="h-5 w-5 text-primary-600 dark:text-gray-400" icon="heroicon-o-check-circle" />
                                    </span>
                                    <span class="mx-3">
                                        Adoptar las medidas para prevenir los factores de riesgo psicosocial, promover el
                                        entorno organizacional favorable, así como para atender las prácticas opuestas al
                                        entorno organizacional favorable y los actos de violencia laboral.
                                    </span>
                                </li>
                                <li class="flex items-start">
                                    <span>
                                        <x-filament::icon class="h-5 w-5 text-primary-600 dark:text-gray-400" icon="heroicon-o-check-circle" />
                                    </span>
                                    <span class="mx-3">
                                        Adoptar las medidas y acciones de control, cuando el resultado del análisis de los
                                        factores de riesgo psicosocial así lo indique.
                                    </span>
                                </li>

                                <li class="flex items-start">
                                    <span>
                                        <x-filament::icon class="h-5 w-5 text-primary-600 dark:text-gray-400" icon="heroicon-o-check-circle" />
                                    </span>
                                    <span class="mx-3">
                                        Identificar a los trabajadores que fueron sujetos a acontecimientos traumáticos
                                        severos durante o con motivo del trabajo y canalizarlos para su atención.
                                    </span>
                                </li>
                                <li class="flex items-start">
                                    <span>
                                        <x-filament::icon class="h-5 w-5 text-primary-600 dark:text-gray-400" icon="heroicon-o-check-circle" />
                                    </span>
                                    <span class="mx-3">
                                        Practicar exámenes médicos y evaluaciones psicológicas a los trabajadores expuestos a violencia laboral y/o a los factores de
                                        riesgo psicosocial, cuando existan signos - síntomas que denoten alguna alteración a su salud.
                                    </span>
                                </li>

                                <li class="flex items-start">
                                    <span>
                                        <x-filament::icon class="h-5 w-5 text-primary-600 dark:text-gray-400" icon="heroicon-o-check-circle" />
                                    </span>
                                    <span class="mx-3">
                                        Difundir y proporcionar información a los trabajadores
                                    </span>
                                </li>
                                <li class="flex items-start">
                                        <span>
                                            <x-filament::icon class="h-5 w-5 text-primary-600 dark:text-gray-400" icon="heroicon-o-check-circle" />
                                        </span>
                                    <span class="mx-3">
                                            Llevar los registros de: resultados de la identificación y análisis de los factores de
                                        riesgo psicosocial; de las evaluaciones del entorno organizacional; medidas de
                                        control adoptadas, y trabajadores a los que se les practicó exámenes médicos.
                                        </span>
                                </li>
                            </ul>

                        @elseif($level===3)
                            <ul class="space-y-3 mt-2">
                                <li class="flex items-start">
                                    <span>
                                        <x-filament::icon class="h-5 w-5 text-primary-600 dark:text-gray-400" icon="heroicon-o-check-circle" />
                                    </span>
                                    <span class="mx-3">
                                        Establecer, implantar, mantener y difundir en el centro de trabajo una <strong>política de
                                            prevención de riesgos psicosociales </strong> que contemple: la prevención de los factores
                                            de riesgo psicosocial; la prevención de la violencia laboral y la promoción de un
                                            entorno organizacional favorable.
                                    </span>
                                </li>
                                <li class="flex items-start">
                                    <span>
                                        <x-filament::icon class="h-5 w-5 text-primary-600 dark:text-gray-400" icon="heroicon-o-check-circle" />
                                    </span>
                                    <span class="mx-3">
                                        Identificar y analizar los factores de riesgo psicosocial.
                                    </span>
                                </li>
                                <li class="flex items-start">
                                    <span>
                                        <x-filament::icon class="h-5 w-5 text-primary-600 dark:text-gray-400" icon="heroicon-o-check-circle" />
                                    </span>
                                    <span class="mx-3">
                                        Evaluar el entorno organizacional.
                                    </span>
                                </li>

                                <li class="flex items-start">
                                    <span>
                                        <x-filament::icon class="h-5 w-5 text-primary-600 dark:text-gray-400" icon="heroicon-o-check-circle" />
                                    </span>
                                    <span class="mx-3">
                                        Adoptar las medidas para prevenir los factores de riesgo psicosocial, promover el
                                        entorno organizacional favorable, así como para atender las prácticas opuestas al
                                        entorno organizacional favorable y los actos de violencia laboral.
                                    </span>
                                </li>
                                <li class="flex items-start">
                                    <span>
                                        <x-filament::icon class="h-5 w-5 text-primary-600 dark:text-gray-400" icon="heroicon-o-check-circle" />
                                    </span>
                                    <span class="mx-3">
                                        Adoptar las medidas y acciones de control, cuando el resultado del análisis de los
                                        factores de riesgo psicosocial así lo indique.
                                    </span>
                                </li>

                                <li class="flex items-start">
                                    <span>
                                        <x-filament::icon class="h-5 w-5 text-primary-600 dark:text-gray-400" icon="heroicon-o-check-circle" />
                                    </span>
                                    <span class="mx-3">
                                        Identificar a los trabajadores que fueron sujetos a acontecimientos traumáticos
                                        severos durante o con motivo del trabajo y canalizarlos para su atención.
                                    </span>
                                </li>
                                <li class="flex items-start">
                                    <span>
                                        <x-filament::icon class="h-5 w-5 text-primary-600 dark:text-gray-400" icon="heroicon-o-check-circle" />
                                    </span>
                                    <span class="mx-3">
                                        Practicar exámenes médicos y evaluaciones psicológicas a los trabajadores expuestos a violencia laboral y/o a los factores de
                                        riesgo psicosocial, cuando existan signos - síntomas que denoten alguna alteración a su salud.
                                    </span>
                                </li>

                                <li class="flex items-start">
                                    <span>
                                        <x-filament::icon class="h-5 w-5 text-primary-600 dark:text-gray-400" icon="heroicon-o-check-circle" />
                                    </span>
                                    <span class="mx-3">
                                        Difundir y proporcionar información a los trabajadores
                                    </span>
                                </li>
                                <li class="flex items-start">
                                        <span>
                                            <x-filament::icon class="h-5 w-5 text-primary-600 dark:text-gray-400" icon="heroicon-o-check-circle" />
                                        </span>
                                    <span class="mx-3">
                                            Llevar los registros de: resultados de la identificación y análisis de los factores de
                                        riesgo psicosocial; de las evaluaciones del entorno organizacional; medidas de
                                        control adoptadas, y trabajadores a los que se les practicó exámenes médicos.
                                        </span>
                                </li>
                            </ul>
                        @endif
                    </div>
                </x-filament::section>
                <x-filament::section class="mb-4"
                                     collapsible
                                     collapsed>
                    <x-slot name="heading">
                        Identificación de los trabajadores que fueron sujetos a acontecimientos
                        traumáticos severos.
                    </x-slot>
                    <x-slot name="description">
                        Identifica a los colaboradores expuestos a eventos traumáticos severos.
                    </x-slot>
                    <!--
                    <p>Para identificar a los colaboradores tienes dos formas de hacerlo:</p>
                    <br>
                    <div class="flex items-center gap-2">
                    <p>
                        1.- Si usted o el centro de trabajo ya <strong>cuenta con información sobre los trabajadores expuestos a acontecimientos traumáticos severos</strong> (acorde con la NOM-019-STPS-2011), genére un listado de forma manual.
                    </p>


                    </div>
                    -->
                    <br>

                    <p>
                        Aplica el Cuestionario (Guía I) para identificar a los colaboradores que han sido expuestos a eventos traumáticos severos.

                    </p>

                    <br>
                    <span class="text-xs bg-gray-50 dark:bg-gray-800 mt-2 ">
                         <strong>Nota:</strong> El proceso no podrá continuar si la identificación no se ha llevado a cabo.
                    </span>
                    <x-slot name="footerActions">
                        <x-filament::button
                            icon="fas-list-check"
                            wire:click="openTestDialog"
                            :disabled="$activeGuideI">
                            Activar Cuestionario
                        </x-filament::button>
                    </x-slot>

                </x-filament::section>


                <x-filament::section class="mb-4"
                                     collapsible
                                     collapsed
                >
                    <x-slot name="heading">
                        <div class="flex items-center space-x-7">
                        <span class="felx flex-col">Identificación y análisis de los factores de riesgo psicosocial </span>
                        <x-filament::badge size="sm" color="warning" class="text-xs mx-3">
                           C final: <span class="text-xs">{{$calificacion}}</span>
                        </x-filament::badge>
                        </div>

                    </x-slot>
                    <x-slot name="description">
                        Solo los colaboradores identificados responderán la siguiente encuesta.
                    </x-slot>

                    <div>
                        <p>
                            Esta encuesta se aplica a todos los colaboradores del centro de trabajo, independientemente de si han sido identificados o no.
                            La finalidad es evaluar los factores de riesgo psicosocial.
                        </p>
                        <br>
                        <div class="flex items-center gap-2">
                            @if(!$activeGuideII)
                            <x-filament::button
                                color="primary"
                                wire:click="activeRiskFactorTest"
                                icon="fas-list-check">
                                Test
                            </x-filament::button>

                            @else
                                <x-filament::button
                                    color="gray"
                                    disabled
                                    icon="fas-list-check">
                                    Activar Test
                                </x-filament::button>
                            @endif
                                <x-filament::button
                                    class="mx-3"
                                    color="success"
                                    wire:click="openModalResults"
                                    icon="fas-list-check">
                                    Resultados
                                </x-filament::button>
                        </div>
                    </div>

                </x-filament::section>
                @if($level===3)
                    <x-filament::section class="mb-4"
                                         collapsible
                                         collapsed
                    >
                        <x-slot name="heading">
                            Encuesta general de riesgos psicosociales y entorno organizacional.
                        </x-slot>
                        <x-slot name="description">
                            Solo los colaboradores identificados responderán la siguiente encuesta.
                        </x-slot>
                        <div>
                            <p>
                                Esta encuesta se aplica a todos los colaboradores del centro de trabajo, independientemente de si han sido identificados o no.
                                La finalidad es evaluar el entorno organizacional y los factores de riesgo psicosocial.
                            </p>
                            <br>
                            <div class="flex items-center gap-2">
                                <x-filament::button
                                    color="primary"
                                    wire:click="openTypeTest"
                                    icon="fas-list-check"
                                    :disabled="$activeGuideIII">

                                Activar Test
                                </x-filament::button>
                                <x-filament::button
                                    color="info"
                                    wire:click="resultsGuideIII"
                                    icon="fas-list-check"
                                    >
                                    Ver Reporte
                                </x-filament::button>

                            </div>
                        </div>


                    </x-filament::section>
                @endif

            </div>


            <div class="sm:col-span-1 ">
                <x-filament::section
                    class="mb-4"
                    icon="heroicon-s-information-circle"
                >
                    <x-slot name="heading">
                        Información
                    </x-slot>
                    <strong>Sede:</strong>{{$norma->sede->name ?? 'No definido'}} <br>
                    <strong>Colaboradores:</strong> {{ $colabs->count() }} <br>
                    <strong>Muestra:</strong> {{ $muestra??'NA' }} <br>
                    <strong>Inicio del proceso:</strong> {{$this->norma->start_date->format('d/m/y')}} <br>
                    <strong>Fecha límite:</strong> {{$this->norma->start_date->addDays(40)->format('d/m/Y')}} <br>
                    <div class="flex items-center gap-2">
                        <strong>Estado del proceso:</strong>
                        <x-filament::badge size="xs" color="{{$norma->status==='en_progreso'?'primary':'success'}}" class="text-xs">
                            {{ __($norma->status==='iniciado'?'Activa':'En progreso') }}
                        </x-filament::badge><br>
                    </div>
                </x-filament::section>
                <x-filament::section
                    icon="heroicon-s-document-check"
                    icon-color="info"
                    class="mb-4">
                    <x-slot name="heading">
                        Documentación
                    </x-slot>

                    <div class="flex items-center gap-2">
                        <x-filament::icon-button
                            icon="heroicon-s-cloud-arrow-down"
                            wire:click="descargarWord"
                            label="descargar"
                            size="sm"
                        />
                        <span>Política de prevención de riesgos psicosociales</span>
                    </div>
                    <div class="flex items-center gap-2 mt-2">
                        <x-filament::icon-button
                            icon="heroicon-s-cloud-arrow-down"
                            color="success"
                            wire:click="descargarExcel"
                            label="descargar"
                            size="sm"
                        />
                        <span>Plantilla Plan de Acción NOM 035</span>
                    </div>

                </x-filament::section>

                <x-filament::section class="mb-4"
                icon="heroicon-c-chart-bar-square"
                icon-color="success">
                    <x-slot name="heading">
                        Monitoreo
                    </x-slot>
                    <!-- Stats -->
                    <div class="lg:pe-6 xl:pe-12 my-3">
                        <p class="text-3xl font-bold leading-10 text-blue-600">
                            @if($colabResponsesG1>0)
                            {{$colabResponsesG1}} <span class="text-xs">de</span> {{$colabs->count()}}
                            @else
                                <span class="text-xs">Aún no se registran respuestas</span>
                            @endif
                            @if($colabResponsesG1>0 && ($colabResponsesG1 === $colabs->count()))
                            <span class="ms-1 inline-flex items-center gap-x-1 bg-gray-200-300 font-medium text-gray-800 text-xs leading-4 rounded-full py-0.5 px-2 dark:bg-neutral-800 dark:text-gray-500">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#22c55e" viewBox="0 0 16 16">
                              <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"/>
                            </svg>
                            Completado
                          </span>
                            @endif
                        </p>
                        <p class="mt-0.5 sm:mt-0.5 text-sm text-gray-500 dark:text-neutral-500">
                            Han respondido la encuesta de Identificación
                        </p>
                    </div>
                    <!-- End Stats -->
                    <!-- Stats -->
                    <div class="lg:pe-6 xl:pe-12 my-3 mt-3 my-3">
                        <p class="text-3xl font-bold leading-10 text-blue-600">
                            @if($norma->identifiedCollaborators()->where('type_identification','encuesta')->where('norma_id',$norma->id)
                                ->count() > 0)
                                {{$norma->identifiedCollaborators()->where('type_identification','encuesta')->where('norma_id',$norma->id)->count()}}

                                <span class="text-xs">Colaboradores</span>
                            @else
                                <span class="text-xs">Aún nigún colaborador</span>
                            @endif
                        </p>
                        <p class="mt-0.5 sm:mt-0.5 text-sm text-gray-500 dark:text-neutral-500">
                            Han sido identificados.
                        </p>
                    </div>
                    <!-- End Stats -->



                </x-filament::section>
                <x-filament::section class="mb-4"
                                     collapsible
                                     collapsed
                >
                    <x-slot name="heading">
                        Canalización para usuarios identificados.
                    </x-slot>
                    <p>
                        Se han identificado <strong>{{$norma->identifiedCollaborators()->where('type_identification','encuesta')->count()}}</strong> colaboradores que han sido expuestos a eventos traumáticos severos.
                        Descarga el resumen y la canalización de los colaboradores identificados para su atención.
                    </p>
                    <br>
                    <x-slot name="footerActions">
                        <div class="flex items-center gap-2">
                            <x-filament::button
                                color="info"
                                wire:click="downloadPdfShift"
                                icon="fas-file-download">
                                Descargar
                            </x-filament::button>

                        </div>
                    </x-slot>

                </x-filament::section>

            </div>

        </div>
    @endif
    <!-- Zone Modals -->
    <x-filament::modal :close-by-clicking-away="false"
                       id="identify-modal"
                       width="xl">
        <x-slot name="heading">
            Identificación de Colaboradores
        </x-slot>

        <x-slot name="description">
            Identifica a los colaboradores que han sido expuestos a eventos traumáticos severos.
        </x-slot>

        <div class="flex flex-col gap-4">
            <!-- Selector de colaboradores y evento traumático -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <x-filament-forms::field-wrapper.label>
                        Colaborador
                    </x-filament-forms::field-wrapper.label>
                    <x-filament::input.wrapper
                        id="collaborator-select-wrapper">
                        <x-filament::input.select
                            wire:model.live="selectedCollaborator">
                            <option value="">Seleccionar colaborador</option>
                            @foreach($availableColaborators as $collaborator)
                                <option value="{{ $collaborator->id }}">{{$collaborator->name.' '.$collaborator->first_name.' '.$collaborator->second_name }}</option>
                            @endforeach
                        </x-filament::input.select>
                    </x-filament::input.wrapper>
                </div>

                <div>
                    <x-filament-forms::field-wrapper.label>
                        Tipo de evento
                    </x-filament-forms::field-wrapper.label>
                    <x-filament::input.wrapper
                        id="collaborator-event-type-wrapper">
                        <x-filament::input.select
                            wire:model.live="selectedEventType">
                            <option value="">Seleccionar tipo</option>
                            @foreach($eventTypesByCategory as $category => $types)
                                <optgroup label="{{ $category }}">
                                    @foreach($types as $type)
                                        <option value="{{ $type->value }}">{{ $type->label() }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </x-filament::input.select>
                    </x-filament::input.wrapper>
                </div>
            </div>


                <x-filament-forms::field-wrapper.label>
                    Descripción breve (opcional)
                </x-filament-forms::field-wrapper.label>
                <x-filament::input.wrapper class="flex-1" id="event-description-wrapper">
                    <x-filament::input
                        type="text-area"
                        wire:model="eventDescription" placeholder="Breve descripción del evento" />
                </x-filament::input.wrapper>


            <div class="flex items-center gap-2">
                <div class="flex-1">
                    <x-filament-forms::field-wrapper.label>
                        Fecha del evento
                    </x-filament-forms::field-wrapper.label>
                    <x-filament::input.wrapper class="flex-1" id="collaborator-event-date-wrapper">
                        <x-filament::input
                            type="date"
                            wire:model="eventDate" />
                    </x-filament::input.wrapper>
                </div>
                <div class="self-end my-2">
                    <br>
                    <x-filament::button
                        icon="iconpark-add"
                        wire:click="addToIdentifiedList"
                        :disabled="!$selectedCollaborator || !$selectedEventType || !$eventDate"
                    >
                        Agregar
                    </x-filament::button>
                </div>


            </div>

            <!-- Lista de colaboradores identificados -->
            @if(count($identifiedColaborators) > 0)
                <div class="border rounded-lg p-4 bg-gray-50 dark:bg-gray-800 mt-2">
                    <h3 class="text-sm font-medium mb-2">Colaboradores identificados ({{ count($identifiedColaborators) }})</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                            <tr>
                                <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Colaborador</th>
                                <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Tipo de evento</th>
                                <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Fecha</th>
                                <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400"></th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($identifiedColaborators as $index => $identified)
                                <tr>
                                    <td class="px-2 py-2 text-sm">{{ $identified['name'] }}</td>
                                    <td class="px-2 py-2 text-sm">{{ $identified['event_type_label']??null }}</td>
                                    <td class="px-2 py-2 text-sm">{{ \Carbon\Carbon::parse($identified['event_date']??null)->format('d/m/Y') }}</td>
                                    <td class="px-2 py-2 text-sm">
                                        <x-filament::icon-button
                                            icon="heroicon-o-x-mark"
                                            color="danger"
                                            wire:click="removeFromIdentifiedList({{ $index }})"
                                            size="sm"
                                        />
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        <x-slot name="footerActions">
            <x-filament::button
                wire:click="closeIdentificationModal"
                color="gray"
            >
                Cancelar
            </x-filament::button>

            <x-filament::button
                wire:click="saveIdentifiedColaborators"
                color="primary"
                :disabled="count($identifiedColaborators) === 0"
            >
                Guardar
            </x-filament::button>
        </x-slot>
    </x-filament::modal>

    <x-filament::modal :close-by-clicking-away="false"
                       id="test-dialog">
        <x-filament::modal.heading>
          ⚠️  Atención!!!
        </x-filament::modal.heading>
        <div>
            <p>Estás a punto de enviar el cuestionario para identificar aquellos colaboradores que han sido expuesto eventos traumáticos severos.</p>
            <br>
            <p>Estás seguro de continuar?</p>
            <br>
            <x-filament::button
                wire:click="closeTestDialog"
                color="danger"
            >
                Cancelar
            </x-filament::button>
            <x-filament::button
                wire:click="sendTest"
                color="success"
            >
                Enviar Test
            </x-filament::button>
        </div>
    </x-filament::modal>
    <x-filament::modal :close-by-clicking-away="false"
                       id="modal-result"
                        width="4xl">
        <x-filament::modal.heading>
           Guía de Referencia II: Resultados de la Identificación y Análisis de los Factores de Riesgo Psicosocial
        </x-filament::modal.heading>

        <h3><strong>Resultados del Cuestionario</strong></h3>
        <div style="background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;">
            <p>Puntos Obtenidos:<strong>{{$calificacion}}</strong> </p>
            <p>Calificación Final: <strong>{{$resultCuestionario}} </strong> </p>
            <p>Tests Realizados: <strong>{{$responsesTotalG2}}</strong></p>
        </div>
        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border border-gray-400 w-full text-center">
                <thead>
                <tr>
                    <th class="bg-gray-200 font-bold border border-gray-400 p-2">Calificación Final</th>
                    <th style="background-color: #dc2626; color: white;" class="font-bold border border-gray-400 p-2">Muy alto</th>
                    <th style="background-color: #ea580c; color: white;" class="font-bold border border-gray-400 p-2">Alto</th>
                    <th style="background-color: #facc15; color: black;" class="font-bold border border-gray-400 p-2">Medio</th>
                    <th style="background-color: #22c55e; color: white;" class="font-bold border border-gray-400 p-2">Bajo</th>
                    <th style="background-color: #3b82f6; color: white;" class="font-bold border border-gray-400 p-2">Nulo o despreciable</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="font-bold border border-gray-400 p-2">No. de Trabajadores</td>
                    <td class="border border-gray-400 p-2">{{$generalResults['very_high']??null}}</td>
                    <td class="border border-gray-400 p-2">{{$generalResults['high']??null}}</td>
                    <td class="border border-gray-400 p-2">{{$generalResults['medium']??null}}</td>
                    <td class="border border-gray-400 p-2">{{$generalResults['low']??null}}</td>
                    <td class="border border-gray-400 p-2">{{$generalResults['null']??null}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        {{-- poner un linea de separación --}}
        <!-- hr class="my-4 border-gray-300 dark:border-gray-600" -->
        <h3><strong>Calificación de la Categoría</strong></h3>
        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border border-gray-400 w-full text-center">
                <thead>
                <tr>
                    <th class="bg-gray-200 font-bold border border-gray-400 p-2">Calificación Categoria</th>
                    <th style="background-color: #dc2626; color: white;" class="font-bold border border-gray-400 p-2">Muy alto</th>
                    <th style="background-color: #ea580c; color: white;" class="font-bold border border-gray-400 p-2">Alto</th>
                    <th style="background-color: #facc15; color: black;" class="font-bold border border-gray-400 p-2">Medio</th>
                    <th style="background-color: #22c55e; color: white;" class="font-bold border border-gray-400 p-2">Bajo</th>
                    <th style="background-color: #3b82f6; color: white;" class="font-bold border border-gray-400 p-2">Nulo o despreciable</th>
                </tr>
                </thead>
                <tbody>
                @foreach($generalResultsCategory as $categoria)
                    <tr>
                        <td class="font-bold border border-gray-400 p-2">{{ $categoria['nombre'] }}</td>
                        <td class="border border-gray-400 p-2">{{ $categoria['very_high'] ?? 0 }}</td>
                        <td class="border border-gray-400 p-2">{{ $categoria['high'] ?? 0 }}</td>
                        <td class="border border-gray-400 p-2">{{ $categoria['medium'] ?? 0 }}</td>
                        <td class="border border-gray-400 p-2">{{ $categoria['low'] ?? 0 }}</td>
                        <td class="border border-gray-400 p-2">{{ $categoria['null'] ?? 0 }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <h3><strong>Resultados del Dominio</strong></h3>
        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border border-gray-400 w-full text-center">
                <thead>
                <tr>
                    <th class="bg-gray-200 font-bold border border-gray-400 p-2">Calificación de Dominio</th>
                    <th style="background-color: #dc2626; color: white;" class="font-bold border border-gray-400 p-2">Muy alto</th>
                    <th style="background-color: #ea580c; color: white;" class="font-bold border border-gray-400 p-2">Alto</th>
                    <th style="background-color: #facc15; color: black;" class="font-bold border border-gray-400 p-2">Medio</th>
                    <th style="background-color: #22c55e; color: white;" class="font-bold border border-gray-400 p-2">Bajo</th>
                    <th style="background-color: #3b82f6; color: white;" class="font-bold border border-gray-400 p-2">Nulo o despreciable</th>
                </tr>
                </thead>
                <tbody>
                @foreach($domainResults as $dominio)
                    <tr>
                        <td class="font-bold border border-gray-400 p-2">{{ $dominio['nombre'] }}</td>
                        <td class="border border-gray-400 p-2">{{ $dominio['very_high'] ?? 0 }}</td>
                        <td class="border border-gray-400 p-2">{{ $dominio['high'] ?? 0 }}</td>
                        <td class="border border-gray-400 p-2">{{ $dominio['medium'] ?? 0 }}</td>
                        <td class="border border-gray-400 p-2">{{ $dominio['low'] ?? 0 }}</td>
                        <td class="border border-gray-400 p-2">{{ $dominio['null'] ?? 0 }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>


        <x-slot name="footerActions">
            <x-filament::button
                wire:click="closeModalResult"
                color="gray"
            >
                Cancelar
            </x-filament::button>

            <x-filament::button
                color="primary"
                wire:click="reportGeneralGIIDownload"
            >
                Descargar Reporte General
            </x-filament::button>
            <x-filament::button
                color="primary"
               wire:click="reportIndividualGIIDownload"
            >
                Descargar Reporte Individual
            </x-filament::button>
            <x-filament::button
                color="primary"
                wire:click="reportCoverGII"
            >
                Descargar Carátula
            </x-filament::button>
        </x-slot>
    </x-filament::modal>
    <x-filament::modal id="type-test-modal" >
        <x-filament::modal.heading>
            Seleccione el método de testeo
        </x-filament::modal.heading>
        <!-- aqui el usuario deberá de elegir si realiza el test al total de los colaboradores o solo a la muestra -->
        <div class="flex flex-col gap-4">
            <p>Seleccione el método de testeo que desea aplicar:</p>
            <div class="flex items-center gap-4">
                <x-filament::button
                    color="primary"
                    wire:click="activeGuiaIII(0)"
                    icon="fas-list-check"
                    :disabled="$activeGuideIII" >

                    Aplicar al total de colaboradores
                </x-filament::button>
                <x-filament::button
                    color="info"
                    disabled="{{$activeGuideIII}}"
                    :disabled="$activeGuideIII"
                    wire:click="activeGuiaIII(1)"
                    icon="fas-list-check">
                    Aplicar a {{$muestraGuideIII}} colaboradores.
                </x-filament::button>
            </div>
            <p class="text-xs text-gray-500 mt-2">
                <strong>Nota:</strong> Si selecciona <strong>"Aplicar a todos los colaboradores"</strong>, el cuestionario se enviará a todos los colaboradores del centro de trabajo.
                Si selecciona <strong>"Aplicar a la muestra seleccionada"</strong>, solo se enviará a la muestra calculada de colaboradores de manera aleatoria.
            </p>
        </div>
        <x-slot name="footerActions">
            <x-filament::button
                wire:click="closeTypeTest"
                color="gray"
            >
                Cerrar
            </x-filament::button>

        </x-slot>

    </x-filament::modal>

    <x-filament::modal :close-by-clicking-away="false"
                       id="test-results-guia-iii"
    width="4xl">
        <x-filament::modal.heading>
            Resultados de la Guía III: Encuesta general de riesgos psicosociales y entorno organizacional
        </x-filament::modal.heading>

        <div style="background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;">
            <p>Puntos Obtenidos: <strong>{{$calificacionG3}}</strong></p>
            <p>Determinación: <strong>{{$resultCuestionarioG3}}</strong></p>
            <p>Tests Realizados: <strong>{{$totalResponsesG3}}</strong>
            <p>Tests Restantes: <strong>{{$colabs->count() - $totalResponsesG3}}</strong></p>
        </div>
        <div class="overflow-x-auto">
            <x-slot name="heading">
                Resultados Generales
            </x-slot>
            <section class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 mb-4">
                <header class="fi-section-header flex flex-col gap-3 px-6 py-4">
                    Resultados Generales
                </header>
                <div class="fi-section-content-ctn border-t border-gray-200 dark:border-white/10">
                   <div class="fi-section-content p-6">


                    <table class="table-auto border-collapse border border-gray-400 w-full text-center">
                        <thead>
                        <tr>
                            <th class="bg-gray-200 font-bold border border-gray-400 p-2">Calificación Final</th>
                            <th style="background-color: #dc2626; color: white;" class="font-bold border border-gray-400 p-2">Muy alto</th>
                            <th style="background-color: #ea580c; color: white;" class="font-bold border border-gray-400 p-2">Alto</th>
                            <th style="background-color: #facc15; color: black;" class="font-bold border border-gray-400 p-2">Medio</th>
                            <th style="background-color: #22c55e; color: white;" class="font-bold border border-gray-400 p-2">Bajo</th>
                            <th style="background-color: #3b82f6; color: white;" class="font-bold border border-gray-400 p-2">Nulo o despreciable</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="font-bold border border-gray-400 p-2">No. de Trabajadores</td>
                            <td class="border border-gray-400 p-2">{{$generalResultsGuideIII['very_high']??null}}</td>
                            <td class="border border-gray-400 p-2">{{$generalResultsGuideIII['high']??null}}</td>
                            <td class="border border-gray-400 p-2">{{$generalResultsGuideIII['medium']??null}}</td>
                            <td class="border border-gray-400 p-2">{{$generalResultsGuideIII['low']??null}}</td>
                            <td class="border border-gray-400 p-2">{{$generalResultsGuideIII['null']??null}}</td>
                        </tr>
                        </tbody>
                    </table>
                   </div>
                </div>
            </section>
        </div>

        <h3><strong>Calificación de la Categoría</strong></h3>
        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border border-gray-400 w-full text-center">
                <thead>
                <tr>
                    <th class="bg-gray-200 font-bold border border-gray-400 p-2">Calificación Categoria</th>
                    <th style="background-color: #dc2626; color: white;" class="font-bold border border-gray-400 p-2">Muy alto</th>
                    <th style="background-color: #ea580c; color: white;" class="font-bold border border-gray-400 p-2">Alto</th>
                    <th style="background-color: #facc15; color: black;" class="font-bold border border-gray-400 p-2">Medio</th>
                    <th style="background-color: #22c55e; color: white;" class="font-bold border border-gray-400 p-2">Bajo</th>
                    <th style="background-color: #3b82f6; color: white;" class="font-bold border border-gray-400 p-2">Nulo o despreciable</th>
                </tr>
                </thead>
                <tbody>
                @foreach($generalResultsGuideIIICategory as $categoria)
                    <tr>
                        <td class="font-bold border border-gray-400 p-2">{{ $categoria['nombre'] }}</td>
                        <td class="border border-gray-400 p-2">{{ $categoria['very_high'] ?? 0 }}</td>
                        <td class="border border-gray-400 p-2">{{ $categoria['high'] ?? 0 }}</td>
                        <td class="border border-gray-400 p-2">{{ $categoria['medium'] ?? 0 }}</td>
                        <td class="border border-gray-400 p-2">{{ $categoria['low'] ?? 0 }}</td>
                        <td class="border border-gray-400 p-2">{{ $categoria['null'] ?? 0 }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <h3><strong>Resultados del Dominio</strong></h3>
        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border border-gray-400 w-full text-center">
                <thead>
                <tr>
                    <th class="bg-gray-200 font-bold border border-gray-400 p-2">Calificación Categoria</th>
                    <th style="background-color: #dc2626; color: white;" class="font-bold border border-gray-400 p-2">Muy alto</th>
                    <th style="background-color: #ea580c; color: white;" class="font-bold border border-gray-400 p-2">Alto</th>
                    <th style="background-color: #facc15; color: black;" class="font-bold border border-gray-400 p-2">Medio</th>
                    <th style="background-color: #22c55e; color: white;" class="font-bold border border-gray-400 p-2">Bajo</th>
                    <th style="background-color: #3b82f6; color: white;" class="font-bold border border-gray-400 p-2">Nulo o despreciable</th>
                </tr>
                </thead>
                <tbody>
                @foreach($generalDomainResultsGuideIII as $dominio)
                    <tr>
                        <td class="font-bold border border-gray-400 p-2">{{ $dominio['nombre'] }}</td>
                        <td class="border border-gray-400 p-2">{{ $dominio['very_high'] ?? 0 }}</td>
                        <td class="border border-gray-400 p-2">{{ $dominio['high'] ?? 0 }}</td>
                        <td class="border border-gray-400 p-2">{{ $dominio['medium'] ?? 0 }}</td>
                        <td class="border border-gray-400 p-2">{{ $dominio['low'] ?? 0 }}</td>
                        <td class="border border-gray-400 p-2">{{ $dominio['null'] ?? 0 }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <x-slot name="footerActions">
            <x-filament::button
                wire:click="closeTestResultsGuideIII"          color="gray"
            >
                Cerrar
            </x-filament::button>
        </x-slot>


    </x-filament::modal>

</x-filament-panels::page>
