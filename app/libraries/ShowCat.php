<?php

class ShowCat
{
	static function Show()
	{
		$cat = Cat::where('deleted','=',0)->get(array('categorias.id','categorias.cat_nomb'));
		$i = 0;
		$subcat = array();
		foreach($cat as $c)
		{
			$aux = SubCat::where('cat_id','=',$c->id)->where('deleted','=',0)->get();
			$subcat[$c->id] = $aux->toArray();
		}
		echo '<ul>';
		foreach($cat as $c)
		{
			

				echo '<li><label class="">
            		<a href="'.URL::to('categorias/'.$c->id).'" class="aSinFormato">'.$c->cat_nomb.'</a></label></li>';
      }
      echo '</ul>';
	}
}