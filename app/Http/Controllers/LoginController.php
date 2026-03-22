<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // enables me to use database queries
use Illuminate\Support\Facades\Hash; // for password hashing
use Illuminate\Support\Facades\Auth; // checks the user credentials and starts a session
use Illuminate\Support\Facades\Password; // allows user to reset their password

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // adding a check to see if the user is logged in already
        if(Auth::check()) {
            return redirect()->intended('/account');
        }

        // assigning variables
        $email_address = ''; // holds the email address which the user enters when logging in
        $password = ''; // holds the password entered by the user
        $error_messages = []; // this will show any error messages

        // this will check if the form has been submitted by the user
        if ($request->isMethod('post')) {
            $email_address = $request->input('email_address'); // this takes the inputted user email address
            $password = $request->input('password'); // this takes the inputted user password

            // check if the email address field is empty
            if ($email_address == '') {
                $error_messages[] = "Please enter your email address.";
            }

            // check if the password field is empty
            if ($password == '') {
                $error_messages[] = "Please enter your password.";
            }

            // check if there are no errors during the login process
            if (empty($error_messages)) {
                $user_credentials = ['email' => $email_address, 'password' => $password]; // the user inputs are ready to be checked

                // here it will attempt to log the user in
                if (Auth::attempt(['email' => $email_address, 'password' => $password])) {
                    $request->session()->regenerate(); // the session ID is reset for security purposes

                    // Merge guest basket into user basket
                    app(\App\Http\Controllers\BasketController::class)->mergeGuestBasketOnLogin();

                    return redirect()->intended('/'); // this will redirect the user to the homepage
                } else {
                    $error_messages[] = "Please login with the correct details."; // user gets this message if the login does not work
                }

            }

        }
        return view('login', ['error_messages' => $error_messages]); // login page refreshes with the error message showing
    }
    // display the forgot password page
    public function showForgotPassword() {
        return view('auth.forgot-password');
    }

    // function which handles sending the reset link
    public function sendResetPasswordLink(Request $request) {
        $request->validate(['email_address' => 'required|email']);
        $request_status = Password::sendResetLink(['email' => $request ->email_address]); // sends a reset email to the user

        return $request_status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($request_status)])
            : back()->withErrors(['email' => __($request_status)]);
    }

    // this will show the form where the user can change their password
    public function showPasswordResetForm(Request $request, $token) {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    // function which updates users password in the database
    public function updatePassword(Request $request) {
        $request->validate(['token' => 'required', 'email' => 'required|email', 'password' => 'required|min:8|confirmed']);
        $request_status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function($user, $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
            }
        );

        return $request_status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($request_status))
            : back()->withErrors(['email' => [__($request_status)]]);
    }


}
