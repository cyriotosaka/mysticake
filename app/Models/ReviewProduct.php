<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class ReviewProduct extends Model
{
    /**
     * Nama tabel
     */
    use HasFactory;

    protected $table = 'review_product';

    /**
     * Primary key
     */
    protected $primaryKey = 'id_review_product';

    /**
     * Tabel tidak menggunakan created_at / updated_at
     */
    public $timestamps = false;

    /**
     * Kolom yang dapat di-fill
     */
    protected $fillable = [
        'id_product',
        'id_user',
        'comment',
        'like_review',
        'rating'
    ];

    /**
     * Relasi ke Product (Many to One)
     */
    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    /**
     * Relasi ke User (Many to One)
     */
    // Relasi ke User yang memberi review
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Helper: apakah review memiliki komentar?
     */
    public function hasComment()
    {
        return !empty($this->comment);
    }

    /**
     * Helper: apakah review memiliki rating baik?
     */
    public function isPositive()
    {
        return $this->rating >= 4;
    }
}
