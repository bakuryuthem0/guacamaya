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
}