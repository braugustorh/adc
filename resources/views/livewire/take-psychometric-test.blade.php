<div>
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-4 lg:px-4">

        <div class="mb-8">
            <div class="flex justify-between text-sm font-medium text-gray-500 mb-2">
                <span>Pregunta {{ $currentQuestionIndex + 1 }} de {{ $totalQuestions }}</span>
                <span>{{ round((($currentQuestionIndex) / $totalQuestions) * 100) }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-300"
                     style="width: {{ (($currentQuestionIndex) / $totalQuestions) * 100 }}%"></div>
            </div>
        </div>

        <div class="bg-white shadow sm:rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:p-6">
                <div wire:key="question-idx-{{ $currentQuestionIndex }}">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Pregunta {{ $currentQuestionIndex + 1 }}
                    </span>

                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6 mt-2">
                        {{ $question->question }}
                    </h3>

                    @if ($errors->any())
                        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4">
                            <p class="text-red-700 text-sm">Por favor revisa tus respuestas.</p>
                        </div>
                    @endif

                    <div class="mt-4">
                        @switch($question->answer_type_id)

                            @case(2)
                                <div class="space-y-4">
                                    @foreach($question->answers as $ans)
                                        <label wire:key="q-idx-{{ $currentQuestionIndex }}-ans-{{ $ans->id }}"
                                               class="flex items-start p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition {{ isset($answers[$question->id]) && $answers[$question->id] == $ans->id ? 'border-indigo-500 bg-indigo-50 ring-1 ring-indigo-500' : 'border-gray-200' }}">
                                            <div class="flex items-center h-5">
                                                <input type="radio"
                                                       wire:model="answers.{{ $question->id }}"
                                                       name="question_{{ $question->id }}"
                                                       value="{{ $ans->id }}"
                                                       class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <span class="font-medium text-gray-700">{{ $ans->text }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                @error("answers.{$question->id}") <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                                @break

                            @case(4)
                                <div class="flex space-x-4 justify-center mt-6">
                                    @foreach($question->answers as $ans)
                                        <label wire:key="q-idx-{{ $currentQuestionIndex }}-ans-{{ $ans->id }}" class="cursor-pointer">
                                            <input type="radio"
                                                   wire:model="answers.{{ $question->id }}"
                                                   name="question_{{ $question->id }}"
                                                   id="ans_radio_{{ $ans->id }}"
                                                   value="{{ $ans->id }}"
                                                   class="sr-only peer">
                                            <span class="px-6 py-3 rounded-md border text-sm font-medium transition-colors block
                                                peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 peer-checked:shadow-md
                                                bg-white text-gray-700 border-gray-300 hover:bg-gray-50">
                                                {{ $ans->text }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                                @error("answers.{$question->id}") <div class="text-center mt-2 text-red-500 text-xs font-bold">{{ $message }}</div> @enderror
                                @break

                            @case(5)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Palabra</th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Más (+)</th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Menos (-)</th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($question->answers as $ans)
                                            <tr wire:key="cleaver-idx-{{ $currentQuestionIndex }}-ans-{{ $ans->id }}">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $ans->text }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <input type="radio"
                                                           wire:model="answers.{{ $question->id }}.most"
                                                           value="{{ $ans->id }}"
                                                           name="most_group_{{ $question->id }}"
                                                           class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <input type="radio"
                                                           wire:model="answers.{{ $question->id }}.least"
                                                           value="{{ $ans->id }}"
                                                           name="least_group_{{ $question->id }}"
                                                           class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300">
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="mt-2 text-center">
                                        @error("answers.{$question->id}.most") <span class="block text-red-500 text-xs font-bold">Selecciona la opción MÁS.</span> @enderror
                                        @error("answers.{$question->id}.least") <span class="block text-red-500 text-xs font-bold">Selecciona la opción MENOS.</span> @enderror
                                    </div>
                                </div>
                                @break
                        @endswitch
                    </div>
                </div>
            </div>

            <div class="px-4 py-4 sm:px-6 bg-gray-50 text-right">
                <button wire:click="nextQuestion"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
                    <span wire:loading.remove>
                        {{ $currentQuestionIndex < $totalQuestions - 1 ? 'Siguiente Pregunta' : 'Finalizar Evaluación' }}
                    </span>
                    <span wire:loading>Procesando...</span>
                    <svg wire:loading.remove class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>


<!-- DEBUG: Agrega esto temporalmente en la vista -->
    <div class="fixed top-4 right-4 bg-yellow-100 p-4 rounded shadow text-xs">
        <p><strong>DEBUG INFO:</strong></p>
        <p>Question ID: {{ $question->id ?? 'NULL' }}</p>
        <p>Question Index: {{ $currentQuestionIndex }}</p>
        <p>Total Questions: {{ $totalQuestions }}</p>
        <p>Question Text: {{ substr($question->question ?? 'NULL', 0, 50) }}...</p>
    </div>
</div>
