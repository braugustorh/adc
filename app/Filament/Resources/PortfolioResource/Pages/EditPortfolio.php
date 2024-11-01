<?php

namespace App\Filament\Resources\PortfolioResource\Pages;

use App\Filament\Resources\PortfolioResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPortfolio extends EditRecord
{
    protected static string $resource = PortfolioResource::class;
    protected static ?string $navigationLabel = 'Editar Portafolio';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
