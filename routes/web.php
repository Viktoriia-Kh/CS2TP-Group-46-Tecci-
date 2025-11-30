<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('displayproduct');
});

// Products listing page 
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Single product details page
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');