<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\Campaign;
use App\Models\Sede;
use App\Models\User;
use App\Services\Evaluation360ProgressService;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

class Monitor360 extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationLabel = 'Monitor de Avance 360';
    protected static ?string $navigationGroup = 'Evaluaciones';
    protected ?string $heading = 'Monitor de Avance 360°';
    protected ?string $subheading = 'Monitoreo en tiempo real del cumplimiento de evaluaciones 360° por central y evaluador.';
    protected static ?int $navigationSort = 2;
    protected static string $view = 'filament.pages.monitor-360';

    // Propiedades de Estado
    public ?int $campaign_id = null;
    public ?int $sede_id = null;
    public string $activeTab = 'sedes'; // 'sedes', 'evaluadores', 'evaluados'
    public string $statusFilter = 'todos'; // 'todos', 'sin_iniciar', 'en_proceso', 'completado'
    public string $search = '';

    // Modal de Desglose Anónimo
    public bool $showBreakdownModal = false;
    public ?array $selectedEvaluator = null;

    protected Evaluation360ProgressService $progressService;

    public function boot(Evaluation360ProgressService $progressService): void
    {
        $this->progressService = $progressService;
    }

    public function isCorpOrAdmin(): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole(['Administrador', 'RH Corp']);
    }

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole([
            'Administrador',
            'RH Corp',
            'RH',
        ]);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canView();
    }

    public function getTitle(): string|Htmlable
    {
        return __('Monitor de Avance 360°');
    }

    public function mount(): void
    {
        $user = auth()->user();
        $isCorpOrAdmin = $this->isCorpOrAdmin();
        $campaigns = $this->progressService->getAvailableCampaigns($user);

        // Seleccionar por defecto la campaña activa más reciente o la primera disponible
        $activeCampaign = $campaigns->firstWhere('status', 'Activa') ?? $campaigns->first();
        $this->campaign_id = $activeCampaign?->id;

        // Si es RH Local, restringir estrictamente a su sede y a pestaña evaluadores
        if (!$isCorpOrAdmin) {
            $this->sede_id = $user->sede_id;
            $this->activeTab = 'evaluadores'; // Para RH Local, iniciar directo en su detalle
        } else {
            $this->sede_id = null; // 'Todas las Centrales' para RH Corp y Admin
            $this->activeTab = 'sedes';
        }
    }

    public function updatedCampaignId(): void
    {
        $this->resetPageFilters();
    }

    public function updatedSedeId(): void
    {
        if (!$this->isCorpOrAdmin()) {
            $this->sede_id = auth()->user()->sede_id;
        }
        $this->resetPageFilters();
    }

    public function updatedStatusFilter(): void
    {
        // No resetea sede ni campaña
    }

    public function updatedSearch(): void
    {
        // No resetea sede ni campaña
    }

    public function setTab(string $tab): void
    {
        // La pestaña de todas las sedes es exclusiva para RH Corp y Admin
        if ($tab === 'sedes' && !$this->isCorpOrAdmin()) {
            $this->activeTab = 'evaluadores';
            return;
        }
        $this->activeTab = $tab;
    }

    public function filterBySedeAndGoToEvaluators(int $sedeId): void
    {
        if (!$this->isCorpOrAdmin()) {
            $this->sede_id = auth()->user()->sede_id;
        } else {
            $this->sede_id = $sedeId;
        }
        $this->activeTab = 'evaluadores';
    }

    public function clearSedeFilter(): void
    {
        if ($this->isCorpOrAdmin()) {
            $this->sede_id = null;
        }
    }

    private function resetPageFilters(): void
    {
        $this->statusFilter = 'todos';
        $this->search = '';
        $this->showBreakdownModal = false;
        $this->selectedEvaluator = null;
    }

    /**
     * Abre el modal de desglose anónimo por roles para un evaluador.
     */
    public function openBreakdownModal(int $evaluatorId): void
    {
        if (!$this->campaign_id) {
            return;
        }

        $evaluators = $this->progressService->getEvaluatorsProgress(
            $this->campaign_id,
            $this->sede_id,
            'todos',
            null
        );

        $evaluator = $evaluators->firstWhere('user_id', $evaluatorId);
        if ($evaluator) {
            $this->selectedEvaluator = $evaluator;
            $this->showBreakdownModal = true;
        }
    }

    public function closeBreakdownModal(): void
    {
        $this->showBreakdownModal = false;
        $this->selectedEvaluator = null;
    }

    /**
     * Envía una notificación individual en plataforma al evaluador.
     */
    public function sendNotification(int $evaluatorId): void
    {
        if (!$this->campaign_id) {
            return;
        }

        $success = $this->progressService->notifyEvaluator($evaluatorId, $this->campaign_id);

        if ($success) {
            Notification::make()
                ->title('Recordatorio enviado')
                ->success()
                ->body('Se ha enviado una notificación en plataforma al evaluador.')
                ->send();
        } else {
            Notification::make()
                ->title('No fue necesario notificar')
                ->info()
                ->body('El evaluador no cuenta con evaluaciones pendientes o ya las completó todas.')
                ->send();
        }
    }

    /**
     * Envía notificaciones masivas a todos los evaluadores que tengan evaluaciones pendientes en la vista actual.
     */
    public function sendBulkNotifications(): void
    {
        if (!$this->campaign_id) {
            return;
        }

        $evaluators = $this->progressService->getEvaluatorsProgress(
            $this->campaign_id,
            $this->sede_id,
            $this->statusFilter,
            $this->search
        );

        $pendingEvaluatorIds = $evaluators
            ->filter(fn ($ev) => $ev['total_pendientes'] > 0)
            ->pluck('user_id')
            ->toArray();

        if (empty($pendingEvaluatorIds)) {
            Notification::make()
                ->title('Sin evaluadores pendientes')
                ->info()
                ->body('No hay evaluadores con asignaciones pendientes en los filtros actuales.')
                ->send();
            return;
        }

        $count = $this->progressService->notifyMultipleEvaluators($pendingEvaluatorIds, $this->campaign_id);

        Notification::make()
            ->title('Recordatorios masivos enviados')
            ->success()
            ->body("Se enviaron exitosamente {$count} notificaciones en plataforma a evaluadores con pendientes.")
            ->send();
    }

    protected function getViewData(): array
    {
        $user = auth()->user();
        $isCorpOrAdmin = $this->isCorpOrAdmin();

        // Reforzar seguridad: si no es Corp ni Admin, sede_id siempre es su sede asignada
        if (!$isCorpOrAdmin) {
            $this->sede_id = $user->sede_id;
            if ($this->activeTab === 'sedes') {
                $this->activeTab = 'evaluadores';
            }
        }

        $campaigns = $this->progressService->getAvailableCampaigns($user);
        $sedes = $this->progressService->getAvailableSedes($user, $this->campaign_id);

        $selectedCampaign = $this->campaign_id ? Campaign::with('sedes')->find($this->campaign_id) : null;

        // Calcular días restantes de campaña
        $daysRemaining = null;
        $isCampaignEnded = false;
        if ($selectedCampaign && $selectedCampaign->end_date) {
            $endDate = Carbon::parse($selectedCampaign->end_date)->endOfDay();
            $now = Carbon::now();
            $isCampaignEnded = $now->greaterThan($endDate);
            $daysRemaining = (int) $now->diffInDays($endDate, false);
        }

        // Métricas Globales (para RH local se calculan solo con su sede_id)
        $metrics = $this->campaign_id
            ? $this->progressService->getGlobalMetrics($this->campaign_id, $this->sede_id)
            : [];

        // Datos de la Pestaña Activa
        $sedesProgress = collect();
        $evaluatorsProgress = collect();
        $evaluatedProgress = collect();

        if ($this->campaign_id) {
            if ($this->activeTab === 'sedes' && $isCorpOrAdmin) {
                $sedesProgress = $this->progressService->getProgressBySede($this->campaign_id);
            } elseif ($this->activeTab === 'evaluadores') {
                $evaluatorsProgress = $this->progressService->getEvaluatorsProgress(
                    $this->campaign_id,
                    $this->sede_id,
                    $this->statusFilter,
                    $this->search
                );
            } elseif ($this->activeTab === 'evaluados') {
                $evaluatedProgress = $this->progressService->getEvaluatedProgress(
                    $this->campaign_id,
                    $this->sede_id,
                    $this->search
                );
            }
        }

        return [
            'campaigns'          => $campaigns,
            'selectedCampaign'   => $selectedCampaign,
            'sedes'              => $sedes,
            'metrics'            => $metrics,
            'sedesProgress'      => $sedesProgress,
            'evaluatorsProgress' => $evaluatorsProgress,
            'evaluatedProgress'  => $evaluatedProgress,
            'daysRemaining'      => $daysRemaining,
            'isCampaignEnded'    => $isCampaignEnded,
            'isCorpOrAdmin'      => $isCorpOrAdmin,
            'currentUser'        => $user,
        ];
    }
}
