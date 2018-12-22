<?php

namespace App\Transformers;
use App\Model\Channel;
use App\Model\User;
use League\Fractal\TransformerAbstract;

class ChannelTransformer extends TransformerAbstract {

	protected $defaultIncludes  = [
		'users', 'pin_posts', 'files'
	];

    public function transform(Channel $channel) {
        return [
            'type' => $channel->type,
            'id' => $channel->id,
            'creator' => $channel->creator,
            'purpose' => $channel->purpose,
            'description' => $channel->description,
            'name' => $channel->name,
            'status' => $channel->status,
	        'created_at' => $channel->created_at,
            'channel_id' => $channel->channel_id,
        ];
    }

	/**
	 * Include Users
	 *
	 * @param Channel $channel
	 * @return \League\Fractal\Resource\Collection
	 */
	public function includeUsers(Channel $channel)
	{
		if ($users = $channel->users) {
			//dd("users".$users);
			return $this->collection($users, new UserTransformer());
		}
	}

	public function includePinPosts(Channel $channel)
	{
		if ($posts = $channel->posts()->pin()->get()) {
			//dd("users".$users);
			return $this->collection($posts, new PostTransformer());
		}
	}

	public function includeFiles(Channel $channel) {
		if ($files = $channel->files()->get()) {
			return $this->collection($files, new FileTransformer());
		}
	}

}
