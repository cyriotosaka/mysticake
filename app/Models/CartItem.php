<?php
//Created by Arsya Nueva D (5026231099)
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_item';
    protected $primaryKey = 'id_cart_item';
    public $timestamps = false;

    protected $fillable = [
        'id_cart',
        'id_product',
        'quantity'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'id_cart');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    /**
     * Get subtotal for this cart item
     */
    public function getSubtotal()
    {
        return $this->product->price * $this->quantity;
    }

}
