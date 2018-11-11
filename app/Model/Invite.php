<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    //
    CONST PENDING = 0;
    CONST SUCCESS = 1;
    CONST REJECT = 2;

    protected $fillable = [
      'user_id', 'invited_email', 'invite_token', 'status'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
