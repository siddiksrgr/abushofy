<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\User;

class AccountController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::user()->id);
        return view('pages.account', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'email' => 'email|unique:users', 
        ]); 
        $data = $request->all(); 

        if ($request->password) {
            $validated = $request->validate([ 
                'password' => 'confirmed|min:5',
            ]); 
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
            unset($data['password_confirmation']);
        }
        $user = User::findOrFail($id);
        $user->update($data);
        return redirect('/account')->with(['message' => 'Akun berhasil diupdate']);
    }

    public function updatePhoto(Request $request, $id)
    {
        $validated = $request->validate([
            'photo' => 'image',
        ]);
        $user = User::findOrFail($id);
        $user->update([
            'photo' => $request->photo->store('users', 'public')
        ]);
        return redirect('/account')->with(['message' => 'Photo berhasil diupdate']);
    }

    public function destroy($id) 
    {
        $user = User::findOrFail($id);
        $user->update(['photo' => 'users/user-default.jpg']);
        return redirect('/account')->with(['message' => 'Photo berhasil dihapus']);
    }
}
