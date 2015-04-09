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
			Session::flash('success','Dirección guardada correctamente.');
			return Redirect::to('mis-compras/'.$dir->id);
		}
	}
	public function getItemPursache($id)
	{
		
	}
}