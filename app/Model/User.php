<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    //use FormAccessibl;
    //use HasPushSubscriptions;

    const IS_TEACHER = true;
    const INACTIVE = 0;
    const ACTIVE = 1;
    const BLOCK = 2;

    const N1 = 1;
    const N2 = 2;
    const N3 = 3;
    const N4 = 4;
    const N5 = 5;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'gender', 'phone_number',
        'address', 'job', 'japanese_level', 'japanese_certificate',
        'about_me', 'facebook_url', 'avatar', 'email_verified_at', 'google_id', 'status',
        'university', 'is_bachelor',  'is_teacher', 'is_bachelor', 'grade', 'role'
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

    public static function selectGender()
    {
        return [
            '0' => 'Male',
            '1' => 'Female'
        ];
    }

    public static function selectLevel()
    {
        return [
            '0' => 'Choose a level',
            self::N1 => 'N1',
            self::N2 => 'N2',
            self::N3 => 'N3',
            self::N4 => 'N4',
            self::N5 => 'N5',
        ];
    }

    public static function selectUserStatus()
    {
        return [
            self::ACTIVE => 'Active',
            'all' => 'All',
            self::BLOCK => 'Blocked'
        ];
    }

    public function getBirthdayAttribute($value)
    {

        if (isset($value)) {
            return Carbon::parse($value)->format('d/m/Y');
        } else {
            return null;
        }
    }
}
