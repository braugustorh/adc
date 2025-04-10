<?php

namespace App\Filament\Resources\DepartmentResource\Pages;

use App\Filament\Resources\DepartmentResource;
use App\Helpers\VisorRoleHelper;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDepartment extends EditRecord
{
    protected static string $resource = DepartmentResource::class;
    protected static ?string $title='Editar Departamento';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->visible(fn()=>VisorRoleHelper::canEdit()),
        ];
    }
    protected function authorizeAccess(): void
    {
        abort_unless(VisorRoleHelper::canEdit(), 403, __('Ups!, no estas autorizado para realizar esta acción.'));
    }
}
