<?php

class UserController extends Controller {

	
	public function getProfile()
	{
		$title ="Cambiar Perfil | guacamayastores.com.ve";

		$user = User::find(Auth::user()->id);
		$estados = Estados::get();
		$mun     = Municipios::get();
		$par     = Parroquias::get();
		if (!empty($user) && $user != "" && !is_null($user) ) {
			return View::make('user.profile')
			->with('title',$title)
			->with('est',$estados)
			->with('mun',$mun)
			->with('par',$par)
			->with('user',$user);
		}		
		
	}
	public function postProfile()
	{
		$input = Input::all();
		$user = User::find(Auth::id());
		$email = $user->email;
		$rules = array(
			'estado'       			 => 'required',
			'municipio'   			 => 'required',
			'dir' 		    		 => 'required'

		);
		$messages = array(
			'required' => ':attribute es obligatorio',
		);
		$custom = array(
			'estado'              => 'El estado',
			'municipio'          => 'El municipio',
			'dir'  		=> 'El campo dirección'
		);
		$validator = Validator::make($input, $rules, $messages,$custom);
		if ($validator->fails()) {
			return Redirect::to('usuario/perfil')->withErrors($validator)->withInput();
		}
		
		if ($user->estado != $input['estado']) {
			$user->estado = $input['estado'];
		}
		if ($user->municipio != $input['municipio']) {
			$user->municipio = $input['municipio'];
		}
		if ($user->dir != $input['dir']) {
			$user->dir = $input['dir'];
		}
		if ($user->telefono != $input['phone']) {
			$user->telefono = $input['phone'];
		}
		if($user->save())
		{
			
			Session::flash('success', 'Datos Cambiados correctamente. Le hemos enviado un correo electrónico como seguridad.');
			return Redirect::to('usuario/perfil');
		}else{
			Session::flash('error','Error no se pudo modificar los datos');
			return Redirect::to('usuario/perfil');
		}
	}
}