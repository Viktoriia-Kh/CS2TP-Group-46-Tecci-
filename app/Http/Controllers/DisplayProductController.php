<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class DisplayProductController extends Controller
{
    /**
     * Show all products.
     * This loads:
     *  - all products
     *  - their category
     *  - their inventory (stock)
     *  - list of categories
     *
     * Then it sends all of that data
     * to the Blade file: displayproduct.blade.php
     */
    public function index(Request $request)
    {
        // Load all active categories for filter buttons
        $categories = Category::where('is_active', true)->get();

        // Start the product query with relationships
        $query = Product::with(['category', 'inventory']);

        // Optional filter by category: ?category=ID
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        // Optional search: ?q=keyword
        if ($request->has('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                  ->orWhere('brand', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
            });
        }

        // Get the final product list
        $products = $query->get();

        // Send data to your Blade file
        return view('displayproduct', [
            'products'          => $products,
            'categories'        => $categories,
            'currentCategoryId' => $request->category ?? null,
            'searchTerm'        => $request->q ?? '',
        ]);
    }
}
