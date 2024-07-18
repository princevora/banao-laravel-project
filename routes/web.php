<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->group(function () {
    Route::view('register', 'users.auth.register')->name('register');
    Route::view('login', 'users.auth.login')->name('login');
});
