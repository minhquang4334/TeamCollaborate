<?php

namespace App\Listeners;

use App\Events\OauthRegistered;
use App\Model\Channel;
use App\Repositories\ChannelRepository;

class AddNewOAuthUserToGeneral
{
	/**
	 * Create the event listener.
	 * @param ChannelRepository $channel
	 * @return void
	 */
	protected $channel;
	public function __construct(ChannelRepository $channel)
	{
		//
		$this->channel = $channel;
	}

	/**
	 * Handle the event.
	 *
	 * @param Registered $event
	 * @return void
	 */
	public function handle(OauthRegistered $event)
	{
		$user = $event->user;
		if(!$user->avatar) {
			$user->avatar = config('const.default_avatar');
			$user->save();
		}
		$channel = $this->channel->getChannelById(Channel::GENERAL_CHANNEL_ID);
		$channel->users()->attach($user->id, ['display_name' => $user->name, 'status' => Channel::ACTIVE ]);
	}
}