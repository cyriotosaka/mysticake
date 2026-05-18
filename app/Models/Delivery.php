<?php

/**
 * Nama: Abdul Ghoni
 * NRP: 5026231109
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'delivery';

    protected $primaryKey = 'id_delivery';

    public $timestamps = false;

    protected $fillable = [
        'type',
        'delivery_charges',
    ];

    /**
     * Orders using this delivery method
     */
    public function orders()
    {
        return $this->hasMany(Orders::class, 'id_delivery', 'id_delivery');
    }

    /**
     * Get all delivery options
     */
    public static function getAllOptions()
    {
        return self::all();
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp '.number_format($this->delivery_charges, 0, ',', '.');
    }
}
