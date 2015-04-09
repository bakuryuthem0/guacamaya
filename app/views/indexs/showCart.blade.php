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
            <buttom class="btn btn-success" data-toggle="collapse" href="#continuar">Continuar</buttom>
            
		</div>
    <div class="collapse contdeColor col-xs-12" id="continuar" style="margin-top:2em;">
      <div class="col-xs-6">
      </div>
       @if((!empty(Auth::user()->dir) && !is_null(Auth::user()->dir)) || count($dir) > 0)
       <legend>Usar dirección creada</legend>
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th></th>
              <th>Email</th>
              <th>Dirección</th>
            </tr>
          </thead>
          <tbody>
            @if(!empty(Auth::user()->dir) && !is_null(Auth::user()->dir))
              <tr>
                <td class="textoPromedio" style="color:white;"><input type="radio" name="dir" value="{{ Auh::user()->dir }}"></td>
                <td class="textoPromedio" style="color:white;">{{ Auth::user()->email }}</td>
                <td class="textoPromedio" style="color:white;">{{ Auth::user()->dir }}</td>
              </tr>
            @endif

            @if(count($dir) > 0)
              @foreach($dir as $d)
                <tr>
                  <td class="textoPromedio" style="color:white;"><input type="radio" name="dir" value="{{ $d->dir }}"></td>
                  <td class="textoPromedio" style="color:white;">{{ $d->email }}</td>
                  <td class="textoPromedio" style="color:white;">{{ $d->dir }}</td>
                </tr>
              @endforeach
            @endif

          </tbody>
        </table>
      @endif
      <hr>
      <div class="col-xs-6">
        <h3>Usar nueva direccion</h3>
        <p class="bg-info textoPromedio" style="padding:0.5em;">En caso de no tener una direccion registrada o desee agregar una nueva llene el siguiente formulario</p>
        <form method="POST" action="{{ URL::to('comprar/ver-carrito/agragar-y-comprar') }}" >
          <label class="textoPromedio">Email.</label>
          <input type="text" class="form-control" name="email" placeholder="Email" value="{{ Input::old('email') }}" required>
          @if ($errors->has('email'))
             @foreach($errors->get('email') as $err)
              <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p class="textoPromedio">{{ $err }}</p>
              </div>
             @endforeach
          @endif
          <br>
          <label class="textoPromedio">Dirección</label>
          <textarea class="form-control" name="dir" placeholder="Dirección" required>{{ Input::old('dir') }}</textarea>
          @if ($errors->has('dir'))
               @foreach($errors->get('dir') as $err)
                <div class="alert alert-danger">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <p class="textoPromedio">{{ $err }}</p>
                </div>
               @endforeach
            @endif
          <br>
          <button class="btn btn-success">Enviar y comprar</button>
        </form>
      </div>
      </div>
	</div>
</div>
@stop