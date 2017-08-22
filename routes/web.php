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
Route::get('/login', function () {
    return view('login');
});
Route::get('/signup', function () {
    return view('login');
});
Route::get('/admin', function () {
    return view('admin');
});

Route::get('/admin/{name}', function () {
    return view('admin');
})->where('name', '(topics)');

Route::get('/{name}', function () {
    return view('welcome');
})->where('name', '(test|grid|prueba|admin/topics)');



 Route::prefix('cvmanagerapi')->group(function () {
    Route::prefix('tests')->group(function () {
        Route::get('/test', 'TestController@test');
    });
    Route::post('/register', 'Auth\AuthController@register');   
    Route::post('/signin', 'Auth\AuthController@signin');   
    Route::get('/user','UserController@index');

    Route::prefix('topics')->group(function () {
        Route::get('/all', 'TopicController@all');
        Route::get('/edit/{id}', 'TopicController@edit');
        Route::post('/create', 'TopicController@create');
        Route::post('/search', 'TopicController@search');
        Route::put('/update/{id}', 'TopicController@update');
        Route::delete('/delete/{id}', 'TopicController@destroy');
    });



});