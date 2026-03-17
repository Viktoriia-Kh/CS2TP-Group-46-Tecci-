<?php

namespace App\Http\Controllers;

use App\Models\Product;

class DisplayProductController extends Controller
{
    public function DisplayProductController()
    {
        // Load all products with category
        $products = Product::with([
            'category',
            'inventory',
            'images',
            'specs',
            'reviews'
        ])->get();

        // Convert DB products
        $productsForJs = $products->map(function ($p) {
            $primaryImage = $p->images->firstWhere('is_primary', true);
            $fallbackImage = $p->images->first();

            $averageRating = $p->reviews->count() > 0
                ? round($p->reviews->avg('rating'), 1)
                : null;

            return [
                'id'           => $p->id,
                'name'         => $p->name,
                'price'        => (float) $p->price,
                'category'     => $p->category
                                    ? strtolower(str_replace(' ', '', $p->category->name))
                                    : 'uncategorised',
                'condition'    => $p->condition ?? 'new',
                'image_url'    => $primaryImage
                                    ? asset($primaryImage->image_path)
                                    : ($fallbackImage
                                        ? asset('storage/' . $fallbackImage->image_path)
                                        : ($p->image_url
                                            ? asset($p->image_url)
                                            : asset('images/Laptop.jpg'))),
                'description'  => $p->description,
                'brand'        => $p->brand,
                'student_price'=> $p->student_price,
                'stock_quantity' => $p->inventory ? $p->inventory->quantity_available : 0,
                'stock_status' => $p->stock_status,
                'avg_rating'   => $averageRating,
                'review_count' => $p->reviews->count(),
                'specs'        => $p->specs->map(function ($spec) {
                    return [
                        'spec_name'  => $spec->spec_name,
                        'spec_value' => $spec->spec_value,
                    ];
                })->values(),
                'images'       => $p->images->map(function ($image) {
                    return [
                        'image_path' => asset('storage/' . $image->image_path),
                        'is_primary' => (bool) $image->is_primary,
                        'sort_order' => $image->sort_order,
                    ];
                })->values(),
            ];
        });

        // Render YOUR list page view
        return view('displayproduct', [
            'productsForJs' => $productsForJs,
        ]);
    }
}