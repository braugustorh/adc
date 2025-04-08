<?php

namespace App\Imports;

use App\Models\EvaluationAssign;
use App\Models\EvaluationsTypes;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class EvaluatedNetworkImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    protected $rowCount = 0;
    protected $evaluationId;
    protected $importId;
    protected static $lastImportId = null;

    public function __construct()
    {
        $this->importId = Str::uuid()->toString();
        self::$lastImportId = $this->importId;

        $evaluationType = EvaluationsTypes::where('name', '360')->first();
        if (!$evaluationType) {
            throw new \Exception('No se encontró la evaluación tipo "360"');
        }
        $this->evaluationId = $evaluationType->id;

        Cache::put("import_{$this->importId}", [
            'rowCount' => 0,
            'failures' => [],
            'error' => null, // Campo adicional para errores generales
        ], now()->addMinutes(30)); // Aumentado a 30 minutos
    }

    public function collection(Collection $collection)
    {
        try {
            foreach ($collection as $row) {
                $campaignId = $row['campana_id'];
                $evaluadorId = $row['evaluador_id'];
                for ($i = 1; $i <= 6; $i++) {
                    $evaluadoIdColumn = "evaluado_id_$i";
                    $evaluadoId = $row[$evaluadoIdColumn] ?? null;

                    if ($evaluadoId && $evaluadoId > 0) {
                        $evaluado = User::find($evaluadoId);

                        if ($evaluado && $evaluado->position_id) {
                            EvaluationAssign::updateOrCreate(
                                [
                                    'evaluation_id' => $this->evaluationId,
                                    'campaign_id' => $campaignId,
                                    'user_id' => $evaluadorId,
                                    'user_to_evaluate_id' => $evaluadoId,
                                ],
                                [
                                    'position_id' => $evaluado->position_id,
                                ]
                            );
                            $this->rowCount++;
                        }
                    }
                }
            }

            Cache::put("import_{$this->importId}", [
                'rowCount' => $this->rowCount,
                'failures' => Cache::get("import_{$this->importId}")['failures'],
                'error' => null,
            ], now()->addMinutes(30));
        } catch (\Exception $e) {
            Cache::put("import_{$this->importId}", [
                'rowCount' => $this->rowCount,
                'failures' => Cache::get("import_{$this->importId}")['failures'],
                'error' => $e->getMessage(),
            ], now()->addMinutes(30));
            \Log::error('Error en collection', ['exception' => $e->getMessage()]);
        }
    }

    public function onFailure(\Maatwebsite\Excel\Validators\Failure ...$failures)
    {
        $currentData = Cache::get("import_{$this->importId}", ['rowCount' => 0, 'failures' => [], 'error' => null]);
        $currentFailures = $currentData['failures'];
        $newFailures = array_merge($currentFailures, $failures);

        Cache::put("import_{$this->importId}", [
            'rowCount' => $currentData['rowCount'],
            'failures' => $newFailures,
            'error' => $currentData['error'],
        ], now()->addMinutes(30));
    }

    public function rules(): array
    {
        return [
            'campana_id' => 'required|exists:campaigns,id',
            'evaluador_id' => 'required|exists:users,id',
            'evaluado_id_1' => 'nullable|exists:users,id',
            'evaluado_id_2' => 'nullable|exists:users,id',
            'evaluado_id_3' => 'nullable|exists:users,id',
            'evaluado_id_4' => 'nullable|exists:users,id',
            'evaluado_id_5' => 'nullable|exists:users,id',
            'evaluado_id_6' => 'nullable|exists:users,id',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            '*.campana_id.required' => 'El ID de campaña es obligatorio.',
            '*.campana_id.exists' => 'La campaña no existe en el sistema.',
            '*.evaluador_id.required' => 'El ID del evaluador es obligatorio.',
            '*.evaluador_id.exists' => 'El evaluador no existe en el sistema.',
            '*.evaluado_id_1.exists' => 'El evaluado 1 no existe en el sistema.',
            '*.evaluado_id_2.exists' => 'El evaluado 2 no existe en el sistema.',
            '*.evaluado_id_3.exists' => 'El evaluado 3 no existe en el sistema.',
            '*.evaluado_id_4.exists' => 'El evaluado 4 no existe en el sistema.',
            '*.evaluado_id_5.exists' => 'El evaluado 5 no existe en el sistema.',
            '*.evaluado_id_6.exists' => 'El evaluado 6 no existe en el sistema.',
        ];
    }

    public function getImportId(): string
    {
        return $this->importId;
    }

    public static function getLastImportId(): ?string
    {
        return self::$lastImportId;
    }

    public static function getImportResults(string $importId): array
    {
        return Cache::get("import_{$importId}", ['rowCount' => 0, 'failures' => [], 'error' => null]);
    }
}
