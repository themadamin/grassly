<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Landing')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::inertia('/farmer/dashboard', 'dashboard/Farmer')->middleware('role:farmer')->name('farmer.dashboard');
    Route::inertia('/merchant/dashboard', 'dashboard/Merchant')->middleware('role:merchant')->name('merchant.dashboard');
});

require __DIR__.'/settings.php';
