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
        // Kita ambil acak (inRandomOrder) atau yang terbaru
        $recommendations = Product::with('reviews')->inRandomOrder()->take(2)->get();

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
            $results = Product::where('name_product', 'LIKE', "%{$query}%")
                              ->with('reviews') // Eager load review untuk rating
                              ->get();
        } else {
            // LOGIKA TAMPILAN AWAL (Ambil produk rating tertinggi)
            // Karena di DB kamu rating dihitung dinamis, kita ambil random dulu atau sort manual collection
            $highestRated = Product::with('reviews')->get()->sortByDesc('average_rating')->take(5);
        }

        return view('search', [
            'query' => $query,
            'results' => $results,
            'highestRated' => $highestRated,
            'recentSearches' => $recentSearches
        ]);
    }
}
