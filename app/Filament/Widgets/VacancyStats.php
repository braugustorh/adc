<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Sede;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;


class VacancyStats extends BaseWidget
{
    protected function getStats(): array
    {
        if (auth()->user()->hasRole('RH') ||
            auth()->user()->hasRole('RH Corp') ||
            auth()->user()->hasRole('Visor') ||
            auth()->user()->hasRole('Administrador') ||
            auth()->user()->hasRole('Supervisor')) {

            $sede = Sede::find(auth()->user()->sede_id);

            if($sede) {
                // Cuenta los usuarios con la misma sede_id
                $occupiedPositions = $sede->count_positions($sede->id);
                // Obtén las posiciones abiertas de la columna open_positions
                $openPositions = $sede->open_positions;
                // Calcula las posiciones disponibles restando las posiciones ocupadas de las posiciones abiertas
                $vacantPositions = $openPositions - $occupiedPositions;
                // Calcula los porcentajes
                $percentageOccupied = $openPositions > 0 ? (int)(($occupiedPositions / $openPositions) * 100) : 0;
                $percentageVacant = $openPositions > 0 ? (int)(($vacantPositions / $openPositions) * 100) : 0;
            } else{
                $occupiedPositions = 0;
                $openPositions= 0;
                $vacantPositions=0;
                $percentageOccupied=0;
                $percentageVacant=0;
            }
            // Define el color para las posiciones vacantes
            if ($vacantPositions === 0) {
                $colorVacant = 'danger';
            } elseif ($vacantPositions > 0 && $vacantPositions <= 3) {
                $colorVacant = 'warning';
            } else {
                $colorVacant = 'success';
            }

            return [
                Stat::make('Puestos Ocupados', $occupiedPositions)
                    ->description("$percentageOccupied% de los puestos ocupados") // Agrega el porcentaje
                    ->color('success'), // Color de la tarjeta

                Stat::make('Puestos Vacantes', $vacantPositions)
                    ->description("$percentageVacant% de puestos vacantes") // Agrega el porcentaje
//                    ->extraAttributes([
//                        'class' => 'cursor-pointer',
//                        'wire:click' => "\$this->dispatch('openModal', 'vacancy-modal')",
//                    ])
                    ->color($colorVacant), // Color de la tarjeta

                Stat::make('Puestos Totales', $openPositions)
                    ->description('Total de puestos disponibles')
                    ->color('primary'), // Color de la tarjeta
            ];
        } else {
            return [];
        }
    }
    protected function getHeaderActions(): array
    {
        return [
            Action::make('refresh')
                ->label('Actualizar')
                ->color('primary')
                ->action(function () {
                    // Lógica para actualizar los datos
                    $this->dispatch('refreshStats');
                }),
        ];
    }
}
