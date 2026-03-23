<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductReview;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        ProductReview::updateOrCreate(
            [
                'product_id' => $productId,
                'user_id' => auth()->id() ?? 1,
            ],
            [
                'rating' => $request->rating,
                'review_text' => $request->comment,
            ]
        );

        return back()->with('success', 'Review submitted successfully!');
    }
}