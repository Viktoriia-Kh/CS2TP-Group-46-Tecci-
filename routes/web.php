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
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminInventoryController;
use App\Http\Controllers\WebsiteReviewController;

// ==========================================
// PUBLIC ROUTES (No authentication required)
// ==========================================

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// About & Contact
Route::get('about-us', function () {
    return view('about-us');
});
Route::get('/contact-us', [ContactController::class, 'showForm'])->name('contact.form');
Route::post('/contact-us', [ContactController::class, 'submit'])->name('contact.submit');

// Products
Route::get('displayproduct', [DisplayProductController::class, 'DisplayProductController'])->name('products.index');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.detail');

// Reviews
Route::post('/reviews', [WebsiteReviewController::class, 'store'])->name('website.reviews.store');
Route::post('/products/{productId}/reviews', [ReviewController::class, 'store'])->name('product.reviews.store');
Route::post('/product/{product}/review', [ReviewController::class, 'store'])->name('reviews.store');

// Basket
Route::get('/basket', [BasketController::class, 'index'])->name('basket.index');
Route::match(['get', 'post'], '/add-to-basket/{id}', [BasketController::class, 'add'])->name('basket.add');
Route::get('/remove-from-basket/{id}', [BasketController::class, 'remove'])->name('basket.remove');
Route::get('/decrease-quantity/{id}', [BasketController::class, 'decrease'])->name('basket.decrease');
Route::post('/apply-discount', [BasketController::class, 'applyDiscount'])->name('basket.discount');
Route::post('/basket/update-ajax', [BasketController::class, 'updateAjax'])->name('basket.update.ajax');
Route::post('/basket/save-delivery', [BasketController::class, 'saveDelivery'])->name('basket.saveDelivery');

// Authentication
Route::match(['get', 'post'], '/login', [LoginController::class, 'login'])->name('login');
Route::get('/signup', [SignUpController::class, 'showForm'])->name('signup.form');
Route::post('/signup', [SignUpController::class, 'submit'])->name('signup.submit');
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/')->with('success', 'Logged out successfully.');
})->name('logout');

// Password Reset
Route::get('/forgot-password', [LoginController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [LoginController::class, 'sendResetPasswordLink']);
Route::get('/reset-password/{token}', [LoginController::class, 'showPasswordResetForm'])->name('password.reset');
Route::post('/reset-password', [LoginController::class, 'updatePassword'])->name('password.update');

// Email Verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::findOrFail($id);
    if (! hash_equals(sha1($user->getEmailForVerification()), (string) $hash)) {
        abort(403, 'Invalid verification link.');
    }
    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new \Illuminate\Auth\Events\Verified($user));
    }
    Auth::login($user);
    app(BasketController::class)->mergeGuestBasketOnLogin();
    return redirect('/signup')->with('success', 'Email verified successfully!');
})->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect('/');
    }
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'Verification email sent again!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// OAuth (Google/Microsoft)
Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('auth.google');

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();
    $user = User::firstOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
            'password' => bcrypt(Str::random(32)),
        ]
    );
    Auth::login($user);
    app(BasketController::class)->mergeGuestBasketOnLogin();
    return redirect('/');
})->name('auth.google.callback');

Route::get('/auth/microsoft', function () {
    return redirect()->away('https://login.microsoftonline.com/');
})->name('auth.microsoft');

Route::get('/auth/microsoft/callback', function () {
    return redirect('/')->with('success', 'Logged in with Microsoft!');
})->name('auth.microsoft.callback');

// Chatbot
Route::prefix('chatbot')->group(function () {
    Route::get('/categories', [ChatbotController::class, 'categories'])->name('chatbot.categories');
    Route::get('/categories/{category}/faqs', [ChatbotController::class, 'faqsByCategory'])->name('chatbot.faqsByCategory');
    Route::get('/faqs/{faq}', [ChatbotController::class, 'faqAnswer'])->name('chatbot.faqAnswer');
});

// ==========================================
// AUTHENTICATED USER ROUTES
// ==========================================

Route::middleware('auth')->group(function () {
    // Checkout & Payment (requires login)
    Route::get('/checkout', [CheckoutController::class, 'showPaymentForm'])->name('checkout');
    Route::get('/checkout/payment', [CheckoutController::class, 'showPaymentForm'])->name('checkout.payment');
    Route::post('/checkout/payment/validate', [CheckoutController::class, 'processPayment'])->name('payment.validate');

    // My Orders
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/order-item/{id}/return', [OrderController::class, 'requestReturn'])->name('item.return');

    // Account Management
    Route::get('/account', [AccountController::class, 'show'])->name('account.show');
    Route::patch('/account/update', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account/delete', [AccountController::class, 'destroy'])->name('account.destroy');
});

// ==========================================
// ADMIN ROUTES (Protected by auth + admin middleware)
// ==========================================

Route::middleware(['auth', 'admin'])->group(function () {
    
    // Admin Dashboard
    Route::get('admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Admin Orders
    Route::get('admin-orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('admin-orders/export', [AdminOrderController::class, 'export'])->name('admin.orders.export');
    Route::get('admin-orders-create', [AdminOrderController::class, 'create'])->name('admin.orders.create');
    Route::post('admin-orders', [AdminOrderController::class, 'store'])->name('admin.orders.store');
    Route::get('/admin/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::put('admin-orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::post('admin-orders/bulk-action', [AdminOrderController::class, 'bulkAction'])->name('admin.orders.bulkAction');
    Route::get('admin-orders/print', [AdminOrderController::class, 'printOrders'])->name('admin.orders.print');
    
    // Admin Inventory
    Route::get('admin-inventory', [AdminInventoryController::class, 'index'])->name('admin.inventory');
    Route::post('/admin-inventory/products', [AdminInventoryController::class, 'store'])->name('admin.inventory.store');
    Route::put('/admin-inventory/products/{product}', [AdminInventoryController::class, 'update']);
    Route::delete('/admin-inventory/products/{product}', [AdminInventoryController::class, 'destroy']);
    
    // Admin Customers
    Route::get('/admin/customers', [AdminCustomerController::class, 'index'])->name('admin.customers');
    Route::get('/admin/customers/{id}/edit', [AdminCustomerController::class, 'edit'])->name('admin.customers.edit');
    Route::put('/admin/customers/{id}', [AdminCustomerController::class, 'update'])->name('admin.customers.update');
    Route::delete('/admin/customers/{id}', [AdminCustomerController::class, 'destroy'])->name('admin.customers.destroy');
    
    // Admin Contacts
    Route::get('/admin/contacts', [ContactController::class, 'adminIndex'])->name('admin.contacts');
    Route::post('/admin/contacts/{id}/reply', [ContactController::class, 'reply'])->name('admin.contacts.reply');
    Route::post('/admin/contacts/{id}/resolve', [ContactController::class, 'markResolved'])->name('admin.contacts.resolve');
    
    // Admin Returns
    Route::post('/admin/returns/{id}/approve', [AdminDashboardController::class, 'approveReturn'])->name('admin.returns.approve');
    Route::post('/admin/returns/{id}/decline', [AdminDashboardController::class, 'declineReturn'])->name('admin.returns.decline');
    
    // Admin Settings
    Route::get('/admin-settings', [AdminSettingsController::class, 'showAdminSettings'])->name('admin.settings');
    Route::patch('/admin-settings', [AdminSettingsController::class, 'update'])->name('admin.settings.update');
    Route::delete('/admin-settings/delete', [AdminSettingsController::class, 'destroy'])->name('admin.settings.delete');
});
