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

Route::get('/admin', function () {
    return view('admin');
});

Route::get('/{name}', function () {
    return view('welcome');
})->where('name', '(test|grid|prueba)');



 Route::prefix('cvmanagerapi')->group(function () {
    Route::prefix('tests')->group(function () {
        Route::get('/test', 'TestController@test');
    });
    Route::prefix('topics')->group(function () {
        Route::get('/all', 'TopicController@all');
        Route::post('/create', 'TopicController@create');
        Route::post('/search', 'TopicController@search');
    });



});
