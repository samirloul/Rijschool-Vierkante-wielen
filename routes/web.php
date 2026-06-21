<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutoController;

Route::view('/', 'welcome')->name('home');
Route::view('/over-ons', 'pages.about')->name('about');
Route::view('/lespakketten', 'pages.packages')->name('packages');
Route::view('/contact', 'pages.contact')->name('contact');

// Auto routes - accessible to guests and authenticated users
Route::get('/auto-overzicht', [AutoController::class, 'overzicht'])->name('autos.overzicht');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('/auto-toevoegen', [AutoController::class, 'create'])->name('autos.create');
    Route::post('/auto-toevoegen', [AutoController::class, 'store'])->name('autos.store');
});

require __DIR__.'/settings.php';
