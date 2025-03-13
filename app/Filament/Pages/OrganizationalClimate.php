<?php

namespace App\Filament\Pages;

use App\Models\Campaign;
use App\Models\ClimateOrganizationalResponses;
use App\Models\Evaluation360Response;
use App\Models\EvaluationAssign;
use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
use Filament\Pages\Page;
use crypt;

class OrganizationalClimate extends Page
{
    protected static ?string $navigationIcon = 'heroicon-m-check-badge';
    protected static ?string $navigationLabel = 'Test de Clima Organizacional';
    protected static ?string $navigationGroup = 'Clima Organizacional';
    protected ?string $heading = 'Test de Clima Organizacional';
    //protected ?string $subheading = 'Realiza la evaluación vertical de tu colaborador';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.test-organizational-climate';

    public $user;
    public $members;
    public $campaigns;
    public $campaing;
    public $supervisors;
    public $responses;
    public $disabledButton=false;
    public $disabledArea=false;
    public function mount()
    {
        if(Campaign::whereStatus('Activa')->exists()){
            //Puede haber dos campañas activas al mismo tiempo
            //Agregar código para evitar hallar la campaña que tenga el clima organizacional como evaluación, si hay dos, entonces seleccionar la mas reciente
            //$campaigns= Campaign::whereStatus('Activa')->first();
            $this->campaigns= Campaign::whereStatus('Activa')->first();
            //AQUI CÓDIGO PARA REVISAR SI YA ESTA CONTESTADA LA EVALUACION DE ESA CAMPAÑA
            $this->user=auth()->user()?->id;
            //Vamos a verificar que el usuario no haya contestado la evaluación de clima organizacional

            if (ClimateOrganizationalResponses::where('campaign_id',$this->campaigns->id)->where('user_id',$this->user)->exists()) {
                $this->disabledArea = false;
            }else{
                $this->disabledArea = true;
            }



        }else{
            $this->disabledArea =false;
            $this->campaigns=collect();
        }

    }

}
