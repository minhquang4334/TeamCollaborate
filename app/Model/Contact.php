<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    CONST FRIEND = 0;
    CONST BLOCK = 1;

    protected $fillable = [
      'user_first_id', 'user_second_id', 'type'
    ];
}
