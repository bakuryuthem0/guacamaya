@extends('layouts.default')
@section('content')
<div class="row">
	<div class="container">
		<div class="col-xs-12 contdeColor">
			<legend>Mi carrito</legend>
			<table class="table table-hover tableCarrito">
               <tr>
                  <th>
                   Imagen
                  </th>
                  <th>
                   Artículo
                  </th>
                  <th>
                    Cantidad
                  </th>
                  <th>
                    Precio Unitario
                  </th>
                  <th>
                    Sub-total
                  </th>
                   <th>
                    Agregar
                  </th>
                   
                  <th>
                    <button class="btn btn-danger btn-xs btnVaciar">
                      Vaciar
                    </button>
                  </th>
                </tr>
              @foreach(Cart::content() as $cart)
                <tr class="carItems" id="{{ $cart->id }}">
                  <td class="carItem">
                    <img src="{{ asset('images/items/'.$cart->options['img']) }}" class="carImg">
                  </td>
                  <td class="carItem">
                    {{ $cart->name }}
                  </td>
                  <td class="carItem columnCant">
                    <input class="form-control cantArt" id="input{{ $cart->id }}" value="{{ $cart->qty }}">
                  </td>
                  <td class="carItem">
                    {{ $cart->price }}
                  </td>
                  <td class="carItem" id="input{{ $cart->id }}_subtotal">
                    {{ $cart->subtotal }}
                  </td>
                  <th class="carItem">
                    <button class="btn btn-success btn-xs btnActualizar btn-carrito" data-field-value="#input{{ $cart->id }}" value="{{ $cart->rowid }}">
                      Actualizar
                    </button>
                  </th>
                  
                  <th class="carItem">
                    <button class="btn btn-danger btn-xs btnQuitar btn-carrito" data-url-value="quitar-item" value="{{ $cart->rowid }}">
                      Quitar
                    </button>
                  </th>
                </tr>
              @endforeach
            </table>
            <a href="{{ URL::to('') }}" class="btn btn-success">Comprar</a>
		</div>

	</div>
</div>
@stop