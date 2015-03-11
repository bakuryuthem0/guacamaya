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
		$art = Items::find($id);
		$a = new stdClass;
		$a->id = $art->id;
		$a->item_nomb = $art->item_nomb;
		$a->item_stock= $art->item_stock;
		$a->item_desc = $art->item_desc;
		$a->item_cod  = $art->item_cod;
		$a->talla = array();
		$a->color = array();
		$misc = Misc::where('item_id','=',$a->id)->get();
		$a->img = array();
		foreach ($misc as $i => $m) {
			$talla = Tallas::find($m->item_talla);
			$color = Colores::find($m->item_color);
			$a->talla[$m->id] = $talla->talla_nomb.' - '.$talla->talla_desc;
			$a->color[$m->id] = $color->color_desc;
			$a->img[$m->id] = array(
				'img_1' => $m->img_1,
				'img_2' => $m->img_2,
				'img_3' => $m->img_3,
				'img_4' => $m->img_4,
				'img_5' => $m->img_5,
				'img_6' => $m->img_6,
				'img_7' => $m->img_7,
				'img_8' => $m->img_8,
			);
		}
		
		$title = $art->nombre;
		if (Auth::user()->role == 1) {
			$layout = 'admin';
		}else
		{
			$layout = 'default';
		}
		return View::make('indexs.artSelf')
		->with('title',$title)
		->with('art',$a)
		->with('layout',$layout);
	}
}