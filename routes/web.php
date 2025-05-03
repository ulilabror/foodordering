<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing.home');
});

Route::get('/about', function () {
    return view('landing.about');
});

Route::get('/menu', function () {
    return view('landing.menu');
});

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

