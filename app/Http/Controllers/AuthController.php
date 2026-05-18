<?php

// Created by Arsya Nueva_099
// Updated by Lailatul Fitaliqoh_229

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman landing page
    public function showLandingPage()
    {
        return view('login.landing');
    }

    // Menampilkan halaman login
    public function showLoginPage()
    {
        return view('login.login');
    }

    // Proses login user
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    // Menampilkan halaman register
    public function showRegisterPage()
    {
        return view('login.register');
    }

    // Proses register user baru
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string|max:255|unique:user,username',
            'email' => 'required|email|max:255|unique:user,email',
            'password' => 'required|string|min:6',
            'phone_number' => 'nullable|numeric|digits_between:10,15',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'phone_number.numeric' => 'Nomor telepon harus berupa angka.',
            'phone_number.digits_between' => 'Nomor telepon harus 10-15 digit.',
        ]);

        // Simpan user baru ke database
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role' => 'buyer', // Default role sebagai buyer
            'profile_pic' => null,
            'id_address' => null,
        ]);

        // Redirect ke home page dengan pesan sukses
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login untuk melanjutkan.');
    }

    // Proses logout user
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('success', 'Anda telah berhasil logout.');
    }

    // FITUR SWITCH ACCOUNT
    public function switchAccount(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Ambil email target yang dikirim dari form JS
        $targetEmail = $request->input('email');

        // Redirect ke login membawa data email agar auto-fill
        return redirect()->route('login')->with('last_email', $targetEmail);
    }

    // Backward compatibility
    public function landing()
    {
        return $this->showLandingPage();
    }

    public function loginPage()
    {
        return $this->showLoginPage();
    }

    public function loginProcess(Request $request)
    {
        return $this->login($request);
    }

    public function registerPage()
    {
        return $this->showRegisterPage();
    }

    public function registerProcess(Request $request)
    {
        return $this->register($request);
    }
}
