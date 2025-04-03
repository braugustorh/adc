<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;


class CompetencesClimaChart extends ChartWidget
{
    protected static ?string $heading = 'Percepción por temas de Clima';
    protected static bool $isLazy = true;
    protected static ?string $maxHeight = '400px';

    public array $chartData = [];


    #[On('chart-data-updated')]
    public function handleChartDataUpdated($chartData): void
    {
        $this->chartData = $chartData;
        Log::info('Se Carga esto al CHART COMPETENCES'.$chartData);
        $this->updateChartData();
    }

    protected function getData(): array
    {
        if (empty($this->chartData)) {
            return [
                'datasets' => [
                    [
                        'label' => 'Competencias',
                        'data' => [],
                        'backgroundColor' => 'rgba(54, 162, 235, 0.7)',
                        'borderColor' => 'rgba(54, 162, 235, 1)',
                        'borderWidth' => 1
                    ]
                ],
                'labels' => [],
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Competencias',
                    'data' => array_column($this->chartData, 'average'),
                    /*
                    'backgroundColor' => array_map(function() {
                        return 'rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).',0.7)';
                    }, $this->chartData),
                    'borderColor' => array_map(function() {
                        return 'rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).',1)';
                    }, $this->chartData),
                    'borderWidth' => 1
                    */
                    'backgroundColor' => [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(83, 219, 139, 0.7)',
                        'rgba(204, 102, 255, 0.7)',
                    ],
                    'borderColor' => [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(83, 219, 139, 1)',
                        'rgba(204, 102, 255, 1)',
                    ],
                    'borderWidth' => 1
                ],
            ],
            'labels' => array_column($this->chartData, 'competence'),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
