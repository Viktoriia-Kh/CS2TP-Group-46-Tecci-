<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    /* Search, filter, and view the status of selected orders. */
    public function index(Request $request)
    {
        // Start query, fetching related items and the user who placed it
        $query = Order::with(['items', 'user'])->orderBy('created_at', 'desc');

        // 1. SEARCH LOGIC (By Order ID or Customer Name)
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('id', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function($q) use ($searchTerm) {
                      $q->where('name', 'like', "%{$searchTerm}%");
                  });
        }

        // 2. FILTER LOGIC (By Status)
        if ($request->filled('status_filter')) {
            $query->where('status', $request->input('status_filter'));
        }

        // 3. FILTER LOGIC (By Price Range)
        if ($request->filled('price_filter')) {
            $range = explode('-', $request->input('price_filter'));
            if (count($range) == 2) {
                $query->whereBetween('total_price', [(float)$range[0], (float)$range[1]]);
            } elseif ($range[0] == '1000+') {
                $query->where('total_price', '>=', 1000);
            }
        }

        $orders = $query->paginate(15);

        return view('admin-orders', compact('orders'));
    }

    /* Process an order... Following this entry, the stock level will be automatically updated. */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Approved,Shipped,Completed,Cancelled'
        ]);

        $order = Order::with('items.product.inventory')->findOrFail($id);
        $newStatus = $request->input('status');

        DB::transaction(function () use ($order, $newStatus) {
            
            // AUTOMATIC STOCK DEDUCTION LOGIC
            // If the order is moving from 'Pending' to an active processed state, deduct stock.
            // We check this so we don't accidentally deduct stock twice if changing from Approved to Shipped.
            if ($order->status === 'Pending' && in_array($newStatus, ['Approved', 'Shipped', 'Completed'])) {
                
                foreach ($order->items as $item) {
                    // Make sure the product and its inventory record still exist
                    if ($item->product && $item->product->inventory) {
                        // Deduct the purchased quantity from the available stock
                        $item->product->inventory->decrement('quantity_available', $item->quantity);
                    }
                }
            }

            // RESTORE STOCK LOGIC (Optional but good practice)
            // If an order is cancelled, give the stock back to the inventory
            if (in_array($order->status, ['Approved', 'Shipped', 'Completed']) && $newStatus === 'Cancelled') {
                foreach ($order->items as $item) {
                    if ($item->product && $item->product->inventory) {
                        $item->product->inventory->increment('quantity_available', $item->quantity);
                    }
                }
            }

            // Finally, update the order status
            $order->update(['status' => $newStatus]);
        });

        return redirect()->back()->with('success', 'Order #' . $order->id . ' has been updated to ' . $newStatus . '.');
    }
}