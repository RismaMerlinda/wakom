<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function loginWeb(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('username', 'password'))) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/transaksi');
            } elseif (Auth::user()->role === 'pelanggan') {
                return redirect()->intended('/pesan');
            } elseif (Auth::user()->role === 'waiter') {
                return redirect()->intended('/waiter/orders');
            } elseif (Auth::user()->role === 'kasir') {
                return redirect()->intended('/kasir/orders');
            }

            return redirect()->intended('/login');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function registerWeb(Request $request)
    {
        $request->validate([
            'nama_user' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:tb_user,username',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'nama_user' => $request->nama_user,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'pelanggan',
        ]);

        return redirect()->route('login')->with('success', 'Berhasil mendaftar! Silakan login.');
    }

    public function logoutWeb(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
