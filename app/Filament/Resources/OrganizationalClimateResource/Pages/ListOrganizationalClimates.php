<?php

namespace App\Filament\Resources\OrganizationalClimateResource\Pages;

use App\Filament\Resources\OrganizationalClimateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrganizationalClimates extends ListRecords
{
    protected static string $resource = OrganizationalClimateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
