<?php

namespace App\Http\Controllers;

use App\Models\WebsiteReview;
use Illuminate\Http\Request;

class WebsiteReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|max:2000',
        ]);

        $review = new WebsiteReview();
        $review->name = $validated['name'] ?? 'Anonymous';
        $review->rating = $validated['rating'];
        $review->message = $validated['message'];
        $review->is_approved = true;
        $review->save();

        return redirect()->back()->with('success', 'Review submitted successfully.');
    }
}