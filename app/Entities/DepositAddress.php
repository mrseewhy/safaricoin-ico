<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class DepositAddress extends Model
{
    protected $table = 'deposit_addresses';

    protected $fillable = ['user_id', 'wallet_id', 'address', 'address_id'];

    public function transactions()
    {
        return $this->hasMany('App\Entities\Transaction');
    }
}
