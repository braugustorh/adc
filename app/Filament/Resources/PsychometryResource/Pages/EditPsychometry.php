<?php

namespace App\Filament\Resources\PsychometryResource\Pages;

use App\Filament\Resources\PsychometryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPsychometry extends EditRecord
{
    protected static string $resource = PsychometryResource::class;
    protected static ?string $title = 'Editar Registro de Talentos';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
