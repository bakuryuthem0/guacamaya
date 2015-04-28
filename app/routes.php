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
Route::get('contactenos','HomeController@getContact');
Route::post('contactenos','HomeController@postContact');
Route::group(array('before' =>'no_auth'),function()
{
	Route::get('iniciar-sesion','HomeController@getLogin');
	Route::post('iniciar-sesion/autenticar','AuthController@postLogin');
});
Route::get('articulos/promocion/{id}','HomeController@getPromotions');

Route::get('articulo/{id}','HomeController@getShowItem');
Route::post('articulo/buscar/colores','HomeController@getColors');

Route::get('categorias/{subcat}/{id}','HomeController@getSubCatBuscar');
Route::get('categorias/{id}','HomeController@getCatBuscar');

Route::post('busqueda','HomeController@search');

Route::get('administrador', 'AdminController@getLogin');
Route::post('administrador/iniciar-sesion/autenticar','AdminController@postLogin');
Route::group(array('before' =>'auth'),function()
{
	/*Rutas del carrito*/
	Route::post('articulo/agregar-al-carrito','ItemController@getItem');
	Route::post('vaciar-carrito', 'ItemController@dropCart');
	Route::post('quitar-item', 'ItemController@dropItem');
	Route::post('agregar-item', 'ItemController@addItem');
	Route::post('restar-item','ItemController@restItem');

	Route::get('comprar/ver-carrito','ItemController@getCart');
	Route::post('actualizar-al-carrito', 'ItemController@getRefresh');
	Route::post('comprar/ver-carrito/enviar','ItemController@postDir');
	Route::post('comprar/ver-carrito/agragar-y-comprar','ItemController@postPurchaseAndNewDir');
	Route::get('compra/procesar/{id}','ItemController@getProcesePurchase');
	/*rutas usuario */
	Route::get('usuario/perfil','UserController@getProfile');
	Route::post('usuario/perfil/enviar','UserController@postProfile');
	Route::get('mis-compras/pago/enviar','ItemController@postPayment');

	Route::get('usuario/mis-compras','UserController@getMyPurchases');
	Route::get('usuario/ver-factura/{id}','UserController@getMyPurchase');
	Route::post('usuario/publicaciones/pago/enviar','ItemController@postSendPayment');

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
		Route::post('administrador/modificar-articulo','AdminController@postMdfItem');
		Route::post('administrador/modificar-miscelania','AdminController@postMdfMisc');
		Route::post('administrador/editar-articulo/eliminar-imagen','AdminController@postElimImg');
		Route::post('administrador/cambiar-imagen','AdminController@changeItemImagen');

		/**/
		/*Ver articulos*/
		Route::get('administrador/ver-articulo', 'AdminController@getShowArt');
		Route::get('administrador/ver-articulo/{id}','HomeController@getShowItem');
		Route::post('administrador/ver-articulo/eliminar','AdminController@postElimItem');
		Route::get('administrador/editar-articulo/{id}','AdminController@getMdfItem');
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
		//pagos
		Route::get('administrador/ver-pagos','AdminController@getPayment');
		Route::get('administrador/ver-factura/{id}','AdminController@getPurchases');
		Route::post('administrador/ver-pagos/aprovar','AdminController@postPaymentAprove');
		Route::post('administrador/ver-pagos/rechazar','AdminController@postPaymentReject');
		Route::get('administrador/ver-pagos-aprobados','AdminController@getPaymentAproved');
		//Nuevo admin
		Route::get('administrador/crear-nuevo','AdminController@getNewAdmin');
		Route::post('administrador/crear-nuevo/enviar','AdminController@postNewAdmin');

		//Nuevo slider
		//unico
		Route::get('administrador/nuevo-slide','AdminController@getNewSlide');
		Route::post('administrador/nuevo-slide/procesar','AdminController@postNewSlide');
		//multiple
		Route::post('administrador/nuevos-slides/procesar','AdminController@post_upload_slides');
		Route::post('administrador/nuevos-slides/eliminar','AdminController@postDeleteSlide');
		//editar
		Route::get('administrador/editar-slides','AdminController@getEditSlides');
		Route::post('administrador/editar-slides/actualizar','AdminController@postEditSlides');
		Route::post('administrador/editar-slides/eliminar','AdminController@postElimSlides');
		//Nueva pub
		Route::get('administrador/nueva-publicidad','AdminController@getNewPub');
		//promocion
		Route::get('administrador/nueva-promocion','AdminController@getNewPromotion');
		Route::post('administrador/nueva-publicidad/procesar','AdminController@postNewPub');
		Route::get('administrador/editar-promocio/{pos}','AdminController@getPosPromotion');
		Route::post('administrador/nueva-promocion/procesar','AdminController@postProcPub');
		Route::get('administrador/promocion/agregar-quitar-articulos/{id}','AdminController@getAddDelItemProm');
		Route::post('administrador/promocion/agregar-quitar-articulos/enviar','AdminController@postAddDelItemProm');

		

	});
	
});

Route::post('chequear/email','AuthController@postEmailCheck');
Route::get('cerrar-sesion','AuthController@logOut');
Route::get('registro', 'AuthController@getRegister');
Route::get('registro/verificar-codigo/{username}/{codigo}', 'AuthController@getCode');
Route::post('registro/enviar','AuthController@postRegister');
Route::post('registro/buscar-municipio','AuthController@getState');
Route::post('registro/buscar-parroquia','AuthController@getParroquia');
