<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $table = 'support';

    protected $fillable = ['user_id', 'transaction_id', 'transaction_hash', 'message'];

    public function user()
    {
        return $this->belongsTo('App\Models\Auth\User');
    }
}
