<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RijlesController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::resource('rijlessen', RijlesController::class)
    ->only(['index', 'show']);
require __DIR__.'/settings.php';
