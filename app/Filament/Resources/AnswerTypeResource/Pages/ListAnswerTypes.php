<?php

namespace App\Filament\Resources\AnswerTypeResource\Pages;

use App\Filament\Resources\AnswerTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnswerTypes extends ListRecords
{
    protected static string $resource = AnswerTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
