<?php

namespace App\Filament\Resources\ControlPanelResource\Pages;

use App\Filament\Resources\ControlPanelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListControlPanels extends ListRecords
{
    protected static string $resource = ControlPanelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
