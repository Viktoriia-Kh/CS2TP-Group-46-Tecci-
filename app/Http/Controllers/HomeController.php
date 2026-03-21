<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::latest()->take(4)->get();

        $reviews = Review::where('is_approved', true)
            ->latest()
            ->take(10)
            ->get();

        return view('home-page', compact('featuredProducts', 'reviews'));
    }
    public function index()

    {

        $featuredProducts = Product::latest()->take(4)->get();


        return view('home-page', [
            'featuredProducts' => $featuredProducts,
        ]); 

    }
}
}
