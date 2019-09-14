<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ManualWithdraw extends Model
{
    const STATUS_NEW = 1;
    const STATUS_PENDING = 2;
    const STATUS_COMPLETE = 5;

    protected $table = 'manual_withdraw';

    protected $fillable = ['user_id', 'address', 'amount', 'status'];

    public function user()
    {
        return $this->belongsTo('App\Models\Auth\User');
    }
}
