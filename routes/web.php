<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\DashboardController;


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(RoleMiddleware::class);

Route::get('/login', function () {
    return 'Login form goes here';
})->name('login');