<?php

namespace App\Livewire;


use App\Models\ClimateOrganizationalResponses;
use App\Models\Competence;
use App\Models\EvaluationsTypes;
use App\Models\Question;
use Livewire\Component;
use App\Models\User;
use Illuminate\Validation\ValidationException;


class OrganizationalClimateController extends Component
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
    public $responses;
    public $user;
    public ?string $tipodeEvaluacion='Clima Organizacional';
    public $countPage;

    public function mount()
    {

        if (auth()->check()){
            if (request()->query('user') && request()->query('campaign')) {
                $this->user = \Crypt::decryptString(request()->query('user'));
                $this->campaign = \Crypt::decryptString(request()->query('campaign'));
                $user = User::find($this->user);
                $this->fullName = $user->name . ' ' . $user->first_name . ' ' . $user->second_name;
                $evaluation=EvaluationsTypes::where('name','Clima Organizacional')->first();
                $this->competencias = Competence::where('evaluations_type_id', $evaluation->id)
                    ->where('status',1)
                    ->with('questions')
                    ->get();

                $this->competenciasCount = $this->competencias->whereNotNull('questions')->where('evaluations_type_id',3)->count();
                $this->responses=ClimateOrganizationalResponses::where('campaign_id',$this->campaign)
                    ->where('user_id',$this->user)
                    ->count()>0;

                $this->currentCompetenciaId = $this->competencias->first()->id ?? null;
                $this->countPage=1;
                $this->first=true;
            }else {
                return redirect()->to('/dashboard');
            }
        }else{
                return redirect()->to('/dashboard');
        }

    }

    public function selectCompetencia($competenciaId)
    {
        // Obtiene las preguntas de la competencia actual
        $competenciaActual = $this->competencias->where('id', $this->currentCompetenciaId)->first();
        $preguntasSinRespuesta = collect($competenciaActual->questions)->filter(function ($question) {
            return empty($this->respuestas[$question->id]);
        });

        // Si hay preguntas sin respuesta, lanza una excepción de validación
        if ($preguntasSinRespuesta->isNotEmpty()) {
            $errores = $preguntasSinRespuesta->mapWithKeys(function ($question) {
                return ["respuestas.{$question->id}" => 'Debe responder todas las preguntas antes de avanzar.'];
            })->toArray();

            throw ValidationException::withMessages($errores);
        }

        // Si todas las preguntas están respondidas, guarda las respuestas y avanza
        $this->dispatch('saveResponses', ['responses' => $this->respuestas]);
        $this->currentCompetenciaId = $competenciaId;
        $this->countPage++;
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
        $this->countPage--;
    }


    public function save()
    {

        $this->dispatch('retrieveResponses');

        // Save responses to the database
        foreach ($this->respuestas as $preguntaId => $valor) {
            // Save logic here
            $question = Question::find($preguntaId);
           $question->climateOrganizationResponses()->create([
                'campaign_id' => $this->campaign,
                'user_id' => $this->user,
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

        return view('livewire.organizational-climate', [
            'competenciaActual' => $competenciaActual,
            'preguntas' => $competenciaActual->questions,
            'tipodeEvaluacion' => $this->tipodeEvaluacion,
        ]) ->layout('components.layouts.app', ['tipodeEvaluacion' => $this->tipodeEvaluacion]);
    }
}
