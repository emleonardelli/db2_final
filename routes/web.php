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

Route::get('/clientes/tarjetas/', 'TarjetaController@index')->name('tarjetas');
Route::post('/clientes/tarjetas/', 'TarjetaController@save');
Route::delete('/clientes/tarjetas/', 'TarjetaController@remove');

Route::get('/clientes', 'ClienteController@index')->name('clientes');
Route::post('/clientes', 'ClienteController@save');
Route::delete('/clientes', 'ClienteController@remove');

Route::get('/categorias', 'CategoriaController@index')->name('categorias');
Route::post('/categorias', 'CategoriaController@save');
Route::delete('/categorias', 'CategoriaController@remove');

Route::get('/marcas', 'MarcaController@index')->name('marcas');
Route::post('/marcas', 'MarcaController@save');
Route::delete('/marcas', 'MarcaController@remove');

Route::get('/productos', 'ProductoController@index')->name('productos');
Route::post('/productos', 'ProductoController@save');
Route::delete('/productos', 'ProductoController@remove');

Route::get('/carrito', 'SaleController@carrito')->name('carrito');
Route::get('/carrito/guardar', 'SaleController@saveCarrito');
Route::get('/carrito/borrar', 'SaleController@deleteCarrito');

Route::get('/ventas', 'SaleController@payments')->name('ventas');
Route::get('/venta/pagar/{carrito_id}', 'SaleController@payCarrito');
Route::get('/venta/guardar', 'SaleController@savePayment');