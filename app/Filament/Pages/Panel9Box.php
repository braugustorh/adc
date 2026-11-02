<?php

namespace App\Filament\Pages;

use App\Models\Campaign;
use App\Livewire\CompetencesChart;
use App\Models\Competence;
use App\Models\Department;
use App\Models\Psychometry;
use App\Models\Sede;
use Filament\Actions\Contracts\HasLivewire;
use Filament\Resources\Concerns\HasTabs;
use Filament\Tables\Grouping\Group;
use App\Models\Evaluation360Response;
use App\Models\EvaluationAssign;
use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Livewire\Attributes\On;


class Panel9Box extends Page implements HasTable
{
    use InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-c-squares-plus';
    protected static ?string $navigationLabel = ' Panel 9Box';
    protected static ?string $navigationGroup = 'Evaluaciones';
    protected ?string $heading = 'Panel 9 Box';
    protected ?string $subheading = 'Visualiza el análisis de los colaboradores';
    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.panel9-box';
    public $members;
    public $campaigns;
    public $campaignId;
    public ?int $sedeId = null;
    public ?int $departmentId = null;
    public ?int $leaderPositionId = null;
    public $totales;
    public $users,$userToEvaluated;
    public $user;
    public $show=false;
    public $showChartOnView=false;
    public $activeTab='tab1';
    public $quadrants = [];
    public array $collaboratorScores = [];
    public $orderedIndexes = [4, 7, 9, 2, 5, 8, 1, 3, 6];
    public $titles = [
        9 => 'Futuro Líder',
        8 => 'Estrella Emergente',
        7 => 'Líder Emergente',
        6 => 'Experto Destacado',
        5 => 'Jugador Clave',
        4 => 'Diamante en Bruto',
        3 => 'Desempeño Sólido',
        2 => 'Jugador Inconsistente',
        1 => 'Riesgo de Talento',
    ];
    public $colorBadgets=[
        9 => 'success',
        8 => 'success',
        7 => 'success',
        6 => 'warning',
        5 => 'warning',
        4 => 'warning',
        3 => 'info',
        2 => 'info',
        1 => 'danger',
    ];

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole([
            'Administrador',
            'Super Administrador',
            'RH Corp',
            'RH',
            'Gerente',
            'Supervisor',
            'Visor',
        ]);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canView();
    }

    /**
     * Determina si el usuario autenticado tiene visión multi-sede global.
     */
    public function isGlobalViewer(): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole([
            'Administrador',
            'Super Administrador',
            'RH Corp',
            'Visor',
        ]);
    }

    /**
     * Determina si el usuario puede explorar todos los departamentos/equipos de su sede.
     */
    public function canFilterTeamsAndDepartments(): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole([
            'Administrador',
            'Super Administrador',
            'RH Corp',
            'RH',
            'Gerente',
            'Visor',
        ]);
    }

    public function mount(): void
    {
        $authUser = auth()->user();

        $this->campaignId = Campaign::whereStatus('Activa')
            ->whereHas('evaluations', fn ($q) => $q->whereIn('evaluations_types.id', [1, 2]))
            ->latest('id')
            ->value('id')
            ?? Campaign::whereStatus('Concluida')
                ->whereHas('evaluations', fn ($q) => $q->whereIn('evaluations_types.id', [1, 2]))
                ->latest('id')
                ->value('id');

        if ($this->isGlobalViewer()) {
            $this->sedeId = null; // Todas las sedes por defecto
            $this->departmentId = null;
            $this->leaderPositionId = null;
        } elseif ($this->canFilterTeamsAndDepartments()) {
            // RH Local y Gerente/Director: fijo en su sede, libre de ver toda la sede, por depto o por equipo
            $this->sedeId = $authUser?->sede_id;
            $this->departmentId = null;
            $this->leaderPositionId = null;
        } else {
            // Supervisor únicamente: fijo en su sede y en su equipo directo
            $this->sedeId = $authUser?->sede_id;
            $this->departmentId = null;
            $this->leaderPositionId = $authUser?->position_id;
        }

        $this->resolveScopedUsers();
    }

    /**
     * Construye y ejecuta la consulta de colaboradores permitidos según el rol,
     * los filtros seleccionados y el candado estricto de auto-exclusión.
     */
    public function resolveScopedUsers(): void
    {
        $authUser = auth()->user();
        if (!$authUser) {
            $this->users = collect();
            return;
        }

        // Reforzar candados de rol sobre las propiedades de filtro
        if (!$this->isGlobalViewer()) {
            $this->sedeId = $authUser->sede_id;
        }
        if (!$this->canFilterTeamsAndDepartments()) {
            $this->leaderPositionId = $authUser->position_id;
        }

        $query = User::with(['position', 'department', 'sede'])
            ->where('status', true)
            ->where('id', '!=', 1)
            // CANDADO ESTRICTO: Ningún usuario (ni RH, ni RH Corp, ni Director) puede ver su propio resultado
            ->where('id', '!=', $authUser->id)
            ->whereNotNull('department_id')
            ->whereNotNull('position_id')
            ->whereNotNull('sede_id');

        if ($this->sedeId) {
            $query->where('sede_id', $this->sedeId);
        }

        if ($this->departmentId) {
            $query->where('department_id', $this->departmentId);
        }

        if ($this->leaderPositionId) {
            $leaderPosId = (int) $this->leaderPositionId;
            $query->whereHas('position', function (Builder $q) use ($leaderPosId) {
                $q->where('supervisor_id', $leaderPosId);
            });
        }

        $this->users = $query
            ->orderBy('name')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
    }

    public function updatedCampaignId($value): void
    {
        $this->campaignId = $value ? (int) $value : null;
        $this->syncAfterFilterChange(keepSelectedUser: true);
    }

    public function updatedSedeId($value): void
    {
        $this->sedeId = ($this->isGlobalViewer() && !empty($value)) ? (int) $value : ($this->isGlobalViewer() ? null : auth()->user()?->sede_id);
        $this->departmentId = null;
        if ($this->canFilterTeamsAndDepartments()) {
            $this->leaderPositionId = null;
        }
        $this->syncAfterFilterChange(keepSelectedUser: false);
    }

    public function updatedDepartmentId($value): void
    {
        $this->departmentId = !empty($value) ? (int) $value : null;
        if ($this->canFilterTeamsAndDepartments()) {
            $this->leaderPositionId = null;
        }
        $this->syncAfterFilterChange(keepSelectedUser: false);
    }

    public function updatedLeaderPositionId($value): void
    {
        if ($this->canFilterTeamsAndDepartments()) {
            $this->leaderPositionId = !empty($value) ? (int) $value : null;
        } else {
            $this->leaderPositionId = auth()->user()?->position_id;
        }
        $this->syncAfterFilterChange(keepSelectedUser: false);
    }

    public function clearScopeFilters(): void
    {
        $authUser = auth()->user();
        $this->sedeId = $this->isGlobalViewer() ? null : $authUser?->sede_id;
        $this->departmentId = null;
        $this->leaderPositionId = $this->canFilterTeamsAndDepartments() ? null : $authUser?->position_id;
        $this->syncAfterFilterChange(keepSelectedUser: false);
    }

    private function syncAfterFilterChange(bool $keepSelectedUser = false): void
    {
        $this->resolveScopedUsers();

        if (!$keepSelectedUser || ($this->user && !$this->users->contains('id', (int) $this->user))) {
            $this->user = '';
            $this->show = false;
            $this->userToEvaluated = null;
            $this->dispatch('update-chart', null, $this->campaignId);
            $this->dispatch('data-updated', null, $this->campaignId, $this->titles, $this->colorBadgets);
        } elseif ($this->user) {
            $this->dispatch('update-chart', $this->user, $this->campaignId);
            $this->dispatch('data-updated', $this->user, $this->campaignId, $this->titles, $this->colorBadgets);
        }

        if ($this->activeTab === 'tab3') {
            $this->prepareQuadrantData();
        }

        $this->resetTable();
        $this->dispatch('team-scope-updated', $this->campaignId, $this->users->pluck('id')->toArray());
    }
    protected function getTableQuery()
    {

        /*
        return Evaluation360Response::select('evaluated_user_id', 'competence_id', DB::raw('AVG(response) as score'))
            ->where('campaign_id', $this->campaignId)
            ->whereIn('evaluated_user_id', $this->users->pluck('id')->toArray())
            ->groupBy('evaluated_user_id', 'competence_id');
        */

        return Evaluation360Response::with('competences')
            ->select('competence_id', DB::raw('AVG(response) as score'))
            ->where('campaign_id', $this->campaignId)
            ->whereIn('evaluated_user_id', $this->users->pluck('id')->toArray())
            ->groupBy('competence_id') // Agregar id al GROUP BY
            ->orderBy('competence_id');// Agrupar por nombre de competencia
    }
    protected function getTableColumns(): array
    {
        return [
            //Tables\Columns\ImageColumn::make('evaluatedUsers.profile_photo')->rounded()->label(''),
            //Tables\Columns\TextColumn::make('evaluatedUsers.name')->label('User'),
            Tables\Columns\TextColumn::make('competences.name')->label('Competencia')
                ->description(
                    fn (Evaluation360Response $record): string => (string) ($record->competences?->description ?? '')
                )->wrap(),
        //Tables\Columns\TextColumn::make('competences.description')->label('Descripción')->wrap(),
            // Tables\Columns\TextColumn::make('questions.question')->label('Pregunta'),
            Tables\Columns\TextColumn::make('score')
                ->label('Score')
                ->formatStateUsing(fn (string $state): string => is_numeric($state) ? number_format((float)$state, 3) : $state)
                ->badge()
                ->color(function (string $state): string {
                    $score = (float) $state;
                    return match (true) {
                        $score >= 4.0 && $score <= 5.0 => 'success',
                        $score >= 2.0 && $score < 4.0 => 'warning',
                        $score >= 0.0 && $score < 2.0 => 'danger',
                        default => 'gray',
                    };
                }),
        ];
    }
    public function getTableRecordKey($record): string
    {
        return (string) ($record->competence_id ?? $record->getKey());
    }

    public function updatedUser($value): void
    {
        if (empty($value) || (int) $value === (int) auth()->id()) {
            $this->user = '';
            $this->show = false;
            $this->showChartOnView = false;
            $this->userToEvaluated = null;
            return;
        }

        // Candado de alcance: el colaborador debe pertenecer al conjunto permitido
        if (!$this->users || !$this->users->contains('id', (int) $value)) {
            $this->user = '';
            $this->show = false;
            $this->showChartOnView = false;
            $this->userToEvaluated = null;
            return;
        }

        $this->userToEvaluated = User::with(['position.supervisor.user', 'department', 'sede'])
            ->where('id', '!=', auth()->id())
            ->find((int) $value);
        $this->show = (bool) $this->userToEvaluated;
        $this->showChartOnView = (bool) $this->userToEvaluated;
        $this->dispatch('update-chart', (int) $value, $this->campaignId);
        $this->dispatch('data-updated', (int) $value, $this->campaignId, $this->titles, $this->colorBadgets);
    }

    /**
     * Navegación interactiva (Drill-down) desde un cuadrante de la matriz 9-Box hacia el detalle individual.
     */
    public function inspectCollaborator(int $userId): void
    {
        if ($userId === (int) auth()->id() || !$this->users || !$this->users->contains('id', $userId)) {
            return;
        }

        $this->quadrants = [];
        $this->collaboratorScores = [];
        $this->activeTab = 'tab1';
        $this->user = $userId;
        $this->updatedUser($userId);
    }

    #[On('show-chart')]
    public function showChart(): void
    {
        $this->showChartOnView = true;
    }

    public function prepareQuadrantData(): void
    {
        // Inicializar los cuadrantes y mapa escalar de puntajes
        $this->collaboratorScores = [];
        for ($i = 1; $i <= 9; $i++) {
            $this->quadrants[$i] = [
                'collaborators' => [],
                'percentage' => 0,
            ];
        }

        $scopedIds = $this->users ? $this->users->pluck('id')->toArray() : [];
        if (empty($scopedIds) || !$this->campaignId) {
            return;
        }

        // Obtener todos los colaboradores evaluados dentro del alcance actual
        $collaborators = Evaluation360Response::select('evaluated_user_id')
            ->selectRaw('AVG(response) as total_360')
            ->where('campaign_id', $this->campaignId)
            ->whereIn('evaluated_user_id', $scopedIds)
            ->groupBy('evaluated_user_id')
            ->get();

        $totalCollaborators = $collaborators->count();
        $potentials = Psychometry::select('user_id', DB::raw('
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
            ->whereIn('user_id', $scopedIds)
            ->groupBy('user_id')
            ->pluck('total_average', 'user_id');

        foreach ($collaborators as $collaborator) {
            $userId = (int) $collaborator->evaluated_user_id;
            $potentialScore = $potentials[$userId] ?? null;
            // Determinar el cuadrante del colaborador
            $quadrant = $this->getQuadrantForCollaborator($collaborator, $potentialScore);

            // Agregar el colaborador al cuadrante correspondiente
            // Solo ids y escalares: un modelo sin PK en una propiedad pública rompe la rehidratación de Livewire (404)
            $this->quadrants[$quadrant]['collaborators'][] = $userId;
            $this->collaboratorScores[$userId] = [
                'score_360' => round((float) $collaborator->total_360, 2),
                'score_potential' => $potentialScore !== null ? round((float) $potentialScore, 2) : null,
            ];
        }

        // Calcular el porcentaje de colaboradores en cada cuadrante
        for ($i = 1; $i <= 9; $i++) {
            $count = count($this->quadrants[$i]['collaborators']);
            $percentage = $totalCollaborators > 0 ? ($count / $totalCollaborators) * 100 : 0;
            $this->quadrants[$i]['percentage'] = number_format($percentage, 2);
        }
    }

    private function getQuadrantForCollaborator($collaborator, $potential)
    {
        $performanceScore = is_object($collaborator) ? ($collaborator->total_360 ?? null) : $collaborator;

        return self::calculateQuadrant($performanceScore, $potential);
    }

    public static function calculateQuadrant($performanceScore, $potentialScore): int
    {
        // Mapear los puntajes a niveles (1: Bajo, 2: Medio, 3: Alto)
        $performanceLevel = self::mapScoreToLevel($performanceScore);
        $potentialLevel = self::mapScoreToLevel($potentialScore);

        $quadrant = ($performanceLevel - 1) * 3 + $potentialLevel;
        static $remap = [
            1 => 1,
            2 => 2,
            3 => 4,
            4 => 3,
            5 => 5,
            6 => 7,
            7 => 6,
            8 => 8,
            9 => 9,
        ];

        return $remap[$quadrant];
    }

    public static function mapScoreToLevel($score): int
    {
        if ($score === null || !is_numeric($score)) {
            return 1; // Bajo
        }

        $normalized = round((float) $score, 2);

        if ($normalized >= 4.0) {
            return 3; // Alto
        } elseif ($normalized >= 3.0 && $normalized < 4.0) {
            return 2; // Medio
        } else {
            return 1; // Bajo
        }
    }

    public function changeTab($tab)
    {
        if ($tab === 'tab3') {
            $this->loadQuadrantData();
            $this->activeTab = $tab;
        } else {
            $this->quadrants = [];
            $this->collaboratorScores = [];
            $this->activeTab = $tab;
        }
    }

    public function loadQuadrantData()
    {
        $this->prepareQuadrantData();
    }

    protected function getViewData(): array
    {
        $authUser = auth()->user();

        $availableCampaigns = Campaign::whereIn('status', ['Activa', 'Concluida'])
            ->whereHas('evaluations', fn ($q) => $q->whereIn('evaluations_types.id', [1, 2]))
            ->orderByRaw("CASE WHEN status = 'Activa' THEN 0 ELSE 1 END")
            ->orderByDesc('id')
            ->get(['id', 'name', 'status']);

        $availableSedes = $this->isGlobalViewer()
            ? Sede::where('status', true)->orderBy('name')->get(['id', 'name'])
            : Sede::where('id', $authUser?->sede_id)->get(['id', 'name']);

        $departmentsQuery = Department::query()->orderBy('name');
        if ($this->sedeId) {
            $departmentsQuery->where('sede_id', $this->sedeId);
        }
        $availableDepartments = $departmentsQuery->get(['id', 'name', 'sede_id']);

        // Identificar posiciones líderes que tienen colaboradores subordinados en el alcance actual (Sede / Depto)
        $subordinatesScope = User::query()
            ->where('status', true)
            ->where('id', '!=', 1)
            ->where('id', '!=', $authUser?->id)
            ->whereNotNull('position_id')
            ->whereNotNull('department_id')
            ->whereNotNull('sede_id');

        if ($this->sedeId) {
            $subordinatesScope->where('sede_id', $this->sedeId);
        }
        if ($this->departmentId) {
            $subordinatesScope->where('department_id', $this->departmentId);
        }

        $supervisorPositionIds = Position::whereIn('id', $subordinatesScope->pluck('position_id')->unique())
            ->whereNotNull('supervisor_id')
            ->pluck('supervisor_id')
            ->unique()
            ->values();

        if (!$this->canFilterTeamsAndDepartments() && $authUser?->position_id) {
            $supervisorPositionIds = collect([$authUser->position_id]);
        }

        $leaderPositions = Position::with(['user' => function ($q) {
                $q->where('status', true)->orderBy('name');
            }])
            ->whereIn('id', $supervisorPositionIds)
            ->orderBy('name')
            ->get();

        $availableLeaders = $leaderPositions->map(function (Position $pos) {
            $holder = $pos->user->first();
            $holderName = $holder
                ? trim($holder->name . ' ' . $holder->first_name . ' ' . $holder->last_name)
                : null;
            return [
                'position_id' => $pos->id,
                'position_name' => $pos->name,
                'holder_name' => $holderName,
                'label' => $holderName ? "{$holderName} · {$pos->name}" : $pos->name,
            ];
        })->values();

        // Métricas ejecutivas del alcance filtrado
        $scopedIds = $this->users ? $this->users->pluck('id')->toArray() : [];
        $totalScopedUsers = count($scopedIds);
        $evaluated360Count = 0;
        $avg360 = null;
        $avgPotential = null;

        if ($totalScopedUsers > 0 && $this->campaignId) {
            $evalStats = Evaluation360Response::query()
                ->where('campaign_id', $this->campaignId)
                ->whereIn('evaluated_user_id', $scopedIds)
                ->selectRaw('COUNT(DISTINCT evaluated_user_id) as evaluated_count, AVG(response) as avg_score')
                ->first();

            $evaluated360Count = (int) ($evalStats?->evaluated_count ?? 0);
            $avg360 = $evalStats?->avg_score !== null ? round((float) $evalStats->avg_score, 2) : null;
        }

        if ($totalScopedUsers > 0) {
            $potAvg = Psychometry::query()
                ->whereIn('user_id', $scopedIds)
                ->selectRaw('
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
                    NULLIF((COUNT(leadership) +
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
                    COUNT(willingness_service)), 0) as avg_pot
                ')
                ->value('avg_pot');

            $avgPotential = $potAvg !== null ? round((float) $potAvg, 2) : null;
        }

        $coveragePct = $totalScopedUsers > 0 ? (int) round(($evaluated360Count / $totalScopedUsers) * 100) : 0;

        return [
            'availableCampaigns' => $availableCampaigns,
            'availableSedes' => $availableSedes,
            'availableDepartments' => $availableDepartments,
            'availableLeaders' => $availableLeaders,
            'isGlobalViewer' => $this->isGlobalViewer(),
            'canFilterTeams' => $this->canFilterTeamsAndDepartments(),
            'scopeMetrics' => [
                'total_users' => $totalScopedUsers,
                'evaluated_360_count' => $evaluated360Count,
                'coverage_pct' => $coveragePct,
                'avg_360' => $avg360,
                'avg_potential' => $avgPotential,
            ],
        ];
    }
}
