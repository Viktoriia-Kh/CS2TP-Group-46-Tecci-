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
        $error_messages = [];
    }
}
