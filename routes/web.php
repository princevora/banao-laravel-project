<?php

use App\Http\Controllers\Users\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->group(function () {
    // Login And Register Routes For Get Method
    Route::view('register', 'users.auth.register')->name('register');
    Route::view('login', 'users.auth.login')->name('login');
    
    // Login And Register Routes For POST Method
    Route::post('register', [AuthController::class, 'register'])->name('register.submit');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');
});
