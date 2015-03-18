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
			$img = Misc::where('deleted','=',0)->where('item_id','=',$inp['id'])->pluck('img_1');
			
			
			Cart::add(array('id' => $inp['id'],'name' => $inp['name'],'qty' => 1,'options' =>array('img' => $img),'price' => $inp['price']));
			$rowid = Cart::search(array('id' => $inp['id']));
			$item = Cart::get($rowid[0]);

			return Response::json(array('img' => $img,'id' => $item->id,'name' => $item->name,'qty' => $item->qty,'price' => $item->price,'subtotal'=>$item->subtotal,'cantArt' => Cart::count(),'total' => Cart::total()));
		}
	}
	public function addItem()
	{
		if (Request::ajax()) {
			$id = Input::get('id');
			Cart::update($id,1);
			$qty = Cart::get($id);
			$qty = $qty->qty;
			$count = Cart::count();
			$total = Cart::total();
			return Response::json(array('type' => 'success','count' => $count,'total' => $total,'qty' => $qty));
		}
	}
	public function dropItem()
	{
		if (Request::ajax()) {
			$id = Input::get('id');
			Cart::remove($id);
			$count = Cart::count();
			$total = Cart::total();
			return Response::json(array('type' => 'success','count' => $count,'total' => 'total'));
		}
	}
	public function dropCart()
	{
		if (Request::ajax()) {
			Cart::destroy();
			
			return Response::json(array('type' => 'success'));
		}
		
	}
}