<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    const CURRENCY_BTC = 'BTC';

    protected $table = 'currencies';

    protected $fillable = ['currency_name', 'currency_name_short', 'rate'];

    public static function getBitcoinRate()
    {
        $currency = self::where('currency_name_short', self::CURRENCY_BTC)
            ->firstOrFail();

        return $currency->rate;
    }
}
