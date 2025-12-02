<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    public function index(Request $request)
    {
        // Get all active categories for filters
        $categories = Category::where('is_active', true)
                              ->orderBy('name')
                              ->get();

        // Base query
        $query = Product::with(['category', 'inventory']);

        // Optional category filter: ?category=ID
        if ($request->filled('category')) {
            $query->where('category_id', $request->query('category'));
        }

        // Optional search filter
        if ($request->filled('q')) {
            $search = $request->query('q');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Paginate results
        $products = $query->paginate(12)->withQueryString();

        return view('displayproduct', [
            'products'   => $products,
            'categories' => $categories,
        ]);
    }

    // Displays Products on the page
    public function show(Product $product)
    {
        // Load all related info
        $product->load(['category', 'inventory']);

        // Render details
        return view('product', [
            'product' => $product,
        ]);
    }
}


