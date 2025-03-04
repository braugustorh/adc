<x-filament-panels::page>
    @if($show===0)

    <x-filament::section>
        <div class="py-5 px-4">
            <h1 class="text-xl mb-4">
                Hola {{auth()->user()->name}}!
            </h1>
            <p class="text-justify mb-2">
                Como parte de nuestro compromiso con la mejora continua, nos gustaría invitarte a participar en nuestra Encuesta de Salida . Tu perspectiva es invaluable para nosotros, ya que nos permitirá identificar áreas de oportunidad, fortalecer nuestra cultura organizacional y garantizar que continuemos siendo un lugar donde las personas puedan crecer y desarrollarse profesionalmente.
            </p>
            <p class="text-justify mb-2">
                Sabemos que este proceso puede parecer un paso más en medio de tu despedida, pero te aseguramos que tus comentarios son tomados con seriedad y nos ayudarán a construir un futuro mejor para todos. Además, tu retroalimentación será completamente confidencial y utilizada únicamente con fines de mejora interna.
            </p>
            <p class="text-justify mb-2">
                Para acceder a la encuesta, simplemente haz clic en el botón de "Comenzar Encuesta". El proceso no tomará más de 5 minutos y marcará una diferencia significativa para nosotros.
            </p>
            <p class="text-justify mb-2">
                Una vez más, gracias por tu contribución a <strong>adc Administradora de Centrales</strong>. Te deseamos mucho éxito en esta nueva etapa de tu carrera profesional, y esperamos que nuestras trayectorias se crucen nuevamente en el futuro.
            </p>
            <p class="text-justify mb-4">
                Con gratitud,<br>
                ADC Team
            </p>
            <div class="flex justify-center">
                <x-filament::button wire:click="showSurvey"
                                    color="primary"
                                    icon="heroicon-s-check"
                                    icon-alias="heroicon-s-check">
                    Comenzar Encuesta
                </x-filament::button>
            </div>
        </div>


    </x-filament::section>
    @elseif($show===1)
    <x-filament::section>
        <x-slot name="heading">
            <strong>Vamos a comenzar!</strong>
        </x-slot>
        <x-slot name="description">
            <div class="mb-4">
                <p class="text-justify mb-2">
                    A continuación, encontrarás una serie de preguntas relacionadas con tu experiencia en <strong>adc Administradora de Centrales</strong>. Por favor, responde con honestidad y de la manera más detallada posible.
                </p>
                <p class="text-justify mb-2">
                    Recuerda que tus respuestas serán completamente confidenciales y utilizadas únicamente con fines de mejora interna. Si tienes alguna duda o inquietud, no dudes en contactar a nuestro equipo de Recursos Humanos.
                </p>
            </div>
        </x-slot>
        <div class="mt-2">

            <form>
                <div class="py-4">
                    {{$this->form}}
                </div>

                <x-filament::button type="submit"
                                    wire:click="saveSurvey"
                                    icon="heroicon-s-paper-airplane"
                                    icon-position="after"
                                    color="primary">
                    Enviar Encuesta
                </x-filament::button>

            </form>




        </div>

    </x-filament::section>
    @endif
</x-filament-panels::page>
