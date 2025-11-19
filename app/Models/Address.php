<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $primaryKey = 'id_address';
    public $timestamps = false;

    protected $fillable = [
        'id_user', 'full_address', 'map_point', 'address_contact'
    ];
}
