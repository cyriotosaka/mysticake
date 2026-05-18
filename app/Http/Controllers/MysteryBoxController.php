<?php

// Created by Arsya Nueva_099
// Updated by Okky Priscila_168 - Menambahkan method fitur drop rate gacha (normal & premium)
// Updated - Drop rate sekarang dinamis berdasarkan stock produk

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\History;
use App\Models\MysteryBoxHistory;
use App\Models\MysteryBoxProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MysteryBoxController extends Controller
{
    /**
     * Price range untuk Normal dan Premium gacha
     */
    private const NORMAL_MIN_PRICE = 0;

    private const NORMAL_MAX_PRICE = 49999;

    private const PREMIUM_MIN_PRICE = 50000;

    private const PREMIUM_MAX_PRICE = 1000000;

    public function showGachaPage(Request $request)
    {
        $user = Auth::user()->load('wallet');
        $mode = $request->query('mode', 'normal');

        return view('gacha.gacha', compact('user', 'mode'));
    }

    public function showGachaHistory(Request $request)
    {
        $mode = $request->query('mode', 'normal');

        $histories = MysteryBoxHistory::where('id_user', Auth::id())
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('gacha.history', [
            'histories' => $histories,
            'mode' => $mode ?? 'normal',
        ]);
    }

    /**
     * Calculate drop rate berdasarkan stock
     *
     * Logic: Drop rate = (stock produk / total stock semua produk dalam range) * 100%
     * Semakin banyak stock, semakin besar kemungkinan user mendapatkan produk tersebut
     *
     * @param  Collection  $products  - Collection of products
     * @return Collection - Products with calculated drop_rate
     */
    private function calculateDropRates($products)
    {
        // Hitung total stock dari semua produk dalam range
        $totalStock = $products->sum('stock');

        // Jika total stock 0, beri rate yang sama untuk semua
        if ($totalStock == 0) {
            $equalRate = count($products) > 0 ? (100 / count($products)) : 0;

            return $products->map(function ($product) use ($equalRate) {
                $product->drop_rate = number_format($equalRate, 2).'%';

                return $product;
            });
        }

        // Hitung drop rate untuk setiap produk berdasarkan stock
        return $products->map(function ($product) use ($totalStock) {
            $dropRate = ($product->stock / $totalStock) * 100;
            $product->drop_rate = number_format($dropRate, 2).'%';

            return $product;
        });
    }

    /**
     * Show Normal Drop Rate Page
     * Dipanggil ketika user klik icon drop rate dari halaman gacha normal
     *
     * Normal gacha: produk dengan harga Rp 0 - Rp 49.999
     * Drop rate dihitung berdasarkan stock masing-masing produk
     */
    public function showNormalDropRatePage()
    {
        // 1. Join tabel mystery_box_product dengan product
        $items = DB::table('mystery_box_product')
            ->join('product', 'mystery_box_product.id_product', '=', 'product.id_product')
            ->where('mystery_box_product.id_mystery_box', 1) // ID 1 = Normal Box
            ->select('product.name_product', 'product.stock')
            ->get();

        // 2. Hitung Total Stock untuk persentase
        $totalStock = $items->sum('stock');
        $rewards = [];

        // 3. Loop data untuk hitung %
        foreach ($items as $item) {
            $rate = $totalStock > 0 ? ($item->stock / $totalStock) * 100 : 0;
            $rewards[] = [
                'name' => $item->name_product,
                'rate' => number_format($rate, 1).'%',
                'stock' => $item->stock,
            ];
        }

        // 4. Return ke View Blade (Bukan JSON)
        return view('gacha.normalDropRate', compact('rewards'));
    }

    /**
     * Show Premium Drop Rate Page
     * Mengambil data REAL dari tabel mystery_box_product (Box ID 2)
     */
    public function showPremiumDropRatePage()
    {
        // 1. Join tabel mystery_box_product dengan product
        $items = DB::table('mystery_box_product')
            ->join('product', 'mystery_box_product.id_product', '=', 'product.id_product')
            ->where('mystery_box_product.id_mystery_box', 2) // ID 2 = Premium Box
            ->select('product.name_product', 'product.stock')
            ->get();

        $totalStock = $items->sum('stock');
        $rewards = [];

        foreach ($items as $item) {
            $rate = $totalStock > 0 ? ($item->stock / $totalStock) * 100 : 0;
            $rewards[] = [
                'name' => $item->name_product,
                'rate' => number_format($rate, 1).'%',
                'stock' => $item->stock,
            ];
        }

        return view('gacha.premiumDropRate', compact('rewards'));
    }

    /**
     * Get Drop Rates API (Optional - untuk AJAX)
     * Mengembalikan drop rates dalam format JSON
     */
    public function getDropRates(Request $request)
    {
        $type = $request->query('type', 'normal');

        if ($type === 'premium') {
            $minPrice = self::PREMIUM_MIN_PRICE;
            $maxPrice = self::PREMIUM_MAX_PRICE;
        } else {
            $minPrice = self::NORMAL_MIN_PRICE;
            $maxPrice = self::NORMAL_MAX_PRICE;
        }

        $products = Product::whereBetween('price', [$minPrice, $maxPrice])
            ->where('stock', '>', 0)
            ->select('id_product', 'name_product', 'stock', 'price')
            ->orderBy('stock', 'desc')
            ->get();

        $rewards = $this->calculateDropRates($products);

        return response()->json([
            'type' => $type,
            'total_products' => $rewards->count(),
            'total_stock' => $products->sum('stock'),
            'rewards' => $rewards->map(function ($product) {
                return [
                    'name' => $product->name_product,
                    'rate' => $product->drop_rate,
                    'stock' => $product->stock,
                    'price' => $product->price,
                ];
            }),
        ]);
    }

    public function rollGacha(Request $request)
    {
        $user = Auth::user()->load('wallet');
        $type = $request->input('type');

        $boxId = 1;
        $gachaCost = 0;
        $isBonus = false;

        if ($type === 'bonus') {
            $isBonus = true;
            if ($user->wallet->point_gacha < 100) {
                return back()->with('error', 'Poin belum cukup (Butuh 100 Poin)!');
            }
            $boxId = 1;
            $gachaCost = 0;
        } elseif ($type === 'normal') {
            $boxId = 1;
            $gachaCost = 15000;
        } elseif ($type === 'premium') {
            $boxId = 2;
            $gachaCost = 25000;
        } else {
            return back()->with('error', 'Tipe gacha tidak valid.');
        }

        if (! $isBonus && $user->wallet->saldo_coin < $gachaCost) {
            return back()->with('error', 'Koin tidak cukup! Silakan top up.');
        }

        try {
            DB::beginTransaction();

            // STEP A: RNG Logic
            $candidates = MysteryBoxProduct::where('id_mystery_box', $boxId)
                ->with('product')
                ->get();

            if ($candidates->isEmpty()) {
                throw new \Exception("Box ID $boxId kosong!");
            }

            $totalWeight = $candidates->sum('drop_rate');
            $random = mt_rand(0, 10000) / 10000 * $totalWeight;

            $wonItem = null;
            $currentWeight = 0;
            foreach ($candidates as $item) {
                $currentWeight += $item->drop_rate;
                if ($random <= $currentWeight) {
                    $wonItem = $item;
                    break;
                }
            }
            if (! $wonItem) {
                $wonItem = $candidates->random();
            }
            $wonProduct = $wonItem->product;

            // STEP B: TRANSAKSI
            if ($isBonus) {
                $user->wallet->point_gacha -= 100;
            } else {
                $user->wallet->saldo_coin -= $gachaCost;
                $user->wallet->point_gacha += 10;
            }
            $user->wallet->save();

            // 1. Create or Find Cart
            $cart = Cart::firstOrCreate(['id_user' => $user->id_user]);

            // 2. Add to Cart (WITHOUT 'price' column to avoid SQL error)
            $newItem = CartItem::create([
                'id_cart' => $cart->id_cart,
                'id_product' => $wonProduct->id_product,
                'quantity' => 1,
            ]);

            // 3. Mark as FREE in Session Registry
            $gachaIds = session('gacha_item_ids', []);
            $gachaIds[] = $newItem->id_cart_item;
            session(['gacha_item_ids' => $gachaIds]);

            // 4. Save History
            MysteryBoxHistory::create([
                'id_user' => $user->id_user,
                'id_product' => $wonProduct->id_product,
            ]);

            DB::commit();

            return redirect()->route('gacha.result')->with([
                'gacha_result' => $wonProduct,
                'gacha_mode' => $type,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan sistem: '.$e->getMessage());
        }
    }

    public function showResultPage()
    {
        // Cek apakah ada data hasil gacha di session
        if (! session()->has('gacha_result')) {
            // Kalau user refresh atau akses langsung, kembalikan ke halaman depan
            return redirect()->route('gacha.index'); // Sesuaikan dengan nama route halaman utama gacha kamu
        }

        $result = session('gacha_result');
        $mode = session('gacha_mode', 'normal');

        return view('gacha.result', compact('result', 'mode'));
    }
}
