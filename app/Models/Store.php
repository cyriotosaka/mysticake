<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $table = 'store';

    protected $primaryKey = 'id_store';

    public $timestamps = false;

    protected $fillable = [
        'name_store',
        'rating_store',
        'store_picture',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'id_store', 'id_store');
    }
}
