<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class SignUpController extends Controller
{
    /**
     * Show the sign up page
     */
    public function showForm()
    {
        return view('signup'); // this will load resources/views/signup.blade.php
    }

    /**
     * Handle the sign up POST request
     */
    public function register(Request $request)
    {
        //  Validate the form input
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed', 
        ]);

        //  Create new user
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // secure hashing
        ]);

        // Redirect wherever you want
        return redirect('/login')->with('success', 'Account created successfully.');
    }
}
use App\Http\Controllers\SignUpController;
