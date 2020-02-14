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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/clientes', 'ClienteController@index')->name('clientes');
Route::post('/clientes', 'ClienteController@save');
Route::delete('/clientes', 'ClienteController@remove');

Route::get('/productos', 'ProductoController@index')->name('productos');
Route::post('/productos', 'ProductoController@save');
Route::delete('/productos', 'ProductoController@remove');
