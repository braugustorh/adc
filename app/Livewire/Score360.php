<?php

namespace App\Livewire;

use App\Filament\Pages\Panel9Box;
use App\Models\Evaluation360Response;
use App\Models\Psychometry;
use Carbon\Carbon;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class Score360 extends BaseWidget
{
    public $user;
    public $campaignId;
    public $total360='-';
    public $totalPotential='-';
    public $titles=[];
    public $icons=[
        9 => 'heroicon-s-star',
        8 => 'heroicon-s-arrow-up-circle',
        7 => 'heroicon-s-rocket-launch',
        6 => 'heroicon-m-face-smile',
        5 => 'heroicon-s-key',
        4 => 'heroicon-s-sparkles',
        3 => 'heroicon-s-check-badge',
        2 => 'heroicon-c-exclamation-triangle',
        1 => 'heroicon-c-face-frown',
    ];
    public $colors=[];
    public $quadrant360;
    public $bandera=false;
    public $application_date;
    protected static bool $isLazy = false;

    public function mount($user = null, $campaignId = null, $titles = [], $colors = []): void
    {
        if (!empty($user) && (int) $user !== (int) auth()->id()) {
            $this->dataUpdated($user, $campaignId, $titles, $colors);
        }
    }

    #[On('data-updated')]
    public function dataUpdated($user, $campaignId,$titles,$colors): void
    {
        if (empty($user) || (int) $user === (int) auth()->id()) {
            $this->bandera = false;
            return;
        }
        $this->user = $user;
        $this->titles=$titles;
        $this->campaignId = $campaignId;
        $this->colors=$colors;
        $this->prepareScore();
        $this->bandera=true;

    }
    protected function getStats(): array
    {
        if (!$this->bandera) {
            return [];
        }

        if ($this->total360 !== null) {
            $perfLevel = Panel9Box::mapScoreToLevel($this->total360);
            $perfValue = number_format((float) $this->total360, 2);
            $perfDesc = match ($perfLevel) {
                3 => 'Nivel Alto (4.00 - 5.00)',
                2 => 'Nivel Medio (3.00 - 3.99)',
                default => 'Nivel Bajo (< 3.00)',
            };
            $perfIcon = match ($perfLevel) {
                3 => 'heroicon-m-arrow-trending-up',
                2 => 'heroicon-m-minus-circle',
                default => 'heroicon-m-arrow-trending-down',
            };
            $perfColor = match ($perfLevel) {
                3 => 'success',
                2 => 'warning',
                default => 'danger',
            };
        } else {
            $perfValue = 'Sin evaluar';
            $perfDesc = 'Sin evaluación 360° registrada';
            $perfIcon = 'heroicon-m-information-circle';
            $perfColor = 'gray';
        }

        if ($this->totalPotential !== null) {
            $potLevel = Panel9Box::mapScoreToLevel($this->totalPotential);
            $potValue = number_format((float) $this->totalPotential, 2);
            $potDesc = $this->application_date
                ? 'Última aplicación: ' . Carbon::parse($this->application_date)->format('d/m/Y')
                : 'Evaluación registrada';
            $potColor = match ($potLevel) {
                3 => 'success',
                2 => 'warning',
                default => 'danger',
            };
        } else {
            $potValue = 'Sin evaluar';
            $potDesc = 'Sin evaluación de potencial registrada';
            $potColor = 'gray';
        }

        $hasQuadrant = $this->quadrant360 && isset($this->titles[$this->quadrant360]);

        return [
            Stat::make('Puntaje de Desempeño', $perfValue)
                ->description($perfDesc)
                ->descriptionIcon($perfIcon)
                ->color($perfColor),
            Stat::make('Puntaje de Potencial', $potValue)
                ->description($potDesc)
                ->color($potColor),
            Stat::make('Resultado 9 box', $hasQuadrant ? $this->titles[$this->quadrant360] : 'Sin clasificar')
                ->description($hasQuadrant ? 'Box ' . $this->quadrant360 : 'Sin evaluaciones registradas')
                ->descriptionIcon($hasQuadrant ? ($this->icons[$this->quadrant360] ?? '') : 'heroicon-m-question-mark-circle', IconPosition::Before)
                ->color($hasQuadrant ? ($this->colors[$this->quadrant360] ?? 'gray') : 'gray'),
        ];
    }
    public function prepareScore()
    {
        $collaborator= Evaluation360Response::select('evaluated_user_id')
            ->selectRaw('AVG(response) as total_360')
            ->where('campaign_id', $this->campaignId)
            ->where('evaluated_user_id', $this->user)
            ->groupBy('evaluated_user_id')
            ->first();

        $potential = Psychometry::select('user_id', DB::raw('MAX(application_date) as application_date'), DB::raw('
            (SUM(leadership) +
            SUM(communication) +
            SUM(conflict_management) +
            SUM(negotiation) +
            SUM(organization) +
            SUM(problem_analysis) +
            SUM(decision_making) +
            SUM(strategic_thinking) +
            SUM(resilience) +
            SUM(focus_on_results) +
            SUM(teamwork) +
            SUM(willingness_service)) /
            (COUNT(leadership) +
            COUNT(communication) +
            COUNT(conflict_management) +
            COUNT(negotiation) +
            COUNT(organization) +
            COUNT(problem_analysis) +
            COUNT(decision_making) +
            COUNT(strategic_thinking) +
            COUNT(resilience) +
            COUNT(focus_on_results) +
            COUNT(teamwork) +
            COUNT(willingness_service))
            as total_average
        '))
            ->where('user_id', $this->user)
            ->groupBy('user_id')
            ->first();

        $this->application_date = $potential?->application_date;
        $this->total360 = $collaborator ? round((float) $collaborator->total_360, 2) : null;
        $this->totalPotential = ($potential && $potential->total_average !== null) ? round((float) $potential->total_average, 2) : null;

        if ($this->total360 !== null || $this->totalPotential !== null) {
            $this->quadrant360 = $this->getQuadrantForCollaborator($this->total360, $this->totalPotential);
        } else {
            $this->quadrant360 = null;
        }
    }
    private function getQuadrantForCollaborator($total360,$potential)
    {
        return Panel9Box::calculateQuadrant($total360, $potential);
    }
    private function mapScoreToLevel($score)
    {
        return Panel9Box::mapScoreToLevel($score);
    }
}
