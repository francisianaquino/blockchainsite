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
    
    Route::get('/announcement/create', 'AnnouncementController@create');
    Route::post('/announcement', 'AnnouncementController@store');

    Route::post('/review', 'ReviewController@store');
});

Route::get('/game/{id}', 'GameController@show');
Auth::routes(['verify' => true]);