<?php

namespace App\Http\Controllers\User\Auth;

use App\Events\OauthRegistered;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'gender' => $request->gender
        ]);

        $token = JWTAuth::fromUser($user);
		event(new OauthRegistered($user));
        return response()->json([
            'message' => trans('messages.user.register_success'),
            'data' => [
                'token' => $token
            ]
        ], 201);
    }

    public function guard()
    {
        return Auth::guard('api');
    }
}
