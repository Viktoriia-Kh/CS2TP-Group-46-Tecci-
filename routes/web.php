<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SignUpController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

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

Route::post('/signup', [SignUpController::class, 'submit'])
    ->name('signup.submit');


/*
|--------------------------------------------------------------------------
| Social Redirect Buttons
|--------------------------------------------------------------------------
*/

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

// Verification link (user clicks from email) – NO auth middleware now
Route::get('/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::findOrFail($id);

    // Check hash is valid for this email
    if (! hash_equals(sha1($user->getEmailForVerification()), (string) $hash)) {
        abort(403, 'Invalid verification link.');
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new \Illuminate\Auth\Events\Verified($user));
    }

    // Optional: log them in so they're authenticated after clicking
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

Route::get('/login', function () {
    return redirect()->route('signup.form');
})->name('login');
