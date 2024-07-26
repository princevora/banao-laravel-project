<?php

use App\Http\Controllers\Users\Api\TaskController;
use App\Http\Controllers\Users\AuthController;
use App\Http\Controllers\Users\Dashboard\DashboardController;
use App\Http\Middleware\ApiAuthentication;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->middleware('guest')->group(function () {
    // Login And Register Routes For Get Method
    Route::view('register', 'users.auth.register')->name('register');
    Route::view('login', 'users.auth.login')->name('login');

    // Login And Register Routes For POST Method
    Route::post('register', [AuthController::class, 'register'])->name('register.submit');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');
});

// Routes For User Dashboard
Route::prefix('u')->middleware('auth')->group(function () {
    // View routes
    Route::view('dashboard', 'users.dashboard.index')->name('dashboard');

    // Get routes.
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    // Tasks prefix
    Route::prefix('tasks')->group(function () {
        Route::get('view', [DashboardController::class, 'index'])->name('user.tasks');
        Route::get('add', [DashboardController::class, 'addTask'])->name('user.tasks.add');
    });
});

// Routes For ToDO API
Route::prefix('api')->middleware(ApiAuthentication::class)->group(function () {
    Route::post('/todo/add', [TaskController::class, 'addTask'])->name('todo.add');
    Route::post('/todo/status', [TaskController::class, 'updateStatus'])->name('todo.update.status');
});
