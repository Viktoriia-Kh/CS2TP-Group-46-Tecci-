<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Basket;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

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


    public function process(Request $request)
    {
        $cart = session()->get('basket', []);

        if(empty($cart)) {
            return redirect()->route('basket.index');
        }

        // Calculate Total again for security
        $total = 0;
        foreach($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        $order = Order::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'total_price' => $total,
            'status' => 'Placed',
        ]);


        foreach($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'product_name' => $details['name'],
                'quantity' => $details['quantity'],
                'price' => $details['price'],
                'image_url' => $details['image'] ?? null,

            ]);
        }

        session()->forget('basket');

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

}