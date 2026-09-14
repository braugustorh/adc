<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Campaign;
use App\Models\Evaluation360Response;
use App\Models\EvaluationAssign;
use App\Models\Sede;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Evaluation360ProgressService
{
    /**
     * Obtiene las campañas disponibles para el usuario según su rol y sede.
     */
    public function getAvailableCampaigns(User $user): Collection
    {
        $query = Campaign::query()
            ->with(['sedes', 'evaluations'])
            ->whereHas('evaluations', function (Builder $q) {
                $q->where('name', '360')
                    ->orWhere('name', 'like', '%360%')
                    ->orWhere('evaluations_types.id', 2);
            });

        // Si no es Admin ni RH Corp, solo ve campañas que incluyan su sede
        if (!$user->hasAnyRole(['Administrador', 'RH Corp'])) {
            $query->whereHas('sedes', function (Builder $q) use ($user) {
                $q->where('sedes.id', $user->sede_id);
            });
        }

        return $query->orderByRaw("
            CASE 
                WHEN status = 'Activa' THEN 1 
                WHEN status = 'Programada' THEN 2 
                WHEN status = 'Concluida' THEN 3 
                ELSE 4 
            END
        ")
        ->orderByDesc('start_date')
        ->get();
    }

    /**
     * Obtiene las sedes permitidas para el usuario.
     */
    public function getAvailableSedes(User $user, ?int $campaignId = null): Collection
    {
        if ($user->hasAnyRole(['Administrador', 'RH Corp'])) {
            if ($campaignId) {
                $campaign = Campaign::find($campaignId);
                if ($campaign) {
                    return $campaign->sedes()->orderBy('name')->get();
                }
            }
            return Sede::orderBy('name')->get();
        }

        // RH Local solo tiene acceso a su propia sede
        return Sede::where('id', $user->sede_id)->get();
    }

    /**
     * Calcula métricas globales para la campaña y sede especificadas.
     */
    public function getGlobalMetrics(int $campaignId, ?int $sedeId = null): array
    {
        // 1. Obtener todas las asignaciones para esta campaña (filtradas por sede del evaluador si aplica)
        $assignQuery = EvaluationAssign::where('campaign_id', $campaignId);

        if ($sedeId) {
            $assignQuery->whereHas('user', function (Builder $q) use ($sedeId) {
                $q->where('sede_id', $sedeId);
            });
        }

        $allAssignments = $assignQuery->get(['id', 'campaign_id', 'user_id', 'user_to_evaluate_id', 'type']);
        $totalAsignadas = $allAssignments->count();

        if ($totalAsignadas === 0) {
            return [
                'total_asignadas'       => 0,
                'total_contestadas'     => 0,
                'total_pendientes'      => 0,
                'porcentaje_avance'     => 0.0,
                'total_evaluadores'     => 0,
                'evaluadores_completos' => 0,
                'evaluadores_en_cero'   => 0,
                'evaluadores_en_proceso'=> 0,
                'total_evaluados'       => 0,
                'evaluados_completos'   => 0,
            ];
        }

        // 2. Obtener pares evaluador-evaluado que ya tienen respuestas
        $completedPairs = $this->getCompletedPairsMap($campaignId);

        $totalContestadas = 0;
        $evaluatorStats = []; // [user_id => ['total' => X, 'done' => Y]]
        $evaluatedStats = []; // [user_to_evaluate_id => ['total' => X, 'done' => Y]]

        foreach ($allAssignments as $assign) {
            $pairKey = "{$assign->user_id}_{$assign->user_to_evaluate_id}";
            $isDone = isset($completedPairs[$pairKey]);

            if ($isDone) {
                $totalContestadas++;
            }

            // Agrupar por evaluador
            if (!isset($evaluatorStats[$assign->user_id])) {
                $evaluatorStats[$assign->user_id] = ['total' => 0, 'done' => 0];
            }
            $evaluatorStats[$assign->user_id]['total']++;
            if ($isDone) {
                $evaluatorStats[$assign->user_id]['done']++;
            }

            // Agrupar por evaluado
            if (!isset($evaluatedStats[$assign->user_to_evaluate_id])) {
                $evaluatedStats[$assign->user_to_evaluate_id] = ['total' => 0, 'done' => 0];
            }
            $evaluatedStats[$assign->user_to_evaluate_id]['total']++;
            if ($isDone) {
                $evaluatedStats[$assign->user_to_evaluate_id]['done']++;
            }
        }

        $totalPendientes = $totalAsignadas - $totalContestadas;
        $porcentajeAvance = round(($totalContestadas / $totalAsignadas) * 100, 1);

        $evaluadoresCompletos = 0;
        $evaluadoresEnCero = 0;
        $evaluadoresEnProceso = 0;

        foreach ($evaluatorStats as $stat) {
            if ($stat['done'] === $stat['total']) {
                $evaluadoresCompletos++;
            } elseif ($stat['done'] === 0) {
                $evaluadoresEnCero++;
            } else {
                $evaluadoresEnProceso++;
            }
        }

        $evaluadosCompletos = 0;
        $totalEvaluados = count($evaluatedStats);

        if ($sedeId) {
            $evaluatedSedeStats = $this->getEvaluatedProgress($campaignId, $sedeId);
            $totalEvaluados = $evaluatedSedeStats->count();
            $evaluadosCompletos = $evaluatedSedeStats->where('is_ready', true)->count();
        } else {
            foreach ($evaluatedStats as $stat) {
                if ($stat['done'] === $stat['total']) {
                    $evaluadosCompletos++;
                }
            }
        }

        return [
            'total_asignadas'        => $totalAsignadas,
            'total_contestadas'      => $totalContestadas,
            'total_pendientes'       => $totalPendientes,
            'porcentaje_avance'      => $porcentajeAvance,
            'total_evaluadores'      => count($evaluatorStats),
            'evaluadores_completos'  => $evaluadoresCompletos,
            'evaluadores_en_cero'    => $evaluadoresEnCero,
            'evaluadores_en_proceso' => $evaluadoresEnProceso,
            'total_evaluados'        => $totalEvaluados,
            'evaluados_completos'    => $evaluadosCompletos,
        ];
    }

    /**
     * Obtiene el avance segmentado por Sede para la campaña.
     */
    public function getProgressBySede(int $campaignId): Collection
    {
        $campaign = Campaign::with('sedes')->find($campaignId);
        if (!$campaign) {
            return collect();
        }

        $completedPairs = $this->getCompletedPairsMap($campaignId);

        $assignments = EvaluationAssign::with(['user.sede', 'userToEvaluate.sede'])
            ->where('campaign_id', $campaignId)
            ->get();

        $bySede = [];

        // Inicializar con todas las sedes de la campaña
        foreach ($campaign->sedes as $sede) {
            $bySede[$sede->id] = [
                'sede_id'           => $sede->id,
                'sede_name'         => $sede->name,
                'total_asignadas'   => 0,
                'total_contestadas' => 0,
                'total_pendientes'  => 0,
                'porcentaje_avance' => 0.0,
                'evaluadores_set'   => [],
                'evaluados_set'     => [],
            ];
        }

        foreach ($assignments as $assign) {
            // Se asocia a la sede del evaluador
            $sedeId = $assign->user?->sede_id;
            if (!$sedeId || !isset($bySede[$sedeId])) {
                $sedeId = $assign->userToEvaluate?->sede_id;
            }

            if (!$sedeId) {
                continue;
            }

            if (!isset($bySede[$sedeId])) {
                $bySede[$sedeId] = [
                    'sede_id'           => $sedeId,
                    'sede_name'         => $assign->user?->sede?->name ?? "Sede #{$sedeId}",
                    'total_asignadas'   => 0,
                    'total_contestadas' => 0,
                    'total_pendientes'  => 0,
                    'porcentaje_avance' => 0.0,
                    'evaluadores_set'   => [],
                    'evaluados_set'     => [],
                ];
            }

            $pairKey = "{$assign->user_id}_{$assign->user_to_evaluate_id}";
            $isDone = isset($completedPairs[$pairKey]);

            $bySede[$sedeId]['total_asignadas']++;
            if ($isDone) {
                $bySede[$sedeId]['total_contestadas']++;
            }

            $bySede[$sedeId]['evaluadores_set'][$assign->user_id] = true;
            $bySede[$sedeId]['evaluados_set'][$assign->user_to_evaluate_id] = true;
        }

        return collect($bySede)->map(function ($item) {
            $total = $item['total_asignadas'];
            $done = $item['total_contestadas'];
            $item['total_pendientes'] = $total - $done;
            $item['porcentaje_avance'] = $total > 0 ? round(($done / $total) * 100, 1) : 0.0;
            $item['total_evaluadores'] = count($item['evaluadores_set']);
            $item['total_evaluados'] = count($item['evaluados_set']);
            unset($item['evaluadores_set'], $item['evaluados_set']);

            return $item;
        })->values();
    }

    /**
     * Obtiene el listado de evaluadores con su avance y desglose anónimo por roles.
     * PRESERVA LA SECRECÍA: No incluye nombres de personas evaluadas.
     */
    public function getEvaluatorsProgress(
        int $campaignId,
        ?int $sedeId = null,
        ?string $statusFilter = 'todos',
        ?string $search = null
    ): Collection {
        $assignQuery = EvaluationAssign::with([
            'user.department',
            'user.position',
            'user.sede',
        ])
        ->where('campaign_id', $campaignId);

        if ($sedeId) {
            $assignQuery->whereHas('user', function (Builder $q) use ($sedeId) {
                $q->where('sede_id', $sedeId);
            });
        }

        if ($search && trim($search) !== '') {
            $term = '%' . trim($search) . '%';
            $assignQuery->whereHas('user', function (Builder $q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('first_name', 'like', $term)
                    ->orWhere('last_name', 'like', $term)
                    ->orWhereHas('department', fn (Builder $dq) => $dq->where('name', 'like', $term))
                    ->orWhereHas('position', fn (Builder $pq) => $pq->where('name', 'like', $term));
            });
        }

        $allAssignments = $assignQuery->get();
        if ($allAssignments->isEmpty()) {
            return collect();
        }

        $completedPairs = $this->getCompletedPairsMap($campaignId);

        $evaluators = [];

        foreach ($allAssignments as $assign) {
            $user = $assign->user;
            if (!$user) {
                continue;
            }

            $userId = $user->id;

            if (!isset($evaluators[$userId])) {
                $evaluators[$userId] = [
                    'user_id'         => $userId,
                    'name'            => trim("{$user->name} {$user->first_name} {$user->last_name}"),
                    'email'           => $user->email,
                    'profile_photo'   => $user->profile_photo,
                    'department'      => $user->department?->name ?? 'Sin Departamento',
                    'position'        => $user->position?->name ?? 'Sin Puesto',
                    'sede'            => $user->sede?->name ?? 'Sin Sede',
                    'total_asignadas' => 0,
                    'total_contestadas'=> 0,
                    'total_pendientes'=> 0,
                    'porcentaje_avance'=> 0.0,
                    'status'          => 'sin_iniciar', // 'completado', 'en_proceso', 'sin_iniciar'
                    // Desglose anónimo por roles: A (Auto), J (Jefe), S (Subordinado), P (Par), C (Cliente)
                    'roles_breakdown' => [
                        'A' => ['label' => 'Autoevaluación', 'total' => 0, 'done' => 0, 'pending' => 0],
                        'J' => ['label' => 'Jefe Inmediato',  'total' => 0, 'done' => 0, 'pending' => 0],
                        'S' => ['label' => 'Colaborador',    'total' => 0, 'done' => 0, 'pending' => 0],
                        'P' => ['label' => 'Par / Colega',   'total' => 0, 'done' => 0, 'pending' => 0],
                        'C' => ['label' => 'Cliente Interno','total' => 0, 'done' => 0, 'pending' => 0],
                    ],
                ];
            }

            $pairKey = "{$assign->user_id}_{$assign->user_to_evaluate_id}";
            $isDone = isset($completedPairs[$pairKey]);

            $evaluators[$userId]['total_asignadas']++;
            if ($isDone) {
                $evaluators[$userId]['total_contestadas']++;
            }

            $roleType = strtoupper(trim((string) $assign->type));
            if (isset($evaluators[$userId]['roles_breakdown'][$roleType])) {
                $evaluators[$userId]['roles_breakdown'][$roleType]['total']++;
                if ($isDone) {
                    $evaluators[$userId]['roles_breakdown'][$roleType]['done']++;
                } else {
                    $evaluators[$userId]['roles_breakdown'][$roleType]['pending']++;
                }
            }
        }

        $result = collect($evaluators)->map(function ($ev) {
            $total = $ev['total_asignadas'];
            $done = $ev['total_contestadas'];
            $ev['total_pendientes'] = $total - $done;
            $ev['porcentaje_avance'] = $total > 0 ? round(($done / $total) * 100, 1) : 0.0;

            if ($done === $total && $total > 0) {
                $ev['status'] = 'completado';
            } elseif ($done > 0) {
                $ev['status'] = 'en_proceso';
            } else {
                $ev['status'] = 'sin_iniciar';
            }

            return $ev;
        });

        // Filtrar por estatus si se solicita
        if ($statusFilter && $statusFilter !== 'todos') {
            $result = $result->filter(fn ($ev) => $ev['status'] === $statusFilter);
        }

        return $result->sortBy([
            ['total_pendientes', 'desc'],
            ['porcentaje_avance', 'asc'],
            ['name', 'asc'],
        ])->values();
    }

    /**
     * Obtiene el estatus de avance por persona EVALUADA (cuántas evaluaciones ha recibido vs cuántas le corresponden).
     */
    public function getEvaluatedProgress(int $campaignId, ?int $sedeId = null, ?string $search = null): Collection
    {
        $assignQuery = EvaluationAssign::with([
            'userToEvaluate.department',
            'userToEvaluate.position',
            'userToEvaluate.sede',
        ])
        ->where('campaign_id', $campaignId);

        if ($sedeId) {
            $assignQuery->whereHas('userToEvaluate', function (Builder $q) use ($sedeId) {
                $q->where('sede_id', $sedeId);
            });
        }

        if ($search && trim($search) !== '') {
            $term = '%' . trim($search) . '%';
            $assignQuery->whereHas('userToEvaluate', function (Builder $q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('first_name', 'like', $term)
                    ->orWhere('last_name', 'like', $term)
                    ->orWhereHas('department', fn (Builder $dq) => $dq->where('name', 'like', $term));
            });
        }

        $allAssignments = $assignQuery->get();
        if ($allAssignments->isEmpty()) {
            return collect();
        }

        $completedPairs = $this->getCompletedPairsMap($campaignId);

        $evaluated = [];

        foreach ($allAssignments as $assign) {
            $user = $assign->userToEvaluate;
            if (!$user) {
                continue;
            }

            $userId = $user->id;

            if (!isset($evaluated[$userId])) {
                $evaluated[$userId] = [
                    'user_id'            => $userId,
                    'name'               => trim("{$user->name} {$user->first_name} {$user->last_name}"),
                    'department'         => $user->department?->name ?? 'Sin Departamento',
                    'position'           => $user->position?->name ?? 'Sin Puesto',
                    'sede'               => $user->sede?->name ?? 'Sin Sede',
                    'total_esperadas'    => 0,
                    'total_recibidas'    => 0,
                    'total_faltantes'    => 0,
                    'porcentaje_avance'  => 0.0,
                    'is_ready'           => false,
                    'roles_summary'      => [
                        'A' => ['label' => 'Auto',        'expected' => 0, 'received' => 0],
                        'J' => ['label' => 'Jefe',        'expected' => 0, 'received' => 0],
                        'S' => ['label' => 'Colaborador', 'expected' => 0, 'received' => 0],
                        'P' => ['label' => 'Par',         'expected' => 0, 'received' => 0],
                        'C' => ['label' => 'Cliente',     'expected' => 0, 'received' => 0],
                    ],
                ];
            }

            $pairKey = "{$assign->user_id}_{$assign->user_to_evaluate_id}";
            $isDone = isset($completedPairs[$pairKey]);

            $evaluated[$userId]['total_esperadas']++;
            if ($isDone) {
                $evaluated[$userId]['total_recibidas']++;
            }

            $roleType = strtoupper(trim((string) $assign->type));
            if (isset($evaluated[$userId]['roles_summary'][$roleType])) {
                $evaluated[$userId]['roles_summary'][$roleType]['expected']++;
                if ($isDone) {
                    $evaluated[$userId]['roles_summary'][$roleType]['received']++;
                }
            }
        }

        return collect($evaluated)->map(function ($ev) {
            $total = $ev['total_esperadas'];
            $done = $ev['total_recibidas'];
            $ev['total_faltantes'] = $total - $done;
            $ev['porcentaje_avance'] = $total > 0 ? round(($done / $total) * 100, 1) : 0.0;
            $ev['is_ready'] = ($done === $total && $total > 0);

            return $ev;
        })->sortBy([
            ['is_ready', 'asc'], // Los incompletos primero
            ['total_faltantes', 'desc'],
            ['name', 'asc'],
        ])->values();
    }

    /**
     * Envía una notificación en plataforma al evaluador con sus evaluaciones pendientes.
     */
    public function notifyEvaluator(int $evaluatorId, int $campaignId): bool
    {
        $evaluator = User::find($evaluatorId);
        $campaign = Campaign::find($campaignId);

        if (!$evaluator || !$campaign) {
            return false;
        }

        $completedPairs = $this->getCompletedPairsMap($campaignId);

        $pendingCount = EvaluationAssign::where('campaign_id', $campaignId)
            ->where('user_id', $evaluatorId)
            ->get()
            ->filter(fn ($assign) => !isset($completedPairs["{$assign->user_id}_{$assign->user_to_evaluate_id}"]))
            ->count();

        if ($pendingCount === 0) {
            return false;
        }

        Notification::make()
            ->title('Evaluaciones 360° Pendientes')
            ->icon('heroicon-o-clipboard-document-check')
            ->iconColor('warning')
            ->body("Tienes {$pendingCount} evaluación(es) 360° pendiente(s) por responder en la campaña \"{$campaign->name}\". Tu retroalimentación es confidencial e indispensable.")
            ->actions([
                Action::make('evaluar')
                    ->button()
                    ->label('Ir a mis evaluaciones')
                    ->url('/dashboard/panel360'),
            ])
            ->sendToDatabase($evaluator);

        return true;
    }

    /**
     * Envía notificación masiva a todos los evaluadores con pendientes.
     */
    public function notifyMultipleEvaluators(array $evaluatorIds, int $campaignId): int
    {
        $notified = 0;
        foreach ($evaluatorIds as $id) {
            if ($this->notifyEvaluator((int) $id, $campaignId)) {
                $notified++;
            }
        }

        return $notified;
    }

    /**
     * Helper que mapea en memoria qué pares (evaluador -> evaluado) ya contestaron.
     * Retorna array asociativo: ["{user_id}_{evaluated_user_id}" => true]
     */
    private function getCompletedPairsMap(int $campaignId): array
    {
        $responses = Evaluation360Response::select('user_id', 'evaluated_user_id')
            ->where('campaign_id', $campaignId)
            ->groupBy('user_id', 'evaluated_user_id')
            ->get();

        $map = [];
        foreach ($responses as $resp) {
            $map["{$resp->user_id}_{$resp->evaluated_user_id}"] = true;
        }

        return $map;
    }
}
