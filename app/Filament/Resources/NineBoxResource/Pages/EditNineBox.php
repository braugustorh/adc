<?php

namespace App\Filament\Resources\NineBoxResource\Pages;

use App\Filament\Resources\NineBoxResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNineBox extends EditRecord
{
    protected static string $resource = NineBoxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
