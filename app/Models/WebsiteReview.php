<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class WebsiteReviewController extends Controller
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
    }
}