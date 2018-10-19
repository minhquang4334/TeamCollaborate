<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\LoginRequest;
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
        $this->middleware('admin')->except(['showLoginForm','authenticate']);
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected $redirectTo = '/admin';

    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.home');
        }
        return view('admin.auth.login');
    }

    /**
     * Create a new controller instance.
     *
     * @return
     *
     */
    public function authenticate(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        $remember = $request->has('remember_token') ? true : false;
        if (Auth::guard('admin')->attempt(['email' => $email, 'password' => $password], $remember)) {
            return redirect()->route('admin.home');
        }
        return redirect()->back()->withErrors(['error' => trans('messages.login_failed')]);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        return redirect()->route('admin.login');
    }
}
