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
    public array $userIds = [];
    public $bandera = true;
    public $campaignId;
    protected static bool $isLazy = false;
    protected static ?string $maxHeight = '300px';
    protected static ?string $pollingInterval = null;

    public function mount($campaignId = null, ?array $userIds = null): void
    {
        $this->campaignId = $campaignId
            ?? Campaign::whereStatus('Activa')
                ->whereHas('evaluations', fn ($q) => $q->whereIn('evaluations_types.id', [1, 2]))
                ->latest('id')
                ->value('id')
            ?? Campaign::whereStatus('Concluida')
                ->whereHas('evaluations', fn ($q) => $q->whereIn('evaluations_types.id', [1, 2]))
                ->latest('id')
                ->value('id');

        if ($userIds !== null) {
            $this->userIds = array_values(array_diff(array_map('intval', $userIds), [(int) auth()->id()]));
        } else {
            $supervisorId = auth()->user()?->position_id;
            $this->userIds = User::where('status', true)
                ->where('id', '!=', 1)
                ->where('id', '!=', auth()->id())
                ->whereNotNull('department_id')
                ->whereNotNull('position_id')
                ->whereNotNull('sede_id')
                ->whereHas('position', function ($query) use ($supervisorId) {
                    $query->where('supervisor_id', $supervisorId);
                })
                ->pluck('id')
                ->map(fn ($id) => (int) $id)
                ->toArray();
        }

        $this->bandera = !empty($this->campaignId) && !empty($this->userIds);
    }

    #[On('team-scope-updated')]
    public function updateTeamScope($campaignId, array $userIds): void
    {
        $this->campaignId = $campaignId ? (int) $campaignId : null;
        $this->userIds = array_values(array_diff(array_map('intval', $userIds), [(int) auth()->id()]));
        $this->bandera = !empty($this->campaignId) && !empty($this->userIds);
    }

    public function getData(): array
    {
        if ($this->bandera && $this->campaignId && !empty($this->userIds)) {
            $data = Evaluation360Response::select('competences.name as competence_name')
                ->selectRaw('AVG(response) as total_360')
                ->join('competences', 'evaluation360_responses.competence_id', '=', 'competences.id')
                ->where('campaign_id', $this->campaignId)
                ->whereIn('evaluated_user_id', $this->userIds)
                ->groupBy('competences.name')
                ->get();

            $values = $data->pluck('total_360')->map(fn ($v) => round((float) $v, 2))->toArray();
            $labels = $data->pluck('competence_name')->toArray();

            $configChart = [
                'datasets' => [
                    [
                        'label' => 'Competencias',
                        'data' => $values,
                    ],
                ],
                'labels' => $labels,
            ];
        } else {
            $configChart = [
                'datasets' => [
                    [
                        'label' => 'Competencias',
                        'data' => [],
                    ],
                ],
                'labels' => [],
            ];
        }

        return $configChart;
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
