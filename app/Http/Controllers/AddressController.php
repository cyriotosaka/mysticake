<?php
/* Created by Lailatul Fitaliqoh (5026231229) */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;

class AddressController extends Controller
{
    /**
     * Menampilkan daftar alamat (Halaman Index)
     * Route: GET /settings/address
     */
    public function index()
    {
        $user = Auth::user();
        $addresses = Address::where('id_user', $user->id_user)->get();
        
        // Cek apakah user masih bisa nambah alamat (max 3)
        $canAddMore = $addresses->count() < 3; 
        return view('settings.address_index', compact('addresses', 'canAddMore'));
    }

    /**
     * Menampilkan form tambah alamat
     * Route: GET /settings/address/create
     */
    public function create()
    {
        return view('settings.address_form'); 
    }

    /**
     * Proses simpan alamat baru ke database
     * Route: POST /settings/address
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'full_address' => 'required|string',
            'map_point' => 'nullable|string',
            'address_contact_number' => 'required|string' // Sesuaikan name di form blade
        ]);

        // Validasi max 3 alamat (Security tambahan di backend)
        if (Address::where('id_user', $user->id_user)->count() >= 3) {
            return redirect()->route('address.index')->with('error', 'Maksimal 3 alamat.');
        }

        // Simpan ke database
        Address::create([
            'id_user' => $user->id_user,
            'full_address' => $request->full_address,
            'map_point' => $request->map_point,
            'address_contact_number' => $request->address_contact_number
        ]);

        return redirect()->route('address.index')->with('success', 'Alamat berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit alamat
     * Route: GET /settings/address/{id}/edit
     */
    public function edit($id)
    {
        // Cari alamat berdasarkan ID dan pastikan milik user yang login
        $address = Address::where('id_address', $id)
                          ->where('id_user', Auth::id())
                          ->firstOrFail();
                          
        return view('settings.address_form', compact('address'));
    }

    /**
     * Proses update alamat yang sudah ada
     * Route: PUT /settings/address/{id}
     */
    public function update(Request $request, $id)
    {
        $address = Address::where('id_address', $id)
                          ->where('id_user', Auth::id())
                          ->firstOrFail();

        $request->validate([
            'full_address' => 'required|string',
            'address_contact_number' => 'required|string'
        ]);
        
        $address->update($request->only(['full_address', 'map_point', 'address_contact_number']));

        return redirect()->route('address.index')->with('success', 'Alamat berhasil diperbarui.');
    }

    /**
     * Hapus alamat
     * Route: DELETE /settings/address/{id}
     */
    public function destroy($id)
    {
        $address = Address::where('id_address', $id)
                          ->where('id_user', Auth::id())
                          ->firstOrFail();
        
        $address->delete();

        return redirect()->route('address.index')->with('success', 'Alamat berhasil dihapus.');
    }
}