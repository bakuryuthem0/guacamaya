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
		$slides = Slides::where('active','=',1)->where('deleted','=',0)->get();

		$top    = Publicidad::where('id','=',1)->first(array('image','item_id'));
		$left   = Publicidad::where('id','=',2)->first(array('image','item_id'));
		$right  = Publicidad::where('id','=',3)->first(array('image','item_id'));
		$first  = Publicidad::where('id','=',4)->first(array('image','item_id'));
		$second = Publicidad::where('id','=',5)->first(array('image','item_id'));

		$art    = Items::leftJoin('miscelanias as m','m.item_id','=','item.id')
		->groupBy('item.id')
		->where('item.deleted','=',0)
		->where('m.deleted','=',0)
		->orderBy('item.created_at','DESC')
		->paginate(8,array(
			'item.id',
			'item.item_nomb',
			'item.item_cod',
			'item.item_stock',
			'item.item_precio',
			'm.id as misc_id',
		));
		$img = array();
		foreach ($art as $a) {
			$img[$a->id] = Images::where('deleted','=',0)->where('misc_id','=',$a->misc_id)->first(array('image'));
		}
		return View::make('indexs.index')
		->with('title',$title)
		->with('art',$art)
		->with('cat',$cat)
		->with('subcat',$subcat)
		->with('slides',$slides)
		->with('top',$top)
		->with('left',$left)
		->with('right',$right)
		->with('img',$img)
		->with('first',$first)
		->with('second',$second);
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
		//$misc    			= Misc::where('item_id','=',$art->id)->first();
		$misc    			= Misc::where('item_id','=',$art->id)->get();
		$aux = array();
		$i = 0;
		foreach ($misc as $m ) {
			$aux[$i] = Images::where('misc_id','=',$m->id)->where('deleted','=',0)->get();
			$i++;
		}
		$a->images   	 	= $aux;
		
		$t = Misc::where('item_id','=',$art->id)->groupBy('item_talla')->get(array('item_talla'));
		$c = Misc::where('item_id','=',$art->id)->get(array('item_color','item_talla'));
		$a->tallas = $t;
		$a->colores= $c;
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
	public function getCaTbuscar($id)
	{
		$auxcat = Cat::find($id);
		$title = "Busqueda por categoria: ".$auxcat->cat_desc;
		$cat = Cat::where('deleted','=',0)->get(array('categorias.id','categorias.cat_nomb'));
		
		$subcat = array();
		foreach($cat as $c)
		{
			$aux = SubCat::where('cat_id','=',$c->id)->where('deleted','=',0)->get();
			$subcat[$c->id] = $aux->toArray();
		}
		$art = Items::leftJoin('miscelanias as m','m.item_id','=','item.id')
		->leftJoin('images as i','m.id','=','i.misc_id')
		->groupBy('item.id')
		->where('item.item_cat','=',$id)
		->where('item.deleted','=',0)
		->get(array(
				'item.id',
				'item.item_nomb',
				'item.item_desc',
				'item.item_precio',
				'item.item_cod',
				'i.image'
			));
		$type = "hola";
		return View::make('indexs.busq')
		->with('title',$title)
		->with('art',$art)
		->with('cat',$cat)
		->with('subcat',$subcat)
		->with('type',$type)
		->with('busq',$auxcat->cat_desc);
	}
	public function getSubCatBuscar($subcat,$id)
	{

		$auxcat = SubCat::find($id);
		$title = "Busqueda por categoria: ".$auxcat->sub_desc;
		$cat = Cat::where('deleted','=',0)->get(array('categorias.id','categorias.cat_nomb'));
		
		$subcat = array();
		foreach($cat as $c)
		{
			$aux = SubCat::where('cat_id','=',$c->id)->where('deleted','=',0)->get();
			$subcat[$c->id] = $aux->toArray();
		}
		$art = Items::leftJoin('miscelanias as m','m.item_id','=','item.id')
		->leftJoin('images as i','m.id','=','i.misc_id')
		->groupBy('item.id')
		->where('item.item_subcat','=',$id)
		->where('item.deleted','=',0)
		->get(
			array(
				'item.id',
				'item.item_desc',
				'item.item_nomb',
				'item.item_precio',
				'item.item_cod',
				'i.image'
			)
		);
		return View::make('indexs.busq')
		->with('title',$title)
		->with('art',$art)
		->with('cat',$cat)
		->with('subcat',$subcat)
		->with('busq',$auxcat->sub_desc);

	}
	public function search()
	{
		$busq = Input::get('busq');
		$title = "Busqueda: ".$busq;
		$cat = Cat::where('deleted','=',0)->get(array('categorias.id','categorias.cat_nomb'));
		
		$subcat = array();
		foreach($cat as $c)
		{
			$aux = SubCat::where('cat_id','=',$c->id)->where('deleted','=',0)->get();
			$subcat[$c->id] = $aux->toArray();
		}
		$art = DB::select("SELECT DISTINCT `item`.`id`,	
										   `item`.`item_nomb`,
										   `item`.`item_cod`,
										   `item`.`item_stock`,
										   `item`.`item_precio`,
										   `m`.`id` AS misc_id,
										   `i`.`image`
			FROM  `item` 
			LEFT JOIN  `miscelanias` AS m ON  `m`.`item_id` =  `item`.`id` 
			LEFT JOIN  `images` 	 AS i ON  `i`.`misc_id` =  `m`.`id`
			LEFT JOIN  `tallas`      AS t ON  `m`.`item_talla`=`t`.`id`
			LEFT JOIN  `colores` 	 AS c ON  `m`.`item_color`=`c`.`id`
			WHERE (
				LOWER(  `item`.`item_nomb` ) LIKE  '%".strtolower($busq)."%' OR
				LOWER(  `item`.`item_desc` ) LIKE  '%".strtolower($busq)."%' OR
				LOWER(  `item`.`item_precio` ) LIKE  '%".strtolower($busq)."%' OR
				LOWER(  `t`.`talla_desc` ) LIKE  '%".strtolower($busq)."%' OR
				LOWER(  `t`.`talla_nomb` ) LIKE  '%".strtolower($busq)."%' OR
				LOWER(  `c`.`color_nomb` ) LIKE  '%".strtolower($busq)."%' OR
				LOWER(  `c`.`color_desc` ) LIKE  '%".strtolower($busq)."%'
			)
			AND  `item`.`deleted` = 0
			GROUP BY item.id
			");

		return View::make('indexs.busq')
		->with('title',$title)
		->with('art',$art)
		->with('cat',$cat)
		->with('subcat',$subcat)
		->with('busq',$busq);
	}
	public function getContact()
	{
		$title = "Contactenos";
		return View::make('indexs.contact')
		->with('title',$title);
	}
	public function postContact()
	{
		$input = Input::all();
		$rules = array(
		'nombre'	 => 'required|min:4',
		'asunto'	 => 'required|min:4',
		'email'  	 => 'required|email',
		'mensaje'    => 'required|min:4'
		);
		$messages = array(
		'required' => 'El :attribute es obligatorio',
		'min'      => 'El :attribute es muy corto',
		'email'    => 'Debe ingresar un :attribute valido'
		);
		$validator = Validator::make($input, $rules, $messages);
		if ($validator->fails()) {

			return Redirect::to('contactenos')->withErrors($validator)->withInput();
		}
		$to_Email     = 'ejemplo@gmail.com';
		$user_Name    = $input['nombre'];
		$subject      = $input['asunto'];
		$user_Email   = $input['email'];
		$user_Message = $input['mensaje'];
		$data = array('subject' => $subject,
							'from' => $user_Email,
							'fecha' => date('Y/m/d H:i:s'),
							'mensaje' => $user_Message,
							'nombre'  => $input['nombre']
							);

			Mail::send('emails.contact', $data, function($message) use ($to_Email,$user_Name,$subject,$user_Email)
			{
				$message->to($to_Email)->from($user_Email)->subject($subject);
			});
			Session::flash('success', 'Mensaje enviado correctamente. pronto nuestros agentes se pondrán en contacto con usted.');
			return Redirect::to('contactenos');
	}
}