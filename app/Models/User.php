<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Nama tabel di database
     */
    protected $table = 'user';

    /**
     * Primary key
     */
    protected $primaryKey = 'id_user';

    /**
     * Tidak memakai timestamps
     */
    public $timestamps = false;

    /**
     * Kolom yang dapat diisi mass-assignment
     */
    protected $fillable = [
        'email',
        'password',
        'username',
        'phone_number',
        'role',
        'id_address',
        'profile_picture'
    ];

    /**
     * Kolom yang harus disembunyikan
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Relasi: User memiliki alamat utama (One to One)
     */
    public function address()
    {
        return $this->belongsTo(Address::class, 'id_address', 'id_address');
    }

    /**
     * Relasi: User dapat memiliki banyak alamat
     */
    public function addresses()
    {
        return $this->hasMany(Address::class, 'id_user', 'id_user');
    }

    /**
     * Relasi: User memiliki 1 dompet (wallet)
     */
    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'id_user', 'id_user');
    }
    // Aksesor untuk mempermudah pemanggilan saldo (Opsional tapi berguna)
    public function getBalanceAttribute()
    {
        // Jika wallet ada, ambil saldonya. Jika tidak, return 0
        return $this->wallet ? $this->wallet->saldo_coin : 0;
    }

    /**
     * Relasi: User memiliki banyak review produk
     */
    public function reviewProducts()
    {
        return $this->hasMany(ReviewProduct::class, 'id_user', 'id_user');
    }

    /**
     * Relasi: User memiliki banyak pesanan
     */
    public function orders()
    {
        return $this->hasMany(Orders::class, 'id_user', 'id_user');
    }

    /**
     * Relasi: User memiliki banyak item di keranjang
     */
    public function carts()
    {
        return $this->hasMany(Cart::class, 'id_user', 'id_user');
    }

    /**
     * Relasi: Jika user adalah seller, dia memiliki store
     */
    public function store()
    {
        return $this->hasOne(Store::class, 'id_user', 'id_user');
    }

    /**
     * Check apakah user adalah seller
     */
    public function isSeller()
    {
        return $this->role === 'seller';
    }

    /**
     * Check apakah user adalah customer
     */
    public function isBuyer()
    {
        return $this->role === 'buyer';
    }

    /**
     * Akses URL foto profil
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset($this->profile_picture);
        }
        return asset('images/default-avatar.png');
    }

    public function topUps()
    {
    return $this->hasMany(TopUp::class, 'id_user', 'id_user');
    }

}
