<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function getFront()
	{
		$title = "Portada";
		return View::make('indexs.portada')->with('title',$title); 
	}
	public function getIndex()
	{
		$title = "Inicio";
		return View::make('indexs.index')->with('title',$title);
	}
	public function getLogin()
	{
		if (Session::has('success')) {
			Session::reflash();
		}
		$title ="Iniciar sesión";
		return View::make('indexs.login')->with('title',$title);
	}
	public function getShowItem($id)
	{
		$art = Items::join('miscelanias as m','m.item_id','=','item.id')
		->join('tallas','tallas.id','=','m.item_talla')
		->join('colores','colores.id','=','m.item_color')
		->where('item.id','=',$id)
		->get();
		foreach ($art as  $value) {
			echo $art.'<br>';
		}
		die();
		$title = $art->nombre;
		if (Auth::user()->role == 1) {
			$layout = 'admin';
		}else
		{
			$layout = 'default';
		}
		return View::make('indexs.artSelf')
		->with('title',$title)
		->with('art',$art)
		->with('layout',$layout);
	}
}