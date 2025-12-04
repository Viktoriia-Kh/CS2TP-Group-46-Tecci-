<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Basket;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function checkout()
    {
        // Fetch all rows from the 'basket' table
        $cart = Basket::all();

        // Calculate the total
        // every item and do (price * quantity), then add it all up
        $total = $cart->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // Fetch 4 products for the featured section
        $featuredProducts = Product::latest()->take(4)->get();

        // Send ALL data to the view
        return view('checkout', [
            'cart'             => $cart,
            'total'            => $total,
            'featuredProducts' => $featuredProducts,
        ]);
    }
}
