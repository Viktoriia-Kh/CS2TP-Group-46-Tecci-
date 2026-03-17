<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminInventoryController extends Controller
{
    /**
     * Requirement: Search, filter, and view the status of selected products
     */
    public function index(Request $request)
    {
        // Start a query, automatically pulling in the linked inventory data
        $query = Product::with(['inventory', 'category']);

        // 1. SEARCH LOGIC
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('brand', 'like', "%{$searchTerm}%");
        }

        // 2. FILTER LOGIC (By Stock Status)
        if ($request->filled('stock_filter')) {
            $filter = $request->input('stock_filter');
            
            if ($filter === 'out_of_stock') {
                $query->whereHas('inventory', function($q) {
                    $q->where('quantity_available', '<=', 0);
                });
            } elseif ($filter === 'low_stock') {
                $query->whereHas('inventory', function($q) {
                    $q->whereColumn('quantity_available', '<=', 'reorder_threshold')
                      ->where('quantity_available', '>', 0);
                });
            } elseif ($filter === 'in_stock') {
                $query->whereHas('inventory', function($q) {
                    $q->whereColumn('quantity_available', '>', 'reorder_threshold');
                });
            }
        }

        // Get results, 15 per page for the dashboard table
        $products = $query->paginate(15);

        return view('admin.inventory.index', compact('products'));
    }

    /**
     * Add products to the inventory. 
     * Stock number is automatically updated.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:150',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'quantity_available' => 'required|integer|min:0',
            'reorder_threshold' => 'required|integer|min:0',
        ]);

        // 2. DB Transaction ensures both tables update simultaneously.
        // If one fails, they both cancel (prevents ghost stock).
        DB::transaction(function () use ($request) {
            
            // Step A: Create the core product
            $product = Product::create([
                'name' => $request->name,
                'brand' => $request->brand,
                'description' => $request->description,
                'price' => $request->price,
                'student_price' => $request->student_price,
                'category_id' => $request->category_id,
                'image_url' => $request->image_url,
            ]);

            // Step B: Automatically create the stock record in the Inventories table
            $product->inventory()->create([
                'quantity_available' => $request->quantity_available,
                'reorder_threshold' => $request->reorder_threshold,
            ]);
        });

        return redirect()->back()->with('success', 'Product and stock successfully added to inventory.');
    }

    /* Edit products / Automatically update stock number */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        DB::transaction(function () use ($request, $product) {
            
            // Update core product details
            $product->update($request->only([
                'name', 'brand', 'description', 'price', 'student_price', 'category_id', 'image_url'
            ]));

            // Automatically update the stock numbers in the separate table
            if ($product->inventory) {
                $product->inventory->update([
                    'quantity_available' => $request->quantity_available,
                    'reorder_threshold' => $request->reorder_threshold,
                ]);
            }
        });

        return redirect()->back()->with('success', 'Product and stock levels updated.');
    }

    /* Remove products from the inventory */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // used `cascadeOnDelete()` in migration, so 
        // deleting the product here will automatically delete the inventory row
        $product->delete();

        return redirect()->back()->with('success', 'Product permanently removed from inventory.');
    }
}