<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignUpController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Main Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Signup Routes
|--------------------------------------------------------------------------
*/

Route::get('/signup', [SignUpController::class, 'showForm'])
    ->name('signup.form');

// If your controller method is called "submit", keep this:
Route::post('/signup', [SignUpController::class, 'submit'])
    ->name('signup.submit');

// If it's called "register", switch submit → register


/*
|--------------------------------------------------------------------------
| Social Redirect Buttons
|--------------------------------------------------------------------------
*/

Route::get('/auth/google', function () {
    return redirect()->away('https://accounts.google.com/signin');
})->name('auth.google');

Route::get('/auth/microsoft', function () {
    return redirect()->away('https://login.microsoftonline.com/');
})->name('auth.microsoft');


/*
|--------------------------------------------------------------------------
| Email Verification Routes
|--------------------------------------------------------------------------
*/

// Show "verify your email" page
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')
  ->name('verification.notice');

// Verification link (user clicks from email)
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // Marks email as verified
    return redirect(to: '/')->with('success', 'Email verified successfully!');
})->middleware(['auth', 'signed', 'throttle:6,1'])
  ->name('verification.verify');

// Resend verification email
Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect('/'); // Already verified
    }

    $request->user()->sendEmailVerificationNotification();

    return back()->with('success', 'Verification email sent again!');
})->middleware(['auth', 'throttle:6,1'])
  ->name('verification.send');

  Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/')->with('success', 'Logged out successfully.');
})->name('logout');
