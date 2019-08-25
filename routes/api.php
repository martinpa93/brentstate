<?php

use Illuminate\Http\Request;
use Carbon\Carbon;

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
Route::get('foo', function () {
     Artisan::call('notify:email', []);

    //
});
Route::group(['middleware' => ['api']], function () {
    Route::post('register', 'UserController@register');
    Route::post('login', 'UserController@login');
    
    Route::group(['middleware' => 'auth.jwt'], function () {
        Route::apiResources([
            'property' => 'PropertyController',
            'renter' => 'RenterController',
            'contract' => 'ContractController'
            ]);
        Route::get('propertiesAvaliable', 'PropertyController@indexByStatus');
        Route::post('upload', 'FileController@store');
        Route::get('notification', 'NotificationController@index');

        Route::get('logout', 'UserController@logout');
        Route::get('user', 'UserController@getUser');
    });   
});