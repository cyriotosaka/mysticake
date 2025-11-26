<?php
/**
     * Nama : Abdul Ghoni
     * NRP : 5026231109
     */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
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
        ]);
    }

    /**
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

        return view('search', [
            'query'          => $keyword,
            'results'        => $productList,
            'highestRated'   => collect(),    // tidak dipakai di result page
            'recentSearches' => $recentSearches,
        ]);
    }
}
