<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class UserEntity extends Model
{
    protected $table = 'users';


    public function referral()
    {
        return $this->belongsTo('App\Models\Auth\User');
    }
}
