    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\CheckoutController;

    Route::get('/', [CheckoutController::class, 'checkout']);
    







