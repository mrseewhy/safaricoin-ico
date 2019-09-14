<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'user_wallets';

    protected $fillable = ['user_id', 'balance_btc', 'balance_usd'];
}
