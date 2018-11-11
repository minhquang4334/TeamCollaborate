<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FacebookSocialAccount extends Model
{
    //
    protected $fillable = [
        'facebook_id', 'access_token', 'refresh_token'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
