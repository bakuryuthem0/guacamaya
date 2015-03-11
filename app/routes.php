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
Route::get('/', 'HomeController@getFront');
Route::get('inicio', 'HomeController@getIndex');
Route::group(array('before' =>'no_auth'),function()
{
	Route::get('iniciar-sesion','HomeController@getLogin');
	Route::post('iniciar-sesion/autenticar','AuthController@postLogin');
});

Route::get('administrador', 'AdminController@getLogin');
Route::post('administrador/iniciar-sesion/autenticar','AdminController@postLogin');
Route::group(array('before' =>'auth'),function()
{

	Route::group(array('before' => 'check_role'), function(){
		Route::get('administrador/inicio','AdminController@getIndex');
		/*Nuevos articulos*/
		Route::get('administrador/nuevo-articulo','AdminController@getNewItem');
		Route::post('administrador/nuevo-articulo/enviar','AdminController@postNewItem');
		Route::get('administrador/nuevo-articulo/continuar/{id}/{misc_id}','AdminController@getContinueNew');
		Route::post('administrador/nuevo-articulo/continuar/enviar/{id}/{misc_id}','AdminController@postContinueNew');
		Route::post('administrador/nuevo-articulo/continuar/guardar-cerrar/{id}/{misc_id}','AdminController@postSaveNew');
		Route::post('administrador/nuevo-articulo/imagenes/procesar','AdminController@post_upload');
		/**/
		/*Ver articulos*/
		Route::get('administrador/ver-articulo', 'AdminController@getShowArt');

		Route::get('administrador/ver-articulo/{id}','HomeController@getShowItem');
	});

});

Route::post('chequear/email','AuthController@postEmailCheck');
Route::get('cerrar-sesion','AuthController@logOut');
Route::get('registro', 'AuthController@getRegister');
Route::post('registro/enviar','AuthController@postRegister');
Route::post('registro/buscar-municipio','AuthController@getState');
Route::post('registro/buscar-parroquia','AuthController@getParroquia');
