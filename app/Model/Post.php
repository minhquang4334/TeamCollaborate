<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    CONST NORMAL = 0;
    CONST PINNED = 1;
    CONST BLOCK = 0;
    CONST ACTIVE = 1;

    protected $fillable = [
      'content', 'is_parent', 'channel_id', 'parent_id',
        'creator', 'user_following_post', 'status', 'type'
    ];

    public function files() {
        return $this->hasMany(File::class,'post_id');
    }

	public function creator() {
		return $this->belongsTo(User::class,'creator');
	}

    public function unreads() {
        return $this->hasMany(Unread::class, 'post_id');
    }

    public function channel() {
        return $this->belongsTo(Channel::class, 'post_id');
    }

    public function reacts() {
        return $this->hasMany(React::class, 'post_id');
    }

    public function children() {
        return $this->hasMany(Post::class, 'parent_id');
    }

    public function parent() {
        return $this->belongsTo(Post::class, 'parent_id');
    }

    public function followers() {
		return $this->hasMany(Follow::class, 'post_id');
    }

    public function scopeParent($query) {
    	return $query->where('is_parent', false);
    }

    public function scopePin($query) {
    	return $query->where('type', Post::PINNED);
    }

}
