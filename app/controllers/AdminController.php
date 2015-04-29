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
		$cat = Cat::where('deleted','=',0)
		->get();
		return View::make('admin.newItem')
		->with('title',$title)
		->with('cat',$cat);
	}
	public function postCatSubCat()
	{
		if (Request::ajax()) {
			$id = Input::get('id');
			$subcat = SubCat::where('cat_id','=',$id)->where('deleted','=',0)->get();
			return $subcat;
		}
	}
	public function postNewItem()
	{
		$input = Input::all();
		$rules = array(
			'cat'    	=> 'required',
			'item_precio'=> 'required',
			'item_cod'  => 'required|unique:item',
			'item_nomb' => 'required|min:4',
			'item_desc' => 'required|min:4',
		);
		$msg = array(
			'required' => 'El campo :attribute es obligatorio',
			'min'	   => 'El campo :attribute es muy corto(a)',
			'unique'   => 'El campo :attribute debe ser unico'
		);
		$attr = array(
			'cat'        => 'categoría',
			'item_precio'=> 'precio',
			'item_cod'   => 'artículo',
			'item_nomb'  => 'artículo',
			'item_desc'  => 'artículo',
		);
		$validation = Validator::make($input, $rules, $msg, $attr);
		if ($validation->fails()) {
			return Redirect::to('administrador/nuevo-articulo')->withErrors($validation)->withInput();
		}else
		{
			$item = new Items;
			$item->item_cat   = $input['cat']; 
			if (!empty($input['subcat'])) {
				$item->item_subcat= $input['subcat'];

			}
			$item->item_cod   = $input['item_cod'];
			$item->item_nomb  = $input['item_nomb'];
			$item->item_desc  = $input['item_desc'];
			$item->item_precio= $input['item_precio'];
			$item->save();
			$id = $item->id;
			$misc = new Misc;
			$misc->item_id = $id;
			$misc->save();
			$misc_id = $misc->id;
			if (!file_exists('images/items/'.$id)) {
				mkdir('images/items/'.$id);
			}
			return Redirect::to('administrador/nuevo-articulo/continuar/'.$id.'/'.$misc_id);	
		}
	}
	public function getContinueNew($id,$misc_id)
	{
		$title = "Colores y tallas";
		$tallas = Tallas::where('deleted','=',0)->get();
		$colors = Colores::where('deleted','=',0)->get();
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
	public function post_upload()
	{

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
		$id 	 = Input::get('art_id');
		$misc_id = Input::get('misc_id');
		$file 	 = Input::file('file');
		$images  = new Images;
		$images->misc_id =  $misc_id;
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
            $blank = Image::make('images/blank.jpg');

            $img = Image::make('images/items/'.$id.'/'.$miImg);
            if ($img->width() > $img->height()) {
            	$img->widen(225);
            }else
            {
            	$img->heighten(300);
            }
            
	        $blank->insert($img,'center')
	           ->interlace()
	           ->save('images/items/'.$id.'/'.$miImg);
            if($miImg != $file->getClientOriginalName()){
            	$images->image = $id.'/'.$miImg;
            }
		}else
		{
			$file->move("images/items/".$id,$file->getClientOriginalName());
			$blank = Image::make('images/blank.jpg');
			$img = Image::make('images/items/'.$id.'/'.$file->getClientOriginalName());
            if ($img->width() > $img->height()) {
            	$img->widen(225);
            }else
            {
            	$img->heighten(300);
            }

            $blank->insert($img,'center')
           ->interlace()
           ->save('images/items/'.$id.'/'.$file->getClientOriginalName());
           $images->image = $id.'/'.$file->getClientOriginalName();
		}
		$images->save();
        return Response::json(array('image' => $images->id));

        if( $upload_success ) {
        	return Response::json('success', 200);
        } else {
        	return Response::json('error', 400);
        }
	}
	public function postDeleteImg()
	{
		$image 		= Input::get('image');
		$file 		= Input::get('name');
		$id     	= Input::get('id');
		$misc_id    = Input::get('misc_id');
		$misc 		= Misc::find($misc_id);
		$img = Images::find($image);
		$img->deleted = 1;
		File::delete('images/items/'.$img->image);
		$img->save();
		
		return Response::json(array('llego' => 'llego'));
	}
	public function postContinueNew()
	{
		$input = Input::all();
		$rules = array(
			'item_stock' 	=> 'required|min:1',
			'talla' 		=> 'required',
			'color' 		=> 'required'
		);
		$msg = array('required' => 'El campo :attribute es obligatorio');
		$validator = Validator::make($input, $rules,$msg);
		if ($validator->fails()) {
			return Redirect::to('administrador/nuevo-articulo/continuar/'.$input['art'].'/'.$input['misc'])->withErrors($validator);
		}
		$misc = Misc::find($input['misc']);
		$misc->item_talla = $input['talla'];
		$misc->item_color = $input['color'];
		$misc->item_stock = $input['item_stock'];
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
			'item_stock' => 'required',
			'talla' 	 => 'required',
			'color' 	 => 'required'
		);
		$msg = array('required' => 'El campo :attribute es obligatorio');
		$validator = Validator::make($input, $rules,$msg);
		if ($validator->fails()) {
			return Redirect::to('administrador/nuevo-articulo/continuar/'.$input['art'].'/'.$input['misc'])->withErrors($validator);
		}
		$misc = Misc::find($input['misc']);
		$misc->item_talla = $input['talla'];
		$misc->item_color = $input['color'];
		$misc->item_stock = $input['item_stock'];
		if ($misc->save()) {
			Session::flash('success', 'Articulo creado correctamente.');
			return Redirect::to('administrador/inicio');
		}
	}
	public function getShowArt()
	{
		$title = "Articulos";
		$art = Items::where('deleted','=',0)->get(array(
			'item.item_cod',
			'item.item_nomb',
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
		$attr = array('name_cat' => 'nombre','desc_cat' =>'título');
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
		$attr = array('name_cat' => 'nombre','desc_cat' =>'título');
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
		$attr = array('name_color' => 'nombre','desc_color' =>'título');
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
		$attr = array('name_color' => 'nombre','desc_color' =>'título');
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
		$attr = array('cat' => 'categoría','name_subcat' => 'nombre','desc_subcat' =>'título');
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
		$subcat = SubCat::join('categorias as c','c.id','=','subcat.cat_id')
		->where('c.deleted','=',0)
		->where('subcat.deleted','=',0)
		->get(array(
			'c.id as cat_id',
			'c.cat_desc',
			'subcat.sub_nomb',
			'subcat.sub_desc',
			'subcat.id'

		));
		return View::make('admin.showSubCat')
		->with('title',$title)
		->with('subcat',$subcat);
	}
	public function getModifySubCatById($id)
	{
		$subcat = SubCat::find($id);
		$cat    = Cat::where('deleted','=',0)->get();
		$title ="Modificar color: ".$subcat->sub_nomb;
		return View::make('admin.mdfSubCat')
		->with('title',$title)
		->with('subcat',$subcat)
		->with('cat',$cat);
	}
	public function postModifySubCatById($id)
	{
		$input = Input::all();
		$rules = array(
			'cat'		  => 'required',
			'name_subcat' => 'required',
			'desc_subcat' => 'required'
		);
		$msg = array('required' => 'El campo :attribute es obligatorio');
		$attr = array('cat' => 'categoría','name_color' => 'nombre','desc_color' =>'título');
		$validator = Validator::make($input, $rules, $msg, $attr);
		if ($validator->fails()) {
			return Redirect::to('administrador/ver-sub-categoria/'.$id)->withErrors($validator)->withInput();
		}
		$subcat = SubCat::find($id);
		$subcat->cat_id   = $input['cat'];
		$subcat->sub_nomb = $input['name_subcat'];
		$subcat->sub_desc = $input['desc_subcat'];
		if ($subcat->save()) {
			Session::flash('success', 'Sub-categoría modificada satisfactoriamente.');
			return Redirect::to('administrador/inicio');
		}else
		{
			Session::flash('error', 'Error al modificar la sub-categoría.');
			return Redirect::to('administrador/ver-sub-categoria/'.$id);
		}
	}
	public function postElimSubCat()
	{
		if (Request::ajax()) {
			$id = Input::get('id');
			$subcat = SubCat::find($id);
			$subcat->deleted = 1;
			$subcat->save();
			return Response::json(array('type' => 'success','msg' => 'Categoría eliminada correctamente'));
		}
	}
	public function getNewAdmin()
	{
		$title = "Crear nuevo administrador";
		return View::make('admin.newAdmin')->with('title',$title);
	}
	public function postNewAdmin()
	{
		$input = Input::all();
		$rules = array(
			'adminUser' => 'required|unique:usuario,username',
			'pass' 		=> 'required|min:8',
			'pass2' 	=> 'required|same:pass'
		);		
		$messages = array(
			'required' => ':attribute es obligatorio',
			'min'	   => ':attribute debe tener al menos 8 caracteres',
			'same'	   => ':attribute no coincide',
			'unique'   => ':attribute debe ser unico'
		);
		$attributes = array(
			'adminUser'  => 'El campo nombre de administrador',
			'pass'  	 => 'El campo contraseña nueva',
			'pass2'  	 => 'El campo repetir contraseña',
			'adminUser'  => 'El campo nombre de usuario'
		);
		$validator = Validator::make($input, $rules, $messages, $attributes);
		if ($validator->fails()) {
			return Redirect::to('administrador/crear-nuevo')->withErrors($validator)->withInput();
		}
		$user = new User;
		$user->username = $input['adminUser'];
		$user->password = Hash::make($input['pass']);
		$user->email    = $input['adminUser'].'@guacamayastores.com.ve';
		$user->role     = 1;

		if ($user->save()) {
			$data = array(
				'username' => $input['adminUser'],
				'createBy' => Auth::user()->username
			);
			Mail::send('emails.newAdmin', $data, function ($message) use ($input){
				    $message->subject('Correo creacion de usuario guacamayastores.com.ve');
				    $message->to('someemail@guacamayastores.com.ve');
				});
			Session::flash('success', 'El usuario fue creado satisfactoriamente');
			return Redirect::to('administrador/crear-nuevo');
		}else
		{
			Session::flash('error', 'El usuario no e pudo crear.');
			return Redirect::to('administrador/crear-nuevo');
		}
	}
	public function getNewSlide()
	{
		$title = "Nuevo slide";
		return View::make('admin.newSlide')->with('title',$title);
	}
	public function postNewSlide()
	{
		$input = Input::all();
		$rules = array(
		    'img' => 'image|max:2000',
		);
		$messages = array(
			'image' => 'Todos los archivos deben ser imagenes',
			'max'	=> 'Las imagenes deben ser de menos de 3Mb'
		);
		$validation = Validator::make($input, $rules, $messages);

		if ($validation->fails())
		{
			return Redirect::to('administrador/nuevo-slide')->withErrors($validation);
		}
		$file = Input::file('img');
		$images = new Slides;
		if (file_exists('images/slides-top/'.$file->getClientOriginalName())) {
			//guardamos la imagen en public/imgs con el nombre original
            $i = 0;//indice para el while
            //separamos el nombre de la img y la extensión
            $info = explode(".",$file->getClientOriginalName());
            //asignamos de nuevo el nombre de la imagen completo
            $miImg = $file->getClientOriginalName();
            //mientras el archivo exista iteramos y aumentamos i
            while(file_exists('images/slides-top/'.$miImg)){
                $i++;
                $miImg = $info[0]."(".$i.")".".".$info[1];              
            }
            //guardamos la imagen con otro nombre ej foto(1).jpg || foto(2).jpg etc
            $file->move("images/slides-top/",$miImg);
            $img = Image::make('images/slides-top/'.$miImg);
            $img->interlace()
	           ->save('images/slides-top/'.$miImg);
            if($miImg != $file->getClientOriginalName()){
            	$images->image = $miImg;
            }
		}else
		{
			$file->move("images/slides-top/",$file->getClientOriginalName());
			$img = Image::make('images/slides-top/'.$file->getClientOriginalName());
            $img->interlace()
            ->save('images/slides-top/'.$file->getClientOriginalName());
            $images->image = $file->getClientOriginalName();
		}
		if($images->save())
		{
			Session::flash('success','Imagen guardada correctamente');
			return Redirect::to('administrador/editar-slides');
		}else
		{
			Session::flash('danger','Error al guardar la imagen');
			return Redirect::to('administrador/nuevo-slide');
		}

	}
	public function post_upload_slides()
	{
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
		$file = Input::file('file');
		$images = new Slides;
		if (file_exists('images/slides-top/'.$file->getClientOriginalName())) {
			//guardamos la imagen en public/imgs con el nombre original
            $i = 0;//indice para el while
            //separamos el nombre de la img y la extensión
            $info = explode(".",$file->getClientOriginalName());
            //asignamos de nuevo el nombre de la imagen completo
            $miImg = $file->getClientOriginalName();
            //mientras el archivo exista iteramos y aumentamos i
            while(file_exists('images/slides-top/'.$miImg)){
                $i++;
                $miImg = $info[0]."(".$i.")".".".$info[1];              
            }
            //guardamos la imagen con otro nombre ej foto(1).jpg || foto(2).jpg etc
            $file->move("images/slides-top/",$miImg);
            $img = Image::make('images/slides-top/'.$miImg)
	           ->interlace()
	           ->save('images/slides-top/'.$miImg);
            if($miImg != $file->getClientOriginalName()){
            	$images->image = $miImg;
            }
		}else
		{
			$file->move("images/slides-top/",$file->getClientOriginalName());
			$img = Image::make('images/slides-top/'.$file->getClientOriginalName())->interlace()
           ->save('images/slides-top/'.$file->getClientOriginalName());
           $images->image = $file->getClientOriginalName();
		}
		$images->save();
        return Response::json(array('image' => $images->id));

        if( $upload_success ) {
        	return Response::json('success', 200);
        } else {
        	return Response::json('error', 400);
        }
	}
	public function postDeleteSlide()
	{
		$file 		= Input::get('name');
		$id     	= Input::get('id');
		$img = Slides::find($id);
		$img->deleted = 1;
		File::delete('images/slides-top/'.$img->image);
		$img->save();
		return Response::json(array('llego' => 'llego'));
	}

	public function getEditSlides()
	{
		$title = 'Editar slides';
		$slides = Slides::where('deleted','=',0)->get();
		return View::make('admin.editSlides')->with('title',$title)->with('slides',$slides);
	}
	public function postEditSlides()
	{
		if (Request::ajax()) {
			$id = Input::get('id');
			$st = Input::get('status');
			$slide = Slides::find($id);
			if ($st == 1) {
				$slide->active = 0;
			}else
			{
				$slide->active = 1;
			}
			if($slide->save())
			{
				return Response::json(array('type' => 'success','msg' => 'Slide activado satisfactoriamente'));
			}else
			{
				return Response::json(array('type' =>'danger','msg' =>'Error al activar el slide'));
			}
		}
	}
	public function postElimSlides()
	{
		if (Request::ajax()) {
			$id = Input::get('id');
			$slides = Slides::find($id);
			File::delete('images/slides-top/'.$slides->image);
			$slides->deleted = 1;
			if($slides->save())
			{
				return Response::json(array('type' => 'success','msg' => 'Slide eliminado satisfactoriamente'));
			}else
			{
				return Response::json(array('type' =>'danger','msg' =>'Error al eliminar el slide'));
			}

		}
	}
	public function getNewPub()
	{
		$title = "Nueva publicidad";
		return View::make('admin.newPub')->with('title',$title);
	}
	public function getNewPromotion()
	{
		$title ="Nueva promocion";
		return View::make('admin.newPromotion')->with('title',$title);
	}
	public function getPosPromotion($pos)
	{
		$title = "Modificar promocion";
		$prom = Publicidad::where('position','=',$pos)->first();
		return View::make('admin.mdfProm')
		->with('title',$title)
		->with('prom',$prom);
	}
	public function postProcPub()
	{
		$id = Input::get('pos');
		$inp = Input::all();
		$prom = Publicidad::find($id);
		if (Input::hasFile('img')) {
			$file = Input::file('img');
			if (file_exists('images/pub/'.$file->getClientOriginalName())) {
				//guardamos la imagen en public/imgs con el nombre original
	            $i = 0;//indice para el while
	            //separamos el nombre de la img y la extensión
	            $info = explode(".",$file->getClientOriginalName());
	            //asignamos de nuevo el nombre de la imagen completo
	            $miImg = $file->getClientOriginalName();
	            //mientras el archivo exista iteramos y aumentamos i
	            while(file_exists('images/pub/'.$miImg)){
	                $i++;
	                $miImg = $info[0]."(".$i.")".".".$info[1];              
	            }
	            //guardamos la imagen con otro nombre ej foto(1).jpg || foto(2).jpg etc
	            $file->move("images/pub/",$miImg);
				$img = Image::make('images/pub/'.$miImg);
				if ($img->width() > $img->height()) {
					$img->widen(200);
				}else
				{
					$img->heighten(200);
				}
				$blank = Image::make('images/blank2.jpg');
				$blank->insert($img,'center')
	           ->interlace()
	           ->save('images/pub/'.$miImg);
	            if($miImg != $file->getClientOriginalName()){
	            	$prom->image = $miImg;
	            }
			}else
			{
				$file->move("images/pub/",$file->getClientOriginalName());
				$img = Image::make('images/pub/'.$file->getClientOriginalName());
				if ($img->width() > $img->height()) {
					$img->widen(200);
				}else
				{
					$img->heighten(200);
				}
				$blank = Image::make('images/blank2.jpg');
		        $blank->insert($img,'center')
	            ->interlace()
            	->save('images/pub/'.$file->getClientOriginalName());
				
				
	          	$prom->image = $file->getClientOriginalName();
			}
		}
		if (!empty($inp['descuento'])) {
			$prom->percent = $inp['descuento'];		
		}
		if (Input::has('active')) {
			$prom->active = 1;
		}else
		{			
			$prom->active = 0;
			$items = Items::where('deleted','=',0)->where('item_prom','=',$prom->id)->get();
			foreach($items as $i)
			{
				$i->item_prom = 0;
				$i->save();
			}
		}
		if ($prom->save()) {
			Session::flash('success', 'Promocion editada satisfactoriamente.');
			return Redirect::to('administrador/promocion/agregar-quitar-articulos/'.$id);
		}else
		{
			Session::flash('error', 'Error al guardar la promocion');
			return Redirect::back();
		}
	}
	public function getAddDelItemProm($id)
	{
		$title = "Agregar/Quitar items";
		$prom = Publicidad::find($id);
		$b = Items::where('deleted','=','0')
		->where(function($query) use ($id)
		{
			$query->where('item_prom','=',0)
			->orWhere('item_prom','=',$id);
		})
		->get(array('item_cod','id','item_prom'));
		$item = array();
		$i = 0;
		foreach($b as $a){
			$aux		= Misc::where('item_id','=',$a->id)->where('deleted','=',0)->first();
			$b->img[$i]	= Images::where('misc_id','=',$aux->id)->where('deleted','=',0)->pluck('image'); 
			$item[$i] 	= $b;
			$i++;

		}
		return View::make('admin.mdfPromItem')
		->with('title',$title)
		->with('prom',$prom)
		->with('items',$item);

	}
	public function postAddDelItemProm()
	{
		$id   = Input::get('id');
		$val  = Input::get('val');
		$item = Items::where('id','=',$id)->first();
		$item->item_prom = $val;
		if($item->save())
		{
			return Response::json(array('type' => 'success','msg' => 'Articulo agregado satisfactoriamente.'));
		}else
		{
			return Response::json(array('type' => 'danger','msg' => 'Error al agregar el articulo.'));
		}
	}
	public function postNewPub()
	{
		$input = Input::all();
		$rules = array(
			'img'  		=> 'required|image|max:2000',
			'position'  => 'required'
		);
		$msg = array(
			'required' => ':attribute es obligatorio',
			'image'	   => ':attribute debe ser una imagen',
			'max'	   => 'La imagen no debe ser mayor a 2Mb',
		);
		$attr = array(
			'img' 	=> 'El campo imagen',
			'position' => 'Error al enviar algunos datos'
		);
		$validator = Validator::make($input, $rules, $msg, $attr);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		}
		if ($input['position'] == 'top') {
			$pub = Publicidad::find(1);
		}elseif($input['position'] == 'left')
		{
			$pub = Publicidad::find(2);
		}elseif($input['position'] == 'right')
		{
			$pub = Publicidad::find(3);
		}

		
		if($pub->save())
		{
		
			$url = "administrador/nueva-publicidad";
			Session::flash('success','Publicidad guardada correctamente');
			return Redirect::to($url);
		}else
		{
			Session::flash('danger','Error al guardar la publicidad');
			return Redirect::back();
		}
	}
	public function postElimItem()
	{
		$id = Input::get('id');
		$item = Items::find($id);
		$misc = Misc::where('item_id','=',$id)->first();
		$img  = Images::where('misc_id','=',$misc->id)->get();
		$item->deleted = 1;
		$misc->deleted = 1;
		foreach ($img as $i) {
			$i->deleted = 1;
			$i->save();
		}
		
		if($item->save() && $misc->save())
		{
			return Response::json(array('type' => 'success','msg' => 'Articulo eliminado satisfactoriamente'));
		}else
		{
			return Response::json(array('type' =>'danger','msg' =>'Error al eliminar el articulo'));
		}
	}
	public function getMdfItem($id)
	{
		$item = Items::find($id);
		$misc = Misc::where('item_id','=',$item->id)->get();
		$aux = array();
		$j = 0;
		foreach ($misc as $m) {
			$aux[$j] = Images::where('misc_id','=',$m->id)->where('deleted','=',0)->get();
			$j++;
		}
		$item->img = $aux;
		
		$item->misc = $misc;
		$title = "Modificar articulo: ".$item->item_nomb;

		$cat = Cat::where('deleted','=',0)->get();
		$tallas = Tallas::where('deleted','=',0)->get();
		$colors = Colores::where('deleted','=',0)->get();
		return View::make('admin.mdfItem')
		->with('title',$title)
		->with('item',$item)
		->with('cat',$cat)
		->with('tallas',$tallas)
		->with('colores',$colors);
	}
	public function postMdfItem()
	{
		$inp = Input::all();
		$rules = array(
			'item_cod'  	=> 'required',
			'item_nomb' 	=> 'required',
			'item_desc' 	=> 'required',
			'item_precio' 	=> 'required',
			'item_stock' 	=> 'required',
		);
		$msg = array(
			'required' => 'El campo no debe estar vacio'
		);
		$validator = Validator::make($inp, $rules, $msg);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validation);
		}
		$item = Items::find($inp['item']);

		if (!empty($inp['cat'])) {
			$item->item_cat = $inp['cat'];
		}
		if (!empty($inp['subcat'])) {
			$item->item_subcat = $inp['subcat'];
		}
		$item->item_cod  	= $inp['item_cod'];
		$item->item_nomb 	= $inp['item_nomb'];
		$item->item_desc 	= $inp['item_desc'];
		$item->item_precio	= $inp['item_precio'];
		$item->item_stock   = $inp['item_stock'];

		if ($misc->save() && $item->save()) {
			Session::flash('success', 'Articulo modificado satisfactoriamente.');
			return Redirect::to('administrador/ver-articulo');
		}else
		{
			Session::flash('dager', 'Error al modificar el articulo.');
			return Redirect::back();
		}
	}
	public function postMdfMisc()
	{
		$inp = Input::all();
		$misc = Misc::find($inp['misc']);
		if (!empty($inp['talla']) && $inp['talla'] != $misc->item_talla) {
			$misc->item_talla = $inp['talla'];
		}elseif (!empty($inp['color']) && $inp['color'] != $misc->item_color) {
			$misc->item_color = $inp['color'];
		}
		if($misc->save())
		{
			Session::flash('success', 'Articulo modificado satisfactoriamente.');
			return Redirect::back();
		}else
		{
			Session::flash('dager', 'Error al modificar el articulo.');
			return Redirect::back();
		}

	}
	public function postElimImg()
	{
		$id = Input::get('id');
		$img = Images::find($id);
		$img->deleted = 1;
		if($img->save())
		{
			$image = $img->image;
			File::delete('images/items/'.$image);
			return Response::json(array('type' => 'success','msg' => 'Imagen borrada satisfactoriamente.'));
		}else
		{
			return Response::json(array('type' => 'danger','msg' => 'Error al guardar la imagen.'));
		}
	}
	public function changeItemImagen()
	{
		$id   	= Input::get('item_id');
		$file 	= Input::file('file');
		$img_id = Input::get('id'); 
		$imagen = Images::find($img_id);
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
            $blank = Image::make('images/blank.jpg');

            $img = Image::make('images/items/'.$id.'/'.$miImg);
            if ($img->width() > $img->height()) {
            	$img->widen(225);
            }else
            {
            	$img->heighten(300);
            }
            
	        $blank->insert($img,'center')
	           ->interlace()
	           ->save('images/items/'.$id.'/'.$miImg);
            if($miImg != $file->getClientOriginalName()){
            	$imagen->image = $id.'/'.$miImg;
            }
		}else
		{
			$file->move("images/items/".$id,$file->getClientOriginalName());
			$blank = Image::make('images/blank.jpg');
			$img = Image::make('images/items/'.$id.'/'.$file->getClientOriginalName());
            if ($img->width() > $img->height()) {
            	$img->widen(225);
            }else
            {
            	$img->heighten(300);
            }

            $blank->insert($img,'center')
           ->interlace()
           ->save('images/items/'.$id.'/'.$file->getClientOriginalName());
           $imagen->image = $id.'/'.$file->getClientOriginalName();
		}
		if($imagen->save())
		{
			Session::flash('success', 'Imagen modificada correctamente.');
			return Redirect::back();
		}else
		{
			Session::flash('danger', 'Error al modificar la imagen.');
			return Redirect::back();
		}
	}
	public function getPayment()
	{
		$title = "Pagos | guacamayastores.com.ve";
		$fac = Facturas::join('direcciones','direcciones.id','=','facturas.dir')
		->join('usuario','usuario.id','=','facturas.user_id')
		->leftJoin('estado','usuario.estado','=','estado.id')
		->leftJoin('municipio','usuario.municipio','=','municipio.id')
		->leftJoin('parroquia','usuario.parroquia','=','parroquia.id')
		->leftJoin('bancos','bancos.id','=','facturas.banco')
		->where('pagada','=',-1)->orderBy('facturas.id','DESC')
		->get(
			array(
				'usuario.id as user_id',
				'usuario.username',
				'usuario.dir as user_dir',
				'usuario.nombre',
				'usuario.apellido',
				'usuario.telefono',
				'usuario.email',
				'estado.nombre as est',
				'municipio.nombre as mun',
				'parroquia.nombre as par',
				'facturas.*',
				'direcciones.email',
				'direcciones.dir as dir_name',
				'bancos.banco'
			)
		);
		$facNot  = Facturas::join('direcciones','direcciones.id','=','facturas.dir')
		->join('usuario','usuario.id','=','facturas.user_id')
		->leftJoin('estado','usuario.estado','=','estado.id')
		->leftJoin('municipio','usuario.municipio','=','municipio.id')
		->leftJoin('parroquia','usuario.parroquia','=','parroquia.id')
		->where('facturas.deleted','=',0)
		->where('facturas.created_at','<=',date('Y-m-d',(time()-(86400*5))))
		->where('pagada','=',0)->orderBy('facturas.id','DESC')
		->get(
			array(
				'usuario.id as user_id',
				'usuario.username',
				'usuario.dir as user_dir',
				'usuario.nombre',
				'usuario.apellido',
				'usuario.telefono',
				'usuario.email',
				'estado.nombre as est',
				'municipio.nombre as mun',
				'parroquia.nombre as par',
				'facturas.*',
				'direcciones.email',
				'direcciones.dir as dir_name',
			)
		);
		return View::make('admin.showPayment')
		->with('title',$title)
		->with('fac',$fac)
		->with('facNot',$facNot);
	}
	public function getPurchases($id)
	{
		$title = "Ver factura | guacamayastores.com.ve";

		$fac = Facturas::find($id);
		$x 	 = FacturaItem::where('factura_id','=',$id)->sum('item_qty');
		$aux = FacturaItem::where('factura_id','=',$id)->get(array('item_id','item_qty'));
		$i = 0;
		foreach ($aux as $a) {
			$b = Items::find($a->item_id);
			$b->qty = $a->item_qty;
			$aux = Misc::where('item_id','=',$a->item_id)->where('deleted','=',0)->first();
			$b->img = Images::where('misc_id','=',$aux->id)->where('deleted','=',0)->first(); 
			$item[$i] = $b;
			$i++;

		}
		$total = 0;
		return View::make('admin.showFactura')
		->with('title',$title)
		->with('total',$total)
		->with('items',$item)
		->with('id',$id);
	}
	public function postPaymentAprove()
	{
		$id  = Input::get('id');
		$fac = Facturas::find($id);
		$fac->pagada = 1;
		$user = User::find($fac->user_id);
		if($fac->save())
		{
			$data = array(
				'username' => Auth::user()->username,
				'fac'  	   => $id,
				'fecha'	   => date('d-m-Y',time())
			);
			Mail::send('emails.aprob', $data, function ($message) use ($id){
				    $message->subject('Correo de aviso guacamayastores.com.ve');
				    $message->to('someemail@guacamayastores.com.ve');
			});
			return Response::json(array('type' => 'success','msg' => 'Pago Aprovado correctamente.'));
		}else
		{
			return Response::json(array('type' => 'danger','msg' => 'Error al aprovar el pago.'));
		}
	}
	public function postPaymentElim()
	{
		$id = Input::get('id');
		$motivo = Input::get('motivo');
		$fac = Facturas::find($id);
		$fi  = FacturaItem::where('factura_id','=',$fac->id)->get();
		foreach ($fi as $f) {
			$item = Misc::where('item_id','=',$f->item_id)
			->where('item_talla','=',$f->item_talla)
			->where('item_color','=',$f->item_color)
			->first();
			$item->item_stock = $item->item_stock+$f->item_qty;
			$item->save();

		}
		$fac->deleted = 1;
		$fac->save();
		$user = User::find($fac->user_id);
		if ($fac->save()) {
			$data = array(
				'username' => Auth::user()->username,
				'fac'  	   => $id,
				'fecha'	   => date('d-m-Y',time()),
				'motivo'   => $motivo,
			);
			Mail::send('emails.reject', $data, function ($message) use ($id,$motivo){
				    $message->subject('Correo de aviso guacamayastores.com.ve');
				    $message->to('someemail@guacamayastores.com.ve');
			});
			return Response::json(array('type' => 'success','msg' => 'Pago Aprovado correctamente.'));
		}else
		{
			return Response::json(array('type' => 'danger','msg' => 'Error al aprovar el pago.'));
		}
	}
	public function postPaymentReject()
	{
		$id = Input::get('id');
		$motivo = Input::get('motivo');
		$fac = Facturas::find($id);
		$fac->pagada = 0;
		$user = User::find($fac->user_id);
		if ($fac->save()) {
			$data = array(
				'username' => Auth::user()->username,
				'fac'  	   => $id,
				'fecha'	   => date('d-m-Y',time()),
				'motivo'   => $motivo,
			);
			Mail::send('emails.reject', $data, function ($message) use ($id,$motivo){
				    $message->subject('Correo de aviso guacamayastores.com.ve');
				    $message->to('someemail@guacamayastores.com.ve');
			});
			return Response::json(array('type' => 'success','msg' => 'Pago Aprovado correctamente.'));
		}else
		{
			return Response::json(array('type' => 'danger','msg' => 'Error al aprovar el pago.'));
		}
	}
	public function getPaymentAproved()
	{
		$title = "Pagos aprobados";
		$title = "Pagos | guacamayastores.com.ve";
		$fac = Facturas::join('direcciones','direcciones.id','=','facturas.dir')
		->join('usuario','usuario.id','=','facturas.user_id')
		->leftJoin('estado','usuario.estado','=','estado.id')
		->leftJoin('municipio','usuario.municipio','=','municipio.id')
		->leftJoin('parroquia','usuario.parroquia','=','parroquia.id')
		->leftJoin('bancos','bancos.id','=','facturas.banco')
		->where('pagada','=',1)->orderBy('facturas.id','DESC')
		->get(
			array(
				'usuario.id as user_id',
				'usuario.username',
				'usuario.dir as user_dir',
				'usuario.nombre',
				'usuario.apellido',
				'usuario.telefono',
				'usuario.email',
				'estado.nombre as est',
				'municipio.nombre as mun',
				'parroquia.nombre as par',
				'facturas.*',
				'direcciones.email',
				'direcciones.dir as dir_name',
				'bancos.banco'
			)
		);
		$type = "apr";
		return View::make('admin.showPayment')
		->with('title',$title)
		->with('fac',$fac)
		->with('type',$type);
	}
	public function getNewBank()
	{
		$title = "Nuevo banco";
		return View::make('admin.newBank')
		->with('title',$title);
	}
	public function postNewBank()
	{
		$inp 	= Input::all();
		$rules  = array(
			'banco' 		=> 'required',
			'numCuenta'		=> 'required',
			'tipoCuenta'	=> 'required',
			'img'			=> 'required|image|max:3000'
		);

		$msg 	= array(
			'required'	=> 'El campo es obligatorio',
			'image'		=> 'El archivo debe ser una imagen',
			'max'		=> 'El archivo no debe tener mas de 3Mb'
		);
		$validator = Validator::make($inp,$rules,$msg);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$banco = new Bancos;
		$banco->banco 		= $inp['banco'];
		$banco->num_cuenta	= $inp['numCuenta'];
		$banco->tipo 		= $inp['tipoCuenta'];
		$file = Input::file('img');
		if (file_exists('images/bancos/'.$file->getClientOriginalName())) {
			//guardamos la imagen en public/imgs con el nombre original
            $i = 0;//indice para el while
            //separamos el nombre de la img y la extensión
            $info = explode(".",$file->getClientOriginalName());
            //asignamos de nuevo el nombre de la imagen completo
            $miImg = $file->getClientOriginalName();
            //mientras el archivo exista iteramos y aumentamos i
            while(file_exists('images/bancos/'. $miImg)){
                $i++;
                $miImg = $info[0]."(".$i.")".".".$info[1];              
            }
            //guardamos la imagen con otro nombre ej foto(1).jpg || foto(2).jpg etc
            $file->move("images/bancos/",$miImg);
            $blank = Image::make('images/blank400x200.jpg');

            $img = Image::make('images/bancos/'.$miImg);
            if ($img->width() > $img->height()) {
            	$img->widen(400);
            }else
            {
            	$img->heighten(200);
            }
            
	        $blank->insert($img,'center')
	           ->interlace()
	           ->save('images/bancos/'.$miImg);
            if($miImg != $file->getClientOriginalName()){
            	$banco->imagen = $miImg;
            }
		}else
		{
			$file->move("images/bancos/",$file->getClientOriginalName());
			$blank = Image::make('images/blank.jpg');
			$img = Image::make('images/bancos/'.$file->getClientOriginalName());
            if ($img->width() > $img->height()) {
            	$img->widen(400);
            }else
            {
            	$img->heighten(200);
            }

            $blank->insert($img,'center')
           ->interlace()
           ->save('images/bancos/'.$file->getClientOriginalName());
           $banco->imagen = $file->getClientOriginalName();
		}
		if ($banco->save()) {
			Session::flash('success', 'Banco creado satisfactoriamente');
			return Redirect::to('administrador/editar-banco');
		}else
		{
			Session::flash('error','Error al crear el banco');
			return Redirect::back();
		}
	}
	public function getEditBank()
	{
		$title = "Editar bancos";
		$bancos = Bancos::where('deleted','=',0)->get();
		return View::make('admin.editBanks')
		->with('title',$title)
		->with('bancos',$bancos);
	}
	public function getEditBankId($id)
	{
		$title ="Editar banco";
		$banco = Bancos::find($id);
		return View::make('admin.editBankSelf')
		->with('title',$title)
		->with('banco',$banco);
	}
	public function postEditBankId($id)
	{
		$inp 	= Input::all();
		$rules  = array(
			'banco' 		=> 'required',
			'numCuenta'		=> 'required',
			'tipoCuenta'	=> 'required'
		);

		$msg 	= array(
			'required'	=> 'El campo es obligatorio'
		);
		$validator = Validator::make($inp,$rules,$msg);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$banco 				= Bancos::find($id);
		$banco->banco 		= $inp['banco'];
		$banco->num_cuenta	= $inp['numCuenta'];
		$banco->tipo 		= $inp['tipoCuenta'];
		if (Input::hasFile('img')) {
			$file = Input::file('img');
			if (file_exists('images/bancos/'.$file->getClientOriginalName())) {
				//guardamos la imagen en public/imgs con el nombre original
	            $i = 0;//indice para el while
	            //separamos el nombre de la img y la extensión
	            $info = explode(".",$file->getClientOriginalName());
	            //asignamos de nuevo el nombre de la imagen completo
	            $miImg = $file->getClientOriginalName();
	            //mientras el archivo exista iteramos y aumentamos i
	            while(file_exists('images/bancos/'. $miImg)){
	                $i++;
	                $miImg = $info[0]."(".$i.")".".".$info[1];              
	            }
	            //guardamos la imagen con otro nombre ej foto(1).jpg || foto(2).jpg etc
	            $file->move("images/bancos/",$miImg);
	            $blank = Image::make('images/blank400x200.jpg');

	            $img = Image::make('images/bancos/'.$miImg);
	            if ($img->width() > $img->height()) {
	            	$img->widen(600);
	            }else
	            {
	            	$img->heighten(300);
	            }
	            
		        $blank->insert($img,'center')
		           ->interlace()
		           ->save('images/bancos/'.$miImg);
	            if($miImg != $file->getClientOriginalName()){
	            	$banco->imagen = $miImg;
	            }
			}else
			{
				$file->move("images/bancos/",$file->getClientOriginalName());
				$blank = Image::make('images/blank.jpg');
				$img = Image::make('images/bancos/'.$file->getClientOriginalName());
	            if ($img->width() > $img->height()) {
	            	$img->widen(600);
	            }else
	            {
	            	$img->heighten(300);
	            }

	            $blank->insert($img,'center')
	           ->interlace()
	           ->save('images/bancos/'.$file->getClientOriginalName());
	           $banco->imagen = $file->getClientOriginalName();
			}
		}
		if ($banco->save()) {
			Session::flash('success', 'Banco creado satisfactoriamente');
			return Redirect::to('administrador/editar-banco');
		}else
		{
			Session::flash('error','Error al crear el banco');
			return Redirect::back();
		}
	}
	public function postElimBank()
	{
		if (Request::ajax()) {
			$id = Input::get('id');
			$banco = Bancos::find($id);
			$banco->deleted = 1;
			if ($banco->save()) {
				return Response::json(array('type' => 'success','msg' => 'Banco eliminado satisfactoriamente'));
			}else
			{
				return Response::json(array('type' => 'danger','msg' => 'Error al eliminar el banco'));
			}
		}
	}
}