<?php

namespace App\Livewire;

use App\Models\Evaluation360Response;
use Filament\Widgets\ChartWidget;
use Livewire\Attributes\On;
use App\Filament\Pages\Panel9Box;

class CompetencesChart extends ChartWidget
{
    protected static ?string $heading = 'Gráfica de Competencias';
    public $user;
    public $bandera=true;
    public $campaignId;
    protected static bool $isLazy = true;
    protected static ?string $maxHeight = '300px';



    #[On('update-chart')]
    public function updateChart($user, $campaignId): void
    {

        $this->user = $user;
        $this->campaignId = $campaignId;
        $this->bandera=true;
        $this->dispatch('show-chart');

        // Forzar la recarga del gráfico
        //$this->dispatchBrowserEvent('update-chart');
    }

    public function getData(): array
    {
        if ($this->bandera) {

            // Get the data from the database
            $data = Evaluation360Response::select('competences.name as competence_name', 'evaluated_user_id')
                ->selectRaw('AVG(response) as total_360')
                ->join('competences', 'evaluation360_responses.competence_id', '=', 'competences.id') // Unión con la tabla de competencias
                ->where('campaign_id', $this->campaignId)
                ->where('evaluated_user_id', $this->user)
                ->groupBy('evaluated_user_id', 'competences.name') // Agrupar por nombre de competencia
                ->get();

// Extraer los valores 'total_360' y los nombres de las competencias
            $values = $data->pluck('total_360')->toArray();
            $labels = $data->pluck('competence_name')->toArray(); // Usar los nombres como etiquetas

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
