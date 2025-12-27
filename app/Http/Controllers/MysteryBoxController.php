<?php
//Updated by Okky Priscila_168 - Menambahkan method fitur drop rate gacha (normal & premium)
//Updated - Drop rate sekarang dinamis berdasarkan stock produk

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\History;

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
            $minPrice  = self::PREMIUM_MIN_PRICE;
            $maxPrice  = self::PREMIUM_MAX_PRICE;
        } else {
            $gachaCost = 15000;
            $minPrice  = self::NORMAL_MIN_PRICE;
            $maxPrice  = self::NORMAL_MAX_PRICE;
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
            // 5. WEIGHTED RANDOM BERDASARKAN STOCK
            // ===============================
            $products = Product::whereBetween('price', [$minPrice, $maxPrice])
                              ->where('stock', '>', 0)
                              ->get();

            if ($products->isEmpty()) {
                // Fallback jika tidak ada produk dalam range
                $wonProduct = Product::where('stock', '>', 0)->inRandomOrder()->first();
            } else {
                // Weighted random berdasarkan stock
                $wonProduct = $this->weightedRandomSelect($products);
            }

            // Fallback terakhir
            if (!$wonProduct) {
                $wonProduct = Product::inRandomOrder()->first();
            }

            // ===============================
            // 6. KURANGI STOCK PRODUK (Optional)
            // ===============================
            // Uncomment jika ingin mengurangi stock setelah gacha
            // if ($wonProduct->stock > 0) {
            //     $wonProduct->stock -= 1;
            //     $wonProduct->save();
            // }

            DB::commit();

            // ===============================
            // 7. RESPONSE KE FRONTEND
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

    /**
     * Weighted Random Selection berdasarkan stock
     * Produk dengan stock lebih banyak punya kemungkinan lebih besar untuk terpilih
     * 
     * @param Collection $products
     * @return Product
     */
    private function weightedRandomSelect($products)
    {
        $totalStock = $products->sum('stock');
        
        if ($totalStock == 0) {
            return $products->random();
        }

        // Generate random number antara 1 dan total stock
        $randomNumber = rand(1, $totalStock);
        
        $cumulativeStock = 0;
        foreach ($products as $product) {
            $cumulativeStock += $product->stock;
            if ($randomNumber <= $cumulativeStock) {
                return $product;
            }
        }

        // Fallback
        return $products->first();
    }
}