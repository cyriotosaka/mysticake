<?php
/* created by Arsya Nueva D (5026231099) */
/* Updated by Lailatul Fitaliqoh (5026231229) */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    // MANAJEMEN PROFIL
    public function showProfile()
    {
        return view('settings.edit_profile', ['user' => Auth::user()]);
    }

    // Memproses Update Profil
    public function updateProfile(Request $request)
    {
        $userAuth = Auth::user();

        // Memastikan mengambil model berdasarkan Primary Key user (id_user)
        $userModel = User::findOrFail($userAuth->id_user);

        $request->validate([
            'username'     => 'required|string|max:255',
            'phone_number' => 'required|numeric',
            'email'        => 'required|email|unique:users,email,'.$userModel->id_user.',id_user', // Validasi unique kecuali punya sendiri
            'role'         => 'required|in:buyer,seller',
            'profile_pic'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Update Data Teks
        $userModel->username     = $request->username;
        $userModel->phone_number = $request->phone_number;
        $userModel->email        = $request->email;
        $userModel->role         = $request->role;

        // Update Foto Profil
        if ($request->hasFile('profile_pic')) {
            if($userModel->profile_pic && $userModel->profile_pic != 'default.jpg') {
            }

            $path = $request->file('profile_pic')->store('public/images/profiles');
            // Simpan path yang bisa diakses publik
            $userModel->profile_pic = str_replace('public/', 'storage/', $path);
        }

        $userModel->save();

        return redirect()->route('settings.profile')->with('success', 'Profile updated successfully!');
    }

    // KEAMANAN (PASSWORD)
    public function showChangePassword()
    {
        return view('settings.change_password');
    }

    // Memproses Ganti Password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = User::find(Auth::id());

        // Cek password lama
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama salah!']);
        }

        // Simpan password baru
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah!');
    }

    public function showMoreSettings()
    {
        return view('settings.more_settings');
    }

   // MANAJEMEN ALAMAT
    public function showAddressList()
    {
        // Ambil alamat milik user yang sedang login
        $addresses = Address::where('id_user', Auth::id())->get();
        return view('settings.address_index', compact('addresses'));
    }

    public function showAddAddressForm()
    {
        return view('settings.address_form', ['address' => null]);
    }

    public function addAddress(Request $request)
    {
        $request->validate([
            'full_address' => 'required',
            'address_contact' => 'required|numeric'
        ]);

        $address = new Address();
        $address->id_user = Auth::id();
        $address->full_address = $request->full_address;
        $address->address_contact = $request->address_contact;
        $address->map_point = '-6.200,106.816';
        $address->save();

        // Redirect kembali ke list alamat
        return redirect()->route('settings.address.list')->with('success', 'Alamat berhasil ditambahkan');
    }

   // Menampilkan Form Edit Alamat
    public function showEditAddressForm($id)
    {
        // Memastikan alamat itu milik user yang sedang login
        $address = Address::where('id_address', $id)
                          ->where('id_user', Auth::id())
                          ->firstOrFail();

        return view('settings.address_form', compact('address'));
    }

    public function editAddress(Request $request, $id)
    {
        $address = Address::where('id_address', $id)
                          ->where('id_user', Auth::id())
                          ->firstOrFail();

        $request->validate([
            'full_address' => 'required',
            'address_contact' => 'required|numeric'
        ]);

        $address->update([
            'full_address' => $request->full_address,
            'address_contact' => $request->address_contact
        ]);

        return redirect()->route('settings.address.list')->with('success', 'Alamat berhasil diubah');
    }

    // Proses Hapus Alamat
    public function removeAddress($id)
    {
        $address = Address::where('id_address', $id)
                          ->where('id_user', Auth::id())
                          ->firstOrFail();

        $address->delete();

        return redirect()->route('settings.address.list')->with('success', 'Alamat berhasil dihapus');
    }
}
