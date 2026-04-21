<?php

namespace App\Livewire;

use App\Models\PsychometricEvaluation;
use App\Models\Question;
use App\Models\EvaluationUserAnswer;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.guest-layout')]
class TakePsychometricTest extends Component
{
    public $token;
    public $evaluation;
    public $currentQuestionIndex = 0;
    public $totalQuestions = 0;
    public $answers = [];

    // --- VARIABLES PARA LA UX DE INSTRUCCIONES ---
    public $showWelcome = true;
    public $instructions = '';
    public $testName = '';

    // --- TIMER ---
    public int $accumulatedSeconds = 0; // Segundos de pruebas anteriores del mismo batch

    // --- GLOSARIO CLEAVER ---
    public bool $isCleaver = false;

    public function mount($token)
    {
        $this->token = $token;
        $this->evaluation = PsychometricEvaluation::getNextPendingByToken($token);

        if (!$this->evaluation) {
            return redirect()->route('evaluation.landing', ['token' => $token]);
        }

        $this->totalQuestions = $this->evaluation->evaluationType->questions()->count();

        // Cargamos el nombre y las instrucciones de la prueba
        $this->testName = $this->evaluation->evaluationType->name ?? 'Evaluación Psicométrica';
        $this->loadInstructions();

        // Detectar si es prueba Cleaver
        $this->isCleaver = $this->evaluation->evaluations_type_id == 11;

        // Calcular segundos acumulados de pruebas anteriores ya completadas
        $this->accumulatedSeconds = $this->evaluation->getAccumulatedSecondsByToken();
    }

    /**
     * Carga el texto exacto de las instrucciones según el ID de la prueba
     */
    public function loadInstructions()
    {
        // NOTA: Verifica que estos IDs coincidan con los de tu base de datos (evaluations_types)
        // Usamos los mismos que vimos en tu PsychometricScoringService (10=Moss, 11=Cleaver, 12=Kostick, 9=MossWess)

        switch ($this->evaluation->evaluations_type_id) {
            case 10: // Moss
                $this->instructions = "Para cada uno de los problemas siguientes, se sugieren cuatro respuestas. Seleccione la respuesta que usted considere más acertada. Solo podrá marcar una opción de respuesta.";
                break;
            case 9: // Moss Wess
            case 13: // Por si acaso tienes otro ID para Wess
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

    /**
     * Oculta la bienvenida y registra la hora de inicio real
     */
    public function startTest()
    {
        $this->showWelcome = false;

        // Registramos el inicio solo cuando el candidato realmente le da "Comenzar"
        if ($this->evaluation->status === 'assigned') {
            $this->evaluation->update(['status' => 'started', 'started_at' => now()]);
        }

        // Disparar evento para iniciar el timer en Alpine
        $this->dispatch('test-started');
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

        // ==========================================
        // 1. VALIDACIÓN: Evitar que avancen sin contestar
        // ==========================================
        if ($question->answer_type_id == 5) {
            // Validación especial para Cleaver (Debe tener MOST y LEAST)
            $this->validate([
                "answers.{$question->id}.most" => 'required',
                "answers.{$question->id}.least" => 'required',
            ], [
                "answers.{$question->id}.most.required" => 'Debes seleccionar una opción en la columna MÁS (+).',
                "answers.{$question->id}.least.required" => 'Debes seleccionar una opción en la columna MENOS (-).'
            ]);
        } else {
            // Validación normal (Moss, Kostick, etc.)
            $this->validate([
                "answers.{$question->id}" => 'required',
            ], [
                "answers.{$question->id}.required" => 'Debe seleccionar una respuesta para continuar.'
            ]);
        }

        // ==========================================
        // 2. Si pasa la validación, procedemos a guardar
        // ==========================================
        $this->saveAnswerToDb($question);

        // ==========================================
        // 3. Avanzamos o terminamos
        // ==========================================
        if ($this->currentQuestionIndex < $this->totalQuestions - 1) {
            $this->currentQuestionIndex++;
            $this->answers = []; // Limpiamos para la siguiente
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
        // Calcular tiempo transcurrido para esta prueba individual
        $elapsedSeconds = 0;
        if ($this->evaluation->started_at) {
            $elapsedSeconds = (int) now()->diffInSeconds($this->evaluation->started_at);
        }

        $this->evaluation->update([
            'status' => 'completed',
            'completed_at' => now(),
            'progress' => 100,
            'elapsed_seconds' => $elapsedSeconds,
        ]);

        return redirect()->route('evaluation.landing', ['token' => $this->token]);
    }

    public function render()
    {
        // Si estamos en la bienvenida, no necesitamos cargar la pregunta aún
        $question = $this->showWelcome ? null : $this->getCurrentQuestion();

        $glosario = $this->isCleaver ? config('cleaver.glosario') : [];

        return view('livewire.take-psychometric-test', [
            'question' => $question,
            'glosario' => $glosario,
        ]);
    }
}
