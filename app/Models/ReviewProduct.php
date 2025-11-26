<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class ReviewProduct extends Model
{
    use HasFactory;

    protected $table = 'review_product';
    protected $primaryKey = 'id_review_product';
    public $timestamps = false;

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    // Relasi ke User yang memberi review
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
