<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //
    protected $fillable = [
      'report_creator_id', 'channel_id', 'post_id', 'description', 'status'
    ];


}
