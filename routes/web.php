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
    return view('welcome');
});

Route::group(['prefix' => '/test'], function(){

    Route::get('/','TestController@index');

    Route::get('/publishArticle','TestController@publishArticle');

    Route::get('/postMessage','TestController@postMessage');

    Route::get('/deleteMessage','TestController@deleteMessage');

});
