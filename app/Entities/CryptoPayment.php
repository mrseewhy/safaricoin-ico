<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class CryptoPayment extends Model
{
    protected $primaryKey = 'paymentID';

    protected $table = 'crypto_payments';
}
