<?php

namespace App\Filament\Widgets;

use App\Models\ClimateOrganizationalResponses;
use App\Models\Evaluation360Response;
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


        // Obtener campañas activas para la sede del usuario
        $campaigns = Campaign::where('status', 'Activa')
            ->where('start_date', '<=', $currentDate)
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
        ];
    }
    protected static string $view = 'filament.widgets.campaign-evaluations-widget';
}
