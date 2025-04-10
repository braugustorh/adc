<?php
// app/Providers/HelperServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Si tienes múltiples helpers, puedes cargarlos todos aquí
        require_once app_path('Helpers/VisorRoleHelper.php');
    }
}
