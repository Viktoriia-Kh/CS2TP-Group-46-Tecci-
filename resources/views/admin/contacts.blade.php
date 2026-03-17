<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact-us');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'phone'      => 'required|regex:/^[0-9]+$/|min:11|max:15',
            'email'      => 'required|email|max:255',
            'issue'      => 'required|string',
        ]);

        Contact::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'phone'      => $validated['phone'],
            'email'      => $validated['email'],
            'issue'      => $validated['issue'],
            'status'     => 'pending',
        ]);

        return redirect()->route('contact.form')->with('success', 'Message sent!');
    }

    public function adminIndex()
    {
        $contacts = Contact::latest()->get();
        return view('admin.contacts', compact('contacts'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => 'required|string',
        ]);

        $contact = Contact::findOrFail($id);

        $contact->admin_reply = $request->admin_reply;
        $contact->replied_at = now();
        $contact->status = 'replied';
        $contact->save();

        try {
            Mail::raw($request->admin_reply, function ($message) use ($contact) {
                $message->to($contact->email)
                        ->subject('Reply to your TECCI enquiry');
            });

            return redirect()->route('admin.contacts')->with('success', 'Reply saved and emailed successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.contacts')->with('success', 'Reply saved, but email could not be sent.');
        }
    }

    public function markResolved($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->status = 'resolved';
        $contact->save();

        return redirect()->route('admin.contacts')->with('success', 'Message marked as resolved.');
    }
}