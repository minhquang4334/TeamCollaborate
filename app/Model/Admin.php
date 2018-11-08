<?php

namespace App\Model;

use App\Scopes\AdminScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends AbstractUser
{
    //
    protected $table = 'admins';
    use Notifiable;

    protected $fillable = [
        'username', 'password', 'status'
    ];

    public static function boot()
    {
        parent::boot();
    }

}
