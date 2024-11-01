<?php

namespace App\Filament\Resources\OrganizationalClimateResource\Pages;

use App\Filament\Resources\OrganizationalClimateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrganizationalClimate extends EditRecord
{
    protected static string $resource = OrganizationalClimateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
