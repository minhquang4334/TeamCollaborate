<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ThreadWasPatched implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $comment;
	public $author;
	public $parentComment;

	/**
	 * Create a new event instance.
	 * @param $comment,
	 * @param $author,
	 * @param $parentComment
	 * @return void
	 */
	public function __construct($comment, $author, $parentComment)
	{
		$this->comment = $comment;
		$this->author = $author;
		$this->parentComment = $parentComment;

		$this->dontBroadcastToCurrentUser();
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return Channel|array
	 */
	public function broadcastOn()
	{

	}

	/**
	 * Get the data to broadcast.
	 *
	 * @return array
	 */
	public function broadcastWith()
	{
		return [

		];
	}
}
