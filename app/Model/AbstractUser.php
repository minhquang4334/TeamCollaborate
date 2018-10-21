<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

abstract class AbstractUser extends Authenticatable
{

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'email', 'password', 'gender', 'phone_number',
        'address', 'job', 'japanese_level', 'japanese_certificate',
        'about_me', 'facebook_url', 'avatar', 'email_verified_at', 'google_id', 'status',
        'university', 'is_bachelor',  'is_teacher', 'grade', 'role', 'is_admin'
    ];

    protected $dates = ['birthday'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'updated_at', 'deleted_at'
    ];

    public function channels() {
        return $this->belongsToMany(Channel::class, 'participations',
            'user_id', 'channel_id');
    }

    public function files() {
        return $this->hasMany(File::class, 'creator');
    }

    public function reacts() {
        return $this->hasMany(React::class, 'user_id');
    }

    public function invites() {
        return $this->hasMany(Invite::class, 'user_id');
    }

    public function posts() {
        return $this->hasMany(Post::class, 'creator');
    }

    public function unreads() {
        return $this->hasMany(Unread::class, 'user_id');
    }

    public function friends() {
        return $this->belongsToMany(User::class,'contacts',
            'user_first_id', 'user_second_id');
    }

}