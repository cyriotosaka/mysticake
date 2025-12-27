<?php
//Created by Arsya Nueva_099
//Updated by Okky Priscila_168 - Menambahkan method fitur drop rate gacha (normal & premium)
//Updated - Drop rate sekarang dinamis berdasarkan stock produk

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\History;
use App\Models\MysteryBoxProduct;
use App\Models\MysteryBox;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\MysteryBoxHistory;

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
            'mode' => $mode ?? 'normal'
        ]);
    }

    /**
     * Calculate drop rate berdasarkan stock
     *
     * Logic: Drop rate = (stock produk / total stock semua produk dalam range) * 100%
     * Semakin banyak stock, semakin besar kemungkinan user mendapatkan produk tersebut
     *
     * @param Collection $products - Collection of products
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
                $product->drop_rate = number_format($equalRate, 2) . '%';
                return $product;
            });
        }

        // Hitung drop rate untuk setiap produk berdasarkan stock
        return $products->map(function ($product) use ($totalStock) {
            $dropRate = ($product->stock / $totalStock) * 100;
            $product->drop_rate = number_format($dropRate, 2) . '%';
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
        // Ambil produk untuk Normal Mystery Box (harga < 50000)
        $products = Product::whereBetween('price', [self::NORMAL_MIN_PRICE, self::NORMAL_MAX_PRICE])
            ->where('stock', '>', 0) // Hanya produk yang ada stock
            ->select('id_product', 'name_product', 'stock', 'price')
            ->orderBy('stock', 'desc') // Urutkan dari stock terbanyak
            ->get();

        // Hitung drop rate berdasarkan stock
        $rewards = $this->calculateDropRates($products);

        // Transform ke format yang dibutuhkan view
        $rewards = $rewards->map(function ($product) {
            return [
                'name' => $product->name_product,
                'rate' => $product->drop_rate,
                'stock' => $product->stock
            ];
        });

        // Jika tidak ada produk, tampilkan pesan
        if ($rewards->isEmpty()) {
            $rewards = collect([
                ['name' => 'No products available', 'rate' => '0.00%', 'stock' => 0]
            ]);
        }

        return view('gacha.normalDropRate', compact('rewards'));
    }

    /**
     * Show Premium Drop Rate Page
     * Dipanggil ketika user klik icon drop rate dari halaman gacha premium
     *
     * Premium gacha: produk dengan harga Rp 50.000 - Rp 1.000.000
     * Drop rate dihitung berdasarkan stock masing-masing produk
     */
    public function showPremiumDropRatePage()
    {
        // Ambil produk untuk Premium Mystery Box (harga >= 50000)
        $products = Product::whereBetween('price', [self::PREMIUM_MIN_PRICE, self::PREMIUM_MAX_PRICE])
            ->where('stock', '>', 0) // Hanya produk yang ada stock
            ->select('id_product', 'name_product', 'stock', 'price')
            ->orderBy('stock', 'desc') // Urutkan dari stock terbanyak
            ->get();

        // Hitung drop rate berdasarkan stock
        $rewards = $this->calculateDropRates($products);

        // Transform ke format yang dibutuhkan view
        $rewards = $rewards->map(function ($product) {
            return [
                'name' => $product->name_product,
                'rate' => $product->drop_rate,
                'stock' => $product->stock
            ];
        });

        // Jika tidak ada produk, tampilkan pesan
        if ($rewards->isEmpty()) {
            $rewards = collect([
                ['name' => 'No products available', 'rate' => '0.00%', 'stock' => 0]
            ]);
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
                    'price' => $product->price
                ];
            })
        ]);
    }

    public function rollGacha(Request $request)
    {
        $user = Auth::user()->load('wallet');
        $type = $request->input('type'); // 'normal', 'premium', atau 'bonus'

        // 1. SETTING VARIABEL
        $boxId = 1;     // Default box (misal bonus pakai barang normal)
        $gachaCost = 0;
        $isBonus = false;

        // 2. VALIDASI TIPE & HARGA
        if ($type === 'bonus') {
            $isBonus = true;
            if ($user->wallet->point_gacha < 100) {
                return back()->with('error', 'Poin belum cukup (Butuh 100 Poin)!');
            }
            $boxId = 1; // Bonus ambil hadiah dari pool Normal Box
            $gachaCost = 0;
        }
        elseif ($type === 'normal') {
            $boxId = 1;
            $gachaCost = 15000;
        }
        elseif ($type === 'premium') {
            $boxId = 2; // Pastikan Box ID 2 ada di database!
            $gachaCost = 25000;
        }
        else {
            return back()->with('error', 'Tipe gacha tidak valid.');
        }

        // 3. CEK SALDO (Hanya jika bukan bonus)
        if (!$isBonus && $user->wallet->saldo_coin < $gachaCost) {
            return back()->with('error', 'Koin tidak cukup! Silakan top up.');
        }

        try {
            DB::beginTransaction();

            // ---------------------------------------------------
            // STEP A: LOGIC RNG (Acak Barang)
            // ---------------------------------------------------
            $candidates = MysteryBoxProduct::where('id_mystery_box', $boxId)
                            ->with('product')
                            ->get();

            if ($candidates->isEmpty()) {
                throw new \Exception("Box ID $boxId kosong, admin belum setting hadiah!");
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
            if (!$wonItem) $wonItem = $candidates->random();
            $wonProduct = $wonItem->product;

            // ---------------------------------------------------
            // STEP B: TRANSAKSI (SALDO, POIN & CART)
            // ---------------------------------------------------

            // 1. Potong Saldo / Poin
            if ($isBonus) {
                $user->wallet->point_gacha -= 100; // Potong Poin
            } else {
                $user->wallet->saldo_coin -= $gachaCost; // Potong Koin
                $user->wallet->point_gacha += 10;        // Tambah Poin
                // Opsional: Batasi poin max 100
                // if($user->wallet->point_gacha > 100) $user->wallet->point_gacha = 100;
            }
            $user->wallet->save();


            // 2. MASUKKAN KE CART (Logic Baru)
            // Cek cart user
            $cart = Cart::firstOrCreate(
                ['id_user' => $user->id_user],
                ['created_at' => now()]
            );

            // Masukkan item dengan harga 0 (Gratis)
            CartItem::create([
                'id_cart'    => $cart->id_cart,
                'id_product' => $wonProduct->id_product,
                'quantity'   => 1,
                'price'      => 0, // Harga 0 karena hadiah
            ]);

            DB::commit();

            MysteryBoxHistory::create([
                'id_user'    => $user->id_user,
                'id_product' => $wonProduct->id_product,
                // created_at otomatis terisi
            ]);

            DB::commit();

            return redirect()->route('gacha.result')->with([
                'gacha_result' => $wonProduct,
                'gacha_mode' => $type
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
    public function showResultPage()
    {
        // Cek apakah ada data hasil gacha di session
        if (!session()->has('gacha_result')) {
            // Kalau user refresh atau akses langsung, kembalikan ke halaman depan
            return redirect()->route('gacha.index'); // Sesuaikan dengan nama route halaman utama gacha kamu
        }

        $result = session('gacha_result');
        $mode = session('gacha_mode', 'normal');

        return view('gacha.result', compact('result', 'mode'));
    }
}
