<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|


Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('/devEnv', 'myController@index');
*/

/*Route::get('/', function(){
    return 'hier findet man nichts..';
});
Route::get('/devEnv', 'PagesController@index');
Route::get('/devEnv/about', 'PagesController@about');*/

/*Modelbinding*/
//Ohne Route binding, muss das in jeder controller funktion eingebunden werden.
$router->bind('songs', function($slug) {
    return App\Songs::where('slug', $slug)->first();
});

Route::get('/', 'WelcomeController@index');

/*Route::get('songs', 'SongsController@index');

Route::get('songs/add', 'SongsController@add'); //aufpassen wegen wildcard
Route::patch('songs/add', 'SongsController@insert');

Route::get('songs/{song}', 'SongsController@show');
Route::get('songs/{song}/edit', 'SongsController@edit');
Route::patch('songs/{song}', 'SongsController@update');
*/
$router->resource('songs', 'SongsController', [
    'names' =>[
        'index' => 'songs_path',
        'create' => 'song_create_path',
        'show' => 'song_path',
        'edit' => 'song_edit_path',
        'update' => 'song_update_path',
        'store' => 'song_store_path',
        'destroy' => 'song_destroy_path'
    ]
]);

//Example of custom Routes
//$router->get('example', ['as' => 'example', 'uses' => 'ExampleController@index']);

