<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function index()
    {
        // Get orders for the logged-in user, ordered by newest first
        $orders = Order::where('user_id', Auth::id())
                        ->with('items') // Load the items too
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('my-orders', compact('orders'));
    }

    // Show the specific details of one order 
    public function show($id)
    {
        $order = Order::with('items')->where('user_id', Auth::id())->findOrFail($id);
        
        return view('order-details', compact('order'));
    }

    public function requestReturn(Request $request, $id){
        
        $request->validate([
            'return_reason' => 'required|string|max:500'
        ]);

        
        $item = \App\Models\OrderItem::findOrFail($id);
        $item->update([
            'return_reason' => $request->return_reason,
            'return_status' => 'Requested'
        ]);

    return back()->with('success', 'Return request sent!');
    }

}
