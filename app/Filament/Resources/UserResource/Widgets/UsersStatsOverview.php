<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UsersStatsOverview extends BaseWidget
{
    public static function canView(): bool
    {
        return \auth()->user()->hasRole(['Administrador','RH Corp','RH','Visor']);

    }
    protected function getStats(): array
    {
        return [
            Stat::make('Total de Usuarios', User::all()->count())
                ->icon('heroicon-s-users')
                ->color('success'),
            Stat::make('Usuarios Activos', User::where('status', true)->count())
            ->icon('heroicon-s-check-badge')
            ->color('success'),
            Stat::make('️👨 Hombres', User::where('sex','Masculino')->count()),
            Stat::make('👩 Mujeres', User::where('sex','Femenino')->count()),
        ];
    }
}
