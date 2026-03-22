<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

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

        // check if the email ends with @tecci.com (makes the user an admin)
        $isAdminStatus = 0; // the user is not an admin by default initially
        if (str_ends_with($validated['email'], '@tecci.com')) {
            $isAdminStatus = 1; // the user is set as an admin
        }

        // 2) create user
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => $isAdminStatus, // admin setting added (if user is not admin value remains 0)
        ]);

        event(new Registered($user)); // this will trigger the sending of the verification email

        // 3) log them in
        Auth::login($user);

        // 4) send the verification email
        //$user->sendEmailVerificationNotification();

        // 5) redirect to the verification notice page
        return redirect()
            ->route('verification.notice')
            ->with('success', 'Account created! Please check your email to verify your address.');
    }
}
