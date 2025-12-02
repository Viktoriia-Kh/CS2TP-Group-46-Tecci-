<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DisplayProductController;

Route::get('/', function () {
    return view('home-page');
});
Route::get('contactus', function () {
    return view('contact-us');
});

Route::get('/contact-us', [ContactController::class, 'showForm'])->name('contact.form');
Route::post('/contact-us', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('about-us', function () {
    return view('about-us');
});

Route::get('display-product', function () {
    return view('displayproduct');
});
Route::get('product', function () {
    return view('product');
});

// Products listing page 
Route::get('displayproduct', [DisplayProductController::class, 'index'])->name('products.index');

// Single product details page
Route::get('/product/{product}', [ProductController::class, 'show'])
    ->name('product.detail');
