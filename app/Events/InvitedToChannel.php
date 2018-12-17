<?php

namespace App\Events;

use App\Support\Transform;
use App\Transformers\ChannelTransformer;
use App\Transformers\PostTransformer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use League\Fractal\Manager;

class InvitedToChannel implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $channel;
	public $author;

	/**
	 * Create a new event instance.
	 * @param $channel,
	 * @param $author,
	 * @param $parentComment
	 * @return void
	 */
	public function __construct($channel, $author)
	{
		$this->channel = $channel;
		$this->author = $author;

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
		$manager = new Manager();
		$transform = new Transform($manager);
		return [
			'data' => $transform->item($this->channel, new ChannelTransformer())
		];
	}

	public function broadcastAs()
	{
		return 'InvitedToChannel';
	}
}
