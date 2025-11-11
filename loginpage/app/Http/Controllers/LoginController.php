<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        session_start(); // once the user has logged in the session will start

        // this will hold the email address which the user enters when logging in
        $email_address = '';

        // this will hold the password entered by the user when they log in
        $password = '';

        // this will show any error messages if something goes wrong during the login (e.g., wrong password)
        $error_messages[] = '';

        if ($request->isMethod('post')) {
            $email_address = $request->input('email_address');
            $password = $request->input('password');

            // check if the email address field is empty
            if ($email_address == '') {
                $error_messages[] = "Please enter your email address.";
            }

            // check if the password field is empty
            if ($password == '') {
                $error_messages[] = "Please enter your password.";
            }

        }

    }
}
