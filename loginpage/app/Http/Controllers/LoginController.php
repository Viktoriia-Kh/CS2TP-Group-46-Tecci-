<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // enables me to use database queries

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

        // this will check if the form has been submitted by the user
        if ($request->isMethod('post')) {
            $email_address = $request->input('email_address'); // this takes the inputted user email address
            $password = $request->input('password'); // thi takes the inputted user password

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
                $user = DB::table('users')->where('email', $email_address)->first(); // checks if the user exists in the database
            }

        }

    }
}
