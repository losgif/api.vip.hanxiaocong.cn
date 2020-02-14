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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'upload'], function() {
    Route::post('/', 'UploadController@info');
    Route::post('info', 'UploadController@info');
    Route::post('image', 'UploadController@image');
});

Route::any('site/{school}', 'SiteController@show');
