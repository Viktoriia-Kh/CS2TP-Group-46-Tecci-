<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function add($id)
    {
        // Find the product in the database
        $product = Product::findOrFail($id);

        // Get current cart
        $cart = session()->get('cart', []);

        // If item exists: increase quantity
        foreach ($cart as &$item) {
            if ($item['id'] == $id) {
                $item['quantity']++;
                session()->put('cart', $cart);
                return back()->with('success', 'Quantity updated!');
            }
        }

        // If item not in cart, add new entry
        $cart[] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'image_url' => $product->image_url,
        ];

        session()->put('cart', $cart);

        return back()->with('success', 'Product added to cart!');
    }
}