<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('auth.login', compact('roles'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
            'role_id' => ['required'],
        ]);
        
        if (Auth::attempt($credentials)) { return redirect()->intended('/'); }     

        return back()->with('error', 'Akun tidak ditemukan');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda berhasil logout');
    }
}
