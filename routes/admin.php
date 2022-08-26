<?php

use App\Http\Livewire\PurchaseOrderProducts\CheckProductions;
use Illuminate\Support\Facades\Route;


Route::prefix('/')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {
        Route::get('purchase-order-products', CheckProductions::class)->name('check-productions');
    });



