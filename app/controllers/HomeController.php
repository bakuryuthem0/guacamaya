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
		$cat = Cat::get(array('categorias.id','categorias.cat_nomb'));
		$i = 0;
		$subcat = array();
		foreach($cat as $c)
		{
			$aux = SubCat::where('cat_id','=',$c->id)->get();
			$subcat[$c->id] = $aux->toArray();
		}
		$art = Items::leftJoin('miscelanias as m','m.item_id','=','item.id')
		
		->groupBy('item.id')
		->get(array(
			'item.item_nomb',
			'item.item_cod',
			'item.item_stock',
			'm.img_1',
		));
		
		return View::make('indexs.index')
		->with('title',$title)
		->with('art',$art)
		->with('cat',$cat)
		->with('subcat',$subcat);
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

		$misc = Misc::where('item_id','=',$a->id)->first();
		$a->img = array();
		$a->misc = $misc->id;

		$talla = Tallas::find($misc->item_talla);
		$color = Colores::find($misc->item_color);
		$misc2 = Misc::where('item_id','=',$a->id)->where('id','!=',$misc->id)->get();
		$a->talla[$misc->id] = $talla->talla_nomb.' - '.$talla->talla_desc;
		$a->color[$misc->id] = $color->color_desc;
		$a->img[$misc->id] = array(
			'img_1' => $misc->img_1,
			'img_2' => $misc->img_2,
			'img_3' => $misc->img_3,
			'img_4' => $misc->img_4,
			'img_5' => $misc->img_5,
			'img_6' => $misc->img_6,
			'img_7' => $misc->img_7,
			'img_8' => $misc->img_8,
		);
		
		$title = $art->nombre;
		if (Auth::user()->role == 1) {
			$layout = 'admin';
		}else
		{
			$layout = 'default';
		}
		$option = array();
		$tallas = Tallas::get();
		$colores = Colores::get();		
		return View::make('indexs.artSelf')
		->with('title',$title)
		->with('art',$a)
		->with('layout',$layout)
		->with('tallas',$tallas)
		->with('colores',$colores);
	}
}