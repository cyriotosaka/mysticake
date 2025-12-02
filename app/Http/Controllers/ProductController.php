<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;
use App\Models\ReviewProduct;

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
     * Menampilkan Halaman Search Awal (GET /search)
     * Sesuai sequence diagram: menampilkan SearchPage view
     */
    public function showSearchPage()
    {
        // Data untuk halaman search awal
        $recentSearches = ['Cake', 'Cheeseroll', 'IceCream', 'Dessert', 'Coklat', 'Puding', 'caramel', 'donat', 'Martabak', 'bolu'];
        
        // Ambil produk rating tertinggi menggunakan scope
        $highestRated = Product::highestRated(6)->get();

        return view('search.search', [
            'query'          => null,
            'results'        => collect(),
            'highestRated'   => $highestRated,
            'recentSearches' => $recentSearches
        ]);
    }

    /**
     * Melakukan Pencarian Produk (POST /search)
     * Sesuai sequence diagram:
     * 1. Route call searchProduct(keyword)
     * 2. ProductController call find(keyword) -> Product Model
     * 3. Product Model return productList
     * 4. ProductController call getDetails(productList)
     * 5. Return view dengan fullProductList
     */
    public function searchProduct(Request $request)
    {
        // Validasi input
        $request->validate([
            'q' => 'required|string|min:1'
        ]);

        $keyword = $request->input('q');

        // Step 1: find(keyword) - Menggunakan scope search() dari Model
        $productList = Product::search($keyword)->get();

        // Step 2: getDetails(productList) - Ambil detail lengkap dengan reviews
        $fullProductList = $this->getDetails($productList);

        return view('search.search-results', [
            'query'          => $keyword,
            'results'        => $fullProductList,
            'highestRated'   => collect(),
            'recentSearches' => []
        ]);
    }

    /**
     * Helper: Mendapatkan detail lengkap produk
     * Sesuai sequence diagram: getDetails(productList)
     * Load relasi reviews untuk setiap produk
     */
    private function getDetails($productList)
    {
        return $productList->load([
            'reviews' => function($query) {
                $query->orderByDesc('created_at')->take(5);
            }
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


    /**
     * Menampilkan Halaman Rating & Feedback (GET /product/{id}/ratings)
     * Sesuai sequence diagram:
     * 1. call getProductDetails(id) -> Product Model
     * 2. call showRatings(productData) -> ReviewProduct Model
     * 3. return RatingPage view
     */
    public function showRatings($id)
    {
        // 1.1.1.1: find(id)
        $product = Product::with('store')->find($id);

        if (!$product) {
            abort(404, 'Product not found');
        }

        // 1.1.2.1: findByProduct(productData.id)
        $reviews = ReviewProduct::findByProduct($id);

        // 1.1.3: return RatingPage view
        return view('rating.rating', [
            'product' => $product,
            'reviews' => $reviews
        ]);
    }
}
