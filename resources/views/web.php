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
 


Route::get('/message/{id}', 'ChatController@chat');

Route::post('/message/{id}',['uses' => 'ChatController@messageOn','as' => 'messageOn']);

Route::get('/group', 'firstController@group')->name('group');
Route::get('/index','firstController@index');
Route::get('/connection', 'ConnectionController@connect')->name('connection');

Route::get('/network', 'NetworkController@network')->name('network');

Route::get('/chat', 'ChatController@chat');
Route::post('/question', 'ChatController@question')->name('chat');

Route::get('/filter', 'ConnectionController@filter')->name('filter');

Route::post('/person-filter', 'ConnectionController@personsFilter')->name('persons.filter');
Route::post('/factoid-type-filter', 'ConnectionController@factoidTypeFilter')->name('factoidType.filter');

Route::get('/', function(){
    return view('d3');
});