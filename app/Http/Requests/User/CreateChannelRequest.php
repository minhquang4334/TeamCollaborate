<?php

namespace App\Http\Requests\User;

use App\Abstracts\JsonFormRequest;

class CreateChannelRequest extends JsonFormRequest
{
    public function rules()
    {
        return [
            'channel_id'    => 'required|unique:channels,channel_id',
            'purpose'       => 'required',
            'description'   => 'required',
            'type'          => 'required|integer|between:0,1',
        ];
    }
}
