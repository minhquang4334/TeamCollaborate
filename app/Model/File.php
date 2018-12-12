<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //
    protected $fillable = [
        'file_path', 'file_name', 'is_image', 'creator', 'channel_id', 'post_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'creator');
    }

    public function post() {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function channel() {
        return $this->belongsTo(Channel::class, 'channel_id');
    }
}
