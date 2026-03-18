<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminSettingsController extends Controller
{
    // function to show the account page
    public function showAdminSettings()
    {
        $user = Auth::user(); // the logged-in admin's data is saved here
        return view('admin.settings', ['user' => $user]);
    }

    // function to update the admin email/ name
    public function update(Request $request)
    {
        $user = Auth::user();
        // adding validation (i.e. check if the email is taken)
        $request->validate([
            'name' => 'required|string|max:255',
            'email_address' => 'required|email|unique:users,email,' . $user->id, // ensures the email is valid
            'phone' =>'nullable|string|max:20', // added validation for the phone number
        ]);

        // save the changes to the database
        $user->update([
            'name' => $request->input('name'), // the name column gets updated here
            'email' => $request->input('email_address'), // the email column gets updated here
            'phone' => $request->input('phone'), // the phone number column gets updated here
        ]);

        return back()->with('success', 'Your details have been updated successfully!'); // success message to the user
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

