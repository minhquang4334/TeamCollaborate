<?php

namespace App\Http\Requests\User;

use App\Abstracts\JsonFormRequest;

class UpdateChannelRequest extends JsonFormRequest
{
    public function rules()
    {
        return [
            'channel_id'    => 'unique:channels,channel_id',
            'type'          => 'integer|between:0,1',
        ];
    }
}
