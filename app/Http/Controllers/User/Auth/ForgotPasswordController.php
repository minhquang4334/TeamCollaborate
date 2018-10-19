<?php

namespace App\Http\Controllers\User\Auth;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest:web');
    }

    protected function validateEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email'],
            ['email.required' => 'Vui lòng nhập email', 'email.email' => 'Email không đúng định dạng']);
    }

    protected function sendResetLinkResponse($response)
    {
        return response()->json([
            'message' => trans('messages.user.reset_password_email_sent'),
            'data' => []
        ], self::CODE_GET_SUCCESS);
    }

    protected function sendResetLinkFailedResponse()
    {
        return response()->json([
            'message' => trans('messages.user.wrong_email'),
            'data' => []
        ], self::CODE_BAD_REQUEST);
    }

    public function broker()
    {
        return Password::broker('users');
    }
}
