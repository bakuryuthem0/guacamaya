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
		$cat = Cat::where('deleted','=',0)->get(array('categorias.id','categorias.cat_nomb'));
		$i = 0;
		$subcat = array();
		foreach($cat as $c)
		{
			$aux = SubCat::where('cat_id','=',$c->id)->where('deleted','=',0)->get();
			$subcat[$c->id] = $aux->toArray();
		}
		$art = Items::leftJoin('miscelanias as m','m.item_id','=','item.id')
		->leftJoin('images as i','m.id','=','i.misc_id')
		->groupBy('item.id')
		->where('item.deleted','=',0)
		->get(array(
			'item.id',
			'item.item_nomb',
			'item.item_cod',
			'item.item_stock',
			'item.item_precio',
			'm.id as misc_id',
			'i.image',
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
		$a->item_nomb 		= $art->item_nomb;
		$a->item_stock		= $art->item_stock;
		$a->item_desc 		= $art->item_desc;
		$a->item_cod 	 	= $art->item_cod;
		$a->item_precio 	= $art->item_precio;
		$a->misc 			= array();
		$a->tallas    		= array();
		$a->colores   		= array();
		$misc    			= Misc::where('item_id','=',$art->id)->first();
		$a->images   	 	= Images::where('misc_id','=',$misc->id)->get();
		if (!empty($misc) || !is_null($misc)) {
				$aux  = Tallas::find($misc->item_talla);
				$aux2 = Colores::find($misc->item_color);
				
				$a->misc 	    	= $misc->id;
				$a->tallas  		= array_merge($a->tallas,array($misc->item_talla => $aux));
				$a->colores 		= array_merge($a->colores,array($misc->item_color => $aux2));
				
		}
		$tallas  = Tallas::get();
		$colores = Colores::get();

		$title = $art->item_nomb;
		if (Auth::check() && Auth::user()->role == 1) {
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