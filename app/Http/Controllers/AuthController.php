<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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

    //Proses login user
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // Coba login dengan kredensial yang diberikan
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Regenerate session untuk keamanan
            $request->session()->regenerate();

            // Redirect ke home page
            return redirect()->route('home');
        }

        // Jika login gagal, kembali ke halaman login dengan error
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
            'username'     => 'required|string|max:255|unique:user,username',
            'email'        => 'required|email|max:255|unique:user,email',
            'password'     => 'required|string|min:6',
            'phone_number' => 'nullable|numeric|digits_between:10,15'
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'phone_number.numeric' => 'Nomor telepon harus berupa angka.',
            'phone_number.digits_between' => 'Nomor telepon harus 10-15 digit.'
        ]);

        // Simpan user baru ke database
        $user = User::create([
            'username'     => $request->username,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role'         => 'buyer', // Default role sebagai buyer
            'profile_pic'  => null,
            'id_address'   => null
        ]);

        // Auto login setelah register berhasil
        Auth::login($user);

        // Redirect ke home page dengan pesan sukses
        return redirect()->route('home')->with('success', 'Akun berhasil dibuat! Selamat datang di MYstiCake.');
    }

    // Proses logout user
    public function logout(Request $request)
    {
        // Logout user
        Auth::logout();

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        // Redirect ke landing page
        return redirect()->route('landing')->with('success', 'Anda telah berhasil logout.');
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
