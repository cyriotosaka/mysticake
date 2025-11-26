<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    /**
     * Tabel yang digunakan
     */
    protected $table = 'chat';

    /**
     * Primary key
     */
    protected $primaryKey = 'id_chat';

    /**
     * Tidak memakai timestamps
     */
    public $timestamps = false;

    /**
     * Kolom yang dapat diisi (mass assignment)
     */
    protected $fillable = [
        'id_user',
        'id_store',
        'id_order',
        'id_product',
        'date',
        'time',
        'message'
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke Store
     */
    public function store()
    {
        return $this->belongsTo(Store::class, 'id_store', 'id_store');
    }

    /**
     * Relasi ke Order
     */
    public function orders()
    {
        return $this->belongsTo(Orders::class, 'id_order', 'id_order');
    }

    /**
     * Relasi ke Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}
