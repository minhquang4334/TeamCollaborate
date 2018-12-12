<?php

namespace App\Listeners;

use App\Model\Channel;
use App\Repositories\ChannelRepository;
use Illuminate\Auth\Events\Registered;

class AddNewUsertoGeneral
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
	public function handle(Registered $event)
	{
		dd(1);
		$user = $event->user;
		if(!$user->avatar) {
			$user->avatar = config('const.default_avatar');
			$user->store();
		}
		$channel = $this->channel->getChannelById(Channel::GENERAL_CHANNEL_ID);
		$channel->users()->attach($user->id, ['display_name' => $user->name, 'status' => Channel::ACTIVE ]);
	}
}