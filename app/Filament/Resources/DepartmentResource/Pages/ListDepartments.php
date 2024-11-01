<?php

namespace App\Filament\Resources\DepartmentResource\Pages;

use App\Filament\Resources\DepartmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDepartments extends ListRecords
{
    protected static string $resource = DepartmentResource::class;
    protected static ?string $title='Departamentos';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Crear Departamento'),
        ];
    }
}
