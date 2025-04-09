<?php

namespace App\Filament\Resources\EvaluationAssignResource\Pages;

use App\Filament\Resources\EvaluationAssignResource;
use App\Models\EvaluationAssign;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateEvaluationAssign extends CreateRecord
{
    protected static string $resource = EvaluationAssignResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $campaignId = $data['campaign_id'];
        $evaluationId = $data['evaluation_id'];
        $userId = $data['user_id'];
        $selectedEvaluados = $data['selected_evaluados'] ?? [];

        $createdRecords = [];

        if (empty($selectedEvaluados)) {
            // Si no hay evaluados, crear un registro con datos mínimos
            return EvaluationAssign::create([
                'campaign_id' => $campaignId,
                'evaluation_id' => $evaluationId,
                'user_id' => $userId,
                'user_to_evaluate_id' => $userId, // Autoevaluación por defecto
                'type' => 'A', // Tipo Autoevaluación por defecto
            ]);
        }

        foreach ($selectedEvaluados as $evaluado) {
            $record = EvaluationAssign::create([
                'campaign_id' => $campaignId,
                'evaluation_id' => $evaluationId,
                'user_id' => $userId,
                'user_to_evaluate_id' => $evaluado['id'],
                'position_id' => $evaluado['position_id'],
                'type' => $evaluado['type'] ?? 'P', // Guardamos el tipo, con "Par" como valor por defecto
            ]);

            $createdRecords[] = $record;
        }

        return $createdRecords[0];
    }

}
