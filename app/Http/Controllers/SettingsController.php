<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class SettingsController extends Controller
{
    public function editProfile()
    {
        return view('settings.edit_profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user(); // Ambil user yg sedang login
        // Karena $user adalah instance Authenticatable, kita pastikan dia model User
        $userModel = User::find($user->id_user);

        $request->validate([
            'username' => 'required|string|max:255',
            'phone_number' => 'required|numeric',
            'email' => 'required|email',
            'role' => 'required|in:buyer,seller',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Update Data Teks
        $userModel->username = $request->username;
        $userModel->phone_number = $request->phone_number;
        $userModel->email = $request->email;
        $userModel->role = $request->role;

        // Update Foto Profil jika ada yang diupload
        if ($request->hasFile('profile_pic')) {
            // Hapus foto lama jika ada (opsional)
            // if($userModel->profile_pic) Storage::delete($userModel->profile_pic);

            $path = $request->file('profile_pic')->store('public/images/profiles');
            // Ubah path agar bisa dibaca asset() (hapus 'public/')
            $userModel->profile_pic = str_replace('public/', 'storage/', $path);
        }

        $userModel->save();

        return redirect()->route('settings.profile')->with('success', 'Profile updated successfully!');
    }

    public function moreSettings() { return view('settings.more_settings'); }
    public function changePassword() { return view('settings.change_password'); }
}
