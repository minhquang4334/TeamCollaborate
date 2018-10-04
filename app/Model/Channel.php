<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    CONST PUBLIC = 0;
    CONST PRIVATE = 1;
    CONST PROTECTED = 2;
    CONST ACTIVE = 1;
    CONST INACTIVE = 0;

    protected $fillable = [
        'type', 'creator', 'purpose', 'description', 'status'
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'participations',
            'channel_id', 'user_id');
    }

    public function files() {
        return $this->hasMany(Channel::class, 'channel_id');
    }

    public function posts() {
        return $this->hasMany(Post::class, 'channel_id');
    }

    public function unreads() {
        return $this->hasMany(Unread::class, 'channel_id');
    }

}
