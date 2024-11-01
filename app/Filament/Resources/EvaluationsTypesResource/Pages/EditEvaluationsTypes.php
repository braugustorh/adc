<?php

namespace App\Filament\Resources\EvaluationsTypesResource\Pages;

use App\Filament\Resources\EvaluationsTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvaluationsTypes extends EditRecord
{
    protected static string $resource = EvaluationsTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
