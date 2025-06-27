<?php

namespace App\Filament\Widgets;

use App\Models\ActiveSurvey;
use App\Models\ClimateOrganizationalResponses;
use App\Models\Evaluation360Response;
use App\Models\EvaluationsTypes;
use App\Models\Nom035Process;
use Filament\Widgets\Widget;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;


class CampaignEvaluationsWidget extends Widget
{
public $responseCO;
public $response360;
public $qtty;
    protected static ?int $sort = -2;
    protected function getViewData(): array
    {
        $user = \auth()->user();
        $currentDate = now()->startOfDay();
        $this->responseCO = ClimateOrganizationalResponses::where('user_id', $user->id)
            ->get();

        $norma=Nom035Process::findActiveProcess(auth()->user()->sede_id);
        if ($norma) {

            $surveys = ActiveSurvey::where('norma_id', $norma->id)
                ->whereIn('evaluations_type_id', [
                    // Aquí iría el ID del tipo de evaluación que estamos usando
                    // Por ejemplo, puedes buscar por nombre:
                    EvaluationsTypes::where('name', 'like', 'Nom035: Guía I')->first()->id ?? null,
                    EvaluationsTypes::where('name', 'like', 'Nom035: Guía II')->first()->id ?? null
                ])
                ->get();

        }else{
            $surveys=collect();
        }

        // Obtener campañas activas para la sede del usuario
        $campaigns = Campaign::where('status', 'Activa')
            //->where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->whereHas('sedes', function ($query) use ($user) {
                $query->where('sede_id', $user->sede_id);
            })
            ->with('evaluations')
            ->get();

        $this->response360= Evaluation360Response::where('user_id', $user->id)
            ->get();

        return [
            'campaigns' => $campaigns,
            'user' => $user,
            'surveys' => $surveys,
        ];
    }
    protected static string $view = 'filament.widgets.campaign-evaluations-widget';
}
