<?php

namespace App\Filament\Resources\ControlPanelResource\Pages;

use App\Filament\Resources\ControlPanelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditControlPanel extends EditRecord
{
    protected static string $resource = ControlPanelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
