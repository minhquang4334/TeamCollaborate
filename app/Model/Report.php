<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    const RESOLVED = 1;
    const YET       = 0;
    protected $fillable = [
      'report_creator_id', 'channel_id', 'post_id', 'description', 'status'
    ];


}
