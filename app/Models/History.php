<?php

// Created by Lailatul Fitaliqoh (5026231229)

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';

    protected $primaryKey = 'id_history';

    public $timestamps = false;

    protected $fillable = [
        'id_order',
        'date',
        'time',
    ];

    /**
     * Relasi ke Orders (Many-to-One)
     */
    public function orders()
    {
        return $this->belongsTo(Orders::class, 'id_order', 'id_order');
    }
}
