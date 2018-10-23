<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    protected $fillable = [
        'google_id', 'access_token', 'refresh_token'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
