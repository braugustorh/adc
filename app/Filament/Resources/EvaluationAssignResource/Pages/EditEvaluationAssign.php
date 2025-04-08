<?php

namespace App\Filament\Resources\EvaluationAssignResource\Pages;

use App\Filament\Resources\EvaluationAssignResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvaluationAssign extends EditRecord
{
    protected static string $resource = EvaluationAssignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
