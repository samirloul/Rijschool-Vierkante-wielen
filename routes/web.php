<?php

use App\Http\Controllers\InstructeurController;
use App\Http\Controllers\LeerlingController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('/over-ons', 'pages.about')->name('about');
Route::view('/lespakketten', 'pages.packages')->name('packages');
Route::view('/contact', 'pages.contact')->name('contact');
Route::get('/instructeurs', [InstructeurController::class, 'index'])->name('instructeurs.index');
Route::get('/leerlingen', [LeerlingController::class, 'index'])->name('leerlingen.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
