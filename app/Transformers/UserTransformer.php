<?php

namespace App\Transformers;
use App\Model\User;
use Illuminate\Support\Facades\Storage;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract {

    public function transform(User $user) {
        return [
        	'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'gender' => $user->gender,
            'phone_number' => $user->phone_number,
            'address' => $user->address,
            'job' => $user->job,
            'japanese_level' => $user->japanese_level,
            'japanese_certificate' => $user->japanese_certificate,
            'about_me' => $user->about_me,
            'facebook_url' => str_after($user->facebook_url, 'https://facebook.com/'),
            'avatar' => ($user->avatar),
            'email_verified_at' => $user->email_verified_at,
            'google_id' => $user->google_id,
            'status' => $user->status,
            'university' => $user->university,
            'is_bachelor' => $user->is_bachelor,
            'is_teacher' => $user->is_teacher,
            'grade' => $user->grade,
            'role' => $user->role,
            'is_admin' => $user->is_admin,
	        'created_at' => $user->created_at,
	        'updated_at' => $user->updated_at,
        ];
    }
}
