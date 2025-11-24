<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $primaryKey = 'IDAddress';

    public $incrementing = false;
    protected $keyType = int;

    public $timestamps = false;

    protected $fillable = [
        'FullAddress',
        'MapPoint',
        'AddressContactNumber'
    ];
}
