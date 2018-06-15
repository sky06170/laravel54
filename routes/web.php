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

Route::group(['prefix' => '/vue'], function(){
    Route::get('/hello', function () {
        return view('hello');
    });
    Route::get('/count', function () {
        return view('count');
    });
    Route::get('/article/{id}', function () {
        return view('article');
    });
    Route::get('/draggable', function () {
        return view('draggable');
    });
});

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['prefix' => '/test'], function(){

    Route::get('/','TestController@index');

    // Route::get('/publishArticle','TestController@publishArticle');

    // Route::get('/deleteArticle','TestController@deleteArticle');

    // Route::get('/postMessage','TestController@postMessage');

    // Route::get('/deleteMessage','TestController@deleteMessage');

});

Route::get('sendmail', function() {
    $data = ['name' => 'Test'];
    Mail::send('welcome', $data, function($message) {
    $message->to('rick.su@juksy.com')->subject('This is test email');
 });
 return 'Your email has been sent successfully!';
});

Route::group(['prefix' => 'youtube'], function(){

	Route::get('/', 'YoutubeController@index');

	Route::get('/watch', 'YoutubeController@watch');

});

Route::group(['prefix' => 'elastic'], function(){

	Route::get('/', 'ElasticController@index');

	Route::get('/{id}/edit', 'ElasticController@edit');

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
