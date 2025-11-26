<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallet';
    protected $primaryKey = 'id_user';
    public $incrementing = false; // because id_user is not AUTO_INCREMENT
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'saldo_coin',
    ];

    /**
     * Relasi ke User (One to One)
     * Satu wallet dimiliki oleh satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Tambah saldo
     */
    public function addSaldo($amount)
    {
        $this->saldo_coin += $amount;
        $this->save();
    }

    /**
     * Kurangi saldo
     */
    public function reduceSaldo($amount)
    {
        if ($this->saldo_coin >= $amount) {
            $this->saldo_coin -= $amount;
            $this->save();
            return true;
        }

        return false; // saldo tidak cukup
    }

    /**
     * Cek apakah saldo cukup
     */
    public function hasEnoughSaldo($amount)
    {
        return $this->saldo_coin >= $amount;
    }

    public function topUps()
    {
    return $this->hasMany(TopUp::class, 'id_user', 'id_user');
    }

}
