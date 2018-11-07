<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
//use App\Http\Requests\user\LoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    public function __construct()
    {
        $this->middleware('user')->except(['showLoginForm','authenticate']);
    }

    protected function guard()
    {
        return Auth::guard('user');
    }

    protected $redirectTo = '/user';

    public function showLoginForm()
    {
        if (Auth::guard('user')->check()) {
            return redirect()->route('user.home');
        }
        return view('user.auth.login');
    }

    public function authenticate(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $remember = $request->has('remember_token') ? true : false;
        if (Auth::guard('user')->attempt(['email' => $email, 'password' => $password], $remember)) {
            return redirect()->route('user.home');
        }
        return redirect()->back()->withErrors(['error' => trans('messages.login_failed')]);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        return redirect()->route('user.login');
    }

    protected function redirectTo()
    {
        return '/path';
    }
}
