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
		$id = Input::get('pub_id');
		$pub = Publicaciones::find($id);
		$file = Input::file('file');
		$campo = "";
		if (empty($pub->img_2)) {
			$pub->img_2 = Auth::user()['username'].'/'.$file->getClientOriginalName();
			$campo = 'img_2';
		}elseif(empty($pub->img_3))
		{
			$pub->img_3 = Auth::user()['username'].'/'.$file->getClientOriginalName();
			$campo = 'img_3';
		}elseif(empty($pub->img_4))
		{
			$pub->img_4 = Auth::user()['username'].'/'.$file->getClientOriginalName();
			$campo = 'img_4';
		}elseif(empty($pub->img_5))
		{
			$pub->img_5 = Auth::user()['username'].'/'.$file->getClientOriginalName();
			$campo = 'img_5';
		}elseif(empty($pub->img_6))
		{
			$pub->img_6 = Auth::user()['username'].'/'.$file->getClientOriginalName();
			$campo = 'img_6';
		}elseif(empty($pub->img_7))
		{
			$pub->img_7 = Auth::user()['username'].'/'.$file->getClientOriginalName();
			$campo = 'img_7';
		}elseif(empty($pub->img_8))
		{
			$pub->img_8 = Auth::user()['username'].'/'.$file->getClientOriginalName();
			$campo = 'img_8';
		}

		if (file_exists('images/pubImages/'.Auth::user()['username'].'/'.$file->getClientOriginalName())) {
			//guardamos la imagen en public/imgs con el nombre original
            $i = 0;//indice para el while
            //separamos el nombre de la img y la extensión
            $info = explode(".",$file->getClientOriginalName());
            //asignamos de nuevo el nombre de la imagen completo
            $miImg = $file->getClientOriginalName();
            //mientras el archivo exista iteramos y aumentamos i
            while(file_exists('images/pubImages/'.Auth::user()['username'].'/'. $miImg)){
                $i++;
                $miImg = $info[0]."(".$i.")".".".$info[1];              
            }
            //guardamos la imagen con otro nombre ej foto(1).jpg || foto(2).jpg etc
            $file->move("images/pubImages/".Auth::user()['username'],$miImg);
            $img = Image::make('images/pubImages/'.Auth::user()['username'].'/'.$miImg)
	           ->heighten(180)
	           ->insert('images/logo.png')
	           ->save('images/pubImages/'.Auth::user()['username'].'/'.$miImg);
            if($miImg != $file->getClientOriginalName()){
                if ($campo == 'img_2') {
					$pub->img_2 = Auth::user()['username'].'/'.$miImg;
				}elseif(empty($pub->img_3))
				{
					$pub->img_3 = Auth::user()['username'].'/'.$miImg;
				}elseif($campo == 'img_4')
				{
					$pub->img_4 = Auth::user()['username'].'/'.$miImg;
				}elseif($campo == 'img_5')
				{
					$pub->img_5 = Auth::user()['username'].'/'.$miImg;
				}elseif($campo == 'img_6')
				{
					$pub->img_6 = Auth::user()['username'].'/'.$miImg;
				}elseif($campo == 'img_7')
				{
					$pub->img_7 = Auth::user()['username'].'/'.$miImg;
				}elseif($campo == 'img_8')
				{
					$pub->img_8 = Auth::user()['username'].'/'.$miImg;
				}
            }
		}else
		{
			$file->move("images/pubImages/".Auth::user()['username'],$file->getClientOriginalName());
			 $img = Image::make('images/pubImages/'.Auth::user()['username'].'/'.$file->getClientOriginalName())
	            ->heighten(180)
	            ->insert('images/logo.png')
	            ->save('images/pubImages/'.Auth::user()['username'].'/'.$file->getClientOriginalName());
		}
		$pub->save();
        return Response::json(array('esto' => $file->getClientOriginalName()));

        if( $upload_success ) {
        	return Response::json('success', 200);
        } else {
        	return Response::json('error', 400);
        }
	}
}