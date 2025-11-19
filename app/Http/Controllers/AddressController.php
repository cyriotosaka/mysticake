<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;

class AddressController extends Controller
{
    public function index()
    {
        // Ambil alamat milik user yang sedang login
        $addresses = Address::where('id_user', Auth::id())->get();
        return view('settings.address_index', compact('addresses'));
    }

    public function create()
    {
        return view('settings.address_form', ['address' => null]); // Form kosong untuk create
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_address' => 'required',
            'address_contact' => 'required|numeric'
        ]);

        $address = new Address();
        $address->id_user = Auth::id();
        $address->full_address = $request->full_address;
        $address->address_contact = $request->address_contact;
        $address->map_point = '-6.200,106.816'; // Dummy dulu atau bisa tambah input map
        $address->save();

        return redirect()->route('address.index');
    }

    public function edit($id)
    {
        $address = Address::where('id_address', $id)->where('id_user', Auth::id())->firstOrFail();
        return view('settings.address_form', compact('address'));
    }

    public function update(Request $request, $id)
    {
        $address = Address::where('id_address', $id)->where('id_user', Auth::id())->firstOrFail();

        $address->update([
            'full_address' => $request->full_address,
            'address_contact' => $request->address_contact
        ]);

        return redirect()->route('address.index');
    }
}
