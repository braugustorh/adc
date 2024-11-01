<?php

namespace App\Livewire;


use App\Models\Competence;
use App\Models\Question;
use Livewire\Component;
use App\Models\User;


class Evaluation360Controller extends Component
{
    public $competencias;
    public $currentCompetenciaId;
    public $competenciasCount;
    public $first=false;
    public $final=false;
    public $respuestas = [];
    public $evaluated;
    public $evaluator;
    public $campaign;
    public $fullName;
    public $tipodeEvaluacion='Evaluación 360';

    public function mount()
    {
        $this->evaluated = \Crypt::decryptString(request()->query('evaluated'));
        $this->evaluator = \Crypt::decryptString(request()->query('evaluator'));
        $this->campaign = \Crypt::decryptString(request()->query('campaign'));
        $user = User::find($this->evaluated);
        $this->fullName = $user->name . ' ' . $user->first_name . ' ' . $user->second_name;
        $this->competencias = Competence::where('evaluations_type_id', 2)
            ->where('status',1)
            ->with('questions')
            ->get();
        $this->competenciasCount = $this->competencias->whereNotNull('questions')->count()-1;

        $this->currentCompetenciaId = $this->competencias->first()->id ?? null;
        $this->first=true;
    }

    public function selectCompetencia($competenciaId)
    {
        // Save current responses to localStorage
        $this->dispatch('saveResponses', ['responses' => $this->respuestas]);

        // Update currentCompetenciaId
        $this->currentCompetenciaId = $competenciaId;


    }
    public function startEvaluation()
    {
        if ($this->first){
            $this->first=false;
        }
    }

    public function backCompetence($competenciaId){
        $this->currentCompetenciaId = $competenciaId- 1;
        $this->dispatch('loadResponses');
    }


    public function save()
    {

        $this->dispatch('retrieveResponses');

        // Save responses to the database
        foreach ($this->respuestas as $preguntaId => $valor) {
            // Save logic here
            $question = Question::find($preguntaId);
            $question->evaluation360responses()->create([
                'campaign_id' => $this->campaign,
                'user_id' => $this->evaluator,
                'evaluated_user_id' => $this->evaluated,
                'competence_id' => $question->competence_id,
                'question_id' => $preguntaId,
                'response' => $valor,
            ]);
        }
        $this->final=true;

        $this->dispatch('clearResponses');

    }

    public function render()
    {
        $competenciaActual = $this->competencias->find($this->currentCompetenciaId);
       // dd($competenciaActual->questions);
        return view('livewire.evaluation360-controller', [
            'competenciaActual' => $competenciaActual,
            'preguntas' => $competenciaActual->questions,
        ])->layout('components.layouts.app', ['tipodeEvaluacion' => $this->tipodeEvaluacion]);
    }
}
