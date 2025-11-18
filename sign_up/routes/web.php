<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignUpController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/signup', [SignUpController::class, 'showForm'])->name('signup.form');
Route::post('/signup', [SignUpController::class, 'register'])->name('signup.submit');
