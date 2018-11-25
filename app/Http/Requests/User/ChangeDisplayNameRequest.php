<?php

namespace App\Http\Requests\User;


use App\Abstracts\JsonFormRequest;

class ChangeDisplayNameRequest extends JsonFormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'display_name'  => 'required',
            'channel_id'    => 'required|integer',
        ];
    }
}
