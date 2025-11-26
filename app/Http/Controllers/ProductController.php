<?php
<<<<<<<<< Temporary merge branch 1
/**
     * Nama : Abdul Ghoni
     * NRP : 5026231109
     */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
=========

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;
>>>>>>>>> Temporary merge branch 2

class ProductController extends Controller
{
    /**
<<<<<<<<< Temporary merge branch 1
     * GET /search
     * Menampilkan Search Page (tanpa hasil),
     * menampilkan Highest Rating + Recently Search.
     *
     * Ini sesuai step 1.1 pada sequence diagram:
     * Halaman Home Page -> GET /search -> return SearchPage view.
     */
    public function showSearchPage(Request $request)
    {
        // dummy recently search, sesuai desain UI
        $recentSearches = [
            'Cake', 'Cheeseroll', 'IceCream',
            'Dessert', 'Coklat', 'Puding',
            'caramel', 'donat', 'Martabak', 'bolu',
        ];

        // Highest rating products (dipakai di Search Page)
        $highestRated = Product::highestRated(6)->get();

        return view('search', [
            'query'          => null,
            'results'        => collect(),    // kosong
            'highestRated'   => $highestRated,
            'recentSearches' => $recentSearches,
=========
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
>>>>>>>>> Temporary merge branch 2
        ]);
    }

    /**
<<<<<<<<< Temporary merge branch 1
     * POST /search
     * Melakukan pencarian dessert berdasarkan keyword.
     *
     * Sesuai sequence diagram:
     * - submitSearch("Cake") -> POST /search
     * - call searchProduct("Cake")
     * - call showResults(productList)
     */
    public function searchProduct(Request $request)
    {
        $keyword = $request->input('q');

        // 1. Ambil list produk berdasarkan keyword
        $productList = Product::search($keyword)
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->get();

        // 2. Lengkapi data detail produk (kalau diperlukan)
        $fullProductList = $this->getDetails($productList);

        // 3. Tampilkan hasil ke view (Result Page)
        return $this->showResults($fullProductList, $keyword);
    }

    /**
     * getDetails(productList)
     *
     * Pada sequence diagram, langkah ini mengambil detail tambahan
     * dari setiap produk. Di sini kamu bisa tambahkan:
     * - hitung average rating (sudah dibantu accessor di model)
     * - mapping data lain kalau perlu
     */
    protected function getDetails($products)
    {
        // Untuk sekarang, kita hanya return apa adanya,
        // karena accessor `average_rating` dan `review_count`
        // sudah tersedia di model Product.
        // Tempat ini bisa dipakai kalau suatu saat kamu butuh
        // enrich data (misal: jarak toko, estimasi waktu kirim, dsb).

        return $products;
    }

    /**
     * showResults(productList)
     *
     * Mengembalikan view Result Page Cake (Search Result Page)
     * lengkap dengan data produk dan kata kunci.
     */
    protected function showResults($productList, ?string $keyword = null)
    {
        $recentSearches = [
            'Cake', 'Cheeseroll', 'IceCream',
            'Dessert', 'Coklat', 'Puding',
            'caramel', 'donat', 'Martabak', 'bolu',
        ];

        // Highest rating products (dipakai di Search Page)
        $highestRated = Product::highestRated(6)->get();

        return view('search', [
            'query'          => null,
            'results'        => collect(),    // kosong
            'highestRated'   => $highestRated,
            'recentSearches' => $recentSearches,
>>>>>>> f44b41630eee142132d21b130e83e9600f344d03
        ]);
    }
=========
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
>>>>>>>>> Temporary merge branch 2
}
