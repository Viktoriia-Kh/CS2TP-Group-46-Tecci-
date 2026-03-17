<?php

namespace App\Http\Controllers;

use App\Models\Product;

class AdminInventoryController extends Controller
{
    public function AdminInventoryController()
    {
        // Load all products with category and inventory
        $products = Product::with('category', 'inventory')->get();

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
                'description'    => $p->description,
                'image_url' => $p->image_url
                    ? asset($p->image_url)
                    : asset('images/Laptop.jpg'),
                'stock_quantity' => $p->inventory ? $p->inventory->quantity_available : 0,
                'stock_status' => $p->stock_status,
            ];
        });

        // Render YOUR list page view
        return view('admin-inventory', [
            'productsForJs' => $productsForJs,
        ]);
    }
}