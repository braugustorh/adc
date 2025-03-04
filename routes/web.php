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
});
Route::group(['middleware' => 'auth'], function () {

    Route::get('/evaluation360', \App\Livewire\Evaluation360Controller::class)->name('evaluacion.index');
    Route::get('/organizational-climate', \App\Livewire\OrganizationalClimateController::class)->name('clima-organizacional.index');
    Route::get('/exit-survey', ExitSurveyPage::class)->name('filament.pages.exit-survey-page');
});


