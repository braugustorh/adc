<?php

namespace App\Filament\Resources\EvaluationsTypesResource\Pages;

use App\Filament\Resources\EvaluationsTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEvaluationsTypes extends ListRecords
{
    protected static string $resource = EvaluationsTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
