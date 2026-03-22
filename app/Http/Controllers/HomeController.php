<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\WebsiteReview;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::latest()->take(4)->get();

        $reviews = WebsiteReview::where('is_approved', true)
            ->latest()
            ->take(10)
            ->get();

        return view('home-page', compact('featuredProducts', 'reviews'));
    }
}