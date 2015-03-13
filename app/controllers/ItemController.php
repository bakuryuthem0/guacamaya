<?php

class ItemController extends BaseController {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function getItem()
	{
		$inp = Input::all();
		Cart::add(array('id' => $inp['id'],'name' => $inp['nombre'],'qty' => 1,'price' => $inp['precio']));
		return  Cart::content();
	}

}