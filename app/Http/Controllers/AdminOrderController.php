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
        $query = Order::with(['items', 'user']);

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

        // SORTING LOGIC (date & price)
        if ($request->has('sort')) {
            if ($request->sort == 'price_asc') {
                $query->orderBy('total_price', 'asc');
            } elseif ($request->sort == 'date_desc') {
                $query->orderBy('created_at', 'desc');
            }
        } else {
            // Default sorting (newest first)
            $query->orderBy('created_at', 'desc');
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
            if ($order->status === 'Pending' && in_array($newStatus, ['Approved', 'Shipped', 'Completed'])) {
                foreach ($order->items as $item) {
                    if ($item->product && $item->product->inventory) {
                        $item->product->inventory->decrement('quantity_available', $item->quantity);
                    }
                }
            }

            // RESTORE STOCK LOGIC (Optional but good practice)
            if (in_array($order->status, ['Approved', 'Shipped', 'Completed']) && $newStatus === 'Cancelled') {
                foreach ($order->items as $item) {
                    if ($item->product && $item->product->inventory) {
                        $item->product->inventory->increment('quantity_available', $item->quantity);
                    }
                }
            }

            $order->update(['status' => $newStatus]);
        });

        return redirect()->back()->with('success', 'Order #' . $order->id . ' has been updated to ' . $newStatus . '.');
    }

    public function show($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        return view('admin-order-details', compact('order'));
    } // <--- THIS WAS THE MISSING BRACE!

    // --- NEW: Show the Create Order Form ---
    public function create()
    {
        // Get all users and products so we can show them in dropdown menus
        $users = \App\Models\User::orderBy('name')->get();
        $products = \App\Models\Product::orderBy('name')->get();
        
        return view('admin-create-order', compact('users', 'products'));
    }

    // --- NEW: Save the Initiated Order ---
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'products' => 'required|array',
        ]);

        // Filter out any empty product rows
        $selectedProducts = array_filter($request->products, function($p) {
            return !empty($p['id']) && !empty($p['quantity']);
        });

        if (empty($selectedProducts)) {
            return back()->withErrors('You must select at least one product with a quantity.');
        }

        // Create the base order
        $order = Order::create([
            'user_id' => $request->user_id,
            'status' => 'Pending', // Starts as pending, stock isn't deducted until Approved/Shipped!
            'total_price' => 0,
        ]);

        $totalPrice = 0;

        // Add the items to the order
        foreach ($selectedProducts as $item) {
            $product = Product::find($item['id']);
            $linePrice = $product->price * $item['quantity'];
            $totalPrice += $linePrice;

            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);
        }

        // Update the final total
        $order->update(['total_price' => $totalPrice]);

        return redirect()->route('admin.orders.index')->with('success', 'New order #' . $order->id . ' has been successfully initiated!');
    }
}