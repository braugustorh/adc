<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;


class CampaignEvaluationsWidget extends Widget
{

    protected function getViewData(): array
    {
        $user = \auth()->user();
        $currentDate = now()->startOfDay();

        // Obtener campañas activas para la sede del usuario
        $campaigns = Campaign::where('status', 'Activa')
            ->where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->whereHas('sedes', function ($query) use ($user) {
                $query->where('sede_id', $user->sede_id);
            })
            ->with('evaluations')
            ->get();

        return [
            'campaigns' => $campaigns,
        ];
    }
    protected static string $view = 'filament.widgets.campaign-evaluations-widget';
}
