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
        
        // Transform to match the format expected by checkout view
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

    public function checkout()
    {
        // Get basket from DATABASE instead of session
        $cart = $this->getBasketItems();

        if(empty($cart)) {
            return redirect()->route('basket.index')->with('error', 'Your basket is empty!');
        }

        $total = 0;
        foreach($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        $featuredProducts = Product::latest()->take(4)->get();

        return view('checkout', compact('cart', 'total', 'featuredProducts'));
    }

    public function showPaymentForm()
    {
        // Get basket from DATABASE instead of session
        $cart = $this->getBasketItems();
        
        if(empty($cart)) {
            return redirect()->route('basket.index');
        }

        $featuredProducts = Product::latest()->take(4)->get();

        return view('payment', compact('featuredProducts'));
    }

    public function processPayment(Request $request)
    {
        // Strict Validation for Card Details
        $request->validate([
            'card_name'   => 'required|string|max:255',
            'card_number' => 'required|digits:16', // Exactly 16 numbers
            'expiry_date' => ['required', 'regex:/^(0[1-9]|1[0-2])\/?([0-9]{2})$/'], // MM/YY format
            'cvv'         => 'required|digits:3', // Exactly 3 numbers
        ], [
            'card_number.digits' => 'The card number must be exactly 16 digits.',
            'cvv.digits'         => 'The CVV must be exactly 3 digits.',
            'expiry_date.regex'  => 'Use the format MM/YY (e.g., 12/26).'
        ]);

        return $this->saveOrder($request);
    }

    protected function saveOrder(Request $request)
    {
        // Get basket from DATABASE instead of session
        $cart = $this->getBasketItems();
        
        $total = 0;
        foreach($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        $order = Order::create([
            'user_id'     => Auth::id(), // Will be NULL for guests
            'total_price' => $total,
            'status'      => 'Placed',
        ]);

        foreach($cart as $id => $details) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $id,
                'product_name' => $details['name'],
                'quantity'     => $details['quantity'],
                'price'        => $details['price'],
                'image_url'    => $details['image'] ?? null,
            ]);
        }

        // Clear basket from DATABASE after successful order
        if (Auth::check()) {
            BasketItem::where('user_id', Auth::id())->delete();
        } else {
            BasketItem::where('session_id', session()->getId())->delete();
        }

        // Also clear any discount codes
        session()->forget(['discount_code', 'discount_multiplier']);

        return redirect()->route('orders.index')->with('success', 'Payment Authorized! Order placed successfully.');
    }
}
