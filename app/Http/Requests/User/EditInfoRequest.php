<?php

namespace App\Http\Requests\User;

use App\Abstracts\JsonFormRequest;

class EditInfoRequest extends JsonFormRequest
{
    public function rules()
    {
        return [
            'status'        =>'integer|between:0,3',
            'phone_number'  => 'regex:/(0)[0-9]{9}/',
            'name'          => 'string',
            'japanese_level' => 'nullable',
            'japanese_certificate' => 'nullable',
            'is_teacher' => 'integer|between:0,1|nullable',
            'is_bachelor' =>'integer|between:0,1',
            'grade' =>'integer',
            'gender' => 'integer|between:0,1',
            'facebook_url' => 'url',
            'email' => 'email',
            'birthday' => 'date',
            'address' => 'nullable',
            'about_me' => 'nullable',
        ];
    }
}
