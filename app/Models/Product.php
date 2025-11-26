<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
