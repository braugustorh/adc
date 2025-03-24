<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Evaluation360Controller;
use App\Http\Livewire\OrganizationalClimateController;
use App\Filament\Pages\Panel9Box;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Livewire;
use App\Filament\Pages\ExitSurveyPage;
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

Route::group(['prefix' => '/'], function () {
    Route::view('/', 'welcome')->name('welcome');
    Route::view('/about', 'about')->name('about');
    Route::view('/contact', 'contact')->name('contact');
    Route::view('/questions', 'questions')->name('questions');
    Route::view('/modules', 'modules')->name('modules');
    Route::view('/modules-360-detail', 'modules-360-detail')->name('modules-360-detail');
    Route::view('/modules-f2f', 'modules-f2f')->name('modules-f2f');
    Route::view('/modules-9box', 'modules-9box')->name('modules-9box');
    Route::view('/modules-nom035', 'modules-nom035')->name('modules-nom035');
    Route::view('/modules-clima', 'modules-clima')->name('modules-clima');
    Route::view('/modules-tablero-de-control', 'modules-tablero-de-control')->name('modules-tablero-de-control');
    Route::view('/modules-psicometria', 'modules-psicometria')->name('modules-psicometria');
    Route::view('/modules-portafolio', 'modules-portafolio')->name('modules-portafolio');
});
Route::group(['middleware' => 'auth'], function () {

    Route::get('/evaluation360', \App\Livewire\Evaluation360Controller::class)->name('evaluacion.index');
    Route::get('/organizational-climate', \App\Livewire\OrganizationalClimateController::class)->name('clima-organizacional.index');
    Route::get('/exit-survey', ExitSurveyPage::class)->name('filament.pages.exit-survey-page');
});


