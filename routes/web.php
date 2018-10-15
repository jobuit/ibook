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

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Busca alimentos de la base de datos
Route::get('buscarLibros', 'HomeController@buscarLibros')->name('buscarLibros');
//alquilar libro
Route::get('alquilarLibro', 'HomeController@alquilarLibro')->name('alquilarLibro');
//mis reservas
Route::get('reservas', 'ReservasController@index')->name('reservas');
Route::get('buscarAlquilados', 'ReservasController@buscarAlquilados')->name('buscarAlquilados');
Route::get('retornarLibro', 'ReservasController@retornarLibro')->name('retornarLibro');
Route::get('buscarAutor', 'HomeController@buscarAutor')->name('buscarAutor');