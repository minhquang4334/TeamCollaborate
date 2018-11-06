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

Route::group(['namespace' => 'User', 'prefix' => 'user'], function () {
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
        Route::get('redirect-homepage', 'AuthController@redirectHomepage');
        Route::get('login-facebook', 'AuthController@loginFacebook');
        Route::group(['middleware' => 'guest:api'], function () {
            Route::post('login', 'AuthController@login');
            Route::post('register', 'RegisterController@register');
            Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
            Route::post('password/reset', 'ResetPasswordController@reset');
        });
        Route::group(['middleware' => 'user:api'], function () {
            Route::post('logout', 'AuthController@logout');
            Route::get('me', 'AuthController@me');
        });
    });

});
