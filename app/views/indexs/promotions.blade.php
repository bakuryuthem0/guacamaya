@extends('layouts.default')

@section('content')

<div class="row">
	<div class="container">
		<div class="col-xs-12">
			@if(count($art)>0)
	        @foreach($art as $a)
	          <a href="{{ URL::to('articulo/'.$a->id) }}">
	            <div class="col-xs-2 contArtPrinc">
	              <img src="{{ asset('images/prom.png') }}" class="imgArtPrinc imgPrinc promImage">
	              <img src="{{ asset('images/items/'.$img[$a->id]['image']) }}" class="imgArtPrinc imgPrinc">
	              <ul class="textoPromedio ulNoStyle">
	                <li>
	                  <label class="aSinFormato">{{ $a->item_nomb.' - Cod: '.$a->item_cod }}</label>
	                </li>
	                <li>
	                  <p class="precio" style="color:red;">Precio actual: Bs.{{ ($a->item_precio - ($a->item_precio*$a->percent)/100) }}</p> 
	                </li>
	                <li class="disabled">
	                	<p style="color:red;">Precio anterior: Bs.{{ $a->item_precio }}</p>
	                </li>
	              </ul>
	            </div>
	          </a>
	        @endforeach
	        @else
	          <div class="alert alert-warning">
	              <p class="textoPromedio" style="text-align:center;">No se encontraron articulos</p>
	          </div>
	        @endif
		</div>
	</div>
</div>
@stop