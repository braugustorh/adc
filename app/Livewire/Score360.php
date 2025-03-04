<?php

namespace App\Livewire;

use App\Models\Evaluation360Response;
use App\Models\Psychometry;
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
        4 => 'fas-hand-sparkles',
        3 => 'heroicon-s-check-badge',
        2 => 'heroicon-c-exclamation-triangle',
        1 => 'heroicon-c-face-frown',
    ];
    public $colors=[];
    public $quadrant360;
    public $bandera=false;
    public $application_date;

    #[On('data-updated')]
    public function dataUpdated($user, $campaignId,$titles,$colors): void
    {
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
        }else {
            $sendStats = [
                Stat::make('Puntaje de Desempeño', $this->total360)
                    ->description('incrementó 5%')
                    ->descriptionIcon('heroicon-m-arrow-trending-up'),
                Stat::make('Puntaje de Potencial', $this->totalPotential)
                    ->description('Última Aplicación: '.$this->application_date),
                Stat::make('Resultado 9 box', $this->quadrant360 ? $this->titles[$this->quadrant360] : '')
                    ->description($this->quadrant360 ? 'Box ' . $this->quadrant360 : '')
                    ->descriptionIcon($this->quadrant360 ? $this->icons[$this->quadrant360] : '',IconPosition::Before)
                    ->color($this->quadrant360 ? $this->colors[$this->quadrant360] : ''),
            ];
        }
        return $sendStats;
    }
    public function prepareScore()
    {
        $collaborator= Evaluation360Response::select('evaluated_user_id')
            ->selectRaw('AVG(response) as total_360')
            ->where('campaign_id', $this->campaignId)
            ->where('evaluated_user_id', $this->user)
            ->groupBy('evaluated_user_id')
            ->first();

        $potentials=Psychometry::select('user_id','application_date',DB::raw('
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
            ->groupBy('user_id','application_date')
            ->get();
        $this->application_date=$potentials->pluck('application_date')->first();
        $this->total360 = $collaborator ? round($collaborator->total_360,2) : null;
        $this->totalPotential = $potentials->count() > 0 ? round($potentials[0]->total_average,2) : null;
        $this->quadrant360=$this->getQuadrantForCollaborator($this->total360,$this->totalPotential);

    }
    private function getQuadrantForCollaborator($total360,$potential)
    {
        // Supongamos que tienes los puntajes de desempeño y potencial
        /*
         * Aqui buscamos los puntajes de desempeño y potencial del colaborador
         * en la Psicometria y en la evaluación
         * el eje X será el desempeño y el eje Y será el potencial
         */
        // Obtener los puntajes de desempeño y potencial (valores de 0 a 5)

        $performanceScore = $total360;
        $potentialScore = $potential;

        // Mapear los puntajes a niveles (1: Bajo, 2: Medio, 3: Alto)
        $performanceLevel = $this->mapScoreToLevel($performanceScore);
        $potentialLevel = $this->mapScoreToLevel($potentialScore);

        // Calcular el cuadrante (1 a 9)
        $quadrant = ($performanceLevel - 1) * 3 + $potentialLevel;

        return $quadrant;
    }
    private function mapScoreToLevel($score)
    {
        if ($score >= 4.0 && $score <= 5.0) {
            return 3; // Alto
        } elseif ($score >= 3.0 && $score <= 3.9) {
            return 2; // Medio
        } else {
            return 1; // Bajo
        }
    }
}
