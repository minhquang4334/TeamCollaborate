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
        Route::get('/', function() {
            return redirect()->route('admin.login');
        });
        Route::post('login', ['as' => 'login', 'uses' => 'LoginController@authenticate']);
        Route::get('forgot-password', ['as' => 'forgot_password', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
        Route::post('email', ['as' => 'email', 'uses' => 'ForgotPasswordController@sendResetLinkEmail']);
        Route::get('get-reset/{token}', ['as' => 'get-reset', 'uses' => 'ResetPasswordController@showResetForm']);
        Route::post('reset', ['as' => 'reset', 'uses' => 'ResetPasswordController@reset']);

        Route::get('changePassword', ['as' => 'changePassword', 'uses' => 'ChangePasswordController@showChangePasswordForm']);
        Route::post('changePassword', ['as' => 'changePassword', 'uses' => 'ChangePasswordController@changePassword'])->name('changePassword');
    });

    Route::group(['middleware' => 'admin'], function () {
//        Route::resource('admin-manager', 'AdminManageController')->middleware('admin.level');
//        Route::group(['middleware' => 'admin.level', 'prefix' => 'admin-manager'], function(){
//            Route::post('store', 'AdminManageController@store');
//            Route::put('{$id}', 'AdminManageController@update');
//            Route::delete('{$id}', 'AdminManageController@destroy');
//        });
//        Route::put('update-admin-status',['as' => 'update-admin-status', 'uses' => "AdminManageController@updateStatus"]);
//
        Route::get('dashboard',['as' => 'home', 'uses' => 'UserController@index']);
//        Route::get('user-manager',['as' => 'user-manager', 'uses' => 'UserController@index']);
        Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
//        Route::put('update-status',"UserController@updateStatus");
//
//        Route::get('users/{id}',"UserController@detail");
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
