<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Offerings extends Model
{
    protected $table = 'offerings';

    protected $fillable = ['start_date', 'end_date', 'coins_total', 'coins_used', 'coins_rate'];

    public static function getCurrentRound()
    {
        return self::where('start_date', '<=', date('Y-m-d'))
            ->where('end_date', '>', date('Y-m-d'))
            ->first();
    }

    public function isActive()
    {
        return $this->coins_total > $this->coins_used;
    }

    public function coinsLeftInRound()
    {
        $left = $this->coins_total - $this->coins_used;

        return $left > 0 ? $left : 0;
    }

    public function coinsBoughtPercentage()
    {
        return min(round(100 / $this->coins_total * $this->coins_used), 100);
    }

    public function getRate()
    {
        return $this->coins_rate;
    }
}
