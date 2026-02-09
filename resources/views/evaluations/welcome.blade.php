<x-guest-layout>
    <div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-lg">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                Bienvenido a tu Evaluación
            </h1>
            <p class="text-gray-600">
                Hola {{$nameEvaluated}}, a continuación realizarás la prueba:
            </p>
        </div>

        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg leading-6 font-medium text-blue-800">
                        {{ $evaluation->evaluationType->name }}
                    </h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p>
                            {{ $evaluation->evaluationType->description ?? 'Por favor lee las instrucciones cuidadosamente antes de comenzar.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h4 class="font-bold text-gray-700">Instrucciones generales:</h4>
            <ul class="list-disc list-inside text-gray-600 mt-2 space-y-1">
                <li>Responde con honestidad, no hay respuestas correctas o incorrectas en personalidad.</li>
                <li>Asegúrate de tener una conexión estable a internet.</li>
                @if($pendingCount > 1)
                    <li class="font-semibold text-orange-600">
                        Tienes {{ $pendingCount }} evaluaciones pendientes en esta sesión.
                    </li>
                @endif
            </ul>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('evaluation.take', ['token' => $token]) }}"
               class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                Comenzar Evaluación
                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </div>
</x-guest-layout>
