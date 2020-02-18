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

Route::group([
    'namespace' => 'Api'
], function () {
    Route::group(['prefix' => 'upload'], function() {
        Route::any('/', 'UploadController@info');
        Route::any('info', 'UploadController@info');
        Route::any('image', 'UploadController@image');
    });

    Route::group(['prefix' => 'site'], function() {
        Route::any('{schoolApplication}', 'SiteController@show');
    });
    
    Route::group([
        'prefix' => 'oauth'
    ], function () {
        Route::any('login', 'OauthController@login');
        Route::any('register', 'OauthController@register');
        Route::any('userInfo', 'OauthController@userInfo');
        Route::any('wechat', 'OauthController@loginByWechat');

        Route::any('sendVerificationCode', 'OauthController@sendVerificationCode');
        Route::any('setUserInfo', 'OauthController@setUserInfo')->middleware('auth:api');
        Route::any('reset', 'OauthController@reset');
    });

    Route::group(['prefix' => 'weixiao'], function() {
        Route::any('/', 'WeixiaoController@index');
        Route::any('{apiKey}', 'WeixiaoController@index');
    });

    Route::group([
        'prefix' => 'information'
    ], function () {
        Route::any('search', 'InformationController@search');
        Route::get('preview', 'InformationController@preview');
    });
});

Route::group([
    'namespace' => 'Api',
    'middleware' => [
        'auth:api'
    ]
],function () {
    Route::group([
        'prefix' => 'user',
    ], function () {
        Route::any('search', 'UserController@search');
        Route::any('assignRole', 'UserController@assignRole');
        Route::any('getInfo', 'UserController@getInfo');
    });

    Route::group([
        'prefix' => 'workplace'
    ], function () {
        Route::any('applications', 'WorkplaceController@applications');
        Route::any('activity', 'WorkplaceController@activity');
        Route::any('data', 'WorkplaceController@data');
    });

    Route::group([
        'prefix' => 'information'
    ], function () {
        Route::any('indexByApplicationId', 'InformationController@indexByApplicationId');
        Route::any('batchDelete', 'InformationController@batchDelete');
    });

    Route::group([
        'prefix' => 'application'
    ], function () {
        Route::any('indexByApplicationId', 'ApplicationController@indexByApplicationId');
    });


    Route::apiResources([
        'information' => 'InformationController',
        'schoolApplication' => 'SchoolApplicationController',
    ]);
});
