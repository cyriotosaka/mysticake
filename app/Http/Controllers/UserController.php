<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    // ==========================================
    // BAGIAN 1: MANAJEMEN PROFIL
    // ==========================================

    /**
     * Menampilkan Halaman Edit Profil
     * Mapping UML: showProfile()
     * Asal: SettingsController@editProfile
     */
    public function showProfile()
    {
        return view('settings.edit_profile', ['user' => Auth::user()]);
    }

    /**
     * Memproses Update Profil
     * Mapping UML: updateProfile(data: User)
     * Asal: SettingsController@updateProfile
     */
    public function updateProfile(Request $request)
    {
        $userAuth = Auth::user();

        // Pastikan ambil model berdasarkan Primary Key user kamu (id_user)
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
            // Hapus foto lama jika bukan default (Opsional, good practice)
            if($userModel->profile_pic && $userModel->profile_pic != 'default.jpg') {
                 // Storage::delete(...) logic here
            }

            $path = $request->file('profile_pic')->store('public/images/profiles');
            // Simpan path yang bisa diakses publik
            $userModel->profile_pic = str_replace('public/', 'storage/', $path);
        }

        $userModel->save();

        return redirect()->route('settings.profile')->with('success', 'Profile updated successfully!');
    }

    // ==========================================
    // BAGIAN 2: KEAMANAN (PASSWORD)
    // ==========================================

    /**
     * Menampilkan Form Ganti Password
     * Mapping UML: showChangePassword()
     * Asal: SettingsController@changePassword
     */
    public function showChangePassword()
    {
        return view('settings.change_password');
    }

    /**
     * Memproses Ganti Password (Tambahan agar sesuai UML)
     * Mapping UML: updatePassword(old: string, new: string)
     */
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

    /**
     * Menu Navigasi Tambahan
     * (Opsional di UML, tapi perlu di kodingan)
     */
    public function showMoreSettings()
    {
        return view('settings.more_settings');
    }

    // ==========================================
    // BAGIAN 3: MANAJEMEN ALAMAT (Merged)
    // ==========================================
    // Masukkan method addAddress, editAddress disini...

    public function showAddressList()
    {
        // Ambil alamat milik user yang sedang login
        $addresses = Address::where('id_user', Auth::id())->get();
        return view('settings.address_index', compact('addresses'));
    }

    /**
     * Menampilkan Form Tambah Alamat
     * Asal: AddressController@create
     */
    public function showAddAddressForm()
    {
        return view('settings.address_form', ['address' => null]);
    }

    /**
     * Proses Simpan Alamat Baru
     * Mapping UML: addAddress(data: Address)
     * Asal: AddressController@store
     */
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
        $address->map_point = '-6.200,106.816'; // Dummy point
        $address->save();

        // Redirect kembali ke list alamat
        return redirect()->route('settings.address.list')->with('success', 'Alamat berhasil ditambahkan');
    }

    /**
     * Menampilkan Form Edit Alamat
     * Asal: AddressController@edit
     */
    public function showEditAddressForm($id)
    {
        // Pastikan alamat itu milik user yang sedang login (Security Check)
        $address = Address::where('id_address', $id)
                          ->where('id_user', Auth::id())
                          ->firstOrFail();

        return view('settings.address_form', compact('address'));
    }

    /**
     * Proses Update Alamat
     * Mapping UML: editAddress(id: int, data: Address)
     * Asal: AddressController@update
     */
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

    /**
     * Proses Hapus Alamat (Tambahan agar sesuai UML removeAddress)
     * Mapping UML: removeAddress(id: int)
     */
    public function removeAddress($id)
    {
        $address = Address::where('id_address', $id)
                          ->where('id_user', Auth::id())
                          ->firstOrFail();

        $address->delete();

        return redirect()->route('settings.address.list')->with('success', 'Alamat berhasil dihapus');
    }
}
