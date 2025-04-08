<?php

namespace App\Livewire;

use App\Models\Campaign;
use App\Models\Evaluation360Response;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Livewire\Attributes\On;

class CompetencesChartTeam extends ChartWidget
{
    protected static ?string $heading = 'Gráfica de Competencias por Equipo';
    public $user,$users;
    public $bandera=true;
    public $data;
    public $campaignId;
    protected static bool $isLazy = true;
    protected static ?string $maxHeight = '300px';
    protected static ?string $pollingInterval = null;



    public function mount(): void
    {
        $this->campaignId = Campaign::whereStatus('Activa')->first();
        if (!$this->campaignId) {
            $this->bandera=false;
            return;
        }
        $this->campaignId = $this->campaignId->id;
        $supervisorId = auth()->user()->position_id;
        $this->users = User::where('status', true)
            ->whereNotNull('department_id')
            ->whereNotNull('position_id')
            ->whereNotNull('sede_id')
            ->whereHas('position', function ($query) use ($supervisorId) {
                $query->where('supervisor_id', $supervisorId);
            })
            ->get();

        $this->data = Evaluation360Response::select('competences.name as competence_name')
            ->selectRaw('AVG(response) as total_360')
            ->join('competences', 'evaluation360_responses.competence_id', '=', 'competences.id') // Unión con la tabla de competencias
            ->where('campaign_id', $this->campaignId)
            ->whereIn('evaluated_user_id', $this->users->pluck('id')->toArray())
            ->groupBy('competences.name') // Agrupar por nombre de competencia
            ->get();
        $this->bandera=true;

    }

    public function getData(): array
    {
        if ($this->bandera) {

            // Get the data from the database


// Extraer los valores 'total_360' y los nombres de las competencias
            $values = $this->data->pluck('total_360')->toArray();
            $labels = $this->data->pluck('competence_name')->toArray(); // Usar los nombres como etiquetas

            $configChart = [
                'datasets' => [
                    [
                        'label' => 'Competencias',
                        'data' => $values,
                    ],
                ],
                'labels' => $labels,
            ];
        }else{
            $configChart=[];
        }
        return $configChart;
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
