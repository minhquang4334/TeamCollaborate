<?php

namespace App\Http\Requests\User;

use App\Abstracts\JsonFormRequest;

class FileRequest extends JsonFormRequest
{
    public function rules()
    {
        return [
            'file' => 'required|max:2048|mimes:jpg,jpeg,png,pdf,xls,xlsx,ppt,pptx,doc,docx,zip,msword',
        ];
    }
}
