<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // checks user credentials and starts a session
use App\Models\User; // links the controller to the database

class AccountController extends Controller
{
    // function to show the account page
    public function show()
    {
        $user = Auth::user(); // the logged-in user's data is saved here
        return view('account-page', ['user' => $user]);
    }

    // function to update the email/ name
    public function update(Request $request)
    {
        $user = Auth::user();
        // adding validation (i.e. check if the email is taken)
        $request->validate([
            'name' => 'required|string|max:255',
            'email_address' => 'required|email|unique:users,email,' . $user->id, // ensures the email is valid
        ]);

        // save the changes to the database
        $user->update([
            'name' => $request->input('name'), // the name column gets updated here
            'email' => $request->input('email_address'), // the email column gets updated here
        ]);

        return back()->with('success', 'Your details have been updated.'); // success message to the user
    }

    // function to handle the account deletion
    public function destroy()
    {
        $user = Auth::user(); // this identifies the user that is going to be deleted
        Auth::logout(); // the user is logged out of the session
        $user->delete();

        request()->session()->invalidate(); // session data is cleared
        request()->session()->regenerateToken(); // token is refreshed for security

        return redirect('/')->with('success', 'Your account has been deleted.'); // returns the user to the homepage
    }

}
