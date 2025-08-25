<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use App\Models\Sede;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
    protected static ?string $title='Usuarios';

    protected function getHeaderActions(): array
    {
        if (auth()->user()->hasRole('Administrador') ||
            auth()->user()->hasRole('RH Corp')) {
            //EL USURIO ADMINISTRADOR AGREGA USUARIOS SIN LIMITE
            return [
                Actions\CreateAction::make()
                    ->label('Agregar Usuario')
                    ->icon('heroicon-o-plus'),
            ];
        }elseif(auth()->user()->hasRole('RH')) {
            // Obtener la sede del usuario autenticado esta es para el jefe de RRH
            $sede = Sede::find(auth()->user()->sede_id);
            //Si el jefe de Área está autenticado se deberá de cargar únicamente lo de su equipo

            // Verificar si se ha alcanzado el límite de open_positions
            $disabled = false;
            if ($sede && ($sede->count_positions($sede->id) >= $sede->open_positions)) {
                $disabled = true;
            }
        }else {

            $disabled = true;
        }

            return [
                Actions\CreateAction::make()
                    ->label('Agregar Usuario')
                    ->disabled($disabled) // Deshabilitar el botón si se cumple la condición
                    ->tooltip($disabled ? 'Se ha alcanzado el límite de posiciones abiertas' : null),
            ];

    }


    protected function getHeaderWidgets(): array
    {
        return [
          UserResource\Widgets\UsersStatsOverview::class,
        ];
    }
}
