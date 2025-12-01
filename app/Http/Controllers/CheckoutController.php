<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display checkout page and calculate totals.
     */
    public function show()
    {
        // Cart is stored in session
        $cart = session()->get('cart', []);

        // Calculate overall total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout', compact('cart', 'total'));
    }

    /**
     * Process checkout (NO payment).
     */
    public function process(Request $request)
    {
        // Here you COULD save an order later when your group adds an orders table.

        // For now: simply clear cart
        session()->forget('cart');

        return redirect()
            ->route('checkout.show')
            ->with('success', 'Order placed successfully!');
    }
}