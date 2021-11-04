<?php

use Illuminate\Support\Facades\Route;

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
    return redirect(action('GameController@index'));
});

Route::get('/game', 'GameController@index');

Route::group(['middleware' => ['auth', 'verified']], function() {
    Route::get('/game/create', 'GameController@create');
    Route::post('/game', 'GameController@store');
    Route::get('/game/pending', 'GameController@pending');
    Route::get('/game/pending/{id}', 'GameController@approve');
    Route::get('/game/{id}/edit', 'GameController@edit');
    Route::post('/game/{id}/update', 'GameController@update');
    Route::get('/game/{id}/destroy', 'GameController@destroy');

    Route::get('/genre', 'GenreController@index');
    Route::post('/genre', 'GenreController@store');
    Route::get('/genre/{id}/destroy', 'GenreController@destroy');

    Route::get('/blockchain', 'BlockchainController@index');
    Route::post('/blockchain', 'BlockchainController@store');
    Route::get('/blockchain/{id}/destroy', 'BlockchainController@destroy');
    
    Route::get('/announcement/create', 'AnnouncementController@create');
    Route::post('/announcement', 'AnnouncementController@store');

    Route::post('/review', 'ReviewController@store');

    Route::get('/user', 'UserController@index');
    Route::get('/user/{id}/edit', 'UserController@edit');
    Route::post('/user/{id}/update', 'UserController@update');
    Route::get('/user/{id}/destroy', 'UserController@destroy');

    Route::get('/profile', 'ProfileController@index');
    Route::post('/profile', 'ProfileController@update');
});

Route::get('/game/{id}', 'GameController@show');

Auth::routes(['verify' => true]);