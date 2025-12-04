<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Basket;


class CheckoutController extends Controller
{
  public function checkout()
    {
        // Fetch all rows from the 'basket' table
        $cart = Basket::all();

        // Calculate the Total
        //  every item and do (price * quantity), then add it all up.
        $total = $cart->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // Send data to the view
        // We use the variable name 'cart' to match your check inside the HTML
        return view('checkout', compact('cart', 'total'));
    }

}