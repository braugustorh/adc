<?php

namespace App\Filament\Resources\PsychometricEvaluationResource\Pages;

use App\Filament\Resources\PsychometricEvaluationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPsychometricEvaluations extends ListRecords
{
    protected static string $resource = PsychometricEvaluationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
