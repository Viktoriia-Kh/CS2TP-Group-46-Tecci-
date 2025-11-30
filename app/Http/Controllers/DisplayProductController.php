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

        $products = $query->get();

        /**
         * Build JSON array for JavaScript (matching your old allProducts array)
         */
        $productsJson = $products->map(function ($p) {
            return [
                'id'        => $p->id,
                'name'      => $p->name,
                'price'     => (float) $p->student_price, // or $p->price
                'category'  => strtolower(optional($p->category)->name ?? 'other'),
                'condition' => 'new', // you can replace this later with a DB column
            ];
        });

        return view('displayproduct', [
            'products'     => $products,
            'productsJson' => $productsJson,
        ]);


    }
}
