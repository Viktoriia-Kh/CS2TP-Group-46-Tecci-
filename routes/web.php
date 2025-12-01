<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('checkout');
});

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;

Route::get('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
