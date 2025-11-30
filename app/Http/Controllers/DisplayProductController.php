<?php

namespace App\Http\Controllers;

use App\Models\Product;

class DisplayProductController extends Controller
{
    public function index()
    {
        // Load all products with category
        $products = Product::with('category')->get();

        // Convert DB products
        $productsForJs = $products->map(function ($p) {
            return [
                'id'        => $p->id,
                'name'      => $p->name,
                'price'     => (float) $p->price,
                'category'  => $p->category
                                ? strtolower(str_replace(' ', '', $p->category->name))
                                : 'uncategorised',
                'condition' => $p->condition ?? 'new',
            ];
        });

        // Render YOUR list page view
        return view('displayproduct', [
            'productsForJs' => $productsForJs,
        ]);
    }
}