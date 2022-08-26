<?php

use App\Http\Livewire\PurchaseOrderProducts\CheckProductions;
use App\Http\Livewire\PurchaseOrderProducts\UnitPricePurchases;
use Illuminate\Support\Facades\Route;


Route::prefix('/')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {
        Route::get('check-productions', CheckProductions::class)->name('check-productions');
        Route::get('unit-price-purchases', UnitPricePurchases::class)->name('unit-price-purchases');
    });



