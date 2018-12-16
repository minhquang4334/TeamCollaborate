<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $table = 'channels';
    public $timestamp=true;
    CONST PUBLIC = 0;
    CONST PRIVATE = 1;
    CONST PROTECTED = 2;
    CONST ACTIVE = 1;
    CONST INACTIVE = 0;
    CONST GENERAL_CHANNEL_ID = 'ASTEAMK60';

    protected $fillable = [
        'type', 'creator', 'purpose', 'description', 'status', 'channel_id', 'name'
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'participations',
            'channel_id', 'user_id');
    }

    public function files() {
        return $this->hasMany(File::class, 'channel_id');
    }

    public function posts() {
        return $this->hasMany(Post::class, 'channel_id');
    }

    public function pinned(){
        return $this->posts()->where('type', Post::PINNED)->get();
    }

    public function unreads() {
        return $this->hasMany(Unread::class, 'channel_id');
    }

    public function getCreator(){
        return $this->hasOne(User::class, 'id', 'creator');
    }

    public function getUsersCount(){
        return $this->users()->whereChannelId($this->id)->count();
    }

    public function getPostsCount(){
        return $this->posts()->whereChannelId($this->id)->count();
    }

    public function scopeProtected($query) {
	    return $query->where('type', Channel::PROTECTED);
    }
}
