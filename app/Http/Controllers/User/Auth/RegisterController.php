<?php

namespace App\Http\Controllers\User\Auth;

//use App\Http\Requests\User\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'gender' => $request->gender
        ]);

        $token = $this->guard()->login($user);

        return response()->json([
            'message' => trans('messages.user.register_success'),
            'data' => [
                'token' => $token
            ]
        ]);
    }

    public function guard()
    {
        return Auth::guard('api');
    }
}
