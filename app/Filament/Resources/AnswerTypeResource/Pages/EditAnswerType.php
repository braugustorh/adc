<?php

namespace App\Filament\Resources\AnswerTypeResource\Pages;

use App\Filament\Resources\AnswerTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnswerType extends EditRecord
{
    protected static string $resource = AnswerTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
