<?php

namespace App\Transformers;
use App\model\Channel;
use League\Fractal\TransformerAbstract;

class ChannelTransformer extends TransformerAbstract {

    public function transform(Channel $channel) {
        return [
            'type' => $channel->type,
            'creator' => $channel->creator,
            'purpose' => $channel->purpose,
            'description' => $channel->description,
            'status' => $channel->status,
            'channel_id' => $channel->channel_id
        ];
    }
}