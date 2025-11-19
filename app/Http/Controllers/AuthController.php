<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Landing Page
    public function landing()
    {
        return view('landing');
    }

    // Halaman Login
    public function loginPage()
    {
        return view('login');
    }

    // Proses Login
    public function loginProcess(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // Coba login
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // Halaman Register
    public function registerPage()
    {
        return view('register');
    }

    // Proses Register (DISESUAIKAN DENGAN DATABASE KAMU)
    public function registerProcess(Request $request)
    {
        $request->validate([
            'username'     => 'required|unique:user,username', // Cek unik di tabel 'user'
            'email'        => 'required|email|unique:user,email',
            'password'     => 'required|min:6',
            'phone_number' => 'nullable|numeric'
        ]);

        // Simpan ke Database sesuai nama kolom di SQL kamu
        $user = User::create([
            'username'     => $request->username,
            'email'        => $request->email,
            'password'     => Hash::make($request->password), // Enkripsi password
            'phone_number' => $request->phone_number,
            'profile_pic'  => null, // Default kosong dulu
            'id_address'   => null  // Default kosong dulu
        ]);

        // Langsung login setelah register
        Auth::login($user);

        return redirect()->route('home');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing');
    }
}
