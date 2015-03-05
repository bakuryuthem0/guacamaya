<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@getIndex');
Route::get('iniciar-sesion','HomeController@getLogin');
Route::get('registro', 'AuthController@getRegister');
Route::post('registro/enviar','AuthController@postRegister');
Route::post('registro/buscar-municipio','AuthController@getState');
Route::post('registro/buscar-parroquia','AuthController@getParroquia');