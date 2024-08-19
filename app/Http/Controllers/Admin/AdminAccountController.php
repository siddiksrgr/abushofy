<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminAccountController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(auth()->user()->id);
        return view('pages.admin.account.index', ['user' => $user]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.admin.account.edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users',
            'password' => 'string|min:5|confirmed'
        ]);
        $user = User::findOrFail($id);
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone_number' => $request->phone_number
        ]);
        return redirect('/admin/account')->with(['message' => 'Akun anda berhasil diedit.']);
    }

}
