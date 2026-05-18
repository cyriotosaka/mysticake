<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MysteryBox extends Model
{
    protected $table = 'mystery_box';

    protected $primaryKey = 'id_mystery_box';

    public $timestamps = false;

    protected $fillable = [
        'name_box',
        'description',
    ];

    /**
     * A Mystery Box contains many products (through the pivot table)
     */
    public function items()
    {
        return $this->hasMany(MysteryBoxProduct::class, 'id_mystery_box', 'id_mystery_box');
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'mystery_box_product',
            'id_mystery_box',
            'id_product'
        )->withPivot([
            'price',
            'point_gacha',
            'history_gacha',
            'type_gacha',
            'drop_rate',
            'cashback',
        ]);
    }
}
