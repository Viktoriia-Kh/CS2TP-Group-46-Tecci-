<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    /* 
     * Process an order status change
     * Stock is deducted when order moves from Pending → Approved/Shipped/Completed
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Approved,Shipped,Completed,Cancelled'
        ]);

        $order = Order::with('items.product.inventory')->findOrFail($id);
        $newStatus = $request->input('status');
        $oldStatus = $order->status;

        DB::transaction(function () use ($order, $newStatus, $oldStatus) {
            
            // AUTOMATIC STOCK DEDUCTION LOGIC
            // When admin approves order, deduct stock
            if ($oldStatus === 'Pending' && in_array($newStatus, ['Approved', 'Shipped', 'Completed'])) {
                foreach ($order->items as $item) {
                    if ($item->product && $item->product->inventory) {
                        $inventory = $item->product->inventory;
                        
                        // Check if enough stock
                        if ($inventory->quantity_available < $item->quantity) {
                            throw new \Exception("Insufficient stock for {$item->product->name}. Available: {$inventory->quantity_available}, Required: {$item->quantity}");
                        }
                        
                        // Deduct stock
                        $inventory->decrement('quantity_available', $item->quantity);
                    }
                }
            }

            // RESTORE STOCK LOGIC
            // If order is cancelled after being approved, restore stock
            if (in_array($oldStatus, ['Approved', 'Shipped', 'Completed']) && $newStatus === 'Cancelled') {
                foreach ($order->items as $item) {
                    if ($item->product && $item->product->inventory) {
                        $item->product->inventory->increment('quantity_available', $item->quantity);
                    }
                }
            }

            $order->update(['status' => $newStatus]);
        });

        return redirect()->back()->with('success', 'Order #' . $order->id . ' has been updated to ' . $newStatus . '. Stock levels have been updated automatically.');
    }

    /**
 * Handle bulk actions on multiple orders
 */
public function bulkAction(Request $request)
{
    try {
        $validated = $request->validate([
            'action' => 'required|in:shipped,completed,cancelled,print',
            'order_ids' => 'required|array|min:1',
            'order_ids.*' => 'exists:orders,id'
        ]);

        $action = $validated['action'];
        $orderIds = $validated['order_ids'];
        $successCount = 0;
        $errors = [];

        DB::beginTransaction();

        foreach ($orderIds as $orderId) {
            try {
                $order = Order::findOrFail($orderId);
                
                switch ($action) {
                    case 'shipped':
                        // Only update if order is Pending or Approved
                        if (in_array($order->status, ['Pending', 'Approved'])) {
                            $order->status = 'Shipped';
                            $order->save();
                            $successCount++;
                        } else {
                            $errors[] = "Order #{$orderId} cannot be shipped (current status: {$order->status})";
                        }
                        break;

                    case 'completed':
                        // Only update if order is Shipped or Approved
                        if (in_array($order->status, ['Shipped', 'Approved'])) {
                            $order->status = 'Completed';
                            $order->save();
                            $successCount++;
                        } else {
                            $errors[] = "Order #{$orderId} cannot be completed (current status: {$order->status})";
                        }
                        break;

                    case 'cancelled':
                        // Can cancel from any non-completed status
                        if ($order->status !== 'Completed' && $order->status !== 'Cancelled') {
                            // Restore stock if order was approved/shipped
                            if (in_array($order->status, ['Approved', 'Shipped'])) {
                                foreach ($order->items as $item) {
                                    if ($item->product && $item->product->inventory) {
                                        $item->product->inventory->increment('quantity_available', $item->quantity);
                                    }
                                }
                            }
                            
                            $order->status = 'Cancelled';
                            $order->save();
                            $successCount++;
                        } else {
                            $errors[] = "Order #{$orderId} cannot be cancelled (current status: {$order->status})";
                        }
                        break;
                }
            } catch (\Exception $e) {
                $errors[] = "Error processing order #{$orderId}: " . $e->getMessage();
                Log::error("Bulk action error for order {$orderId}", ['error' => $e->getMessage()]);
            }
        }

        DB::commit();

        // Build response message
        $message = "{$successCount} order(s) updated successfully";
        if (!empty($errors)) {
            $message .= ". " . count($errors) . " order(s) had issues: " . implode('; ', array_slice($errors, 0, 3));
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'updated_count' => $successCount,
            'errors' => $errors
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Invalid request data',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Bulk action failed', ['error' => $e->getMessage()]);
        
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while processing bulk action: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Generate print view for selected orders
 */
public function printOrders(Request $request)
{
    $orderIds = explode(',', $request->input('ids', ''));
    $orders = Order::with(['items.product', 'user'])
                   ->whereIn('id', $orderIds)
                   ->get();

    return view('admin-print-orders', compact('orders'));
}


    /* View single order details */
    public function show($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        return view('admin-order-details', compact('order'));
    }

    /* Show the Create Order Form */
    public function create()
    {
        // Get all users and products for dropdown menus
        $users = User::orderBy('name')->get();
        $products = Product::with('inventory')->orderBy('name')->get();
        
        return view('admin-create-order', compact('users', 'products'));
    }

    /* Save the Initiated Order */
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

        // Wrap in transaction for data integrity
        try {
            DB::beginTransaction();

            // Create the base order (starts as Pending - no stock deducted yet)
            $order = Order::create([
                'user_id' => $request->user_id,
                'status' => 'Pending',
                'total_price' => 0,
            ]);

            $totalPrice = 0;

            // Add the items to the order
            foreach ($selectedProducts as $item) {
                $product = Product::findOrFail($item['id']);
                $quantity = (int) $item['quantity'];
                
                // Validate quantity
                if ($quantity < 1) {
                    throw new \Exception("Quantity must be at least 1 for {$product->name}");
                }
                
                $linePrice = $product->price * $quantity;
                $totalPrice += $linePrice;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name, 
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'image_url' => $product->image_url ?? null,
                ]);
            }

            // Update the final total
            $order->update(['total_price' => $totalPrice]);

            DB::commit();

            return redirect()->route('admin.orders.index')
                ->with('success', 'Order #' . $order->id . ' has been successfully created! Status: Pending. Stock will be deducted when order is Approved.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error creating order: ' . $e->getMessage());
        }
    }
}
