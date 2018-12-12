<?php

namespace App\Listeners;

use App\Events\NotificationToUser;
use App\Model\User;
use App\Notifications\TestNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendUserNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NotificationToUser  $event
     * @return void
     */
    public function handle(NotificationToUser $event)
    {
        $subUsers = $event->subUsers;
        foreach ($subUsers as $subUser) {
            $user = User::findOrFail($subUser->id);
            $user->notify(new TestNotification($subUser->token));
        }
    }
}
