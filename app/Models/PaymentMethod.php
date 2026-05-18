<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'payment_method';

    protected $primaryKey = 'id_payment_method';

    public $timestamps = false;

    protected $fillable = [
        'name_method',
        'payment_barcode',
    ];

    public function orders()
    {
        return $this->hasMany(Orders::class, 'id_payment_method');
    }

    /**
     * Get all payment methods
     */
    public static function getAllMethods()
    {
        return self::all();
    }
}
