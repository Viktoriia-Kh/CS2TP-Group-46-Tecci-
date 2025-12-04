<?php

namespace App\Http\Controllers;

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

    // Add Item Logic
    public function add($id)
    {
        $basket = session()->get('basket', []);

        // Logic - Check if item exists, if yes, add +1 to quantity
        if(isset($basket[$id])) {
            $basket[$id]['quantity']++;
        } else {
            
            $basket[$id] = [
                "name" => "Demo Product " . $id,
                "quantity" => 1,
                "price" => 20.00,
                "image" => "https://via.placeholder.com/150"
            ];
        }

        // Save the updated list back to the browser memory
        session()->put('basket', $basket);
        
        // Refresh the page so you see the new item
        return redirect()->back(); 
    }

    
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