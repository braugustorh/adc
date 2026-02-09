<?php

namespace App\Livewire;

use App\Models\PsychometricEvaluation;
use App\Models\Question;
use App\Models\EvaluationUserAnswer;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

#[Layout('components.guest-layout')]
class TakePsychometricTest extends Component
{
    public $token;
    public $evaluation;
    public $currentQuestionIndex = 0;
    public $totalQuestions = 0;
    public $answers = [];

    public function mount($token)
    {
        $this->token = $token;
        $this->evaluation = PsychometricEvaluation::getNextPendingByToken($token);

        if (!$this->evaluation) {
            return redirect()->route('evaluation.landing', ['token' => $token]);
        }

        $this->totalQuestions = $this->evaluation->evaluationType->questions()->count();

        if ($this->evaluation->status === 'assigned') {
            $this->evaluation->update(['status' => 'started', 'started_at' => now()]);
        }
    }

    // ⚠️ CAMBIA ESTO: De propiedad computada a metodo normal
    public function getCurrentQuestion()
    {
        return $this->evaluation->evaluationType
            ->questions()
            ->with('answers')
            ->orderBy('order', 'asc')
            ->orderBy('id', 'asc')
            ->skip($this->currentQuestionIndex)
            ->take(1)
            ->first();
    }

    public function nextQuestion()
    {
        // ⚠️ CAMBIA ESTO: Llama al metodo directamente
        $question = $this->getCurrentQuestion();

        if (!$question) {
            return;
        }

        $this->validateCurrentQuestion($question);
        $this->saveAnswerToDb($question);

        $currentQuestionId = $question->id;
        unset($this->answers[$currentQuestionId]);

        if ($this->currentQuestionIndex < $this->totalQuestions - 1) {
            $this->currentQuestionIndex++;
            $this->resetErrorBag();
        } else {
            $this->finishEvaluation();
        }
    }

    public function validateCurrentQuestion($question)
    {
        if ($question->answer_type_id == 5) {
            $this->validate([
                "answers.{$question->id}.most" => 'required',
                "answers.{$question->id}.least" => 'required|different:answers.'.$question->id.'.most',
            ], [
                'required' => 'Debes seleccionar una opción.',
                'different' => 'No puedes elegir la misma palabra para "Más" y "Menos".'
            ]);
        } else {
            $this->validate([
                "answers.{$question->id}" => 'required'
            ], ['required' => 'Por favor selecciona una respuesta.']);
        }
    }

    public function saveAnswerToDb($question)
    {
        if ($question->answer_type_id == 5) {
            $data = $this->answers[$question->id];

            EvaluationUserAnswer::create([
                'psychometric_evaluation_id' => $this->evaluation->id,
                'question_id' => $question->id,
                'answer_id' => $data['most'],
                'attribute' => 'MOST'
            ]);

            EvaluationUserAnswer::create([
                'psychometric_evaluation_id' => $this->evaluation->id,
                'question_id' => $question->id,
                'answer_id' => $data['least'],
                'attribute' => 'LEAST'
            ]);
        } else {
            EvaluationUserAnswer::create([
                'psychometric_evaluation_id' => $this->evaluation->id,
                'question_id' => $question->id,
                'answer_id' => $this->answers[$question->id],
                'attribute' => null
            ]);
        }
    }

    public function finishEvaluation()
    {
        $this->evaluation->update([
            'status' => 'completed',
            'completed_at' => now(),
            'progress' => 100
        ]);

        return redirect()->route('evaluation.landing', ['token' => $this->token]);
    }

    public function render()
    {
        return view('livewire.take-psychometric-test', [
            // ⚠️ CAMBIA ESTO: Llama al metodo directamente
            'question' => $this->getCurrentQuestion()
        ]);
    }
}
