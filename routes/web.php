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


Route::get('/', function () {
    return view('layouts.index');
})->name('home');

Route::group(['namespace' => 'Admin', 'as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::group(['namespace' => 'Auth', 'middleware' => 'guest'], function () {
        Route::get('login', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
        Route::get('/', 'LoginController@showLoginForm');
        Route::post('login', ['as' => 'login', 'uses' => 'LoginController@authenticate']);
        Route::get('forgot-password', ['as' => 'forgot_password', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
        Route::post('email', ['as' => 'email', 'uses' => 'ForgotPasswordController@sendResetLinkEmail']);
        Route::get('get-reset/{token}', ['as' => 'get-reset', 'uses' => 'ResetPasswordController@showResetForm']);
        Route::post('reset', ['as' => 'reset', 'uses' => 'ResetPasswordController@reset']);

        Route::get('changePassword', ['as' => 'changePassword', 'uses' => 'ChangePasswordController@showChangePasswordForm']);
        Route::post('changePassword', ['as' => 'changePassword', 'uses' => 'ChangePasswordController@changePassword'])->name('changePassword');
    });

    Route::group(['middleware' => 'admin'], function () {

        Route::get('dashboard',['as' => 'home', 'uses' => 'DashBoardController@index']);
        Route::get('dashboard/get-chart', 'DashBoardController@getChart');


        Route::get('/', 'UserManagerController@index');
        Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

        Route::get('users-manager',['as' => 'users-manager', 'uses' => 'UserManagerController@index']);
        Route::put('update-user-status',"UserManagerController@updateStatus");
        Route::get('users/{id}',"UserManagerController@detail");

        Route::get('channels-manager', ['as' => 'channels-manager', 'uses' => "ChannelManagerController@index"]);
        Route::put('update-channel-status', "ChannelManagerController@updateStatus");
        Route::get('channels/{id}', "ChannelManagerController@detail");
        Route::delete('channels/{id}', "ChannelManagerController@delete");

        Route::get('files-manager', ['as' => 'files-manager', 'uses' => "FileManagerController@index"]);
        Route::get('download/{id}', "FileManagerController@download");
        Route::delete('files/{id}', "FileManagerController@delete");
        Route::resource('reports-manager', "ReportManagerController");
    });
});


Route::group(['namespace' => 'User\Auth'], function () {
    Route::get('user/auth/facebook-login', 'OAuthController@redirectToProvider');
    Route::get('oauth/facebook/callback', 'OAuthController@handleProviderCallback');
    Route::get('#/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('user.rs_pwd_form');
    Route::get('/verify/{id}', ['as' => 'verification.verify', 'uses' => 'VerificationController@verify']);

});

Route::get('{path}', function () {
    return view('layouts.index');
})->where('path', '(.*)');
