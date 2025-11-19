<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';          // Nama tabel di DB kamu
    protected $primaryKey = 'id_user';  // Primary key kamu
    public $timestamps = false;         // Di DB kamu tidak ada created_at/updated_at

    protected $fillable = [
        'username', 'email', 'password', 'phone_number', 'id_address', 'profile_pic'
    ];

    protected $hidden = [
        'password',
    ];
}
