<?php

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
            Route::post('logout', 'AuthController@logout');
            Route::get('me', 'AuthController@me');
        });
    });

    Route::group(['middleware' => 'jwt.auth'], function() {
        Route::group(['namespace' => 'Auth', 'prefix' => 'verification'], function () {
            Route::get('resend', ['as' => 'resend', 'uses' => 'VerificationController@resend']);
            Route::get('verify', ['as' => 'notice', 'uses' => 'VerificationController@show']);

        });
    });
});

Route::group(['namespace' => 'Api'], function () {
	Route::group(['middleware' => 'jwt.auth'], function() {
		Route::get('/emojis', 'EmojiController@index');
		Route::post('/invite-to-app', 'InviteToAppController@create');
        Route::group(['prefix' => 'channel', 'as' => 'channel'], function (){
            Route::post('create',['as' => 'create', 'uses' => 'ChannelApiController@create'] );
            Route::get('info', 'ChannelApiController@getChannelInfo');
            Route::get('my', 'ChannelApiController@getListChannelOfUser');
            Route::get('list', 'ChannelApiController@getListChannel');
            Route::put('update', 'ChannelApiController@update');
            Route::delete('destroy', 'ChannelApiController@destroy');
            Route::post('invite', 'ChannelApiController@invite');
            Route::put('leave', 'ChannelApiController@leave');
            Route::delete('ban', 'ChannelApiController@removeUserFromChannel');
        });
        Route::group(['prefix' =>'user', 'as' => 'user-info'], function (){
            Route::put('update', 'UserApiController@changeUserProfile');
            Route::put('change-password', 'UserApiController@changePassword');
            Route::get('list', 'UserApiController@getListUser');
            Route::delete('delete', 'UserApiController@deleteAccount');
            Route::get('users', 'UserApiController@getListUserInChannel');
            Route::put('change-name', 'UserApiController@changeDisplayName');
            Route::post('avatar', 'UserApiController@changeUserAvatar');
	        Route::post('subscriptions', 'PushSubscriptionApiController@update');
	        Route::delete('subscriptions/delete', 'PushSubscriptionApiController@destroy');
            Route::get('get-notifications', 'NotificationApiController@index');
	        Route::post('notifications', 'NotificationApiController@store');
	        Route::patch('notifications/{id}/read', 'NotificationApiController@markAsRead');
	        Route::post('notifications/mark-all-read', 'NotificationApiController@markAllRead');
	        Route::post('notifications/{id}/dismiss', 'NotificationApiController@dismiss');

        });
        Route::group(['prefix' => 'post', 'as' => 'post'], function (){
            Route::post('add', 'PostApiController@add');
            Route::get('list', 'PostApiController@getList');
            Route::put('update', 'PostApiController@update');
            Route::delete('destroy', 'PostApiController@destroy');
            Route::post('pin', 'PostApiController@pin');
            Route::put('edit', 'PostApiController@edit');
            Route::get('pinned', 'PostApiController@getPinned');
            Route::delete('unfollow', 'PostApiController@unFollow');
            Route::post('follow', 'PostApiController@follow');
            Route::post('report', 'PostApiController@report');
            Route::post('like', 'PostApiController@like');
            Route::get('list-comment', 'PostApiController@getListComment');

        });

        Route::group(['prefix' => 'file', 'as' => 'file'], function (){
            Route::post('upload', 'FileApiController@upload');
            Route::get('list', 'FileApiController@getListFile');
            Route::delete('delete', 'FileApiController@removeFile');
            Route::get('path', 'FileApiController@getFilePath');
        });
	});
});
