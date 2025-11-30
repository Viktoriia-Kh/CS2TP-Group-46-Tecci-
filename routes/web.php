<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DisplayProductController;


Route::get('/', function () {
    return view('product');
});
Route::get('/', function () {
    return view('displayproduct');
});

// Products listing page 
Route::get('/products', [DisplayProductController::class, 'index'])->name('products.index');

// Single product details page
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');