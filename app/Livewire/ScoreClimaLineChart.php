<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;
use Livewire\Attributes\On;

class ScoreClimaLineChart extends ChartWidget
{
    protected static ?string $heading = 'Evolución del Puntaje Global por Campaña';
    public array $chartData = [];
    protected static bool $isLazy = true;
    protected static ?string $maxHeight = '600px';

    #[On('line-chart-data-updated')]
    public function handleChartDataUpdated($chartData): void
    {
        $this->chartData = $chartData;
        $this->updateChartData();
    }
    protected function getData(): array
    {
        if (empty($this->chartData)) {
            return [
                'labels' => [],
                'datasets' => [
                    [
                        'label' => 'Puntaje Global por Campaña',
                        'data' => [],
                        'fill' => false,
                        'borderColor' => 'rgba(153, 102, 255, 0.7)',
                        'tension' => 0.1,
                        'pointBorderWidth' => 4,
                        'pointBackgroundColor' => 'rgb(255, 99, 132)',
                        'pointRadius' => 9,
                    ]
                ]
            ];
        }

        return [
            'labels' => array_column($this->chartData, 'campaign'),
            'datasets' => [
                [
                    'label' => 'Puntaje Global por Campaña',
                    'data' => array_column($this->chartData, 'score'),
                    'fill' => false,
                    'borderColor' => 'rgba(255, 159, 64)',
                    'backgroundColor' => 'rgba(255, 159, 64)',
                    'tension' => 0.1,
                    'radius'=> 5,
                    'pointBorderWidth' => 4,
                    'pointBackgroundColor' => 'rgb(255, 99, 132)',
                    'pointRadius' => 5,

                ]

            ],

        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
