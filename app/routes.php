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

Route::get('articulo/{id}','HomeController@getShowItem');

Route::get('administrador', 'AdminController@getLogin');
Route::post('administrador/iniciar-sesion/autenticar','AdminController@postLogin');

Route::group(array('before' =>'auth'),function()
{
	/*Rutas del carrito*/
	Route::post('articulo/agregar-al-carrito','ItemController@getItem');
	Route::post('vaciar-carrito', 'ItemController@dropCart');
	Route::post('quitar-item', 'ItemController@dropItem');
	Route::post('agregar-item', 'ItemController@addItem');
	
	Route::group(array('before' => 'check_role'), function(){
		Route::get('administrador/inicio','AdminController@getIndex');
		/*Nuevos articulos*/
		Route::get('administrador/nuevo-articulo','AdminController@getNewItem');
		Route::post('administrador/categoria/buscar-sub-categoria','AdminController@postCatSubCat');
		Route::post('administrador/nuevo-articulo/enviar','AdminController@postNewItem');
		Route::post('administrador/nuevo-articulo/imagenes/eliminar','AdminController@postDeleteImg');
		Route::get('administrador/nuevo-articulo/continuar/{id}/{misc_id}','AdminController@getContinueNew');
		Route::post('administrador/nuevo-articulo/continuar/enviar/{id}/{misc_id}','AdminController@postContinueNew');
		Route::post('administrador/nuevo-articulo/continuar/guardar-cerrar/{id}/{misc_id}','AdminController@postSaveNew');
		Route::post('administrador/nuevo-articulo/imagenes/procesar','AdminController@post_upload');
		/**/
		/*Ver articulos*/
		Route::get('administrador/ver-articulo', 'AdminController@getShowArt');
		Route::get('administrador/ver-articulo/{id}','HomeController@getShowItem');

		/*Categorias*/
		/*nueva*/
		Route::get('categoria/nueva','AdminController@getNewCat');
		Route::post('categoria/nueva/enviar', 'AdminController@postNewCat');
		/*Modificar*/
		Route::get('categoria/ver-categorias','AdminController@getModifyCat');
		Route::get('administrador/ver-categoria/{id}','AdminController@getModifyCatById');
		Route::post('administrador/ver-categoria/modificar/{id}','AdminController@postModifyCatById');
		/*Eliminar*/
		Route::post('categoria/eliminar','AdminController@postElimCat');
		//nueva sub-categoria
		Route::get('categoria/nueva-sub-categoria','AdminController@getNewSubCat');
		Route::post('sub-categoria/nueva/enviar','AdminController@postNewSubCat');
		//ver
		Route::get('sub-categoria/ver-sub-categorias', 'AdminController@getModifySubCat');
		Route::get('administrador/ver-sub-categoria/{id}','AdminController@getModifySubCatById');
		Route::post('administrador/ver-sub-categoria/modificar/{id}','AdminController@postModifySubCatById');
		//eliminar
		Route::post('sub-categoria/eliminar','AdminController@postElimSubCat');
		/**/
		/*Colores*/
		//nuevo
		Route::get('color/nuevo', 'AdminController@getNewColor');
		Route::post('color/nuevo/enviar','AdminController@postNewColor');
		//ver
		Route::get('colores/ver-colores', 'AdminController@getModifyColor');
		//Modificar
		Route::get('administrador/ver-color/{id}','AdminController@getModifyColorById');
		Route::post('administrador/ver-color/modificar/{id}','AdminController@postModifyColorById');

		//eliminar
		Route::post('colores/eliminar','AdminController@postElimColor');
	});

});

Route::post('chequear/email','AuthController@postEmailCheck');
Route::get('cerrar-sesion','AuthController@logOut');
Route::get('registro', 'AuthController@getRegister');
Route::get('registro/verificar-codigo/{username}/{codigo}', 'AuthController@getCode');
Route::post('registro/enviar','AuthController@postRegister');
Route::post('registro/buscar-municipio','AuthController@getState');
Route::post('registro/buscar-parroquia','AuthController@getParroquia');
