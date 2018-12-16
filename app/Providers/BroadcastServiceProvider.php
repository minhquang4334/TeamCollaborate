<?php

namespace App\Providers;

use App\Model\Channel;
use App\Model\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
	    Broadcast::routes();

	    // Authenticate the user's personal channel.
	    Broadcast::channel('App.User.{userId}', function ($user, $userId) {
		    return (int) $user->id === (int) $userId;
	    });

	    Broadcast::channel('channel.{channelId}', function ($user, $channelId) {
	    	$channel_id = $channelId;
	    	$channel = new Channel();
		    $channel = $channel->where('channel_id', $channel_id)->get()->toArray();
	    	$findUser = User::find($user->id);
	    	$c = $channel[0];
		    return $findUser->channels->contains('id', $c['id']);
	    });
    }
}
