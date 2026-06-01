<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('/over-ons', 'pages.about')->name('about');
Route::view('/lespakketten', 'pages.packages')->name('packages');
Route::view('/contact', 'pages.contact')->name('contact');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
