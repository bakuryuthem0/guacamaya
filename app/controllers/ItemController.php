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

			return Response::json(array('img' => $img,'id' => $item->id,'name' => $item->name,'qty' => $item->qty,'price' => $item->price,'cantArt' => Cart::count(),'total' => Cart::total()));
		}
	}
	public function dropCart()
	{
		Cart::destroy();
		
		return Response::json(array('type' => 'success'));
		
		/*para eliminar en especifico creo q esto puede funcionar

	$rowid = Cart::search(array('id' => $inp['id']));
			return Cart::get($rowid[0]);
		*/
	}
}