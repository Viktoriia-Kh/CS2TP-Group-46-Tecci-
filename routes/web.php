<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::get('/contact-us', [ContactController::class, 'showForm'])->name('contact.form');
Route::post('/contact-us', [ContactController::class, 'submit'])->name('contact.submit');



Route::get('/', function () {
    return view('home-page');
});
Route::get('contactus', function () {
    return view('contact-us');
});