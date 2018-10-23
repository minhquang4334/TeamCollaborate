<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['domain' => env('DOMAIN_LMS', 'localhost')], function () {
    Route::get('/', function () {
        return view('layouts.index');
    })->name('lms');
    Route::group(['namespace' => 'User\Auth'], function () {
        Route::get('user/auth/facebook-login', 'OAuthController@redirectToProvider');
        Route::get('oauth/facebook/callback', 'OAuthController@handleProviderCallback');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm');
    });

    Route::get('{path}', function () {
        return view('layouts.index');
    })->where('path', '(.*)');
});
