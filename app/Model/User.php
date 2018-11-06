<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends AbstractUser implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    //use FormAccessible;
    //use HasPushSubscriptions;

    protected $table = 'users';

    const IS_TEACHER = true;
    const INACTIVE = 0;
    const ACTIVE = 1;
    const BLOCK = 2;

    const N1 = 1;
    const N2 = 2;
    const N3 = 3;
    const N4 = 4;
    const N5 = 5;

    public static function boot()
    {
        parent::boot();
    }

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
            'all' => 'All',
            self::ACTIVE => 'Active',
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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function socialAccount()
    {
        return $this->hasOne(SocialAccount::class);
    }

}
