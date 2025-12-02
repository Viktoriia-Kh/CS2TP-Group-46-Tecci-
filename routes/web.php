<?php

use Illuminate\Support\Facades\Route;

Route::get('/homepage', function () {
    return view('home-page-2');
});
