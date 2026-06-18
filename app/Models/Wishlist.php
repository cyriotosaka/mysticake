<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlist';

    protected $primaryKey = 'id_wishlist';

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_product',
        'created_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
