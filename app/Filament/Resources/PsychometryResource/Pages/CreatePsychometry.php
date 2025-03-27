<?php

namespace App\Filament\Resources\PsychometryResource\Pages;

use App\Filament\Resources\PsychometryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePsychometry extends CreateRecord
{
    protected static string $resource = PsychometryResource::class;
    protected static ?string $title = 'Crear Registro de Talentos';
}
