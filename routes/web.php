<?php

use App\Http\Controllers\BetalingOverzichtController;
use App\Http\Controllers\InstructeurController;
use App\Http\Controllers\LeerlingController;
use App\Http\Controllers\RijlespakkettenOverzichtController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RijlesController;

Route::view('/', 'welcome')->name('home');
Route::view('/over-ons', 'pages.about')->name('about');
Route::get('/lespakketten', [RijlespakkettenOverzichtController::class, 'index'])
    ->name('packages');
Route::get('/instructeurs', [InstructeurController::class, 'index'])->name('instructeurs.index');
Route::get('/leerlingen', [LeerlingController::class, 'index'])->name('leerlingen.index');
Route::view('/contact', 'pages.contact')->name('contact');
Route::get('betaling-overzicht', [BetalingOverzichtController::class, 'index'])
    ->name('betaling.overzicht');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('dashboard/rijlespakketten-overzicht', [RijlespakkettenOverzichtController::class, 'dashboardIndex'])// Deze route toont het overzicht van rijlespakketten in het dashboard aan de gebruiker. We gebruiken een aparte methode in de controller (dashboardIndex) om het overzicht te laden, zodat we eventuele specifieke logica of gegevens kunnen toevoegen die alleen relevant zijn voor het dashboard, zonder de index-methode te beïnvloeden die wordt gebruikt voor het openbare overzicht van rijlespakketten.
        ->name('dashboard.packages');
    Route::post('dashboard/rijlespakketten-overzicht', [RijlespakkettenOverzichtController::class, 'store'])// Deze route verwerkt het formulier voor het toevoegen van een nieuw rijlespakket in het dashboard. We gebruiken de store-methode in de controller om de logica voor het opslaan van het nieuwe rijlespakket te verwerken, inclusief validatie en het aanroepen van de stored procedure om het pakket toe te voegen aan de database. Na het succesvol toevoegen van het pakket, sturen we de gebruiker terug naar het overzicht van rijlespakketten in het dashboard met een succesmelding.
        ->name('dashboard.packages.store');
});

Route::resource('rijlessen', RijlesController::class)
    ->only(['index', 'show']);
require __DIR__.'/settings.php';
