<?php

/**
 * Created by PhpStorm.
 * User: john
 * Date: 27.09.2018
 * Time: 23:25
 */

/******************************** MAIN - PUBLIC *****************************************/
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::post('/login', 'Auth\LoginController@login');
Route::post('/signup', 'Auth\RegisterController@register');
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('restore');
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset');

Route::group(['middleware' => ['touchUser'], 'as' => 'frontend::', 'namespace' => 'Main\Frontend'], function(){

    Route::get('/', 'IndexController@index')->name('home');

    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::get('/profile/settings', 'ProfileController@settings')->name('profile-settings');
    Route::post('/profile/uploadImage', 'ProfileController@uploadImage');
    Route::post('/profile/update', 'ProfileController@update')->name('profile-update');

    Route::get('/pay', 'PaymentController@index')->name('payment');

    Route::get('/logout', 'LogoutController@logout')->name('logout');
});

Route::post('/feedback', 'Main\Frontend\IndexController@feedback');

/******************************** MAIN - ADMIN *****************************************/

Route::get('/admin/login', 'Auth\LoginAdminController@showLoginForm');
Route::post('/admin/login', 'Auth\LoginAdminController@login');
Route::get('/admin/logout',['as' => 'admin.logout','uses' => 'Auth\LoginController@logout']);

Route::group([
    'middleware' => ['checkAdmin', 'touchUser'],
    'as' => 'backend::',
    'prefix' => 'admin',
    'namespace' => 'Main\Backend'], function(){

    Route::get('/', 'VueController@index')->name('admin');

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::delete('/log/{id}', 'DashboardController@deleteLog');
    Route::delete('/message/{id}', 'DashboardController@deleteMessage');
    Route::post('/message/read/{id}', 'DashboardController@readMessage');

    Route::get('/users/search', 'UsersController@search')->name('search');
    Route::resource('/users', 'UsersController',
        ['except' => ['create', 'edit']]
    );

    Route::get('/articles/search', 'ArticleController@search')->name('search');
    Route::post('/articles/upload', 'ArticleController@upload')->name('upload');
    Route::resource('/articles', 'ArticleController',
        ['except' => ['create', 'edit']]
    );

    Route::resource('/categories', 'CategoryController',
        ['except' => ['edit', 'create']]
    );

    Route::get('/comments/search', 'CommentController@search')->name('search');
    Route::resource('/comments', 'CommentController',
        ['except' => ['edit', 'create']]
    );

    Route::resource('/meta', 'MetaController',
        ['except' => ['edit', 'create']]
    );

    Route::post('/send', 'VueController@testmail');
});

