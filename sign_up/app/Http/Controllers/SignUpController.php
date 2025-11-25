<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SignUpController extends Controller
{
    // show the signup form
    public function showForm()
    {
        return view('signup'); // resources/views/signup.blade.php
    }

    // handle form submission
    public function submit(Request $request)
    {
        // 1) validate input
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // uses password_confirmation
        ]);

        // 2) create user in DB
        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // 3) redirect back with success message
        return redirect()
            ->route('signup.form')
            ->with('success', 'Account created successfully!');
    }
}
