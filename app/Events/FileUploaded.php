<?php

namespace App\Events;

use App\Support\Transform;
use App\Transformers\FileTransformer;
use App\Transformers\PostTransformer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use League\Fractal\Manager;

class FileUploaded implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $file;
	public $channel_id;

	public function __construct($file, $channel_id)
	{
		$this->file = $file;
		$this->channel_id = $channel_id;

		$this->dontBroadcastToCurrentUser();
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return Channel|array
	 */
	public function broadcastOn()
	{
		return new PrivateChannel('channel.'.$this->channel_id);
	}


	public function broadcastWith()
	{
		$manager = new Manager();
		$transform = new Transform($manager);
		return [
			'data' => $transform->item($this->file, new FileTransformer())
		];
	}

	public function broadcastAs()
	{
		return 'FileUploaded';
	}
}
