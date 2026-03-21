<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|max:2000',
        ]);

        Review::create([
            'name' => $validated['name'] ?? 'Anonymous',
            'rating' => $validated['rating'],
            'message' => $validated['message'],
            'is_approved' => true,
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully.');
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        Review::updateOrCreate(
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