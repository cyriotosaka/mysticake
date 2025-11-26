<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'id_cart';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function items()
    {
        return $this->hasMany(CartItem::class, 'id_cart');
    }
}
