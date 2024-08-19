<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('pages.admin.user.index', ['users' => $users]);
    }

    public function create()
    {
        return view('pages.admin.user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users',
            'password' => 'string|min:5|confirmed'
        ]);
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), 
            'photo' => 'users/user-default.jpg',
            'role' => $request->role
        ]);
        return redirect('/admin/users')->with(['message' => 'Akun ' .$request->role. ' berhasil ditambah']);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.admin.user.edit', ['user' => $user]);
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
            'photo' => 'users/user-default.jpg',
            'role' => $request->role
        ]);
        return redirect('/admin/users')->with(['message' => 'Akun ' .$request->role. ' berhasil diedit']);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with(['message' => 'Akun ' .$user->role. ' berhasil dihapus']);
    }
}
