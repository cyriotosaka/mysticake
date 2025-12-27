<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil User yang sedang login
        $user = Auth::user();

        // 2. Hitung jumlah barang di keranjang user ini
        // (Jika user belum login, cart 0)
        $cartCount = 0;
        if ($user) {
            $cart = Cart::where('id_user', $user->id_user)->first();
            if ($cart) {
                $cartCount = CartItem::where('id_cart', $cart->id_cart)->count();
            }
        }

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
}
