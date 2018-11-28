<?php

namespace App\Transformers;
use App\Model\Channel;
use App\Model\User;
use League\Fractal\TransformerAbstract;

class ChannelTransformer extends TransformerAbstract {

	protected $defaultIncludes  = [
		'users'
	];

    public function transform(Channel $channel) {
        return [
            'type' => $channel->type,
            'creator' => $channel->creator,
            'purpose' => $channel->purpose,
            'description' => $channel->description,
            'name' => $channel->name,
            'status' => $channel->status,
            'channel_id' => $channel->channel_id
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

}
