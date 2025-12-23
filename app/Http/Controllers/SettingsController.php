<?php
//Muhammad Fikri Khalilullah/5026231198

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    // Matches "Laman Profil" / "Edit Profile"
    public function editprofile()
    {
        $user = Auth::user();
        return view('settings.profile', compact('user'));
    }

    // Matches "More Setting"
    public function moreSettings()
    {
        return view('settings.more');
    }

    // Matches "Change Password"
    public function changepassword()
    {
        return view('settings.password');
    }

    // Matches "Login History"
    public function loginHistory()
    {
        return view('settings.login-history');
    }

    // Matches "Change Language"
    public function changeLanguage()
    {
        return view('settings.language');
    }
}