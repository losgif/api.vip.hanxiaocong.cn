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

Route::group(['prefix' => '/', 'namespace' => 'Home'], function () {
    Route::get('/', "IndexController@index");
    Route::post('/upload', "IndexController@upload");
});

Route::group(['prefix' => 'wechat', 'namespace' => 'Wechat'], function() {
    Route::any('serve', 'ServeController@serve');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/getAllInfo', 'HomeController@getAllInfo');

Route::get('/open', 'HomeController@open');

Route::get('/{school}', 'Home\IndexController@school');
