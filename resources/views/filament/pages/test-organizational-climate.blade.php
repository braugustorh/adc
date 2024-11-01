<style>
    .bg-yellow-100 {
        --tw-bg-opacity: 1;
        background-color: rgb(254 249 195 / var(--tw-bg-opacity));
    }
    .text-yellow-500 {
        --tw-text-opacity: 1;
        color: rgb(234 179 8 / var(--tw-text-opacity));
    }
    .border-yellow-200 {
        --tw-border-opacity: 1;
        border-color: rgb(254 240 138 / var(--tw-border-opacity));
    }

    .border-yellow-50 {
        --tw-border-opacity: 1;
        border-color: rgb(254 252 232 / var(--tw-border-opacity));
    }

    .border-yellow-500 {
        --tw-border-opacity: 1;
        border-color: rgb(234 179 8 / var(--tw-border-opacity));
    }

    .border-yellow-600 {
        --tw-border-opacity: 1;
        border-color: rgb(202 138 4 / var(--tw-border-opacity));

    .mb-4 {
            margin-bottom: 1rem;
        }
    }
</style>
<x-filament-panels::page>
    @if(!$disabledArea)
    <div class="mt-6 relative isolate px-6 pt-14 lg:px-8">
        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
        <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">

            <div class="mt-2 text-justify">
                <h1 class="text-balance text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">¡Bienvenido(a) al Test de Clima Organizacional!</h1>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    Este cuestionario es una oportunidad para que compartas tu perspectiva sobre el ambiente de trabajo en nuestra empresa. Tu opinión es fundamental para mejorar y fortalecer nuestro entorno laboral, buscando siempre el bienestar y el crecimiento de todos los colaboradores.
                </p>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    Te invitamos a responder de manera sincera, ya que tus respuestas serán clave para identificar áreas de mejora y continuar construyendo un equipo más unido y eficiente.
                </p>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    ¡Gracias por tu valiosa participación!
                </p>
                <div class="mt-6 flex items-center justify-center gap-x-6">
                    <x-filament::modal>
                        <x-slot name="trigger">
                            <x-filament::button>
                                Open modal
                            </x-filament::button>
                        </x-slot>
                        <x-slot name="heading">
                            Instrucciones
                        </x-slot>

                    </x-filament::modal>
                    <x-filament::button icon="heroicon-m-sparkles"
                                        href="{{route('clima-organizacional.index',[
                                                        'user' => \Crypt::encryptString($user),
                                                        'campaign' => \Crypt::encryptString($campaigns->id)
                                        ])}}"
                                        tag="a"
                                        target="_blank"
                                        wire:click="$set('disabledButton', true)"
                                        disabled="{{$disabledButton===true?'true':null}}">
                        Comenzar!
                    </x-filament::button>

                </div>
            </div>
        </div>
        <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
            <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
    </div>
    @else
    <div class="relative flex flex-col bg-white shadow-lg rounded-xl dark:bg-neutral-900">
        <div class="p-4 sm:p-10 text-center overflow-y-auto">
            <!-- Icon -->
            <span class="mb-4 inline-flex justify-center items-center size-[62px] rounded-full border-4 border-yellow-50 bg-yellow-100 text-yellow-500 dark:bg-yellow-700 dark:border-yellow-600 dark:text-yellow-100">
          <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="62" height="62" fill="currentColor" viewBox="-4.1 -2.2 24 24">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
          </svg>
        </span>
            <!-- End Icon -->

            <h3 id="hs-sign-out-alert-label" class="mb-2 text-2xl font-bold text-gray-800 dark:text-neutral-200">
                Ups!
            </h3>
            <p class="text-gray-500 dark:text-neutral-500">
                <h3>La Evaluación de Clima Organizacional ya fue contestada o no existe una campaña activa para su Sede.</h3>
            </p>


        </div>
    </div>
    @endif


</x-filament-panels::page>
