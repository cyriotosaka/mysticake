<?php
// Created by Lailatul Fitaliqoh (5026231229)

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class SettingsController extends Controller
{
    // Menampilkan halaman Edit Profil
    public function editprofile()
    {
        $user = Auth::user();
        return view('settings.profile', compact('user'));
    }

    // Proses Update Profil
    public function updateProfile(Request $request)
    {
        $userAuth = Auth::user();
        $userModel = User::findOrFail($userAuth->id_user);

        // Validasi
        $request->validate([
            'username'     => 'required|string|max:255',
            'phone_number' => 'required|numeric',
            // Validasi email unique kecuali untuk user ini sendiri
            'email'        => 'required|email|unique:user,email,'.$userModel->id_user.',id_user',
            'role'         => 'required|in:buyer,seller',
            'profile_picture'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Update Data Teks
        $userModel->username     = $request->username;
        $userModel->phone_number = $request->phone_number;
        $userModel->email        = $request->email;
        $userModel->role         = $request->role;

        // Update Foto Profil
        if ($request->hasFile('profile_picture')) {
            
            // Simpan file baru
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/profiles'), $filename);
            
            // Simpan path ke database
            $userModel->profile_picture = 'images/profiles/' . $filename; 
        }

        $userModel->save();

        return redirect()->route('settings.profile')->with('success', 'Profile updated successfully!');
    }

    // Menampilkan halaman More Settings
    public function moreSettings()
    {
        return view('settings.more');
    }

    public function changepassword()
    {
        return view('settings.password'); 
    }

    public function updatePassword(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'current_password' => 'required|current_password', 
            'new_password'     => 'required|string|min:6|confirmed|different:current_password',
        ], [
            'current_password.current_password' => 'Password saat ini salah.',
            'new_password.min'       => 'Password baru minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
            'new_password.different' => 'Password baru tidak boleh sama dengan password lama.'
        ]);

        // 2. Update Password User
        $user = Auth::user();
        $userModel = User::find($user->id_user);
        $userModel->password = Hash::make($request->new_password);
        $userModel->save();

        return back()->with('success', 'Password berhasil diperbarui!');
    }

    public function loginHistory(Request $request)
    {
        // 1. Deteksi User Agent (Device & Browser)
        $userAgent = $request->header('User-Agent');
        
        $device = 'Unknown Device';
        if (strpos($userAgent, 'iPhone') !== false) $device = 'iPhone';
        elseif (strpos($userAgent, 'Android') !== false) $device = 'Android Phone';
        elseif (strpos($userAgent, 'Windows') !== false) $device = 'Windows PC';
        elseif (strpos($userAgent, 'Macintosh') !== false) $device = 'Macbook / iMac';

        $browser = 'Unknown Browser';
        if (strpos($userAgent, 'Chrome') !== false) $browser = 'Chrome';
        elseif (strpos($userAgent, 'Safari') !== false) $browser = 'Safari';
        elseif (strpos($userAgent, 'Firefox') !== false) $browser = 'Firefox';

        // 2. DETEKSI LOKASI ASLI MENGGUNAKAN API EKSTERNAL
        try {
            // Mengambil data JSON dari API publik
            $response = Http::get('http://ip-api.com/json/');
            $data = $response->json();

            if ($data['status'] == 'success') {
                // Jika berhasil, ambil Kota dan Negara
                $location = $data['city'] . ', ' . $data['country'];
                $ipAddress = $data['query']; // IP Public asli 
            } else {
                // Jika gagal, fallback
                $location = 'Unknown Location';
                $ipAddress = $request->ip();
            }
        } catch (\Exception $e) {
            // Jika tidak ada internet
            $location = 'Connection Failed';
            $ipAddress = $request->ip();
        }

        // 3. Bungkus data
        $agentInfo = [
            'device'  => $device,
            'browser' => $browser,
            'ip'      => $location, // Ganti IP dengan Nama Lokasi biar user friendly
            'real_ip' => $ipAddress // Simpan IP asli jika butuh debug
        ];

        return view('settings.history', compact('agentInfo'));
    }

    // Hapus Akun
    public function deleteAccount(Request $request)
    {
        // 1. Ambil user yang sedang login
        $user = Auth::user();

        // 2. Hapus User dari Database
        $userModel = User::find($user->id_user);
        
        if ($userModel) {
            $userModel->delete();
        }

        // 3. Logout & Invalidate Session
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 4. Redirect ke Landing Page
        return redirect()->route('landing')->with('success', 'Your account has been deleted. We are sorry to see you go.');
    }
}