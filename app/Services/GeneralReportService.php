<?php

namespace App\Services;

use App\Models\PsychometricEvaluation;
use App\Models\EvaluationsTypes;
use App\Services\CompetencyScoringService;

/**
 * GeneralReportService
 *
 * Concentra los resultados de todas las evaluaciones completadas de un batch.
 * Uso: $service->calculateBatch($batchId) → array consolidado listo para PDF/presentación.
 *
 * Para reporte con IA:
 *   $service->generateAiReport($batchId, $deepSeekService) → array con análisis DeepSeek
 */
class GeneralReportService
{
    protected PsychometricScoringService $scoring;

    public function __construct()
    {
        $this->scoring = new PsychometricScoringService();
    }

    /**
     * Calcula y consolida resultados de todas las evaluaciones COMPLETADAS de un batch.
     */
    public function calculateBatch(string $batchId): array
    {
        $evaluations = PsychometricEvaluation::with(['evaluable', 'evaluationType'])
            ->where('batch_id', $batchId)
            ->where('status', 'completed')
            ->get();

        if ($evaluations->isEmpty()) {
            return [];
        }

        $first = $evaluations->first();

        $consolidated = [
            'evaluable'               => $first->evaluable,
            'puesto'                  => $first->puesto,
            'batch_id'                => $batchId,
            'assigned_at'             => $first->assigned_at,
            'total_elapsed_seconds'   => 0,
            'total_elapsed_formatted' => '0m 00s',
            'tests'                   => [],
        ];

        foreach ($evaluations as $evaluation) {
            $testName = $evaluation->evaluationType->name
                ?? "Prueba #{$evaluation->evaluations_type_id}";

            try {
                $results = $this->scoring->calculate($evaluation);
            } catch (\Throwable $e) {
                $results = [
                    'error'     => $e->getMessage(),
                    'test_name' => $testName,
                ];
            }

            $elapsed = max(0, (int) ($evaluation->elapsed_seconds ?? 0));

            $consolidated['tests'][$testName] = [
                'evaluation_id'       => $evaluation->id,
                'test_name'           => $testName,
                'evaluations_type_id' => $evaluation->evaluations_type_id,
                'elapsed_seconds'     => $elapsed,
                'elapsed_formatted'   => self::formatSeconds($elapsed),
                'completed_at'        => $evaluation->completed_at,
                'results'             => $results,
            ];

            $consolidated['total_elapsed_seconds'] += $elapsed;
        }

        $consolidated['total_elapsed_formatted'] = self::formatSeconds(
            $consolidated['total_elapsed_seconds']
        );

        return $consolidated;
    }

    /**
     * Puente entre GeneralReportService y DeepSeekService.
     *
     * Pasos:
     *   1. Llama a calculateBatch() para los resultados psicométricos.
     *   2. Transforma el array al formato que espera DeepSeekService.
     *   3. Llama a DeepSeekService::generateReport() y retorna la respuesta IA.
     *
     * Estructura retornada:
     *   consolidated => resultado de calculateBatch()
     *   ai_report    => respuesta de DeepSeek (array decodificado)
     *   ai_raw       => string JSON crudo para debug
     */
    public function generateAiReport(string $batchId, DeepSeekService $deepSeek, ?string $puestoOverride = null): array
    {
        // 1. Calcular resultados psicométricos
        $consolidated = $this->calculateBatch($batchId);

        if (empty($consolidated)) {
            return ['error' => 'No se encontraron evaluaciones completadas en este batch.'];
        }

        $evaluable = $consolidated['evaluable'];
        $puestoOriginal = $consolidated['puesto'] ?? 'General';

        // Si se pasa un puestoOverride, se usa SOLO para el cálculo/interpretación;
        // el registro original de la evaluación (puesto asignado) no se modifica.
        $puestoNombre = $puestoOverride ?: $puestoOriginal;

        // 2. Preparar $candidateData para DeepSeek
        $candidateData = [
            'name'   => $evaluable->name ?? 'Sin nombre',
            'puesto' => $puestoNombre,
        ];

        // 3. Transformar tests al formato que espera DeepSeekService::generateReport()
        //    Solo pasamos los 'results' de cada prueba, no los metadatos internos.
        $testResults = collect($consolidated['tests'])
            ->mapWithKeys(fn ($test, $name) => [$name => $test['results']])
            ->toArray();

        // 4. Calcular competencias
        $competencyService = app(CompetencyScoringService::class);

        $competencias = $competencyService->calculate($puestoNombre, $testResults);

        // Ajuste estricto + Ajuste relativo
        $ajusteGlobal = $competencyService->calcularAjusteGlobal($competencias);
        $ajusteRelativo = $competencyService->calcularAjusteRelativo($competencias, $puestoNombre);

        // Obtener dictamen dinámico según nivel jerárquico
        $dictamenPHP = $competencyService->obtenerDictamen($ajusteGlobal, $puestoNombre);

        // Obtener el perfil Ideal para la gráfica
        $competenciasIdeal = $competencyService->getIdealCompetenciesProfile($puestoNombre);

        // 4b. Obtener perfil ideal Cleaver para el radar chart
        $cleaverIdeal = $deepSeek->getIdealCleaverForChart($puestoNombre);

        // 5. Llamar a DeepSeek (Actualizamos la firma para pasar el ajuste global)
        $aiResponse = $deepSeek->generateReport($candidateData, $testResults, $competencias, $ajusteGlobal,$dictamenPHP);

        // Detectar si la IA devolvió un error
        $aiError = null;
        if ($aiResponse && isset($aiResponse['reporte']['resultado_global'])) {
            $aiResponse['reporte']['resultado_global']['dictamen'] = $dictamenPHP;
            $aiResponse['reporte']['resultado_global']['apto'] = ($ajusteGlobal >= 70);
            $aiResponse['reporte']['resultado_global']['porcentaje_ajuste'] = $ajusteGlobal;
        }

        if (isset($aiResponse['__ai_error']) && $aiResponse['__ai_error'] === true) {
            $aiError    = $aiResponse;
            $aiResponse = null;
        } elseif (empty($aiResponse)) {
            $aiError = [
                '__ai_error' => true,
                'message' => 'DeepSeek devolvió una respuesta vacía o no válida',
                'code' => 'empty_response',
            ];
            $aiResponse = null;
        }

        $result = [
            'consolidated' => $consolidated,
            'competencias' => $competencias,
            'cleaver_ideal' => $cleaverIdeal,
            'ai_report'    => $aiResponse,
            'ai_error'     => $aiError,
            'ajuste_global'=> $ajusteGlobal,      // <-- AQUI PASAMOS EL 48.91%
            'ajuste_relativo' => $ajusteRelativo,
            'dictamen_calculado' => $dictamenPHP, // <-- AQUI PASAMOS EL "NO APTO"
            'competencias_ideal' => $competenciasIdeal,
            'puesto_original' => $puestoOriginal,
            'puesto_evaluado' => $puestoNombre,
            'ai_raw'       => is_string($aiResponse) ? $aiResponse : json_encode($aiResponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
        ];

        // Persistir el reporte como snapshot histórico si el evaluado es un Candidato.
        if ($evaluable instanceof \App\Models\Candidate) {
            $this->persistSnapshot($evaluable, $batchId, $result);
        }

        return $result;
    }

    /**
     * Guarda un reporte generado como registro histórico ligado al candidato,
     * habilitando comparar reportes del mismo candidato contra distintos puestos
     * sin depender del Cache temporal usado para la previsualización.
     */
    protected function persistSnapshot(\App\Models\Candidate $candidate, string $batchId, array $result): \App\Models\CandidateReportSnapshot
    {
        return \App\Models\CandidateReportSnapshot::create([
            'candidate_id'            => $candidate->id,
            'batch_id'                => $batchId,
            'puesto_original'         => $result['puesto_original'] ?? null,
            'puesto_evaluado'         => $result['puesto_evaluado'] ?? 'General',
            'ajuste_global'           => $result['ajuste_global'] ?? null,
            'ajuste_relativo'         => $result['ajuste_relativo'] ?? null,
            'dictamen'                => $result['dictamen_calculado'] ?? null,
            'competencias_json'       => $result['competencias'] ?? [],
            'competencias_ideal_json' => $result['competencias_ideal'] ?? [],
            'ai_report_json'          => $result['ai_report'] ?? null,
            'cleaver_ideal_json'      => $result['cleaver_ideal'] ?? [],
            'generated_by'            => auth()->id(),
        ]);
    }

    /**
     * Compara 2 o más snapshots de reporte del mismo candidato (por ejemplo,
     * el mismo batch evaluado contra distintos puestos) para ayudar a decidir
     * cuál perfil de puesto conviene más al candidato.
     *
     * @param int[] $snapshotIds
     */
    public function compareSnapshots(array $snapshotIds): array
    {
        $snapshots = \App\Models\CandidateReportSnapshot::whereIn('id', $snapshotIds)
            ->orderBy('created_at')
            ->get();

        if ($snapshots->count() < 2) {
            return ['error' => 'Se necesitan al menos 2 reportes para comparar.'];
        }

        // Índice de competencias por nombre para cada snapshot
        $porCompetencia = [];
        foreach ($snapshots as $snapshot) {
            foreach (($snapshot->competencias_json ?? []) as $comp) {
                $nombre = $comp['nombre'] ?? 'Desconocida';
                $porCompetencia[$nombre][$snapshot->id] = $comp['puntaje'] ?? null;
            }
        }

        return [
            'snapshots' => $snapshots->map(fn ($s) => [
                'id'              => $s->id,
                'puesto_evaluado' => $s->puesto_evaluado,
                'ajuste_global'   => $s->ajuste_global,
                'ajuste_relativo' => $s->ajuste_relativo,
                'dictamen'        => $s->dictamen,
                'generated_at'    => $s->created_at,
            ])->values()->toArray(),
            'competencias' => $porCompetencia,
        ];
    }


    /**
     * Formatea segundos a string legible: "1h 23m 04s" o "12m 05s"
     */
    public static function formatSeconds(int $seconds): string
    {
        $h = intdiv($seconds, 3600);
        $m = intdiv($seconds % 3600, 60);
        $s = $seconds % 60;

        return $h > 0
            ? sprintf('%dh %02dm %02ds', $h, $m, $s)
            : sprintf('%dm %02ds', $m, $s);
    }
}

