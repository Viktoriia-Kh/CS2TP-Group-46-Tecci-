<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BasketItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /* Get basket items from database (same logic as BasketController) */
    private function getBasketItems()
    {
        if (Auth::check()) {
            $items = BasketItem::where('user_id', Auth::id())->with('product')->get();
        } else {
            $items = BasketItem::where('session_id', session()->getId())->with('product')->get();
        }
        
        // Transform to match the format expected by views
        $basket = [];
        foreach ($items as $item) {
            $basket[$item->product_id] = [
                'name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'image' => $item->product->image_url,
            ];
        }
        
        return $basket;
    }

    /* Show Payment Form (combined with shipping address) */
    public function showPaymentForm()
    {
        // Get basket from DATABASE
        $cart = $this->getBasketItems();
        
        if(empty($cart)) {
            return redirect()->route('basket.index')->with('error', 'Your basket is empty!');
        }

        // Calculate totals
        $subtotal = 0;
        foreach($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Get delivery cost from session (set on basket page)
        $delivery = session()->get('delivery_cost', 3.99); // Default to standard
        
        // Get discount from session
        $discountMultiplier = session()->get('discount_multiplier', 1);
        $discount = $subtotal * (1 - $discountMultiplier);
        
        // Calculate total
        $total = ($subtotal * $discountMultiplier) + $delivery;

        return view('payment', compact('cart', 'subtotal', 'delivery', 'discount', 'total'));
    }

    /* Process Payment with Shipping Address */
    public function processPayment(Request $request)
    {
        // Validate Shipping Address + Card Details
        $request->validate([
            // Shipping fields
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'postcode' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            
            // Card fields
            'card_name' => 'required|string|max:255',
            'card_number' => 'required|digits:16',
            'expiry_date' => ['required', 'regex:/^(0[1-9]|1[0-2])\/?([0-9]{2})$/'],
            'cvv' => 'required|digits:3',
        ], [
            'card_number.digits' => 'The card number must be exactly 16 digits.',
            'cvv.digits' => 'The CVV must be exactly 3 digits.',
            'expiry_date.regex' => 'Use the format MM/YY (e.g., 12/26).'
        ]);

        return $this->saveOrder($request);
    }

    /* Save Order with Shipping Address */
    protected function saveOrder(Request $request)
    {
        // Get basket from DATABASE
        $cart = $this->getBasketItems();
        
        // Calculate total
        $subtotal = 0;
        foreach($cart as $details) {
            $subtotal += $details['price'] * $details['quantity'];
        }

        $delivery = session()->get('delivery_cost', 3.99);
        $discountMultiplier = session()->get('discount_multiplier', 1);
        $total = ($subtotal * $discountMultiplier) + $delivery;

        // Create order with shipping address
        $order = Order::create([
            'user_id' => Auth::id(), // NULL for guests
            'total_price' => $total,
            'status' => 'Placed',
            
            // Shipping address fields
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'city' => $request->city,
            'postcode' => $request->postcode,
            'country' => $request->country,
            'phone' => $request->phone,
        ]);

        // Create order items
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

        // Clear basket from DATABASE
        if (Auth::check()) {
            BasketItem::where('user_id', Auth::id())->delete();
        } else {
            BasketItem::where('session_id', session()->getId())->delete();
        }

        // Clear session data
        session()->forget(['discount_code', 'discount_multiplier', 'delivery_cost']);

        return redirect()->route('orders.index')->with('success', 'Payment Authorized! Order placed successfully.');
    }
}
