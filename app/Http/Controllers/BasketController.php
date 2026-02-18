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

        //  Retrieves discount data from session so it stays on refresh
        $discountCode = session()->get('discount_code', null);
        $discountMultiplier = session()->get('discount_multiplier', 1);
        
        return view('basket', compact('basket', 'discountCode', 'discountMultiplier'));
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

        // If basket is now empty, clear the discount 
        if (empty($basket)) {
            session()->forget(['discount_code', 'discount_multiplier']);
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

        //If basket is now empty, clear the discount
        if (empty($basket)) {
            session()->forget(['discount_code', 'discount_multiplier']);
        }

        return redirect()->back();
    }

    // Apply Discount
    public function applyDiscount(Request $request)
    {
        $code = strtolower(trim($request->input('code')));

        //Hardcoded valid discount codes
       $validCodes = [
        'xmas10' => 0.90, //10% off
        'welcome20' => 0.80 //20% off
    ];

    if (array_key_exists($code, $validCodes)){
        // Save to Session
            session()->put('discount_code', $code);
            session()->put('discount_multiplier', $validCodes[$code]);
            
            return response()->json([
                'success' => true,
                'message' => 'Discount applied!',
            ]);
    }

    return response()->json([
            'success' => false,
            'message' => 'Invalid discount code.'
        ], 400); // Returns 400 error for invalid code

    }

    // --- AJAX Update Method ---
    public function updateAjax(Request $request)
    {
        $id = $request->input('id');
        $action = $request->input('action');
        
        $basket = session()->get('basket', []);
        
        // 1 - Process the Action
        if(isset($basket[$id])) {
            if($action === 'increase') {
                $basket[$id]['quantity']++;
            } elseif($action === 'decrease') {
                if($basket[$id]['quantity'] > 1) {
                    $basket[$id]['quantity']--;
                } else {
                    unset($basket[$id]);
                    $action = 'remove'; // Treat as removal if quantity goes to 0
                }
            } elseif($action === 'remove') {
                unset($basket[$id]);
            }
        }

        // 2 - Save Session
        session()->put('basket', $basket);
        
        // Clear discount if empty
        if (empty($basket)) {
            session()->forget(['discount_code', 'discount_multiplier']);
        }

        // 3 - Recalculate Totals
        $total = 0;
        $totalQty = 0;
        foreach($basket as $item) {
            $total += $item['price'] * $item['quantity'];
            $totalQty += $item['quantity'];
        }

        // 4 - Return Data to JS
        return response()->json([
            'success' => true,
            'action' => $action, // increase, decrease, or remove
            'newQuantity' => isset($basket[$id]) ? $basket[$id]['quantity'] : 0,
            'subtotal' => number_format($total, 2),
            'subtotalRaw' => $total, // For JS math (delivery threshold)
            'totalQty' => $totalQty, // For the Header Badge
            'itemCount' => count($basket) // To check if empty
        ]);
    }
}