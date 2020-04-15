<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// User Routes
Route::group(['prefix' => 'user'] , function() {
    Route::post('create', 'UserController@create')->name('create');
    Route::get('get', 'UserController@get')->name('get');
    Route::post('update', 'UserController@update')->name('update');
    Route::get('getOne/{id}', 'UserController@getOne')->name('getOne');
    Route::get('delete/{id}', 'UserController@delete')->name('delete');
    Route::post('login', 'UserController@login')->name('create');
});

// Photo Routes
Route::group(['prefix' => 'photo'] , function() {
    Route::post('create', 'PhotoController@create')->name('create');
    Route::get('get', 'PhotoController@get')->name('get');
    Route::post('update', 'PhotoController@update')->name('update');
    Route::get('getOne/{id}', 'PhotoController@getOne')->name('getOne');
    Route::get('delete/{id}', 'PhotoController@delete')->name('delete');
});

// Comment Routes
Route::group(['prefix' => 'comment'] , function() {
    Route::post('create', 'CommentController@create')->name('create');
    Route::get('get', 'CommentController@get')->name('get');
    Route::post('update', 'CommentController@update')->name('update');
    Route::get('getOne/{id}', 'CommentController@getOne')->name('getOne');
    Route::get('delete/{id}', 'CommentController@delete')->name('delete');
});

