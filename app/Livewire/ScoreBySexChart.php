<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;
use Livewire\Attributes\On;

class ScoreBySexChart extends ChartWidget
{
    protected static ?string $heading = 'Competencias por Género';
    protected static bool $isLazy = true;
    protected static ?string $maxHeight = '800px';

    public array $chartData = [];

    #[On('sex-chart-data-updated')]
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
                'datasets' => [],
            ];
        }

        return [
            'labels' => $this->chartData['labels'],
            'datasets' => $this->chartData['datasets'],
        ];
    }

    protected function getType(): string
    {
        return 'radar';
    }
}
