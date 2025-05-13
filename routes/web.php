<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Filament\Customer\Pages\Basket;

Route::get('/', function () {
    return view('landing.home');
});

Route::get('/about', function () {
    return view('landing.about');
});

Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

Route::get('/events', function () {
    return view('landing.events');
});

Route::get('/chefs', function () {
    return view('landing.chefs');
});

Route::get('/gallery', function () {
    return view('landing.gallery');
});

Route::get('/contact', function () {
    return view('landing.contact');
});

Route::get('/filament/pages/basket', Basket::class)->name('filament.pages.basket');

