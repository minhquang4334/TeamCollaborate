<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CommentWasDeleted implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $commentId;
	public $channelId;
	public $author;

	/**
	 * Create a new event instance.
	 * @param $comment,
	 * @param $author,
	 * @param $channelId
	 * @return void
	 */
	public function __construct($commentId, $author, $channelId)
	{
		$this->commentId = $commentId;
		$this->author = $author;
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
		return new PrivateChannel('channel.'.$this->channelId);
	}

	public function broadcastWith()
	{

		return [
			'data' => $this->commentId
		];
	}

	public function broadcastAs()
	{
		return 'CommentWasDeleted';
	}
}
