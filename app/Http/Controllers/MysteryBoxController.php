<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\History;

class MysteryBoxController extends Controller
{
    public function showGachaPage(Request $request)
    {
        $user = Auth::user()->load('wallet');
        $mode = $request->query('mode', 'normal');

        return view('gacha.gacha', compact('user', 'mode'));
    }

    public function showGachaHistory(Request $request)
    {
        $mode = $request->query('mode', 'normal');
        $histories = History::with('orders.product')
            ->whereHas('orders', function ($q) {
                $q->where('id_user', Auth::id());
            })
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->limit(10)
            ->get();

        return view('gacha.history', [
            'histories' => $histories,
            'mode' => $mode ?? 'normal'
        ]);
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
        $user = Auth::user()->load('wallet');
        $type = $request->input('type');

        // ===============================
        // 1. VALIDASI MODE
        // ===============================
        if (!in_array($type, ['normal', 'premium'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tipe gacha tidak valid.'
            ], 400);
        }

        // ===============================
        // 2. SETTING BIAYA & RANGE PRODUK
        // ===============================
        if ($type === 'premium') {
            $gachaCost = 25000;
            $minPrice  = 50000;
            $maxPrice  = 1000000;
        } else {
            $gachaCost = 15000;
            $minPrice  = 0;
            $maxPrice  = 49999;
        }

        // ===============================
        // 3. CEK SALDO COIN
        // ===============================
        if ($user->wallet->saldo_coin < $gachaCost) {
            return response()->json([
                'status' => 'error',
                'message' => 'Koin tidak cukup! Silakan top up terlebih dahulu.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // ===============================
            // 4. KURANGI COIN USER
            // ===============================
            $user->wallet->saldo_coin -= $gachaCost;
            $user->wallet->save();

            // ===============================
            // 5. RANDOM PRODUK DARI DATABASE
            // ===============================
            $wonProduct = Product::whereBetween('price', [$minPrice, $maxPrice])
                                ->inRandomOrder()
                                ->first();

            // Fallback kalau range kosong
            if (!$wonProduct) {
                $wonProduct = Product::inRandomOrder()->first();
            }

            DB::commit();

            // ===============================
            // 6. RESPONSE KE FRONTEND
            // ===============================
            return response()->json([
                'status'         => 'success',
                'item_name'      => $wonProduct->name_product,
                'item_image'     => $wonProduct->product_picture,
                'item_price'     => $wonProduct->price,
                'remaining_coin' => $user->wallet->saldo_coin
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem.'
            ], 500);
        }
    }
}
