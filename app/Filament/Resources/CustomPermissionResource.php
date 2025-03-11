<?php

namespace App\Filament\Resources;

use Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource as BasePermissionResource;
use Filament\Resources\Resource;

class CustomPermissionResource extends BasePermissionResource
{
    public static function canViewAny(): bool
    {
        // Solo los administradores pueden ver este recurso
        return auth()->check() && auth()->user()->hasRole('Administrador');
    }

    public static function shouldRegisterNavigation(): bool
    {
        // Oculta el recurso del menú de navegación si el usuario no tiene permiso
        return static::canViewAny();
    }
}
