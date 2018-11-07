<?php

namespace App\Http\Requests\User;

use App\Abstracts\JsonFormRequest;

class RegisterRequest extends JsonFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'gender' => 'boolean',
        ];
    }
}
