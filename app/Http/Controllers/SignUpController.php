<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // 2) create user
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => $request->input('is_admin', 0) // admin setting added (if user is not admin value remains 0)
        ]);

        // 3) log them in
        Auth::login($user);

        // 4) send the verification email
        $user->sendEmailVerificationNotification();

        // 5) redirect to the verification notice page
        return redirect()
            ->route('verification.notice')
            ->with('success', 'Account created! Please check your email to verify your address.');
    }
}
