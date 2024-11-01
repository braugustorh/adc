<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class OrganizationalClimateStatics extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Análisis de Clima Organizacional';
    protected static ?string $navigationGroup = 'Clima Organizacional';
    protected ?string $heading = 'Análisis de Clima Organizacional';
    //protected ?string $subheading = 'Realiza la evaluación vertical de tu colaborador';
    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.organizational-climate-statics';

    public static function canView(): bool
    {
        //Este Panel solo lo debe de ver los Jefes de Área y el Administrador
        //Se debe de agregar la comprobación de que estpo se cumpla para que solo sea visible para los Jefes de Área
        if (\auth()->user()->hasRole('Jefe de Área') || \auth()->user()->hasRole('Administrador') || \auth()->user()->hasRole('Administrador')) {
            return true;
        }else{
            return false;
        }

    }

    public static function shouldRegisterNavigation(): bool
    {
        // Esto controla la visibilidad en la navegación.
        return static::canView();
    }

}
