<?php

namespace App\Filament\Resources\NineBoxResource\Pages;

use App\Filament\Resources\NineBoxResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNineBoxes extends ListRecords
{
    protected static string $resource = NineBoxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
