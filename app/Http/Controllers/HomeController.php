<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil User yang sedang login
        $user = Auth::user();

        // 2. Hitung jumlah barang di keranjang user ini
        // (Jika user belum login, cart 0)
        $cartCount = $user ? Cart::where('id_user', $user->id_user)->count() : 0;

        // 3. Ambil 2 Produk untuk bagian "Recommendation"
        // Gunakan withAvg agar tidak memicu N+1 saat mengakses rata-rata rating
        $recommendations = Product::withAvg('reviews', 'rating')
                      ->withCount('reviews')
                      ->inRandomOrder()
                      ->take(2)
                      ->get();

        // 4. Kirim data ke View
        return view('home', [
            'user' => $user,
            'cartCount' => $cartCount,
            'recommendations' => $recommendations
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        // Data Default (Tampilan Awal)
        $highestRated = [];
        $recentSearches = ['Cake', 'Cheeseroll', 'IceCream', 'Dessert', 'Coklat', 'Puding', 'caramel', 'donat', 'Martabak', 'bolu'];
        $results = [];

        if ($query) {
            // LOGIKA PENCARIAN (Jika ada query ?q=...)
            // Eager-load average and count to avoid running extra queries in the view
            $results = Product::where('name_product', 'LIKE', "%{$query}%")
                              ->withAvg('reviews', 'rating')
                              ->withCount('reviews')
                              ->get();
        } else {
            // LOGIKA TAMPILAN AWAL (Ambil produk rating tertinggi)
            // Gunakan withAvg dan orderBy agar DB menghitung rata-rata (efisien)
            $highestRated = Product::withAvg('reviews', 'rating')
                                  ->withCount('reviews')
                                  ->orderByDesc('reviews_avg_rating')
                                  ->take(5)
                                  ->get();
        }

        return view('search', [
            'query' => $query,
            'results' => $results,
            'highestRated' => $highestRated,
            'recentSearches' => $recentSearches
        ]);
    }
}
