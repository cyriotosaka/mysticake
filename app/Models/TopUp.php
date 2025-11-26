<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    /**
     * Nama tabel
     */
    protected $table = 'top_up';

    /**
     * Primary key
     */
    protected $primaryKey = 'id_top_up';

    /**
     * Tidak memakai timestamps (created_at, updated_at)
     */
    public $timestamps = false;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'id_payment_method',
        'id_user',
        'total_top_up',
        'date',
        'time',
        'admin_fee'
    ];

    /**
     * Relasi ke User (Top Up dilakukan oleh user)
     * Many top_ups belong to one user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke PaymentMethod
     * Top Up menggunakan salah satu metode pembayaran
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'id_payment_method', 'id_payment_method');
    }

    /**
     * Format total top up + admin fee (computed)
     */
    public function getTotalIncludingFeeAttribute()
    {
        return $this->total_top_up + $this->admin_fee;
    }
}
