<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignUpController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/signup', [SignUpController::class, 'showForm'])->name('signup.form');
Route::post('/signup', [SignUpController::class, 'submit'])->name('signup.submit');
Route::get('/auth/google', function () {
   
    return redirect()->away('https://accounts.google.com/signin');
})->name('auth.google');

Route::get('/auth/microsoft', function () {
    return redirect()->away('https://login.microsoftonline.com/');
})->name('auth.microsoft');
