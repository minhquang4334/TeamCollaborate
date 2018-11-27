<?php

namespace App\Http\Requests\User;

use App\Abstracts\JsonFormRequest;

class CreateChannelRequest extends JsonFormRequest
{
    public function rules()
    {
        return [
        	'name'          => 'required|max:22',
            'purpose'       => 'required',
            'description'   => 'nullable',
            'type'          => 'nullable|integer|between:0,1',
        ];
    }
}
