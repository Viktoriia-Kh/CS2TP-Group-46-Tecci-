<?php

use App\Http\Controllers\DisplayProductController;
use App\Http\Controllers\ProductController;

// Instead of returning the view directly, call the controller:
Route::get('/', [DisplayProductController::class, 'index'])
    ->name('home');

// Products listing page (same controller method)
Route::get('/products', [DisplayProductController::class, 'index'])
    ->name('products.index');

// Single product details page (if you need it later)
Route::get('/products/{product}', [ProductController::class, 'show'])
    ->name('products.show');