<?php

namespace App\Http\Controllers\User\Auth;

//use App\Http\Requests\User\ResetPasswordRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $token;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('user.app');
    }

    public function reset(Request $request)
    {
        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($response)
            : $this->sendResetFailedResponse($request, $response);
    }

    protected function sendResetResponse($response)
    {
        return response()->json([
            'message' => trans('messages.user.password_reset_success'),
            'data' => [
                'token' => $this->token
            ]
        ], self::CODE_GET_SUCCESS);
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response()->json([
            'message' => trans('messages.user.password_reset_fail'),
            'data' => []
        ], self::CODE_BAD_REQUEST);
    }

    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);

        $user->save();

        $this->token = $this->guard()->login($user);
    }

    protected function guard()
    {
        return Auth::guard('api');
    }
}
