<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MysteryBoxProduct extends Model
{
    /**
     * Nama tabel
     */
    protected $table = 'mystery_box_product';

    /**
     * Karena tabel ini memiliki composite primary key,
     * kita matikan auto increment dan biarkan Laravel
     * menangani insert/update tanpa PK tunggal.
     */
    public $incrementing = false;

    /**
     * Tabel tidak menggunakan timestamps
     */
    public $timestamps = false;

    /**
     * Field yang bisa diisi
     */
    protected $fillable = [
        'id_mystery_box',
        'id_product',
        'price',
        'point_gacha',
        'history_gacha',
        'type_gacha',
        'drop_rate',
        'cashback'
    ];

    /**
     * Relasi ke MysteryBox (Many to One)
     */
    public function mysteryBox()
    {
        return $this->belongsTo(MysteryBox::class, 'id_mystery_box', 'id_mystery_box');
    }

    /**
     * Relasi ke Product (Many to One)
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}
