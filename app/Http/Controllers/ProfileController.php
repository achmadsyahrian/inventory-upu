<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $auth = Auth::user();
        return view('auth.profile', compact('auth'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'photo' => 'nullable|image|max:2048',
            'name' => 'required',
            'username' => 'required|min:5',
            'email' => 'nullable|email',
            'phone' => ['nullable', 'regex:/^[0-9]+$/'],
            'password' => 'nullable|min:5',
        ]);

        $user = Auth::user();

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::delete('public/photos/user/' . $user->photo);
            }

            $photoPath = $request->file('photo')->store('public/photos/user');
            $fileName = basename($photoPath);
            
            $user->photo = $fileName;
        }

        // Update informasi pengguna
        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        $user->phone = $validatedData['phone'];

        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }
        $user->save();

        return redirect()->back()->with('success', 'Profile berhasil diperbarui');
    }


}
