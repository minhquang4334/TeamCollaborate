<?php

namespace App\Events;

use App\Support\Transform;
use App\Transformers\PostTransformer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use League\Fractal\Manager;

class CommentWasLiked implements ShouldBroadcast
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
		$channel = new \App\Model\Channel();
		$channel = $channel->findOrFail($this->comment->channel_id);
		if($channel) {
			$channelId = $channel->channel_id;
			//dd('channel.'.$channelId);
			return new PrivateChannel('channel.'.$channelId);
		}
	}


	public function broadcastWith()
	{
		$manager = new Manager();
		$transform = new Transform($manager);
		return [
			'data' => $transform->item($this->comment, new PostTransformer())
		];
	}

	public function broadcastAs()
	{
		return 'CommentWasLiked';
	}
}
