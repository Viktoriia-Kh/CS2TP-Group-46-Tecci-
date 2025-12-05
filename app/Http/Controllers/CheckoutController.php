<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Basket;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function checkout()
    {
        // Fetch the basket from the session (same way BasketController does)
        // If 'basket' doesn't exist, use empty array []
        $cart = session()->get('basket', []);

        // Safety Check - If basket empty, redirect to basket page
        if(empty($cart)) {
            return redirect()->route('basket.index')->with('error', 'Your basket is empty!');
        }

        // Calculate the Total
        // Session data is an Array, loop through it
        $total = 0;
        foreach($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

         // Fetch 4 products for the featured section
        $featuredProducts = Product::latest()->take(4)->get();

        // Send data to view
        // Pass 'cart' & 'total' so the checkout page displays items
        return view('checkout', compact('cart', 'total', 'featuredProducts'));
    }
}