<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * Nama tabel di database
     *
     * @var string
     */
    protected $table = 'address';

    /**
     * Primary key dari tabel
     *
     * @var string
     */
    protected $primaryKey = 'id_address';

    /**
     * Menandakan bahwa primary key bukan auto increment
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Tipe data primary key
     *
     * @var string
     */
    protected $keyType = 'int';

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
        'id_user',
        'full_address',
        'map_point',
        'address_contact'
    ];

    /**
     * Relasi ke model User (Many to One)
     * Alamat dimiliki oleh satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi untuk user yang menggunakan alamat ini sebagai alamat utama
     */
    public function mainAddressUsers()
    {
        return $this->hasMany(User::class, 'id_address', 'id_address');
    }

    /**
     * Get koordinat latitude dari map_point
     *
     * @return float|null
     */
    public function getLatitudeAttribute()
    {
        if ($this->map_point) {
            $coords = explode(',', $this->map_point);
            return isset($coords[0]) ? (float) trim($coords[0]) : null;
        }
        return null;
    }

    /**
     * Get koordinat longitude dari map_point
     *
     * @return float|null
     */
    public function getLongitudeAttribute()
    {
        if ($this->map_point) {
            $coords = explode(',', $this->map_point);
            return isset($coords[1]) ? (float) trim($coords[1]) : null;
        }
        return null;
    }

    /**
     * Get Google Maps URL dari koordinat
     *
     * @return string|null
     */
    public function getMapUrlAttribute()
    {
        if ($this->latitude && $this->longitude) {
            return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
        }
        return null;
    }
}