<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Landing')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::inertia('/merchant/dashboard', 'dashboard/Merchant')->name('merchant.dashboard');
    Route::resource('offers', OfferController::class)
        ->only(['index', 'show'])
        ->whereNumber('offer');
    Route::resource('products', ProductController::class)
        ->only(['index', 'show'])
        ->whereNumber('product');

    Route::middleware('role:farmer')->group(function () {
        Route::inertia('/farmer/dashboard', 'dashboard/Farmer')->name('farmer.dashboard');
        Route::resource('offers', OfferController::class)
            ->only(['create', 'store', 'edit', 'update', 'destroy'])
            ->whereNumber('offer');
        Route::resource('products', ProductController::class)
            ->only(['create', 'store', 'edit', 'update', 'destroy'])
            ->whereNumber('product');
    });
});

require __DIR__.'/settings.php';
