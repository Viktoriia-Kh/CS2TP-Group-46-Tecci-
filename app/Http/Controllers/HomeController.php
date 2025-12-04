<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //Show the home page with products
    public function index()
    {
        // Get 4 products
        $featuredProducts = Product::latest()->take(4)->get();


        return view('home-page', [
            'featuredProducts' => $featuredProducts,
        ]);
    }
}
