<?php

namespace App\Filament\Pages;

use App\Models\PsychometricEvaluation;
use App\Models\User;
use App\Models\EvaluationUserAnswer;
use Filament\Pages\Page;

class TakeInternalEvaluation extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.take-internal-evaluation';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $slug = 'mis-evaluaciones/contestar/{record}';
    protected static ?string $title = 'Evaluación Psicométrica';

    // --- PROPIEDADES ---
    public $evaluation;
    public $currentQuestionIndex = 0;
    public $totalQuestions = 0;
    public $answers = [];
    public $showWelcome = true;
    public $instructions = '';
    public $testName = '';

    public function mount($record)
    {
        $this->evaluation = PsychometricEvaluation::findOrFail($record);

        // BLINDAJE DE SEGURIDAD: Validar que la prueba pertenezca al usuario logueado
        if ($this->evaluation->evaluable_id !== auth()->id() || $this->evaluation->evaluable_type !== User::class) {
            abort(403, 'No tienes permiso para acceder a esta evaluación.');
        }

        // Si ya está completada, lo regresamos
        if ($this->evaluation->status === 'completed') {
            return redirect(MyPsychometricEvaluations::getUrl());
        }

        $this->totalQuestions = $this->evaluation->evaluationType->questions()->count();
        $this->testName = $this->evaluation->evaluationType->name ?? 'Evaluación Psicométrica';
        $this->loadInstructions();
    }

    public function loadInstructions()
    {
        switch ($this->evaluation->evaluations_type_id) {
            case 10: // Moss
                $this->instructions = "Para cada uno de los problemas siguientes, se sugieren cuatro respuestas. Seleccione la respuesta que usted considere más acertada. Solo podrá marcar una opción de respuesta.";
                break;
            case 9: // Moss Wess
            case 13:
                $this->instructions = "A continuación encontrará unas frases relacionadas con el trabajo. Aunque están pensadas para muy distintos ambientes laborales, es posible que algunas no se ajusten del todo al lugar donde usted trabaja. Trate de acomodarlas a su propio caso y decida si son verdaderas o falsas en relación con su centro de trabajo.\n\nEn las frases, el jefe es la persona de autoridad (coordinador, encargado, supervisor, Director, etc.) con quien usted se relaciona. La palabra empleado se utiliza en sentido general, aplicado a todos los que forman parte del personal del centro o empresa.\n\nSi cree que la frase, aplicada a su lugar de trabajo, es verdadera o casi siempre verdadera, seleccione la opción de V (verdadero). Si cree que la frase es falsa o casi siempre falsa, seleccione la opción F (falso).";
                break;
            case 11: // Cleaver
                $this->instructions = "Las palabras descriptivas que verá a continuación se encuentran agrupadas en series de cuatro, examine las palabras de cada serie y marque en la columna \"MÁS\" de la palabra que mejor describa su forma de ser o de comportarse. Después marque en la palabra que menos lo describa o se acerque a su forma de ser, bajo la columna de \"MENOS\". Solo podrá seleccionar una opción para MÁS y una para MENOS en cada serie de palabras.";
                break;
            case 12: // Kostick
                $this->instructions = "Hay 90 pares de frases, usted debe elegir de cada par, aquella que más se asemeje a su forma de ser o de pensar. A veces tendrá la impresión de que ninguna frase se asemeja a su manera de ser, o al contrario, que ambas lo hacen, en cualquier caso usted debe optar por una de las dos.\n\nLea a continuación cada una de las afirmaciones y conteste de acuerdo a sus preferencias. No existe límite de tiempo, sin embargo no se detenga mucho tiempo en contestar, sea espontáneo y sincero con sus respuestas.";
                break;
            default:
                $this->instructions = "Lea cuidadosamente cada pregunta y seleccione la opción que considere correcta. No hay respuestas buenas ni malas, sea lo más sincero posible.";
                break;
        }
    }

    public function startTest()
    {
        $this->showWelcome = false;
        if ($this->evaluation->status === 'assigned') {
            $this->evaluation->update(['status' => 'started', 'started_at' => now()]);
        }
    }

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
        $question = $this->getCurrentQuestion();

        // 1. VALIDACIÓN
        // Filament Form maneja validación visual, pero llamamos a validate() explícitamente sobre el state
        // para asegurarnos antes de guardar.
        // Aunque el $this->form->getState() ya dispara validación, mantenemos tu lógica robusta.

        if ($question->answer_type_id == 5) {
             $this->validate([
                "answers.{$question->id}.most" => 'required',
                "answers.{$question->id}.least" => 'required|different:answers.'.$question->id.'.most',
                // Agregué 'different' para UX: no deberías ser MÁS y MENOS lo mismo.
            ], [
                "answers.{$question->id}.most.required" => 'Debes seleccionar una opción en la columna MÁS (+).',
                "answers.{$question->id}.least.required" => 'Debes seleccionar una opción en la columna MENOS (-).',
                "answers.{$question->id}.least.different" => 'No puedes seleccionar la misma palabra para MÁS y MENOS.'
            ]);
        } else {
             $this->validate([
                "answers.{$question->id}" => 'required',
            ], [
                "answers.{$question->id}.required" => 'Debe seleccionar una respuesta para continuar.'
            ]);
        }

        // 2. GUARDADO
        $this->saveAnswerToDb($question);

        // 3. AVANCE
        if ($this->currentQuestionIndex < $this->totalQuestions - 1) {
            $this->currentQuestionIndex++;
            $this->answers = [];

        } else {
            $this->finishEvaluation();
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

        // Al terminar, lo regresamos a su dashboard de pruebas
        return redirect(MyPsychometricEvaluations::getUrl());
    }

    public function getViewData(): array
    {
        return [
            'question' => $this->showWelcome ? null : $this->getCurrentQuestion()
        ];
    }
}
