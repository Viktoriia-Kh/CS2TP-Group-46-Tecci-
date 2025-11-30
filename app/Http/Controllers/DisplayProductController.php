<?php

namespace App\Http\Controllers;

use App\Models\Product;

class DisplayProductController extends Controller
{
    public function index()
        {
            // Load all products with their category
            $products = Product::with('category')->get();

            // Map Eloquent models to the array
            $productsForJs = $products->map(function ($product) {
                return [
                    'id'   => $product->id,
                    'name' => $product->name,
                    'price' => (float) $product->price,

                    // Category string used by the front-end JS tabs.
                    'category' => $product->category
                        ? strtolower(str_replace(' ', '', $product->category->name))
                        : 'uncategorised',

                    'condition' => $product->condition ?? 'new',
                ];
            });

            return view('displayproduct', [
                'productsForJs' => $productsForJs,
            ]);
        }
    }
