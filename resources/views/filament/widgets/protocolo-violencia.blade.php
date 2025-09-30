<x-filament-widgets::widget>
    <x-filament::section>
        <div class="p-6">
            <div class="flex flex-col items-center text-center space-y-4">
                <div class="w-16 h-16 bg-red-100 dark:bg-red-900/20 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Protocolo contra la Violencia Laboral
                </h3>

                <p class="text-sm text-gray-600 dark:text-gray-400 max-w-md">
                    Tu bienestar y seguridad en el trabajo son nuestra prioridad. Conoce el protocolo y repórtanos cualquier situación.
                </p>

                <x-filament::button
                    id="open-protocol-modal"
                    color="primary"
                    size="lg"
                    wire:click="openProtocolModal"
                >
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </x-slot>
                    Protocolo para prevenir y erradicar la violencia en tu centro de trabajo
                </x-filament::button>
            </div>
        </div>
    </x-filament::section>

    <!-- Modal del Protocolo -->
    <x-filament::modal id="modal-protocol" width="lg">
        <x-slot name="heading">
            Protocolo contra la Violencia Laboral
        </x-slot>

                <div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                            Protocolo contra la Violencia Laboral
                        </h3>
                        <div class="mt-4">
                            <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 p-4 mb-4">
                                <div class="flex">
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700 dark:text-blue-300 mt-2">
                                            <strong>Tu voz importa.</strong> Denunciar actos de violencia, hostigamiento o acoso laboral es fundamental para crear un ambiente de trabajo seguro y respetuoso para todos. No estás solo/a en esto, y tu denuncia será tratada con la máxima confidencialidad y seriedad.
                                        </p>
                                        <p class="text-sm text-blue-700 dark:text-blue-300 mt-2">
                                            <strong>Cero tolerancia.</strong> Nuestra empresa tiene una política de cero tolerancia hacia cualquier forma de violencia o acoso. Estamos comprometidos a erradicar estos comportamientos y proteger la dignidad de cada colaborador.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--
                            <p class="text-sm text-gray-600 dark:text-gray-400 text-left">
                                En este documento encontrarás información detallada sobre:
                            </p>
                            <ul class="text-sm text-gray-600 dark:text-gray-400 text-left mt-2 space-y-1">
                                <li>• Definiciones de violencia laboral, hostigamiento y acoso</li>
                                <li>• Procedimientos para presentar una queja</li>
                                <li>• Medidas de protección y apoyo</li>
                                <li>• Proceso de investigación</li>
                                <li>• Sanciones correspondientes</li>
                            </ul>
                            -->
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                    <x-filament::button
                        wire:click="downloadProtocol"
                        target="_blank"
                        color="primary"
                        class="sm:col-start-2"
                    >
                        <x-slot name="icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </x-slot>
                        Descargar y Conoce el Protocolo
                    </x-filament::button>

                    <x-filament::button
                        id="open-complaint-form"
                        color="danger"
                        wire:click="openComplaintModal"
                        class="mt-3 sm:mt-0 sm:col-start-1"
                    >
                        <x-slot name="icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </x-slot>
                        Presentar Queja
                    </x-filament::button>
                </div>

                <div class="absolute top-0 right-0 pt-4 pr-4">
                    <button id="close-protocol-modal" type="button" class="bg-white dark:bg-gray-800 rounded-md text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="sr-only">Cerrar</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>


    </x-filament::modal>

    <!-- Modal del Formulario de Queja -->
    <x-filament::modal id="modal-complaint" width="xl">
        <x-slot name="heading">
            FORMATO PARA LA PRESENTACIÓN DE QUEJA DE VIOLENCIA LABORAL, HOSTIGAMIENTO Y ACOSO SEXUAL
        </x-slot>
        <form id="complaint-form" method="POST" wire:submit="sendComplaint" class="space-y-6">
            @csrf
            <div class="space-y-6">
                <!--
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ciudad</label>
                            <input type="text" name="ciudad" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                            <input type="text" name="estado" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha</label>
                            <input type="date" name="fecha_presentacion" value="{{ date('Y-m-d') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                    </div>
                </div>
                -->
                <!-- Datos de la persona que presenta la queja -->
                <div>
                    <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-3">DATOS DE LA PERSONA QUE PRESENTA LA QUEJA</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                            <input type="text" wire:model="quejosoNombre" name="quejoso_nombre" value="{{ auth()->user()->name }} {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Puesto</label>
                            <input type="text" wire:model="quejosoPuesto" name="quejoso_puesto" value="{{ auth()->user()->position->name ?? '' }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono</label>
                            <input type="tel" wire:model="quejosoTelefono" name="quejoso_telefono" value="{{ auth()->user()->phone }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Área</label>
                            <input type="text" wire:model="quejosoArea" name="quejoso_area" value="{{ auth()->user()->department->name ?? '' }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jefe/a Inmediato</label>
                            <input type="text" wire:model="quejosoJefe" name="quejoso_jefe_inmediato" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                    </div>
                </div>

                <!-- Datos de la persona sobre la que se presenta la queja -->
                <div>
                    <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-3">DATOS DE LA PERSONA SOBRE LA QUE SE PRESENTA LA QUEJA</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                            <input type="text" wire:model="acusadoNombre" name="acusado_nombre" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Puesto</label>
                            <input type="text" wire:model="acusadoPuesto" name="acusado_puesto" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono</label>
                            <input type="tel" wire:model="acusadoTelefono" name="acusado_telefono" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Área</label>
                            <input type="text" wire:model="acusadoArea" name="acusado_area" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jefe/a Inmediato</label>
                            <input type="text" wire:model="acusadoJefe"  name="acusado_jefe_inmediato" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                    </div>
                </div>

                <!-- Declaración de hechos -->
                <div>
                    <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-3">DECLARACIÓN DE HECHOS</h4>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha en que ocurrió</label>
                                <input type="date" wire:model="fechaOcurrencia" name="fecha_ocurrencia" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hora en que ocurrió</label>
                                <input type="time" wire:model="horaOcurrencia" name="hora_ocurrencia" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lugar en que ocurrió</label>
                                <input type="text" wire:model="lugarOcurrencia" name="lugar_ocurrencia" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Frecuencia (si fue una sola vez o varias veces)</label>
                            <textarea name="frecuencia" wire:model="frecuencia" rows="2" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">¿Cómo se manifestó el hostigamiento o acoso sexual?</label>
                            <textarea name="manifestacion_hostigamiento" wire:model="manifestacionHostigamiento" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Actitud de la persona que le hostigó/acosó</label>
                            <textarea name="actitud_hostigador" wire:model="actitudHostigador" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">¿Cómo reaccionó inmediatamente Usted ante la situación?</label>
                            <textarea name="reaccion_inmediata" wire:model="reaccionInmediata" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mencione si su caso es aislado o conoce de otros</label>
                            <textarea name="caso_aislado" wire:model="casoAislado" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">¿Cómo le afectó el hostigamiento emocionalmente?</label>
                            <textarea name="afectacion_emocional" wire:model="afectacionEmocional" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">¿Cómo le afectó en su rendimiento personal durante el tiempo en que se presentó el hostigamiento?</label>
                            <textarea name="afectacion_rendimiento" wire:model="afectacionRendimiento" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">¿Considera que el hostigamiento que sufrió fue causado por alguna situación en particular? ¿Cuál?</label>
                            <textarea name="causa_particular" wire:model="causaParticular" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">¿Cómo percibió Usted el ambiente laboral durante el hostigamiento y qué diferencia observa actualmente?</label>
                            <textarea name="percepcion_ambiente_laboral" wire:model="percepcionAmbienteLaboral" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">¿Considera que el hostigamiento que sufrió le afectará a largo plazo a nivel personal, emocional, social y laboral?</label>
                            <textarea name="afectacion_largo_plazo" wire:model="afectacionLargoPlazo" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">¿Cree necesario acudir con una persona experta para que, con su colaboración, pueda tratarse el daño psicológico que causó el acto de violencia laboral?</label>
                            <textarea name="necesita_apoyo_psicologico" wire:model="necesitaApoyoPsicologico" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-filament::button
                    type="button"
                    class="mx-3"
                    wire:click="closeComplaintModal"
                    id="close-complaint-modal"
                    color="gray"
                    outlined
                >
                    Cancelar
                </x-filament::button>

                <x-filament::button
                    type="submit"
                    color="danger"
                >
                    <x-slot name="icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </x-slot>
                    Enviar Queja
                </x-filament::button>
            </div>
        </form>

    </x-filament::modal>




    <!-- Modal de confirmación -->
    <div id="success-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="relative inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div>
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 dark:bg-green-900/20">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            Queja enviada exitosamente
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Su queja ha sido enviada correctamente a contactorh@adcentrales.com. Nos pondremos en contacto con usted a la brevedad posible.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6">
                    <x-filament::button
                        id="close-success-modal"
                        color="primary"
                        class="w-full"
                    >
                        Entendido
                    </x-filament::button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Abrir modal del protocolo
                document.getElementById('open-protocol-modal').addEventListener('click', function() {
                    document.getElementById('protocol-modal').classList.remove('hidden');
                });

                // Cerrar modal del protocolo
                document.getElementById('close-protocol-modal').addEventListener('click', function() {
                    document.getElementById('protocol-modal').classList.add('hidden');
                });

                // Abrir formulario de queja
                document.getElementById('open-complaint-form').addEventListener('click', function() {
                    document.getElementById('protocol-modal').classList.add('hidden');
                    document.getElementById('complaint-modal').classList.remove('hidden');
                });

                // Cerrar modal de queja
                document.getElementById('close-complaint-modal').addEventListener('click', function() {
                    document.getElementById('complaint-modal').classList.add('hidden');
                });

                // Cerrar modal de éxito
                document.getElementById('close-success-modal').addEventListener('click', function() {
                    document.getElementById('success-modal').classList.add('hidden');
                });

                // Manejar envío del formulario
                document.getElementById('complaint-form').addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);

                    fetch('{{ route("quejas-violencia.store") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('complaint-modal').classList.add('hidden');
                                document.getElementById('success-modal').classList.remove('hidden');
                                document.getElementById('complaint-form').reset();
                            } else {
                                alert('Ocurrió un error al enviar la queja. Por favor, inténtelo de nuevo.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Ocurrió un error al enviar la queja. Por favor, inténtelo de nuevo.');
                        });
                });
            });
        </script>
    @endpush
</x-filament-widgets::widget>
