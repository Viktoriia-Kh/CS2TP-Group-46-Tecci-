<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Show the main products page.
     *
     * This will fetch:
     *  - all products (with their category + inventory)
     *  - all categories (for filter buttons, if you want)
     *
     * It then sends them to the Blade view "displayproduct".
     */
    public function index(Request $request)
    {
        // Get all active categories (for filters)
        $categories = Category::where('is_active', true)
                              ->orderBy('name')
                              ->get();

        // Base query for products with relationships
        $query = Product::with(['category', 'inventory']);

        // Optional: filter by category if ?category=ID is in the URL
        $currentCategoryId = $request->query('category');
        if (!empty($currentCategoryId)) {
            $query->where('category_id', $currentCategoryId);
        }

        // Optional: search by keyword if ?q= is in the URL
        $searchTerm = $request->query('q');
        if (!empty($searchTerm)) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('brand', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Get all products (you can change to paginate() later)
        $products = $query->get();

        // Send data to your Blade view: resources/views/displayproduct.blade.php
        return view('displayproduct', [
            'products'          => $products,
            'categories'        => $categories,
            'currentCategoryId' => $currentCategoryId,
            'searchTerm'        => $searchTerm,
        ]);
    }

    /**
     * Show a single product detail page.
     * (We can use this later if you have a separate product details page)
     */
    public function show(Product $product)
    {
        $product->load(['category', 'inventory']);

        return view('productshow', [ // you'll create resources/views/productshow.blade.php later
            'product' => $product,
        ]);
    }
}

