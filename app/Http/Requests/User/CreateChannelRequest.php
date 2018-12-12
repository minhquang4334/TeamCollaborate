<?php

namespace App\Http\Requests\User;

use App\Abstracts\JsonFormRequest;

class CreateChannelRequest extends JsonFormRequest
{
    public function rules()
    {
        return [
            'purpose'       => 'required',
            'description'   => 'nullable',
            'type'          => 'nullable|integer|between:0,2',
        ];
    }
}
