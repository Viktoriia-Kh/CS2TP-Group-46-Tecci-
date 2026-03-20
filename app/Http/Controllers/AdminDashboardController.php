<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index(){

        $salesToday = \App\Models\Order::whereDate('created_at', \Carbon\Carbon::today())->count();

        $revenueMonth = \App\Models\Order::whereMonth('created_at', \Carbon\Carbon::now()->month)
        ->whereYear('created_at', \Carbon\Carbon::now()->year)
        ->sum('total_price');

        $refundRequests = OrderItem::whereNotNull('return_status')
            ->where('return_status', '!=', 'none')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        // orders that need to be processed
        $pendingOrders = \App\Models\Order::where('status', 'Pending')->latest()->get();

        // show items that are out of stock
        $itemsOutOfStock = \App\Models\Inventory::where('quantity', '<=', 0)
            ->with('product') // gets the product name from the database
            ->get();

        return view('admin-dashboard', compact('refundRequests', 'salesToday', 'revenueMonth', 'pendingOrders', 'itemsOutOfStock'));
    }

    public function approveReturn($id){
    $item = \App\Models\OrderItem::findOrFail($id);

    $item->return_status = 'Approved';
    $item->save();


    return back()->with('success', 'Refund for Order #' . $item->order_id . ' has been approved.');
    }

    public function declineReturn($id){
    $item = \App\Models\OrderItem::findOrFail($id);
    $item->return_status = 'Declined';
    $item->save();

    return back()->with('success', 'Refund for Order #' . $item->order_id . ' has been declined.');
    }

}
