<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MysteryBoxController extends Controller
{
    public function showGachaPage()
    {
        $user = Auth::user();
        return view('gacha.index', compact('user'));
    }

    public function showGachaHistory()
    {
        return view('gacha.history');
    }

    public function getDropRates()
    {
        $rates = [
            'Normal Box' => [
                'Common' => '60%',
                'Rare' => '30%',
                'Epic' => '10%'
            ],
            'Premium Box' => [
                'Rare' => '50%',
                'Epic' => '40%',
                'Legendary' => '10%'
            ]
        ];

        return view('gacha.droprate', compact('rates'));
    }

    public function rollGacha(Request $request)
    {
        $user = Auth::user();
        $type = $request->input('type');

        $gachaCost = 0;
        $minProductPrice = 0;
        $maxProductPrice = 0;

        if ($type === 'premium') {
            $gachaCost = 25000;
            // Premium: Dapat produk harga 50rb ke atas (Item Mahal)
            $minProductPrice = 50000;
            $maxProductPrice = 1000000;
        } else {
            // Normal: Dapat produk harga 10rb - 50rb (Item Biasa)
            $gachaCost = 15000;
            $minProductPrice = 0;
            $maxProductPrice = 49999;
        }

        // Cek apakah user punya cukup koin
        if ($user->balance < $gachaCost) {
            return response()->json([
                'status' => 'error',
                'message' => 'Koin tidak cukup! Top up dulu yuk.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // A. Kurangi Koin User
            $user->balance -= $gachaCost;
            $user->save();

            // B. Ambil Random Product sesuai Kriteria
            $wonProduct = Product::whereBetween('price', [$minProductPrice, $maxProductPrice])
                                ->inRandomOrder() // Fitur Ajaib Laravel untuk Random
                                ->first();

            // Jaga-jaga jika stok produk di range harga tersebut kosong
            if (!$wonProduct) {
                // Fallback: Ambil barang random apa saja
                $wonProduct = Product::inRandomOrder()->first();
            }

            // C. Simpan ke History Gacha (Opsional / Sesuai Diagram)
            // GachaHistory::create([
            //     'id_user' => $user->id_user,
            //     'id_product' => $wonProduct->id_product,
            //     'gacha_type' => $type,
            //     'date' => now()
            // ]);

            DB::commit(); // Simpan perubahan

            // 4. Return Data Produk ke Frontend
            return response()->json([
                'status' => 'success',
                'item_name' => $wonProduct->name_product,
                // Pastikan kolom gambar di DB namanya product_picture
                'item_image' => $wonProduct->product_picture,
                'item_price' => $wonProduct->price,
                'remaining_coin' => $user->balance
            ]);

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan jika error
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem.'
            ], 500);
        }

    }
}
