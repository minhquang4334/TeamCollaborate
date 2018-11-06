<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'User\Auth', 'prefix' => 'email', 'as' => 'verification'], function() {

});

Route::group(['namespace' => 'User', 'prefix' => 'user'], function () {

    Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {

        Route::get('redirect-homepage', 'AuthController@redirectHomepage');
        Route::get('login-facebook', 'AuthController@loginFacebook');
        Route::group(['middleware' => 'guest:api'], function () {
            Route::post('login', 'AuthController@login');
            Route::post('register', 'RegisterController@register');
            Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
            Route::post('password/reset', 'ResetPasswordController@reset')->name('password.reset');
        });
        Route::group(['middleware' => 'jwt.auth'], function () {
            Route::post('logout', 'AuthController@logout')->middleware('verified');
            Route::get('me', 'AuthController@me');

        });
    });

    Route::group(['middleware' => 'jwt.auth'], function() {
        Route::get('check', 'UserController@check');
        Route::group(['namespace' => 'Auth', 'prefix' => 'verification'], function () {
            Route::get('resend', ['as' => 'resend', 'uses' => 'VerificationController@resend']);
            Route::get('verify', ['as' => 'notice', 'uses' => 'VerificationController@show']);
        });
    });
    Route::group(['namespace' => 'Auth'], function () {
        Route::get('verify/{id}', ['as' => 'verification.verify', 'uses' => 'VerificationController@verify']);
    });
});
