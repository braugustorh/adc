<?php

namespace App\Filament\Resources\PsychometricEvaluationResource\Pages;

use App\Filament\Resources\PsychometricEvaluationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPsychometricEvaluation extends EditRecord
{
    protected static string $resource = PsychometricEvaluationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
