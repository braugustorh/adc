<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Evaluation360Controller;
use App\Http\Livewire\OrganizationalClimateController;
use App\Filament\Pages\Panel9Box;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Livewire;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');

});
Route::group(['middleware' => 'auth'], function () {

    Route::get('/evaluation360', \App\Livewire\Evaluation360Controller::class)->name('evaluacion.index');
    Route::get('/organizational-climate', \App\Livewire\OrganizationalClimateController::class)->name('clima-organizacional.index');
});
