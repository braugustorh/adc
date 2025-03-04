<?php

namespace App\Filament\Pages;

use App\Models\Campaign;
use App\Models\Evaluation360Response;
use App\Models\EvaluationAssign;
use App\Models\User;
use App\Models\Position;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use mysql_xdevapi\Collection;

class Panel360 extends Page
{
    protected static ?string $navigationIcon = 'heroicon-m-arrow-path';
    protected static ?string $navigationLabel = ' Panel 360';
    protected static ?string $navigationGroup = 'Evaluaciones';
    protected ?string $heading = 'Panel 360';
    protected ?string $subheading = 'Visualiza a las personas a evaluar y el estatus de las evaluaciones';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.360-panel';
    public string $activeTab='tab1';
    public $users;
    public $members;
    public $campaigns;
    public $daysRemaining;
    public $today;
    public $supervisors;
    public $responses;
    public function getTitle(): string | Htmlable
    {
        return __('Panel 360');
    }

    public function mount()
    {
        $exists=Campaign::whereStatus('Activa')->whereHas('sedes', function ($query) {
            $query->where('sede_id', auth()->user()->sede_id);
        })->exists();

        if($exists  && !auth()->user()->hasRole('Administrador')){
            $campaigns= Campaign::whereStatus('Activa')->whereHas('sedes', function ($query) {
                $query->where('sede_id', auth()->user()->sede_id);
            })->first();

            $this->campaigns= Campaign::whereStatus('Activa')->first();
            $this->today= Carbon::now();
            $this->daysRemaining= $this->today->diffInDays($this->campaigns->end_date);
            $position= Position::find(auth()->user()->position_id);
            $supervisor= User::where('position_id',$position->supervisor_id)
                ->get()
                ->first();

            if(auth()->user()->hasRole('Administrador')){ //se le pone el rol mas alto
                $this->members= EvaluationAssign::where('campaign_id', $campaigns->id)->get();
                $this->supervisors=collect();
            }else{
                if ($supervisor){
                    $this->members= EvaluationAssign::where('campaign_id', $campaigns->id)
                        ->where('user_id', auth()->user()->id)
                        ->where('user_to_evaluate_id','<>', $supervisor->id)
                        ->get();
                    $this->supervisors= EvaluationAssign::where('campaign_id', $campaigns->id)
                        ->where('user_id',auth()->user()->id)
                        ->where('user_to_evaluate_id', $supervisor->id)
                        ->get();
                    if ($this->supervisors->count()===0){
                        $this->supervisors=collect();
                    }
                }else{
                    $this->members= EvaluationAssign::where('campaign_id', $campaigns->id)
                        ->where('user_id', auth()->user()->id)
                        // ->where('user_to_evaluate_id','<>', $supervisor->id)
                        ->get();
                    $this->supervisors=collect();

                }

            }

            /*busca al supervisor en una coleccion y lo compara con el usuario autenticado
            $searchResponse = $this->members->search(function ($item, $key) {
                return $item->user->position->supervisor_id == auth()->user()->id;
            });
            */

            $this->responses= Evaluation360Response::where('campaign_id', $campaigns->id)
                ->where('user_id', auth()->user()->id)
                ->get();
        }else{
            $this->campaigns=collect();
            $this->members=collect();
            $this->supervisors=collect();
            $this->responses=collect();
        }

    }
}
