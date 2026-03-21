<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DisplayProductController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SignUpController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReviewController;

use App\Http\Controllers\AdminInventoryController;

// Homepage
Route::get('/', [HomeController::class, 'HomeController'])->name('home');



Route::match(['get', 'post'], '/login', [LoginController::class, 'login'])->name('login');


// Basket Logic (Viewing, Adding, Removing)
Route::get('/basket', [BasketController::class, 'index'])->name('basket.index');
Route::get('/add-to-basket/{id}', [BasketController::class, 'add'])->name('basket.add');
Route::get('/remove-from-basket/{id}', [BasketController::class, 'remove'])->name('basket.remove');
Route::get('/decrease-quantity/{id}', [BasketController::class, 'decrease'])->name('basket.decrease');


Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/signup', [SignUpController::class, 'showForm'])
    ->name('signup.form');

Route::post('/signup', [SignUpController::class, 'submit'])
    ->name('signup.submit');

Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('auth.google');
Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();

    // Find or create local user
    $user = User::firstOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            'name'     => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
            'password' => bcrypt(Str::random(32)), // random, they’ll log in via Google
        ]
    );

    Auth::login($user);

    // After login, send them home (change if you want)
    return redirect('/');   // or route('signup.form')
})->name('auth.google.callback');


Route::get('/auth/microsoft', function () {
    return redirect()->away('https://login.microsoftonline.com/');
})->name('auth.microsoft');
Route::get('/auth/microsoft/callback', function () {
    return redirect('/')->with('success', 'Logged in with Microsoft!');
})->name('auth.microsoft.callback');

// Show "verify your email" page
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')
  ->name('verification.notice');

// Verification link (user clicks from email)
Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::findOrFail($id);

    // Check hash is valid for this email
    if (! hash_equals(sha1($user->getEmailForVerification()), (string) $hash)) {
        abort(403, 'Invalid verification link.');
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new \Illuminate\Auth\Events\Verified($user));
    }
    // log them in so they're authenticated after clicking
    Auth::login($user);

    return redirect('/signup')->with('success', 'Email verified successfully!');
})->middleware(['signed', 'throttle:6,1'])
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


// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/')->with('success', 'Logged out successfully.');
})->name('logout');



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
Route::get('displayproduct', [DisplayProductController::class, 'DisplayProductController'])->name('products.index');

// Single product details page
Route::get('/product/{product}', [ProductController::class, 'show'])
    ->name('product.detail');

// Checkout route
Route::get('checkout', [CheckoutController::class, 'checkout']);

// forgot password route
Route::get('/forgot-password', [LoginController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [LoginController::class, 'sendResetPasswordLink']);

// reset password routes
Route::get('/reset-password/{token}', [LoginController:: class, 'showPasswordResetForm'])->name('password.reset');
Route::post('/reset-password', [LoginController::class, 'updatePassword'])->name('password.update'); // saves the new password to database

// Reviews routee
Route::post('/product/{product}/review', [ReviewController::class, 'store'])
    ->name('reviews.store');

//Admin Inventory route
Route::get('admin-inventory', function () {
    return view('admin-inventory');
});

Route::get('/admin-inventory', [AdminInventoryController::class, 'index'])->name('admin.inventory');
Route::post('/admin-inventory/products', [AdminInventoryController::class, 'store'])->name('admin.inventory.store');
Route::put('/admin-inventory/products/{product}', [AdminInventoryController::class, 'update']);
Route::delete('/admin-inventory/products/{product}', [AdminInventoryController::class, 'destroy']);


