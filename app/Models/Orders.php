<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id_order';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_payment_method',
        'id_address',
        'id_delivery',
        'order_date',
        'extra_charges',
        'total_payment',
        'status_order'
    ];

    /**
     * User yang membuat order
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Metode pembayaran
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'id_payment_method', 'id_payment_method');
    }

    /**
     * Alamat pengiriman
     */
    public function address()
    {
        return $this->belongsTo(Address::class, 'id_address', 'id_address');
    }

    /**
     * Metode pengiriman (delivery)
     */
    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'id_delivery', 'id_delivery');
    }

    /**
     * Item-item di dalam order
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'id_order', 'id_order');
    }

    /**
     * Hitung total item
     */
    public function totalItems()
    {
        return $this->items()->sum('quantity');
    }

    /**
     * Check apakah order sudah selesai
     */
    public function isCompleted()
    {
        return $this->status_order === 'completed';
    }

    public function histories()
    {
    return $this->hasMany(History::class, 'id_order', 'id_order');
    }

}
