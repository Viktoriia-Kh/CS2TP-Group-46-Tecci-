<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
public function index()
{
    $customers = User::latest()->paginate(10);
    return view('Admincustomers', compact('customers'));
}

public function edit($id)
{
    $customer = User::findOrFail($id);
    return view('Editcustomers', compact('customer'));
}

   public function update(Request $request, $id)
{
    $customer = User::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $customer->id,
    ]);

    $customer->name = $validated['name'];
    $customer->email = $validated['email'];

    if ($request->filled('password')) {
        $customer->password = bcrypt($request->password);
    }

    $customer->save();

    return redirect()->route('admin.customers')->with('success', 'Customer updated successfully.');
}
}