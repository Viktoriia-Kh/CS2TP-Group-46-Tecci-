<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DisplayProductController;


Route::get('/', function () {
    return view('displayproduct');
});
Route::get('product', function () {
    return view('product');
});

// Products listing page 
Route::get('/', [DisplayProductController::class, 'index'])->name('products.index');

// Single product details page
Route::get('/product/{product}', [ProductController::class, 'show'])
    ->name('product.detail');