<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReviewProduct; // pastikan ini ada ya

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $primaryKey = 'id_product';
    public $timestamps = false;

    // Relasi ke Review untuk hitung rating
    public function reviews()
    {
        return $this->hasMany(ReviewProduct::class, 'id_product', 'id_product');
    }

    // Menghitung rata-rata rating secara otomatis
    public function getAverageRatingAttribute()
    {
        // Jika query menggunakan withAvg('reviews', 'rating'), Eloquent
        // menaruh nilai rata-rata di atribut `reviews_avg_rating`.
        $avg = $this->getAttribute('reviews_avg_rating');
        if ($avg !== null) {
            return round($avg, 1);
        }

        $avg = $this->reviews()->avg('rating');
        return $avg !== null ? round($avg, 1) : 0;
    }

    // Menghitung jumlah yang merating
    public function getReviewCountAttribute()
    {
        // Jika query menggunakan withCount('reviews'), Eloquent
        // menaruh jumlah di atribut `reviews_count`.
        $count = $this->getAttribute('reviews_count');
        if ($count !== null) {
            return (int) $count;
        }

        return $this->reviews()->count();
    }

    /*
    |--------------------------------------------------------------------------
    | Tambahan: Query Scope untuk Use Case Pencarian Dessert
    |--------------------------------------------------------------------------
    */

    /**
     * scopeSearch
     *
     * Memfilter produk berdasarkan keyword yang diketik user.
     * Digunakan di ProductController::searchProduct().
     *
     * Pemanggilan:
     * Product::search($keyword)->get();
     */
    public function scopeSearch($query, ?string $keyword)
    {
        if (empty($keyword)) {
            return $query;
        }

        return $query->where(function ($q) use ($keyword) {
            $q->where('name_product', 'LIKE', "%{$keyword}%")
              ->orWhere('description', 'LIKE', "%{$keyword}%");
        });
    }

    /**
     * scopeHighestRated
     *
     * Mengambil produk dengan rating tertinggi, dibatasi $limit.
     * Digunakan di ProductController::showSearchPage().
     */
    public function scopeHighestRated($query, int $limit = 6)
    {
        return $query->withAvg('reviews', 'rating')
                     ->withCount('reviews')
                     ->orderByDesc('reviews_avg_rating')
                     ->take($limit);
    }
}
