<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login'); // Sesuaikan dengan lokasi file blade kamu
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $login = $request->input('email');
        $password = $request->input('password');

        // Cek apakah input berupa email
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => $login, 'password' => $password];
        } else {
            $credentials = ['nik' => $login, 'password' => $password];
        }

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard')->with('success', 'Selamat datang, Admin!');
            } else {
                return redirect()->intended('/users/dashboard')->with('success', 'Berhasil login!');
            }
        }

        // Kalau gagal login
        return back()->with('error', 'Email/NIK atau password salah!')->withInput();
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Berhasil logout.');
    }
}
