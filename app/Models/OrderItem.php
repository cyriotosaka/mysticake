<?php

/**
 * OrderItem Model
 *
 * Updated by: Abdul Ghoni (5026231109)
 *
 * Use Case 3 - Rating dan Review:
 * - Model ini digunakan di ReviewProduct::hasUserPurchased() untuk validasi
 *   apakah user sudah pernah membeli produk sebelum bisa memberikan review
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_item';

    protected $primaryKey = 'id_order_item';

    public $timestamps = false;

    protected $fillable = [
        'id_order',
        'id_product',
        'quantity',
        'subtotal',
    ];

    /** ORDER (belongsTo) */
    public function orders()
    {
        return $this->belongsTo(Orders::class, 'id_order', 'id_order');
    }

    /** PRODUCT (belongsTo) */
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    /** Auto calculate subtotal */
    public function calculateSubtotal()
    {
        if ($this->product) {
            $this->subtotal = $this->product->price * $this->quantity;
            $this->save();
        }
    }
}
