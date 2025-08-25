<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;

class CompetencesClimaAgesChart extends ChartWidget
{
    protected static ?string $heading = 'Promedio por Competencia y Rango de Edad';
    protected static bool $isLazy = true;
    protected static ?string $maxHeight = '600px';

    public array $chartData = [];

    #[On('ages-chart-data-updated')]
    public function handleChartDataUpdated(array $chartData): void
    {
        $this->chartData = $chartData;
        $this->updateChartData();
    }

    protected function getData(): array
    {
        // Estructura esperada por Chart.js vía Filament
        return $this->chartData ?: [
            'labels' => [],
            'datasets' => [],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

