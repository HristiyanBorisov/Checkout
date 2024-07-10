<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [ DashboardController::class, 'index'])->name('dashboard');

Route::middleware([ IsAdmin::class ])->group(function () {
    Route::get(
        '/admin/',
        [ AdminDashboardController::class, 'index' ]
    )->name(
        'admin.dashboard'
    );
});
