<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BasketController; 

// Root URL
Route::get('/', function () {
    return view('welcome');
});

// Homepage (where user clicks "Return to Home")
Route::get('/homepage', function () {
    return view('home-page-2');
});

// Basket Logic (Viewing, Adding, Removing)
Route::get('/basket', [BasketController::class, 'index'])->name('basket.index');
Route::get('/add-to-basket/{id}', [BasketController::class, 'add'])->name('basket.add');
Route::get('/remove-from-basket/{id}', [BasketController::class, 'remove'])->name('basket.remove');
Route::get('/decrease-quantity/{id}', [BasketController::class, 'decrease'])->name('basket.decrease');

// Placeholder Routes (until pages are properly linked)
// "Continue Shopping" -> Redirects to Homepage for now
Route::get('/products', function () { 
    return redirect('/homepage'); 
}); 

// "Checkout Now" -> Shows temporary text page
Route::get('/checkout', function () { 
    return "Checkout Page Coming Soon"; 
});