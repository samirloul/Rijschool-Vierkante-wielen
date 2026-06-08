<?php

use App\Http\Controllers\BetalingOverzichtController;
use App\Http\Controllers\InstructeurController;
use App\Http\Controllers\LeerlingController;
use App\Http\Controllers\RijlespakkettenOverzichtController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RijlesController;
use App\Http\Controllers\AutoController;

Route::view('/', 'welcome')->name('home');
Route::view('/over-ons', 'pages.about')->name('about');
Route::get('/lespakketten', [RijlespakkettenOverzichtController::class, 'index'])
    ->name('packages');
Route::get('/instructeurs', [InstructeurController::class, 'index'])->name('instructeurs.index');
Route::get('/leerlingen', [LeerlingController::class, 'index'])->name('leerlingen.index');
Route::view('/contact', 'pages.contact')->name('contact');
Route::get('betaling-overzicht', [BetalingOverzichtController::class, 'index'])
    ->name('betaling.overzicht');
    Route::view('/lespakketten', 'pages.packages')->name('packages');

    // Auto routes - accessible to guests and authenticated users
Route::get('/auto-overzicht', [AutoController::class, 'overzicht'])->name('autos.overzicht');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('dashboard/rijlespakketten-overzicht', [RijlespakkettenOverzichtController::class, 'dashboardIndex'])
        ->name('dashboard.packages');
});

Route::resource('rijlessen', RijlesController::class)
    ->only(['index', 'show']);
require __DIR__.'/settings.php';