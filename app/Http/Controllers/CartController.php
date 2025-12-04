<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    // Show the cart page
   public function showCheckout()
    {
    $cart = session()->get('cart', []); // ensures it's always an array
    $total = collect($cart)->sum(function ($item) {
        return $item['price'] * $item['quantity'];
    });

    return view('checkout', [
        'cart' => $cart,
        'total' => $total
    ]);
    }

    // Add to cart
    public function addToCart(Request $request)
    {
        $cart = session()->get('cart', []);

        $id = $request->id;

        // Increase quantity if exists
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            // Add new item
            $cart[$id] = [
                'name'      => $request->name,
                'price'     => $request->price,
                'image_url' => $request->image_url,
                'quantity'  => 1,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Item added to cart!');
    }

    // Remove a single item
    public function removeItem($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Item removed.');
    }

    // Clear entire cart
    public function clearCart()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared.');
    }
}
