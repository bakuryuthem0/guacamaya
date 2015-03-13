<?php

class AdminController extends BaseController {

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

	public function getLogin()
	{
		$title = "Administrador | guacamayastores.com.ve";
		return View::make('admin.login')->with('title',$title);
	}
	public function postLogin()
	{

		$input = Input::all();
		if (isset($input['remember'])) {
			$valor = true;
		}else
		{
			$valor = false;
		}
		$find = User::where('username','=',$input['username'])->pluck('user_deleted');
		if ($find == 1) {
			Session::flash('error', 'Su usuario ha sido eliminado, para más información contáctenos desde nuestro módulo de contacto.');
			return Redirect::to('iniciar-sesion');
		}
		$userdata = array(
			'username' 	=> $input['username'],
			'password' 	=> $input['password']

		);
		$pass = User::where('username','=',$input['username'])->pluck('password');
		if (Auth::attempt($userdata,$valor)) {
			if (Auth::user()->role == 1) {
				return Redirect::to('administrador/inicio');	
			}else
			{
				return Redirect::to('inicio');
			}
		}else
		{
			Session::flash('error', 'Usuario o contraseña incorrectos');
			return Redirect::to('iniciar-sesion');
		}
		
	}
	public function logOut()
	{
		Auth::logout();
		return Redirect::to('inicio');
	}
	public function getIndex()
	{
		$title = "Inicio administrador | guacamayastores.com.ve";
		return View::make('admin.index')->with('title',$title);
	}
	public function getNewItem()
	{
		$title = "Nuevo articulo | guacamayastores.com.ve";
		return View::make('admin.newItem')->with('title',$title);
	}
	public function postNewItem()
	{
		$input = Input::all();
		$rules = array(
			'item_cod' => 'required|unique:item',
			'item_nomb' => 'required|min:4',
			'item_desc' => 'required|min:4',
			'item_stock'=> 'required|min:1'
		);
		$msg = array(
			'required' => ':attribute es obligatorio',
			'min'	   => ':attribute es muy corto(a)',
			'unique'   => ':attribute debe ser unico'
		);
		$custom = array(
			'item_cod'   => 'El código del artículo',
			'item_nomb'  => 'El nombre del artículo',
			'item_desc'  => 'La descripción del artículo',
			'item_stock' => 'La cantidad de artículos'
		);
		$validation = Validator::make($input, $rules, $msg, $custom);
		if ($validation->fails()) {
			return Redirect::to('administrador/nuevo-articulo')->withErrors($validation)->withInput();
		}else
		{
			$item = new Items;
			$item->item_cod   = $input['item_cod'];
			$item->item_nomb  = $input['item_nomb'];
			$item->item_desc  = $input['item_desc'];
			$item->item_stock = $input['item_stock'];
			$item->save();
			$id = $item->id;
			$misc = new Misc;
			$misc->item_id = $id;
			$misc->save();
			$misc_id = $misc->id;
			mkdir('images/items/'.$id);
			return Redirect::to('administrador/nuevo-articulo/continuar/'.$id.'/'.$misc_id);	
		}
	}
	public function getContinueNew($id,$misc_id)
	{
		$title = "Colores y tallas";
		$tallas = Tallas::get();
		$colors = Colores::get();
		return View::make('admin.continueNew')
		->with('title',$title)
		->with('id',$id)
		->with('misc_id',$misc_id)
		->with('tallas',$tallas)
		->with('colores',$colors);
		
	}
	public function getImagesNew($id)
	{
		$title = "Cargar imagenes";
		return View::make('admin.newImage')
		->with('title',$title)
		->with('id',$id);
		;
	}
	public function post_upload(){

		$input = Input::all();
		$rules = array(
		    'file' => 'image|max:3000',
		);
		$messages = array(
			'image' => 'Todos los archivos deben ser imagenes',
			'max'	=> 'Las imagenes deben ser de menos de 3Mb'
		);
		$validation = Validator::make($input, $rules, $messages);

		if ($validation->fails())
		{
			return Response::make($validation)->withErrors($validation);
		}
		$id = Input::get('art_id');
		$misc_id = Input::get('misc_id');
		$file = Input::file('file');
		$misc = Misc::find($misc_id);
		$campo = "";
		if (empty($misc->img_1)) {
			$misc->img_1 = $id.'/'.$file->getClientOriginalName();
			$campo = 'img_1';
		}elseif (empty($misc->img_2)) {
			$misc->img_2 = $id.'/'.$file->getClientOriginalName();
			$campo = 'img_2';
		}elseif(empty($misc->img_3))
		{
			$misc->img_3 = $id.'/'.$file->getClientOriginalName();
			$campo = 'img_3';
		}elseif(empty($misc->img_4))
		{
			$misc->img_4 = $id.'/'.$file->getClientOriginalName();
			$campo = 'img_4';
		}elseif(empty($misc->img_5))
		{
			$misc->img_5 = $id.'/'.$file->getClientOriginalName();
			$campo = 'img_5';
		}elseif(empty($misc->img_6))
		{
			$misc->img_6 = $id.'/'.$file->getClientOriginalName();
			$campo = 'img_6';
		}elseif(empty($misc->img_7))
		{
			$misc->img_7 = $id.'/'.$file->getClientOriginalName();
			$campo = 'img_7';
		}elseif(empty($misc->img_8))
		{
			$misc->img_8 = $id.'/'.$file->getClientOriginalName();
			$campo = 'img_8';
		}
		
		if (file_exists('images/items/'.$id.'/'.$file->getClientOriginalName())) {
			//guardamos la imagen en public/imgs con el nombre original
            $i = 0;//indice para el while
            //separamos el nombre de la img y la extensión
            $info = explode(".",$file->getClientOriginalName());
            //asignamos de nuevo el nombre de la imagen completo
            $miImg = $file->getClientOriginalName();
            //mientras el archivo exista iteramos y aumentamos i
            while(file_exists('images/items/'.$id.'/'. $miImg)){
                $i++;
                $miImg = $info[0]."(".$i.")".".".$info[1];              
            }
            //guardamos la imagen con otro nombre ej foto(1).jpg || foto(2).jpg etc
            $file->move("images/items/".$id,$miImg);
            $img = Image::make('images/items/'.$id.'/'.$miImg)
	           ->heighten(180)
	           ->save('images/items/'.$id.'/'.$miImg);
            if($miImg != $file->getClientOriginalName()){
                if ($campo == 'img_1') {
					$misc->img_1 = $id.'/'.$miImg;
				}elseif ($campo == 'img_2') {
					$misc->img_2 = $id.'/'.$miImg;
				}elseif(empty($misc->img_3))
				{
					$misc->img_3 = $id.'/'.$miImg;
				}elseif($campo == 'img_4')
				{
					$misc->img_4 = $id.'/'.$miImg;
				}elseif($campo == 'img_5')
				{
					$misc->img_5 = $id.'/'.$miImg;
				}elseif($campo == 'img_6')
				{
					$misc->img_6 = $id.'/'.$miImg;
				}elseif($campo == 'img_7')
				{
					$misc->img_7 = $id.'/'.$miImg;
				}elseif($campo == 'img_8')
				{
					$misc->img_8 = $id.'/'.$miImg;
				}
            }
		}else
		{
			$file->move("images/items/".$id,$file->getClientOriginalName());
			$img = Image::make('images/items/'.$id.'/'.$file->getClientOriginalName())
            ->heighten(180)
            ->save('images/items/'.$id.'/'.$file->getClientOriginalName());
		}
		$misc->save();
        return Response::json(array('esto' => $file->getClientOriginalName()));

        if( $upload_success ) {
        	return Response::json('success', 200);
        } else {
        	return Response::json('error', 400);
        }
	}
	public function postContinueNew()
	{
		$input = Input::all();
		$rules = array(
			'talla' => 'required',
			'color' => 'required'
		);
		$msg = array('required' => 'El campo :attribute es obligatorio');
		$validator = Validator::make($input, $rules,$msg);
		if ($validator->fails()) {
			return Redirect::to('administrador/nuevo-articulo/continuar/'.$input['art'].'/'.$input['misc'])->withErrors($Validator);
		}
		$misc = Misc::find($input['misc']);
		$misc->item_talla = $input['talla'];
		$misc->item_color = $input['color'];
		if ($misc->save()) {
			$misc = new Misc;
			$misc->item_id = $input['art'];
			$misc->save();
			return Redirect::to('administrador/nuevo-articulo/continuar/'.$input['art'].'/'.$misc->id);
		}
	}
	public function postSaveNew(){
		$input = Input::all();
		$rules = array(
			'talla' => 'required',
			'color' => 'required'
		);
		$msg = array('required' => 'El campo :attribute es obligatorio');
		$validator = Validator::make($input, $rules,$msg);
		if ($validator->fails()) {
			return Redirect::to('administrador/nuevo-articulo/continuar/'.$input['art'].'/'.$input['misc'])->withErrors($Validator);
		}
		$misc = Misc::find($input['misc']);
		$misc->item_talla = $input['talla'];
		$misc->item_color = $input['color'];
		if ($misc->save()) {
			Session::flash('success', 'Articulo creado correctamente.');
			return Redirect::to('administrador/inicio');
		}
	}
	public function getShowArt()
	{
		$title = "Articulos";
		$art = Items::get(array(
			'item.item_cod',
			'item.item_nomb',
			'item.item_stock',
			'item.id'
		));
		return View::make('admin.showArt')
		->with('title',$title)
		->with('art',$art);
	}
	public function getNewCat()
	{
		$title ="Nueva Categoria";
		return View::make('admin.newCat')
		->with('title',$title);
	}
	public function postNewCat()
	{
		$input = Input::all();
		$rules = array(
			'name_cat' => 'required',
			'desc_cat' => 'required'
		);
		$msg = array('required' => 'El campo :attribute es obligatorio');
		$attr = array('name_cat' => 'nombre','desc_cat' =>'titulo');
		$validator = Validator::make($input, $rules, $msg, $attr);
		if ($validator->fails()) {
			return Redirect::to('categoria/nueva')->withErrors($validator)->withInput();
		}
		$cat = new Cat;
		$cat->cat_nomb = $input['name_cat'];
		$cat->cat_desc = $input['desc_cat'];
		if ($cat->save()) {
			Session::flash('success', 'Categoría creada satisfactoriamente.');
			return Redirect::to('administrador/inicio');
		}else
		{
			Session::flash('error', 'Error al guardar la nueva categoría.');
			return Redirect::to('categoria/nueva');
		}
	}
	public function getModifyCat()
	{
		$title = "Ver categorías";
		$cat = Cat::where('deleted','=',0)->get();
		return View::make('admin.showCat')
		->with('title',$title)
		->with('cat',$cat);
	}
	public function getModifyCatById($id)
	{
		$cat = Cat::find($id);
		$title ="Modificar categoria: ".$cat->cat_nomb;
		return View::make('admin.mdfCat')
		->with('title',$title)
		->with('cat',$cat);
	}
	public function postModifyCatById($id)
	{
		$input = Input::all();
		$rules = array(
			'name_cat' => 'required',
			'desc_cat' => 'required'
		);
		$msg = array('required' => 'El campo :attribute es obligatorio');
		$attr = array('name_cat' => 'nombre','desc_cat' =>'titulo');
		$validator = Validator::make($input, $rules, $msg, $attr);
		if ($validator->fails()) {
			return Redirect::to('administrador/ver-categoria/'.$id)->withErrors($validator)->withInput();
		}
		$cat = Cat::find($id);
		$cat->cat_nomb = $input['name_cat'];
		$cat->cat_desc = $input['desc_cat'];
		if ($cat->save()) {
			Session::flash('success', 'Categoría modificada satisfactoriamente.');
			return Redirect::to('administrador/inicio');
		}else
		{
			Session::flash('error', 'Error al modificar la categoría.');
			return Redirect::to('administrador/ver-categoria/'.$id);
		}
	}
	public function postElimCat()
	{
		if (Request::ajax()) {
			$id = Input::get('id');
			$cat = Cat::find($id);
			$cat->deleted = 1;
			$cat->save();
			return Response::json(array('type' => 'success','msg' => 'Categoría eliminada correctamente'));
		}
	}
	public function getNewColor()
	{
		$title = "Nuevo color";
		return View::make('admin.newColor')
		->with('title',$title);
	}
	public function postNewColor()
	{
		$input = Input::all();
		$rules = array(
			'name_color' => 'required',
			'desc_color' => 'required'
		);
		$msg = array('required' => 'El campo :attribute es obligatorio');
		$attr = array('name_color' => 'nombre','desc_color' =>'titulo');
		$validator = Validator::make($input, $rules, $msg, $attr);
		if ($validator->fails()) {
			return Redirect::to('color/nuevo')->withErrors($validator)->withInput();
		}
		$color = new Colores;
		$color->color_nomb = $input['name_color'];
		$color->color_desc = $input['desc_color'];
		if ($color->save()) {
			Session::flash('success', 'Color creado satisfactoriamente.');
			return Redirect::to('administrador/inicio');
		}else
		{
			Session::flash('error', 'Error al guardar el nuevo color.');
			return Redirect::to('color/nuevo');
		}
	}
	public function getModifyColor()
	{
		$title = "Ver categorías";
		$color = Colores::where('deleted','=',0)->get();
		return View::make('admin.showColor')
		->with('title',$title)
		->with('color',$color);
	}
	public function getModifyColorById($id)
	{
		$color = Colores::find($id);
		$title ="Modificar color: ".$color->color_nomb;
		return View::make('admin.mdfColor')
		->with('title',$title)
		->with('color',$color);
	}
	public function postModifyColorById($id)
	{
		$input = Input::all();
		$rules = array(
			'name_color' => 'required',
			'desc_color' => 'required'
		);
		$msg = array('required' => 'El campo :attribute es obligatorio');
		$attr = array('name_color' => 'nombre','desc_color' =>'titulo');
		$validator = Validator::make($input, $rules, $msg, $attr);
		if ($validator->fails()) {
			return Redirect::to('administrador/ver-color/'.$id)->withErrors($validator)->withInput();
		}
		$color = Colores::find($id);
		$color->color_nomb = $input['name_color'];
		$color->color_desc = $input['desc_color'];
		if ($color->save()) {
			Session::flash('success', 'Color modificado satisfactoriamente.');
			return Redirect::to('administrador/inicio');
		}else
		{
			Session::flash('error', 'Error al modificar el color.');
			return Redirect::to('administrador/ver-color/'.$id);
		}
	}
	public function postElimColor()
	{
		if (Request::ajax()) {
			$id = Input::get('id');
			$color = Colores::find($id);
			$color->deleted = 1;
			$color->save();
			return Response::json(array('type' => 'success','msg' => 'Categoría eliminada correctamente'));
		}
	}
	public function getNewSubCat()
	{
		$title = "Nueva sub-categoria";
		$cat = Cat::where('deleted','=',0)
		->get();
		return View::make('admin.newSubCat')
		->with('title',$title)
		->with('cat',$cat);
	}
	public function postNewSubCat()
	{
		$input = Input::all();
		$rules = array(
			'cat' 		  => 'required',
			'name_subcat'  => 'required',
			'desc_subcat' => 'required'
		);
		$msg = array('required' => 'El campo :attribute es obligatorio');
		$attr = array('cat' => 'categoría','name_subcat' => 'nombre','desc_subcat' =>'titulo');
		$validator = Validator::make($input, $rules, $msg, $attr);
		if ($validator->fails()) {
			return Redirect::to('categoria/nueva-sub-categoria')->withErrors($validator)->withInput();
		}
		$subcat = new SubCat;
		$subcat->cat_id 	= $input['cat'];
		$subcat->sub_nomb = $input['name_subcat'];
		$subcat->sub_desc = $input['desc_subcat'];
		if ($subcat->save()) {
			Session::flash('success', 'Sub-categoría creada satisfactoriamente.');
			return Redirect::to('administrador/inicio');
		}else
		{
			Session::flash('error', 'Error al guardar la nueva sub-categoría.');
			return Redirect::to('categoria/nueva-sub-categoria');
		}
	}
	public function getModifySubCat()
	{
		$title = "Ver sub-categorías";
		$subcat = SubCat::join('categorias as c','c.id','=','subcat.cat_id')->where('c.deleted','=',0)->where('subcat.deleted','=',0)->get();
		return View::make('admin.showSubCat')
		->with('title',$title)
		->with('subcat',$subcat);
	}
}