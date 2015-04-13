<?php

class AuthController extends BaseController {

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

		$title = "Inicio de Sesión";
		if (Auth::check())
        {
            return Redirect::to('inicio');
        }

		return View::make('login')->with('title',$title);

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
	public function getRegister()
	{
		$title = 'Registro de usuario';
		$estados = Estados::get();
		return View::make('indexs.register')->with('title',$title)->with('estados',$estados);
	}
	public function postRegister()
	{
		$input = Input::all();
		$rules = array(
			'username'   			 => 'required|min:4|unique:usuario',
			'pass'      		 	 => 'required|min:6|confirmed',
			'pass_confirmation'      => 'required',
			'name'       			 => 'required|min:4',
			'lastname'   			 => 'required|min:4',
			'email'      			 => 'required|email|unique:usuario',
			'dir' 			 		 => 'required',
			'estado'				 => 'required',
			'municipio'				 => 'required',
			'g-recaptcha-response'   => 'required',

		);
		$messages = array(
			'required' => ':attribute es obligatoria',
			'min'      => ':attribute debe ser mas largo',
			'email'    => 'Debe introducir un email válido',
			'unique'   => ':attribute ya existe',
			'confirmed'=> 'La contraseña no concuerdan'
		);
		$custom = array(
			'username' 			=> 'EL campo nombre de usuario',
			'pass'    	 		=> 'El campo contraseña',
			'pass_confirmation' => 'El campo confirmacion de la contraseña',
			'name'              => 'El campo nombre',
			'lastname'          => 'El campo apellido',
			'email' 			=> 'El campo email',
			'dir'  			    => 'El campo departamento',
			'estado'			=> 'El campo estado',
			'municipio'			=> 'El campo municipio',
			'g-recaptcha-response' => 'El captcha'
		);
		$validator = Validator::make($input, $rules, $messages,$custom);
		if ($validator->fails()) {
			return Redirect::to('registro')->withErrors($validator)->withInput();
		}
		$codigo = md5(rand());
		$user = new User;
		$user->username 	 = $input['username'];
		$user->password    	 = Hash::make($input['pass']);
		$user->email    	 = $input['email'];
		$user->nombre    	 = $input['name'];
		$user->apellido 	 = $input['lastname'];
		$user->estado  		 = $input['estado'];
		$user->municipio     = $input['municipio'];
		$user->role 		 = 3;
		if (!empty($input['parroquia'])) {
			$user->parroquia  		 = $input['parroquia'];	
		}
		if (!empty($input['telefono'])) {
			$user->telefono = $input['telefono'];
		}
		$user->role          = 'Usuario';
		
		if ($user->save()) {
			Session::flash('success', 'Su cuenta fue creada satisfractoriamente, inicie sesión para disfrutar de nuestros servicios.');
			return Redirect::to('iniciar-sesion');
			
		}else
		{
			Session::flash('error','Error al crear el usuario, por favor contacte con el administrador del sitio');
			return Redirect::to('registro');

		}
	}
	public function getCode($username,$codigo)
	{
		$user = User::where('username','=',$username)->get(array('id','register_cod','register_cod_active'));
		if ($user[0]->register_cod_active == 0) {
			$title = "Link usado";
			Session::flash('error','El link al que accedio ya fue usado o ha caducado, de ser así llene el formulario nuevamente, o inicie sesión');
			return View::make('indexs.login')->with('title',$title);
		}
		if ($user[0]->register_cod == $codigo) {
			$up = User::find($user[0]->id);
			$up->register_cod_active = 0;
			if ($up->save()) {
				Session::flash('success','Usuario creado, inicie sesión para disfrutar de los servicios');	
			}else
			{
				Session::flash('error','Error al crear el usuario');
			}
			$title ="Activación de nuevo usuario completa";
			
			return View::make('indexs.login')->with('title',$title);
		}else
		{
			$title = "Activación fallida";
			Session::flash('error','Codigo incorrecto');
			return View::make('indexs.login')->with('title',$title);
		}
	}
	public function postEmailCheck()
	{
		if (Request::ajax()) {
			$email = Input::get('email');
			$user = User::where('email','=',$email)->get();
			if (count($user)<1) {
				return Response::json(array('type' => 'danger','msg' => 'Error, el email no existe.'));
			}else
			{

				$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
			    //Obtenemos la longitud de la cadena de caracteres
			    $longitudCadena=strlen($cadena);
			     
			    //Se define la variable que va a contener la contraseña
			    $pass = "";
			    //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
			    $longitudPass=8;
			    
			    //Creamos la contraseña
			    for($i=1 ; $i<=$longitudPass ; $i++){
			        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
			        $pos=rand(0,$longitudCadena-1);
			     
			        //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
			        $pass .= substr($cadena,$pos,1);
			    }
			    $user[0]->password = Hash::make($pass);
			  	$data = array(
					'pass' => $pass,
					'texto' => 'Usted ha solicitado recuperar su contraseña',
					'title' => 'recuperar contraseña'
				);

			  	if ($user[0]->save()) {
			  		Mail::send('emails.passNew', $data, function ($message) use ($pass,$email){
					    $message->subject('Correo de restablecimiento de contraseña guacamayastores.com.ve');
					    $message->to($email);
					});
					return Response::json(array('type' => 'success','msg' => 'Se ha enviado un email con una clave provisional.'));

			  	}else
			  	{
					return Response::json(array('type' => 'danger','msg' => 'Error, no se ha podido cambiar la contraseña, le agradecemos ponerse en contacto por medio de nuestro modulo de contacto.'));
			  	}
			    

			}
			
		}
	}
	public function getState()
	{
		if (Request::ajax()) {
			$id = Input::get('id');
			$municipio = Municipios::where('estado_id','=',$id)->get();
			return $municipio;
		}
	}
	public function getParroquia()
	{
		if (Request::ajax()) {
			$id = Input::get('id');
			$parroquia = Parroquias::where('municipio_id','=',$id)->get();
			return $parroquia;
		}
	}
}
