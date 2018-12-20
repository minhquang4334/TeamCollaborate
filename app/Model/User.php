<?php

namespace App\Model;

use App\Notifications\InviteToAppNotification;
use App\Notifications\ReportAcceptedNotification;
use App\Notifications\ReportedNotification;
use App\Notifications\UserResetPasswordNotification;
use App\Notifications\UserVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\CanResetPassword;

class User extends AbstractUser implements JWTSubject, MustVerifyEmail, CanResetPassword
{
    use Notifiable;
    use SoftDeletes;
	use HasPushSubscriptions;


	//use FormAccessible;
    //use HasPushSubscriptions;

    protected $table = 'users';
    protected $email;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'id', 'name', 'email', 'password', 'gender', 'phone_number',
        'address', 'job', 'japanese_level', 'japanese_certificate',
        'about_me', 'facebook_url', 'avatar', 'google_id', 'status',
        'university', 'is_bachelor',  'is_teacher', 'grade', 'active'
    ];

    protected $dates = [
    	'birthday'
    ];

    protected $hidden = [
    	'password'
    ];

    const IS_TEACHER = true;
    const INACTIVE = 0;
    const ACTIVE = 0;
    const BLOCK = 1;

    const N1 = 1;
    const N2 = 2;
    const N3 = 3;
    const N4 = 4;
    const N5 = 5;

    /**
     *
     */
    public static function boot()
    {
        parent::boot();
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function channels() {
        return $this->belongsToMany(Channel::class, 'participations',
            'user_id', 'channel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files() {
        return $this->hasMany(File::class, 'creator');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reacts() {
        return $this->hasMany(React::class, 'user_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invites() {
        return $this->hasMany(Invite::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts() {
        return $this->hasMany(Post::class, 'creator');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function unreads() {
        return $this->hasMany(Unread::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function friends() {
        return $this->belongsToMany(User::class,'contacts',
            'user_first_id', 'user_second_id');
    }

    public function follows() {
    	return $this->hasMany(Follow::class, 'user_id');
    }
    /**
     * @return array
     */
    public static function selectGender()
    {
        return [
            '0' => 'Male',
            '1' => 'Female'
        ];
    }

    /**
     * @return array
     */
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

    /**
     * @return array
     */
    public static function selectUserStatus()
    {
        return [
            'all' => 'All',
            self::ACTIVE => 'Active',
            self::BLOCK => 'Blocked'
        ];
    }

    /**
     * @param $value
     * @return null|string
     */
    public function getBirthdayAttribute($value)
    {

        if (isset($value)) {
            return Carbon::parse($value)->format('d/m/Y');
        } else {
            return null;
        }
    }

    /**
     * @return mixed
     */
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function socialAccount()
    {
        return $this->hasOne(SocialAccount::class);
    }

    /**
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPasswordNotification($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new UserVerifyEmail());
    }

    public function setEmail($email){
        $this->email = $email;
        return $this;
    }
    /**
     * Send email to invite user to app
     *
     * @param $link
     */
    public function sendInviteToAppNotification($link){
        $this->notify(new InviteToAppNotification($link));
    }

    /**
     * send notify to user whose post is reported
     */
    public function sendReportedNotification(){
        $this->notify(new ReportedNotification());
    }

    /**
     * send to user, who create report
     */
    public function sendReportAcceptedNotification(){
        $this->notify(new ReportAcceptedNotification());
    }
}
