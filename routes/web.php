<?php

use App\Http\Controllers\CropController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DemandController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Landing')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::inertia('/merchant/dashboard', 'dashboard/Merchant')->name('merchant.dashboard');

    // Shared Market browse — both roles land here (segmented Selling/Buying/All).
    Route::get('/market', MarketController::class)->name('market');
    // Crop typeahead — shared by the product-create crop picker and the Market
    // filter panel's crop field.
    Route::get('/crops', [CropController::class, 'index'])->name('crops.index');
    // Offer detail is shared (a merchant can view an offer they're browsing);
    // the offers INDEX is the farmer's own listings, so it's farmer-gated below.
    Route::resource('offers', OfferController::class)
        ->only(['show'])
        ->whereNumber('offer');
    Route::resource('products', ProductController::class)
        ->only(['index', 'show'])
        ->whereNumber('product');

    // Orders (claims). Both roles see a list + detail; placing a claim is
    // merchant-only (Phase 4). Farmer sees incoming claims, merchant sees placed.
    Route::resource('orders', OrderController::class)
        ->only(['index', 'show'])
        ->whereNumber('order');
    // Demand detail is shared (farmers browse + claim); writes are merchant-only.
    Route::get('demands/{demand}', [DemandController::class, 'show'])
        ->whereNumber('demand')
        ->name('demands.show');

    Route::middleware('role:merchant')->group(function () {
        // Placing a claim against an offer.
        Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
        // Demand CRUD (the buy side) is merchant-owned.
        Route::resource('demands', DemandController::class)
            ->only(['index', 'create', 'store'])
            ->whereNumber('demand');
    });

    Route::middleware('role:farmer')->group(function () {
        Route::inertia('/farmer/dashboard', 'dashboard/Farmer')->name('farmer.dashboard');
        Route::resource('offers', OfferController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
            ->whereNumber('offer');
        Route::resource('products', ProductController::class)
            ->only(['create', 'store', 'edit', 'update', 'destroy'])
            ->whereNumber('product');
    });
});

require __DIR__.'/settings.php';
