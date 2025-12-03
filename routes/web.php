<?php

use App\Http\Controllers\BasketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/basket', [BasketController::class, 'index']);
