<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Show the contact us form.
     */
   public function adminIndex()
{
    $contacts = Contact::latest()->get(); // newest first
    return view('admin.contacts', compact('contacts'));
}

    /**
     * Handle the form submission.
     */
    public function submit(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'phone'      => 'required|regex:/^[0-9]+$/|min:11|max:15',
            'email'      => 'required|email|max:255',
            'issue'      => 'required|string',
        ]);

        // Save the data into the contacts table
        Contact::create($validated);

        // Redirect back to the form with a success message
        return redirect()->route('contact.form')->with('success', 'Message sent!');
    }
}
