<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Nama tabel di database
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * Primary key dari tabel
     *
     * @var string
     */
    protected $primaryKey = 'id_user';

    /**
     * Menandakan bahwa tabel tidak menggunakan timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Atribut yang dapat diisi secara mass assignment
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'phone_number',
        'role',
        'id_address',
        'profile_pic'
    ];

    /**
     * Atribut yang harus disembunyikan untuk serialization
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Relasi ke model Address (One to One)
     * User memiliki satu alamat utama
     */
    public function address()
    {
        return $this->belongsTo(Address::class, 'id_address', 'id_address');
    }

    /**
     * Relasi ke model Address (One to Many)
     * User dapat memiliki banyak alamat
     */
    public function addresses()
    {
        return $this->hasMany(Address::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke model Cart
     * User memiliki banyak item di keranjang
     */
    public function carts()
    {
        return $this->hasMany(Cart::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke model ReviewProduct
     * User dapat membuat banyak review produk
     */
    public function reviews()
    {
        return $this->hasMany(ReviewProduct::class, 'id_user', 'id_user');
    }

    /**
     * Check apakah user adalah seller
     *
     * @return bool
     */
    public function isSeller()
    {
        return $this->role === 'seller';
    }

    /**
     * Check apakah user adalah buyer
     *
     * @return bool
     */
    public function isBuyer()
    {
        return $this->role === 'buyer';
    }

    /**
     * Get URL foto profil user
     *
     * @return string
     */
    public function getProfilePicUrlAttribute()
    {
        if ($this->profile_pic) {
            return asset($this->profile_pic);
        }
        
        // Default avatar jika belum upload foto
        return asset('images/default-avatar.png');
    }
}