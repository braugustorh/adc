<?php

namespace App\Livewire;


use App\Models\Competence;
use App\Models\Evaluation360Response;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Evaluation360Controller extends Component
{
    public $competencias;
    public int $currentStep = 0;
    public int $competenciasCount = 0;
    public bool $first = false;
    public bool $final = false;
    public bool $alreadyCompleted = false;
    public $respuestas = [];
    public $evaluated;
    public $evaluator;
    public $campaign;
    public $fullName = '';
    public $tipodeEvaluacion = 'Evaluación 360';

    public function mount()
    {
        if (!auth()->check()) {
            return redirect()->to('/dashboard');
        }

        if (!request()->query('evaluated') || !request()->query('evaluator') || !request()->query('campaign')) {
            return redirect()->to('/dashboard/panel360');
        }

        try {
            $this->evaluated = Crypt::decryptString(request()->query('evaluated'));
            $this->evaluator = Crypt::decryptString(request()->query('evaluator'));
            $this->campaign = Crypt::decryptString(request()->query('campaign'));
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard/panel360');
        }

        // CANDADO 1: Verificar si ya contestó previamente esta evaluación
        $alreadyAnswered = Evaluation360Response::where('campaign_id', $this->campaign)
            ->where('user_id', $this->evaluator)
            ->where('evaluated_user_id', $this->evaluated)
            ->exists();

        if ($alreadyAnswered) {
            $this->alreadyCompleted = true;
            return;
        }

        $user = User::find($this->evaluated);
        if (!$user) {
            return redirect()->to('/dashboard/panel360');
        }

        $secondName = $user->second_name ?? $user->last_name ?? '';
        $this->fullName = trim("{$user->name} {$user->first_name} {$secondName}");

        // Cargar solo competencias activas que tengan preguntas, re-indexadas de 0 a N-1
        $this->competencias = Competence::where('evaluations_type_id', 2)
            ->where('status', 1)
            ->has('questions')
            ->with(['questions' => function ($query) {
                $query->orderBy('id');
            }])
            ->orderBy('id')
            ->get()
            ->values();

        $this->competenciasCount = $this->competencias->count();
        $this->currentStep = 0;
        $this->first = true;

        // Recuperar borrador de sesión si existe
        $draft = session()->get($this->getDraftSessionKey());
        if (is_array($draft) && !empty($draft)) {
            $this->respuestas = $draft;
        }
    }

    public function startEvaluation()
    {
        $this->first = false;
    }

    public function getCompetenciaActualProperty()
    {
        return $this->competencias[$this->currentStep] ?? null;
    }

    public function nextStep()
    {
        unset($this->competenciaActual);
        $competenciaActual = $this->competencias[$this->currentStep] ?? null;
        if (!$competenciaActual) {
            return;
        }

        // Validar que todas las preguntas del segmento actual estén respondidas
        $preguntasSinRespuesta = collect($competenciaActual->questions)->filter(function ($question) {
            return empty($this->respuestas[$question->id]);
        });

        if ($preguntasSinRespuesta->isNotEmpty()) {
            $errores = $preguntasSinRespuesta->mapWithKeys(function ($question) {
                return ["respuestas.{$question->id}" => 'Debe responder todas las preguntas antes de avanzar.'];
            })->toArray();

            throw ValidationException::withMessages($errores);
        }

        // Respaldar borrador en sesión
        session()->put($this->getDraftSessionKey(), $this->respuestas);

        // Avanzar índice si no es la última pantalla
        if ($this->currentStep < $this->competenciasCount - 1) {
            $this->currentStep++;
            unset($this->competenciaActual);
        }
    }

    public function previousStep()
    {
        unset($this->competenciaActual);
        // Respaldar en sesión las respuestas acumuladas
        session()->put($this->getDraftSessionKey(), $this->respuestas);

        // Retroceder índice de manera segura
        if ($this->currentStep > 0) {
            $this->currentStep--;
            unset($this->competenciaActual);
        }
    }

    // Métodos alias para compatibilidad retroactiva
    public function selectCompetencia($competenciaId = null)
    {
        $this->nextStep();
    }

    public function backCompetence($competenciaId = null)
    {
        $this->previousStep();
    }

    public function save()
    {
        // CANDADO 2: Verificar si ya existe registro previo
        $alreadyAnswered = Evaluation360Response::where('campaign_id', $this->campaign)
            ->where('user_id', $this->evaluator)
            ->where('evaluated_user_id', $this->evaluated)
            ->exists();

        if ($alreadyAnswered) {
            $this->alreadyCompleted = true;
            $this->final = true;
            session()->forget($this->getDraftSessionKey());
            return;
        }

        // Validación exhaustiva: asegurar que TODAS las preguntas de TODAS las competencias activas estén contestadas
        $todasLasPreguntas = $this->competencias->flatMap->questions;
        $preguntasSinRespuesta = $todasLasPreguntas->filter(function ($question) {
            return empty($this->respuestas[$question->id]);
        });

        if ($preguntasSinRespuesta->isNotEmpty()) {
            // Si la pregunta faltante es de una pantalla previa, posicionar al usuario en dicha pantalla
            $primerFaltante = $preguntasSinRespuesta->first();
            $stepFaltante = $this->competencias->search(function ($c) use ($primerFaltante) {
                return $c->questions->contains('id', $primerFaltante->id);
            });

            if ($stepFaltante !== false && $stepFaltante !== $this->currentStep) {
                $this->currentStep = $stepFaltante;
            }

            $errores = $preguntasSinRespuesta->mapWithKeys(function ($question) {
                return ["respuestas.{$question->id}" => 'Debe responder todas las preguntas antes de finalizar.'];
            })->toArray();

            throw ValidationException::withMessages($errores);
        }

        // Guardado en transacción atómica en la base de datos
        DB::transaction(function () {
            foreach ($this->respuestas as $preguntaId => $valor) {
                $question = Question::find($preguntaId);
                if ($question) {
                    Evaluation360Response::create([
                        'campaign_id' => $this->campaign,
                        'user_id' => $this->evaluator,
                        'evaluated_user_id' => $this->evaluated,
                        'competence_id' => $question->competence_id,
                        'question_id' => $preguntaId,
                        'response' => $valor,
                    ]);
                }
            }
        });

        // Limpiar el borrador temporal de la sesión
        session()->forget($this->getDraftSessionKey());

        $this->final = true;
    }

    private function getDraftSessionKey(): string
    {
        return "eval360_draft_{$this->campaign}_{$this->evaluator}_{$this->evaluated}";
    }

    public function render()
    {
        $competenciaActual = $this->competenciaActual;

        return view('livewire.evaluation360-controller', [
            'competenciaActual' => $competenciaActual,
            'preguntas' => $competenciaActual ? $competenciaActual->questions : collect(),
        ])->layout('components.layouts.app', ['tipodeEvaluacion' => $this->tipodeEvaluacion]);
    }
}
