<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/




Route::any('wrong-url', [
    'as' => 'wrong-url',
    'uses' => 'HomeController@wrong_url'
]);


/************** - Candidate Login - **************/

Route::get('candidate', [
    'as' => 'candidate',
    'uses' => 'Auth\AuthController@candidate_login_page'
]);

Route::any('post-candidate-login', [
    'as' => 'post-candidate-login',
    'uses' => 'Auth\AuthController@post_candidate_login'
]);

Route::any('candidate-logout/{id}', [
    //'middleware' => 'acl_access:user/delete-user/{id}',
    'as' => 'candidate-logout',
    'uses' => 'Auth\AuthController@candidate_logout'
]);

/************** - Candidate Login - **************/

Route::any('/', [
    'as' => 'dashboard',
    'uses' => 'HomeController@dashboard'
]);

Route::get('admin', [
    'as' => 'admin',
    'uses' => 'Auth\AuthController@getLogin'
]);

Route::any('post-user-login', [
    'as' => 'post-user-login',
    'uses' => 'Auth\AuthController@postLogin'
]);

Route::any('reset-password/{user_id}', [
    'as' => 'reset-password',
    'uses' => 'Auth\AuthController@reset_password'
]);

Route::any('update-new-password', [
    'as' => 'update-new-password',
    'uses' => 'Auth\AuthController@update_new_password'
]);


Route::group(['middleware' => 'auth'], function()
{

    Route::any('/', [
        'as' => 'dashboard',
        'uses' => 'HomeController@dashboard'
    ]);

    Route::any('dashboard', [
        'as' => 'dashboard',
        'uses' => 'HomeController@dashboard'
    ]);

    Route::any('all_routes_uri', [
        'as' => 'all_routes_uri',
        'uses' => 'HomeController@all_routes_uri'
    ]);

});
