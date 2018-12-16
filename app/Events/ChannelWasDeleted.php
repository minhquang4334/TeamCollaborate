<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChannelWasDeleted implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $channelId;

	/**
	 * Create a new event instance.
	 * @param $channelId
	 * @return void
	 */
	public function __construct($channelId)
	{
		$this->channelId = $channelId;

		$this->dontBroadcastToCurrentUser();
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return Channel|array
	 */
	public function broadcastOn()
	{
		return new PrivateChannel('channel.'.\App\Model\Channel::GENERAL_CHANNEL_ID);
	}

	public function broadcastWith()
	{

		return [
			'data' => $this->channelId
		];
	}

	public function broadcastAs()
	{
		return 'ChannelWasDeleted';
	}
}
