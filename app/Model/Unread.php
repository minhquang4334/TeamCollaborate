<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Unread extends Model
{
    //
    protected $fillable = [
      'user_id', 'post_id', 'channel_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel() {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function post() {
        return $this->belongsTo(Post::class, 'post_id');
    }


}
