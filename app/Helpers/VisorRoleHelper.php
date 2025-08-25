<?php
namespace App\Helpers;

class VisorRoleHelper
{
    public static function canEdit(): bool
    {
        // Devuelve true si el usuario NO tiene el rol de visor
        //return !auth()->user()->hasRole('Visor');
        return auth()->user()->hasAnyRole(['Administrador', 'RH Corp', 'RH']);
    }

    public static function canEditOrDelete(): bool
    {
        // Si necesitas una función más específica
        return auth()->user()->hasAnyRole(['Administrador', 'RH Corp', 'RH']);
    }
}
