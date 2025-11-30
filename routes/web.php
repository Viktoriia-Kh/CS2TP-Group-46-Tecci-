<?php


use App\Http\Controllers\DisplayProductController;
use App\Http\Controllers\ProductController;


Route::get('/', function () {
    return view('displayproduct');
});

// Products listing page 
Route::get('/products', [DisplayProductController::class, 'index'])->name('products.index');

// Single product details page
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');