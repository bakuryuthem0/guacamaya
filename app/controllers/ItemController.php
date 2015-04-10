<?php

class ItemController extends BaseController {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function getItem()
	{
		if (Request::ajax()) {
			$inp = Input::all();
			$misc = Misc::where('item_id','=',$inp['id'])->where('deleted','=',0)->first();

			$img = Images::where('deleted','!=',1)->where('misc_id','=',$misc->id)->first();
			Cart::add(array('id' => $inp['id'],'name' => $inp['name'],'qty' => 1,'options' =>array('img' => $img->image),'price' => $inp['price']));
			$rowid = Cart::search(array('id' => $inp['id']));
			$item = Cart::get($rowid[0]);

			return Response::json(array(
				'rowid'		=> $rowid[0],
				'img' 		=> $img->image,
				'id' 		=> $item->id,
				'name' 		=> $item->name,
				'qty' 		=> $item->qty,
				'price' 	=> $item->price,
				'subtotal'	=>$item->subtotal,
				'cantArt' 	=> Cart::count(),
				'total' 	=> Cart::total()
			));
		}
	}
	public function addItem()
	{
		if (Request::ajax()) {
			$id = Input::get('id');
			$cart = Cart::get($id);
			$qty = $cart->qty;
			Cart::update($id,$qty+1);
			$count = Cart::count();
			$total = Cart::total();
			return Response::json(array('type' => 'success','count' => $count,'total' => $total,'qty' => $cart->qty,'id' => $cart->id,'subtotal'=>$cart->subtotal));
		}
	}
	public function dropItem()
	{
		if (Request::ajax()) {
			$id = Input::get('id');
			$cart = Cart::get($id);
			Cart::remove($id);
			$count = Cart::count();
			$total = Cart::total();
			return Response::json(array('type' => 'success','id' =>$cart->id,'count' => $count,'total' => 'total'));
		}
	}
	public function dropCart()
	{
		if (Request::ajax()) {
			Cart::destroy();
			
			return Response::json(array('type' => 'success'));
		}
		
	}
	public function restItem()
	{
		if (Request::ajax()) {
			$id = Input::get('id');
			$cart = Cart::get($id);
			$qty = $cart->qty;
			Cart::update($id,$qty-1);
			$count = Cart::count();
			$total = Cart::total();
			return Response::json(array('type' => 'success','count' => $count,'total' => $total,'qty' => $cart->qty,'id' => $cart->id,'subtotal'=>$cart->subtotal));
		}
	}
	public function getCart()
	{
		$title = "Mi carrito";
		$c   = Dir::where('user_id','=',Auth::user()->id)->count();
		if ($c > 0) {
			$dir   = Dir::where('user_id','=',Auth::user()->id)->get();
		}else{
			$dir   = array();
		}
		return View::make('indexs.showCart')
		->with('title',$title)
		->with('dir',$dir);
	}
	public function getRefresh()
	{
		if (Request::ajax()) {
			$id = Input::get('id');
			$qty = Input::get('qty');
			$cart = Cart::get($id);
			Cart::update($id,$qty);
			$count = Cart::count();
			$total = Cart::total();
			return Response::json(array('type' => 'success','count' => $count,'total' => $total,'qty' => $cart->qty,'id' => $cart->id,'subtotal'=>$cart->subtotal));
		}
	}
	public function postDir()
	{
		$id = Input::get('dir');
		if ($id == 'user_id') {
			$dir = array('dir' =>Auth::user()->dir,'email' => Auth::user()->email);
		}else
		{
			$dir = Dir::find($id);
		}
		$fac = new Facturas;
		$fac->user_id =  Auth::user()->id;
		$fac->dir     = $dir['dir'];
		if($fac->save())
		{
			foreach (Cart::content() as $c) {
				$itemFac = new FacturaItem;
				$itemFac->factura_id = $fac->id;
				$itemFac->item_id    = $c->id;
				$itemFac->item_qty	 = $c->qty;
				$itemFac->save();
			}
			Cart::destroy();
			return Redirect::to('compra/procesar');			
		}
	}
	public function postPurchaseAndNewDir()
	{
		$input = Input::all();
		$rules = array(
			'email' => 'required|email',
			'dir'   => 'required'
		);
		$msg = array(
			'required' => 'Campo requerido',
			'email'	   => 'El campo debe ser un email'
		);
		$validator = Validator::make($input,$rules,$msg);
		if ($validator->fails()) {
			Redirect::back()->withError($validator)->withInput();
		}
		$dir = new Dir;
		$dir->user_id = Auth::user()->id;
		$dir->email   = $input['email'];
		$dir->dir 	  = $input['dir'];
		if ($dir->save()) {
			$fac = new Facturas;
			$fac->user_id =  Auth::user()->id;
			$fac->dir 	  = $dir->dir;
			if($fac->save())
			{
				foreach (Cart::content() as $c) {
					$itemFac = new FacturaItem;
					$itemFac->factura_id = $fac->id;
					$itemFac->item_id    = $c->id;
					$itemFac->item_qty	 = $c->qty;
					$itemFac->save();
				}
				Cart::destroy();
				return Redirect::to('compra/procesar/'.$fac->id);			
			}
		}
	}
	public function getProcesePurchase($id)
	{
		return $id;
		$title = "Metodo de pago | guacamayastores.com.ve";
		$method= "hola";
		$mp = new MP('8718886882978199','K1SlqcrxB2kKnnrhxt6PCyLtC6RuSuux');
		
		return View::make('indexs.showCart')
		->with('title',$title)
		->with('method',$method);
	}

	public function postPayment(){
		$input = Input::all();
		$id = $input['enviarPago'];
		$rules = array('transNumber' => 'required|numeric');
		$messages = array('required' => 'El numero de transacción es obligatorio.','numeric' => 'El campo debe ser un número.');
		$validator = Validator::make($input, $rules, $messages);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		}
		$fac 		  	= new Facturas;
		$fac->user_id 	= Auth::user()->id;
		$fac->num_trans = $input['enviarPago'];
		
		if ($fac->save()) {
			$subject = "Correo de administrador";
			$data = array(
				'subject' => $subject,
				'createBy'=> Auth::user()->username,
				'monto'   => Cart::total(),
				'num_trans' => $input['transNumber']
			);
			$to_Email = 'ejemplo@gmail.com';
			Mail::send('emails.newPayment', $data, function($message) use ($input,$to_Email,$subject)
			{
				$message->to($to_Email)->from('sistema@guacamayastores.com.ve')->subject($subject);
			});
			Session::flash('success', 'Pago enviado, pronto procesaremos su pago');
			return Redirect::to('usuario/publicaciones/mis-publicaciones');
		}else
		{
			Session::flash('error', 'Error al guardar el pago');
			return Redirect::to('usuario/publicaciones/mis-publicaciones');
		}
	}
}