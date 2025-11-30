<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
class ProductController extends Controller
{

     // Show the main products page.
    public function index(Request $request)
    {
        // Get all active categories for the filter buttons / dropdown
        $categories = Category::where('is_active', true)
                              ->orderBy('name')
                              ->get();

        // Start a base query for products
        $query = Product::with(['category', 'inventory']);

        // Filter by category if ?category=ID is used
        $currentCategoryId = $request->query('category');
        if (!empty($currentCategoryId)) {
            $query->where('category_id', $currentCategoryId);
        }

        // Search by keyword if ?q= is used
        $searchTerm = $request->query('q');
        if (!empty($searchTerm)) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('brand', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Results
        $products = $query->paginate(12)->withQueryString();

        // Pass variables Blade view
        return view('products.index', [
            'products'          => $products,
            'categories'        => $categories,
            'currentCategoryId' => $currentCategoryId,
            'searchTerm'        => $searchTerm,
        ]);
    }

    // Show a single product detail page.
    public function show(Product $product)
    {
        // Eager-load relations for this product (category + inventory)
        $product->load(['category', 'inventory']);

        return view('products.show', [
            'product' => $product,
        ]);
    }
}
