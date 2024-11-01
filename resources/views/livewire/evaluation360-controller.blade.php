<div>
    {{-- Stop trying to control. --}}
    @if($first===true)
        <div class="container my-2">

            <div class="p-5 text-center bg-body-tertiary rounded-3">
                <!-- svg class="bi mt-4 mb-3" style="color: var(--bs-indigo);" width="100" height="100"><use xlink:href="#bootstrap"/></svg -->
                <img src="img/360/logo_header_home.png" class="bi mt-2 mb-3">
                <!-- h1 class="text-body-emphasis">Evaluación 360</h1 -->
            </div>
            <main class="container mb-0">
                <div class="my-3 p-3 bg-body rounded shadow-sm">
                    <h5 class="border-bottom pb-2 mb-0">Hola {{auth()->user()->name.' '.auth()->user()->primer_apellido}}</h5>
                    </p>
                    <div class="text-body-secondary pt-3">
                        <h6>¡Bienvenido a la Evaluación 360! </h6>
                        <p>
                            La Evaluación 360 es una herramienta que te permitirá recibir retroalimentación de tus compañeros de trabajo, superiores y subordinados, con el objetivo de identificar tus fortalezas y áreas de oportunidad para tu desarrollo profesional.
                            En esta ocasión evaluarás a <strong>{{$fullName}}</strong>
                        </p>
                        <h6>Antes de comenzar la evaluación, es importante que leas las siguientes instrucciones.</h6>
                        <p>
                            Recuerda que toda la información proporcionada en esta evaluación será tratada de manera confidencial y utilizada únicamente con fines de desarrollo profesional. Agradecemos tu sinceridad y confianza.
                        </p>
                        <h6 class="pb-2 mb-0">Instrucciones:</h6>
                        <ol>
                            <li type="disc">Lee cada pregunta cuidadosamente. Asegúrate de entender completamente lo que se te pregunta. </li>
                            <li type="disc">Selecciona la opción que mejor represente tu opinión. No hay respuestas correctas o incorrectas, simplemente queremos conocer tu punto de vista.</li>
                            <li type="disc">Sé honesto y sincero. Tus respuestas nos ayudarán a mejorar.</li>
                            <li type="disc">Si no estás seguro, elige la opción que más se acerque a tu opinión.</li>
                        </ol>
                    </div>
                    <small class="d-block text-end mt-3">
                        <!-- a href="#">All updates</a -->
                    </small>
                </div>
                <div class="d-flex justify-content-end gap-2 mb-5">
                    <button class="btn btn-outline-secondary btn-lg px-4 rounded-pill" type="button" onClick="window.location.href='dashboard/panel360'">
                        Cancelar
                    </button>

                        <button wire:click="startEvaluation" wire:loading.attr="disabled" class="d-inline-flex align-items-center btn btn-success btn-lg px-4 rounded-pill" type="button">
                            <i wire:loading.class.remove="d-none" class="fas fa-spinner fa-pulse d-none"></i>
                            Comenzar la Evaluación
                            <svg class="bi ms-2" width="24" height="24"><use xlink:href="#arrow-right-short"/></svg>

                        </button>

                </div>
            </main>
        </div>
    @elseif($final===true)
        <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
            <symbol id="check2-circle" viewBox="0 0 16 16">
                <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"></path>
                <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"></path>
            </symbol>
        </svg>
        <main>

            <div class="container my-5">
                <div class="position-relative p-5 text-center text-muted bg-body border border-dashed rounded-5">
                    <button type="button" class="position-absolute top-0 end-0 p-3 m-3 btn-close bg-secondary bg-opacity-10 rounded-pill" aria-label="Close"  onClick="window.close();">
                    </button>
                    <svg class="bi mt-5 mb-3" width="48" height="48"><use xlink:href="#check2-circle"/></svg>
                    <h1 class="text-body-emphasis">¡Muchas gracias por tu participación!</h1>

                    <p class="col-lg-6 mx-auto mb-4">
                        Tus comentarios son un regalo invaluable para nosotros. Estamos comprometidos a utilizar esta información para crear un entorno de trabajo aún más positivo y colaborativo.
                        <br>

                    </p>
                    <button class="btn btn-danger px-5 mb-5" type="button"  onClick="window.location.href='dashboard/panel360'">
                        Salir
                    </button>
                </div>
            </div>

        </main>
    @else
    <main class="container">
                    <!-- img class="me-3" src="../assets/brand/bootstrap-logo-white.svg" alt="" width="48" height="38" -->

                @foreach($preguntas as $pregunta)
                    <div wire:loading.delay.shortest wire:loading.class="d-none" class="d-flex align-items-center p-3 my-3 bg-body rounded shadow-sm mt-3">
                        <i class="fas fa-chevron-right fa-lg mx-2"></i>
                        <div class="lh-1" >
                            <h1 class="h5 mb-0 lh-1">{{ $pregunta->question }}</h1>
                        </div>
                    </div>
                    <div class="my-3 p-3 bg-body rounded shadow-sm" wire:loading.delay.shortest wire:loading.class="d-none" >
                        <h6 class="border-bottom pb-2 mb-0">Respuesta</h6>
                        <div class="d-flex text-body-secondary pt-3">
                            <div class="likert">
                                @foreach(range(1, 5) as $valor)
                                    <label>
                                        <input type="radio" wire:model="respuestas.{{ $pregunta->id }}" value="{{ $valor }}" required>
                                        <span id="{{ $valor == 1 ? 'md' : ($valor == 2 ? 'ad' : ($valor == 3 ? 'ns' : ($valor == 4 ? 'ac' : 'ma'))) }}">
                                        <i class="fas fa-{{ $valor == 1 ? 'angry' : ($valor == 2 ? 'frown' : ($valor == 3 ? 'meh' : ($valor == 4 ? 'smile' : 'laugh-beam'))) }} fa-lg color-success"></i>
                                        <div class="likert-text mt-2">{{ $valor == 1 ? 'Muy en Desacuerdo' : ($valor == 2 ? 'Algo en Desacuerdo' : ($valor == 3 ? 'Ni de acuerdo, ni en desacuerdo' : ($valor == 4 ? 'Algo de Acuerdo' : 'Muy de Acuerdo'))) }}</div>
                                        </span>
                                    </label>

                                @endforeach
                            </div>
                        </div>
                        <small class="d-block text-end mt-3">
                            <!-- a href="#">All updates</a -->
                        </small>
                    </div>


                @if($loop->last)
                <div class="d-flex justify-content-between p-3 my-3 bg-body rounded shadow-sm mt-3" wire:loading.delay.shortest wire:loading.class="d-none">
                    <div class="mt-auto p-2">
                        @if($competenciaActual->id!==1)
                            <button wire:click="backCompetence({{ $competenciaActual->id }})"
                                    class="btn btn-warning hover:text-blue-700 font-semibold"
                                    onclick="scrollToTop()">
                                Anterior
                            </button>
                        @endif

                    </div>

                    <div class="mt-auto p-2">
                        <h1 class="h6 mb-0 lh-1">
                            {{$competenciaActual->id}}/{{$competenciasCount}}
                        </h1>
                    </div>
                    <div class="mt-auto p-2">
                        @if($competenciaActual->id!==$competenciasCount)
                            <button wire:click="selectCompetencia({{ $competenciaActual->id + 1 }})"
                                    class="btn btn-warning hover:text-blue-700 font-semibold"
                                    onclick="scrollToTop()">
                                Siguiente
                            </button>
                        @else
                            <button  wire:click="save" wire:loading.attr="disabled" wire:target="save"
                                    class="btn btn-success hover:text-blue-700 font-semibold">
                                <i wire:loading.class.remove="d-none" wire:target="save" class="fas fa-spinner fa-pulse d-none"></i>
                                Finalizar
                            </button>
                        @endif

                    </div>
                </div>
                @endif
        @endforeach
    </main>
        <div class="row text-center">
            <div class="col-4 text-center">
            </div>
            <div class="col-4 text-center d-none" wire:loading.delay.shortest wire:loading.class.remove="d-none">
                <img src="img/360/load.gif" class="rounded" alt="...">
            </div>
            <div class="col-4 text-center" >
            </div>
        </div>
    @endif


</div>
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('saveResponses', function (event) {
            localStorage.setItem('respuestas', JSON.stringify(event.responses));
        });

        Livewire.on('loadResponses', function () {
            let responses = JSON.parse(localStorage.getItem('respuestas'));
            if (responses) {
                @this.set('respuestas', responses);

            }
        });

        Livewire.on('retrieveResponses', function () {
            let responses = JSON.parse(localStorage.getItem('respuestas'));
            if (responses) {
                @this.set('respuestas', responses);
            }
        });

        Livewire.on('clearResponses', function () {
            localStorage.removeItem('respuestas');
        });
    });
</script>
