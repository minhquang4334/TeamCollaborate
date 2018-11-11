<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class React extends Model
{
    //
    protected $fillable = [
      'user_id', 'post_id', 'react_code'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function post() {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
