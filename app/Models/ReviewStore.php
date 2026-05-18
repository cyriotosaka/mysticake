<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewStore extends Model
{
    /**
     * Tabel yang digunakan
     */
    protected $table = 'review_store';

    /**
     * Primary key
     */
    protected $primaryKey = 'id_review_store';

    /**
     * Tidak memakai timestamps
     */
    public $timestamps = false;

    /**
     * Kolom yang dapat diisi mass-assignment
     */
    protected $fillable = [
        'id_store',
        'id_user',
        'comment',
        'like_review',
        'rating',
    ];

    /**
     * Relasi ke Store
     */
    public function store()
    {
        return $this->belongsTo(Store::class, 'id_store', 'id_store');
    }

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
