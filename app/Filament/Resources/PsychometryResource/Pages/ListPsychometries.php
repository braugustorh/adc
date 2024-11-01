<?php

namespace App\Filament\Resources\PsychometryResource\Pages;

use App\Filament\Resources\PsychometryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPsychometries extends ListRecords
{
    protected static string $resource = PsychometryResource::class;
    protected static ?string $title = 'Psicometrías';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Agregar Psicometría'),
        ];
    }
}
