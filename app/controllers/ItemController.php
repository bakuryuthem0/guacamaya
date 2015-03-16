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
			Cart::add(array('id' => $inp['id'],'img' => $img,'name' => $inp['name'],'qty' => 1,'price' => $inp['price']));
			return Response::json(array('cantArt' => Cart::count(),'total' => Cart::total()));
		}
	}
	public function dropCart()
	{
		if(Cart::destroy())
		{
			return Response::json(array('type' => 'success'));
		}

	}
}