<?php

namespace App\Http\Controllers\User\Auth;

//use App\Http\Requests\User\LoginRequest;
//use App\Http\Requests\StoreTeacherRequest;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Get a JWT token via given credentials.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        if ($token = $this->guard()->attempt(['email' => $request->email, 'password' => $request->password, 'status' => User::ACTIVE, 'deleted_at' => null])) {
            return $this->respondWithToken($token);
        }

        return response()->json(['login-failed' => trans('auth.failed')], self::CODE_UNAUTHORIZED);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user(), self::CODE_GET_SUCCESS);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => trans('messages.user.logout_success')], self::CODE_UPDATE_SUCCESS);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token
        ], self::CODE_GET_SUCCESS);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }

    public function redirectHomepage()
    {
        $urlHomepage = route('home');
        return response()->json([
            'urlHomepage' => $urlHomepage
        ], self::CODE_GET_SUCCESS);
    }

    public function loginFacebook()
    {
        $urlLoginFB = $_SERVER['HTTP_HOST'] . '/user/auth/facebook-login';
        return response()->json([
            'urlLoginFB' => $urlLoginFB
        ], self::CODE_GET_SUCCESS);
    }
}
