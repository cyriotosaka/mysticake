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
        return round($this->reviews()->avg('rating'), 1) ?? 0;
    }

    // Menghitung jumlah yang merating
    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }
}
