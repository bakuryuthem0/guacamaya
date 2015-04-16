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
			->with('estados',$estados)
			->with('user',$user);
		}		
		
	}
	public function postProfile()
	{
		$input = Input::all();
		$user = User::find(Auth::user()->id);
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
	public function getMyPurchases()
	{
		$title = "Mis compras | guacamayastores.com.ve";
		$fac = Facturas::where('user_id','=',Auth::user()->id)->orderBy('id','DESC')->get();
		return View::make('user.myPurchases')
		->with('title',$title)
		->with('fac',$fac);
	}
	public function getMyPurchase($id)
	{
		$title = "Factura";
		$fac   = Facturas::find($id);
		$user = User::find($fac->user_id);
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
		return View::make('user.factura')
		->with('fact',$item)
		->with('title',$title)
		->with('user',$user)
		->with('factura',$fac);
	}
}