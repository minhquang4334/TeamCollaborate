<?php

namespace App\Providers;

use App\Events\CommentWasCreated;
use App\Events\OauthRegistered;
use App\Listeners\AddNewOAuthUserToGeneral;
use App\Listeners\AddNewUsertoGeneral;
use App\Listeners\SendCommentWasCreatedNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
	        AddNewUsertoGeneral::class
        ],
	    OauthRegistered::class => [
		    AddNewOAuthUserToGeneral::class
	    ],
	    CommentWasCreated::class => [
	    	SendCommentWasCreatedNotification::class
	    ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
