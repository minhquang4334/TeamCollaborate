<?php

namespace App\model;

use App\Scopes\AdminScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends AbstractUser
{
    //
    protected $table = 'users';
    use Notifiable;

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new AdminScope());
    }


}
