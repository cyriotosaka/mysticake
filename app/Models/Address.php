<?php

// Muhammad Fikri Khalilullah/5026231198
// Updated by Lailatul Fitaliqoh_229

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';

    protected $primaryKey = 'id_address';

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'full_address',
        'map_point',
        'address_contact_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function orders()
    {
        return $this->hasMany(Orders::class, 'id_address');
    }

    // Coordinate parsing
    public function getLatitudeAttribute()
    {
        return $this->map_point ? floatval(explode(',', $this->map_point)[0]) : null;
    }

    public function getLongitudeAttribute()
    {
        return $this->map_point ? floatval(explode(',', $this->map_point)[1]) : null;
    }

    public function getMapUrlAttribute()
    {
        if (! $this->latitude || ! $this->longitude) {
            return;
        }

        return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
    }

    /**
     * Scope untuk filter address by user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('id_user', $userId);
    }

    /**
     * Get all addresses for a user
     */
    public static function getUserAddresses($userId)
    {
        return self::forUser($userId)->get();
    }

    /**
     * Check if user can add more addresses (max 3)
     */
    public static function canAddAddress($userId)
    {
        $count = self::forUser($userId)->count();

        return $count < 3;
    }

    /**
     * Get address count for user
     */
    public static function getAddressCount($userId)
    {
        return self::forUser($userId)->count();
    }
}
