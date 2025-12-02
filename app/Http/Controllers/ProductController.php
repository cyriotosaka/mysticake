<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;

class ProductController extends Controller
{
    public function showHomepage()
    {
        // 1. Ambil User yang sedang login
        $user = Auth::user();

        // 2. Hitung jumlah barang di keranjang user ini
        $cartCount = 0;
        if ($user) {
            // Pastikan menggunakan 'id_user' atau 'id' sesuai database kamu
            $cartCount = Cart::where('id_user', $user->id_user ?? $user->id)->count();
        }

        // 3. Ambil 2 Produk untuk bagian "Recommendation"
        $recommendations = Product::with('reviews')->inRandomOrder()->take(2)->get();

        // 4. Kirim data ke View 'home'
        return view('home', [
            'user'            => $user,
            'cartCount'       => $cartCount,
            'recommendations' => $recommendations
        ]);
    }

    /**
     * Menampilkan Halaman Search & Hasil Pencarian
     * Menangani: GET /search (awal) dan GET /search?q=keyword
     */
    public function searchProduct(Request $request)
    {
        // Mengambil input 'q' dari URL (?q=keyword)
        $query = $request->input('q');

        // Data Default
        $highestRated = [];
        $results = collect();

        // Dummy Recent Searches
        $recentSearches = ['Cake', 'Cheeseroll', 'IceCream', 'Dessert', 'Coklat', 'Puding', 'caramel', 'donat', 'Martabak', 'bolu'];

        if ($query) {
            // --- KONDISI 1: ADA PENCARIAN ---
            $results = Product::where('name_product', 'LIKE', "%{$query}%")
                            ->with('reviews')
                            ->get();
        } else {
            // --- KONDISI 2: HALAMAN SEARCH AWAL ---
            // Ambil produk rating tertinggi
            $highestRated = Product::with('reviews')
                                ->get()
                                ->sortByDesc(function($product) {
                                    return $product->reviews->avg('rating');
                                })
                                ->take(6);
        }

        return view('search', [
            'query'          => $query,
            'results'        => $results,
            'highestRated'   => $highestRated,
            'recentSearches' => $recentSearches
        ]);
    }

    /**
     * Menampilkan Detail Produk
     */
    public function showProductDetail($id)
    {
        // 1. Cari produk berdasarkan ID, atau error 404 jika tidak ada
        $product = Product::with('reviews')->findOrFail($id);

        // 2. Hitung rata-rata rating
        $avgRating = $product->reviews()->avg('rating') ?? 0;

        // 3. Hitung jumlah review (misal: "3.2k")
        $totalReviews = $product->reviews()->count();

        // 4. Format angka review (opsional, biar jadi 1k, 3.2k, dll)
        if ($totalReviews > 1000) {
            $totalReviews = round($totalReviews / 1000, 1) . 'k';
        }

        // Tampilkan view (Pastikan folder view-nya benar)
        return view('product.detail', [
            'product' => $product,
            'avgRating' => $avgRating,
            'totalReviews' => $totalReviews
        ]);
    }

    /**
     * Menampilkan Rekomendasi
     */
    public function showRecommendation()
    {
        $recommendations = Product::inRandomOrder()->take(10)->get();
        return view('product.recommendation', compact('recommendations'));
    }
}
