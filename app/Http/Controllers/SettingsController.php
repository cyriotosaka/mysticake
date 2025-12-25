<?php
// Muhammad Fikri Khalilullah/5026231198
// Updated by Lailatul Fitaliqoh (5026231229)

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
}