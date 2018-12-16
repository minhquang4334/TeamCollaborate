<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    const RESOLVED = 1;
    const YET       = 0;
    protected $fillable = [
      'report_creator_id', 'channel_id', 'post_id', 'description', 'status', 'subject'
    ];


    public function creator(){
        return $this->belongsTo(User::class, 'report_creator_id');
    }

    public function channel(){
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function post(){
        return $this->belongsTo(Post::class, 'post_id');
    }
}
