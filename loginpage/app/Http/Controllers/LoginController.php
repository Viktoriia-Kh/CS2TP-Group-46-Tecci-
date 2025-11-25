<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // enables me to use database queries
use Illuminate\Support\Facades\Hash; // for password hashing
use Illuminate\Support\Facades\Auth; // checks the user credentials and starts a session

class LoginController extends Controller
{
    public function login(Request $request)
    {

        // assigning variables
        $email_address = ''; // this will hold the email address which the user enters when logging in
        $password = ''; // this will hold the password entered by the user when they log in
        $error_messages = []; // this will show any error messages if something goes wrong

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
                    return redirect()->intended('/homepage'); // this will redirect the user to the homepage
                } else {
                    $error_messages[] = "Please login with the correct details."; // user gets this message if the login does not work
                }

            }

        }
        return view('login', ['error_messages' => $error_messages]); // login page refreshes with the error message showing
    }
}
