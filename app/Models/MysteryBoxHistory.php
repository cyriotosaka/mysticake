<?php

// created by Arsya Nueva_099

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MysteryBoxHistory extends Model
{
    // Sesuaikan dengan nama tabel kamu
    protected $table = 'mystery_box_history';

    // Sesuaikan dengan Primary Key di SQL tadi
    protected $primaryKey = 'id_gacha_history';

    public $timestamps = true;

    protected $fillable = [
        'id_user',
        'id_product',
    ];

    // Relasi ke Product (PENTING biar bisa ambil gambar & nama)
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}
