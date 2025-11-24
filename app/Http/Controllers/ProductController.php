<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;

class ProductController extends Controller
{
    /**
     * Menampilkan Halaman Utama (Homepage)
     * Sesuai UML: showHomepage()
     */
    public function showHomepage()
    {
        // 1. Ambil User yang sedang login
        $user = Auth::user();

        // 2. Hitung jumlah barang di keranjang user ini
        // (Logic Cart disisipkan di sini untuk kebutuhan View header)
        $cartCount = 0;
        if ($user) {
            $cartCount = Cart::where('id_user', $user->id_user)->count();
        }

        // 3. Ambil 2 Produk untuk bagian "Recommendation"
        // Sesuai logika: ambil acak atau terbaru
        $recommendations = Product::with('reviews')->inRandomOrder()->take(2)->get();

        // 4. Kirim data ke View 'home'
        return view('home', [
            'user'            => $user,
            'cartCount'       => $cartCount,
            'recommendations' => $recommendations
        ]);
    }

    /**
     * Menampilkan Detail Produk
     * Sesuai UML: showProductDetail(id)
     */
    public function showProductDetail($id)
    {
        // Ambil data produk berdasarkan ID
        $product = Product::with('reviews')->findOrFail($id);

        // Tampilkan view detail
        return view('products.detail', compact('product'));
    }

    /**
     * Melakukan Pencarian Produk
     * Sesuai UML: searchProduct(keyword)
     */
    public function searchProduct(Request $request)
    {
        // Mengambil input 'q' dari URL (?q=keyword)
        $query = $request->input('q');

        // Data Default (Inisialisasi)
        $highestRated = [];
        $results = [];
        // Hardcode recent searches (atau bisa ambil dari history user di DB jika ada)
        $recentSearches = ['Cake', 'Cheeseroll', 'IceCream', 'Dessert', 'Coklat', 'Puding', 'caramel', 'donat', 'Martabak', 'bolu'];

        if ($query) {
            // --- LOGIKA PENCARIAN ---
            // Mencari produk yang namanya mirip dengan query
            $results = Product::where('name_product', 'LIKE', "%{$query}%")
                            ->with('reviews') // Eager load relasi reviews
                            ->get();
        } else {
            // --- LOGIKA TAMPILAN AWAL (SEARCH PAGE) ---
            // Jika tidak ada query, tampilkan produk dengan rating tertinggi
            // Catatan: sortByDesc dilakukan di level Collection (PHP), bukan Query SQL
            $highestRated = Product::with('reviews')
                                ->get()
                                ->sortByDesc(function($product) {
                                    return $product->reviews->avg('rating'); // Asumsi ada relasi reviews
                                })
                                ->take(5);
        }

        return view('search', [
            'query'          => $query,
            'results'        => $results,
            'highestRated'   => $highestRated,
            'recentSearches' => $recentSearches
        ]);
    }

    /**
     * Menampilkan Rekomendasi (Opsional, jika ada halaman khusus rekomendasi)
     * Sesuai UML: showRecommendation()
     */
    public function showRecommendation()
    {
        // Logika rekomendasi yang lebih kompleks bisa ditaruh sini
        $recommendations = Product::inRandomOrder()->take(10)->get();
        return view('products.recommendation', compact('recommendations'));
    }

    // ... method showProductRating() dll ...
}
