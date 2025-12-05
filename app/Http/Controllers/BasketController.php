<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    // Show the Basket Page
    public function index() 
    {
        // Get the basket data from the session
        // If it doesn't exist yet, we use an empty list []
        $basket = session()->get('basket', []);
        
        return view('basket', compact('basket'));
    }

    // Add Item To Basket Logic
    public function add($id)
    {
    // Find the product in the DB using the ID passed from the route
    $product = Product::findOrFail($id);

    // Get the current basket from session (or start a new empty one)
    $basket = session()->get('basket', []);

    // Check if this specific product ID is already in the basket
    if(isset($basket[$id])) {
        // If yes, just add 1 to the quantity
        $basket[$id]['quantity']++;
    } else {
        // If no, add the real product details to the array
        $basket[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            // We map the DB column 'image_url' to the session key 'image'
            "image" => $product->image_url 
        ];
    }

    // Save the updated basket back to the session
    session()->put('basket', $basket);

    // Go back to the page with a success message
    return redirect()->back()->with('success', 'Product added to basket successfully!');
    }

    // Remove Items
    public function remove($id)
    {
        $basket = session()->get('basket');

        if(isset($basket[$id])) {
            unset($basket[$id]);
            session()->put('basket', $basket);
        }

        return redirect()->back();
 
    }

    // Decrease Quantity
    public function decrease($id)
    {
        $basket = session()->get('basket', []);

        if(isset($basket[$id])) {
            // If quantity is more than 1, subtract 1
            if($basket[$id]['quantity'] > 1) {
                $basket[$id]['quantity']--;
            } else {
                // If quantity is 1, remove the single item entirely
                unset($basket[$id]);
            }
        }

        session()->put('basket', $basket);
        return redirect()->back();
    }
}