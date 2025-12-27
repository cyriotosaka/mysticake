<?php
// Created by Okky Priscila_168

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TopUp extends Model
{
    /**
     * Nama tabel sesuai dengan database MySQL
     * Table: top_up
     */
    protected $table = 'top_up';

    /**
     * Primary key sesuai dengan database
     * Column: id_top_up (int, auto_increment)
     */
    protected $primaryKey = 'id_top_up';

    /**
     * Tidak memakai timestamps (created_at, updated_at)
     * Karena tabel menggunakan kolom date dan time terpisah
     */
    public $timestamps = false;

    /**
     * Mass assignable fields
     * Sesuai dengan struktur tabel:
     * - id_payment_method: int(11)
     * - id_user: int(11)
     * - total_top_up: double
     * - date: date
     * - time: time
     * - admin_fee: double
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
     * Cast attributes to native types
     * Memastikan tipe data sesuai dengan database
     */
    protected $casts = [
        'id_top_up' => 'integer',
        'id_payment_method' => 'integer',
        'id_user' => 'integer',
        'total_top_up' => 'double',
        'date' => 'date',
        'time' => 'string',
        'admin_fee' => 'double'
    ];

    /**
     * Relasi ke User (Top Up dilakukan oleh user)
     * Many top_ups belong to one user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke PaymentMethod
     * Top Up menggunakan salah satu metode pembayaran
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'id_payment_method', 'id_payment_method');
    }

    /**
     * Accessor: Format total top up + admin fee (computed)
     * Contoh penggunaan: $topUp->total_including_fee
     * 
     * @return double
     */
    public function getTotalIncludingFeeAttribute()
    {
        return $this->total_top_up + $this->admin_fee;
    }

    /**
     * Accessor: Format total_top_up sebagai currency string
     * Contoh penggunaan: $topUp->formatted_amount
     * 
     * @return string
     */
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->total_top_up, 0, ',', '.');
    }

    /**
     * Accessor: Format admin_fee sebagai currency string
     * Contoh penggunaan: $topUp->formatted_admin_fee
     * 
     * @return string
     */
    public function getFormattedAdminFeeAttribute()
    {
        return 'Rp ' . number_format($this->admin_fee, 0, ',', '.');
    }

    /**
     * Accessor: Format total (amount + fee) sebagai currency string
     * Contoh penggunaan: $topUp->formatted_total
     * 
     * @return string
     */
    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total_including_fee, 0, ',', '.');
    }

    /**
     * Accessor: Get formatted datetime
     * Contoh penggunaan: $topUp->formatted_datetime
     * 
     * @return string
     */
    public function getFormattedDatetimeAttribute()
    {
        if (!$this->date || !$this->time) {
            return '-';
        }

        return Carbon::parse($this->date)->format('d M Y') . ' ' . $this->time;
    }

    /**
     * Scope: Filter by user
     * Contoh penggunaan: TopUp::forUser($userId)->get()
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('id_user', $userId);
    }

    /**
     * Scope: Filter by payment method
     * Contoh penggunaan: TopUp::byPaymentMethod($methodId)->get()
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $paymentMethodId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByPaymentMethod($query, $paymentMethodId)
    {
        return $query->where('id_payment_method', $paymentMethodId);
    }

    /**
     * Scope: Filter by date range
     * Contoh penggunaan: TopUp::betweenDates($startDate, $endDate)->get()
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $startDate
     * @param string $endDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Scope: Order by most recent
     * Contoh penggunaan: TopUp::recent()->get()
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('date', 'desc')->orderBy('time', 'desc');
    }
}