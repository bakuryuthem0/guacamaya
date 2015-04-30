@extends('layouts.default')
@section('content')
<div class="row">
	<div class="container">
		<div class="col-xs-12 contdeColor">
			<legend>Mi carrito</legend>
      @if(Session::has('danger'))
        <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <p class="textoPromedio">{{ Session::get('danger') }}</p>
        </div>
      @endif
			       <table class="table table-hover tableCarrito">
               <tr class="textoPromedio">
                 @if(isset($method))
                  <th>
                    Codigo del articulo
                  </th>
                  @endif
                  <th>
                   Imagen
                  </th>
                  <th>
                   Artículo
                  </th>
                  <th>
                   Talla del Artículo
                  </th>
                  <th>
                   Color del Artículo
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
                  @if(!isset($method))
                   <th>
                    Agregar
                  </th>
                   
                  <th>
                    <button class="btn btn-danger btn-xs btnVaciar">
                      Vaciar
                    </button>
                  </th>
                  @endif
                </tr>
              @if(!isset($method))
              <?php 
              $total = 0; 
              ?>
              @foreach(Cart::content() as $cart)
                <tr class="textoPromedio carItems" id="{{ $cart->id }}">
                  <td class="carItem">
                    <img src="{{ asset('images/items/'.$cart->options['img']) }}" class="carImg">
                  </td>
                  <td class="carItem">
                    {{ $cart->name }}
                  </td>
                  <td class="carItem">
                    {{ $cart->options['talla_desc'] }}
                  </td>
                  <td class="carItem">
                    {{ $cart->options['color_desc'] }}
                  </td>
                  <td class="carItem columnCant">
                    <input class="form-control cantArt" id="input{{ $cart->id }}" value="{{ $cart->qty }}">
                  </td>
                  <td class="carItem">
                    Bs.{{ $cart->price }}
                  </td>
                  <td class="carItem" id="input{{ $cart->id }}_subtotal">
                    Bs.{{ $cart->subtotal }} 
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
                <?php $total = $total+($cart->qty*$cart->price); ?>
              @endforeach
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><h3>Total:</h3></td>
                <td><h3 class="precio total">Bs.{{ $total }}</h3></td>
              </tr>
              @else
                @foreach($items as $cart)
                <tr class="textoPromedio carItems" id="{{ $cart->id }}">
                  <td>
                    {{ $cart->item_cod }}
                  </td>
                  <td class="carItem">
                    <img src="{{ asset('images/items/'.$cart->img->image) }}" class="carImg">
                  </td>
                  <td class="carItem">
                    {{ $cart->item_nomb }}
                  </td>
                  <td class="carItem">
                    {{ $cart->item_talla }}
                  </td>
                  <td class="carItem">
                    {{ $cart->item_color }}
                  </td>
                  <td class="carItem columnCant">
                    {{ $cart->qty }}
                  </td>
                  <td class="carItem">
                    Bs.{{ $cart->precio }}
                  </td>
                  <td class="carItem" id="input{{ $cart->id }}_subtotal">
                    Bs.{{ $cart->qty*$cart->precio }}
                  </td>
                  <?php $total = $total+($cart->qty*$cart->precio); ?>
                </tr>
              @endforeach
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

                <td><h3>Total:</h3></td>
                <td><h3 class="precio total">Bs.{{ $total }}</h3></td>
              </tr>
              @endif
            </table>
            @if(!isset($method))<buttom class="btn btn-success continuar" data-toggle="collapse" href="#continuar">Continuar</buttom>@endif
            
		</div>
    @if(!isset($method))
    <div class="collapse contdeColor col-xs-12 scrollTo" id="continuar" style="margin-top:2em;">
      <div class="col-xs-6">
      
       @if((!empty(Auth::user()->dir) && !is_null(Auth::user()->dir)) || count($dir) > 0)
       <h3>Usar dirección existente</h3>
       <hr>
       <form method="POST" action="{{ URL::to('comprar/ver-carrito/enviar') }}">
        <table class="table table-striped table-hover table-dir">
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
                <td class="textoPromedio" ><input type="radio" name="dir" value="user_id"></td>
                <td class="textoPromedio" >{{ Auth::user()->email }}</td>
                <td class="textoPromedio" >{{ Auth::user()->dir }}</td>
              </tr>
            @endif

            @if(count($dir) > 0)
              @foreach($dir as $d)
                <tr>
                  <td class="textoPromedio" ><input type="radio" name="dir" value="{{ $d->id }}"></td>
                  <td class="textoPromedio" >{{ $d->email }}</td>
                  <td class="textoPromedio" >{{ $d->dir }}</td>
                </tr>
              @endforeach
            @endif

          </tbody>
        </table>
        <button class="btn btn-success">Comprar</button>
      </form>
      @endif
      </div>
      <div class="col-xs-6">
        <h3>Usar nueva direccion</h3>
        <hr>
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
    @else
    <div class="contdeColor col-xs-12 scrollTo" style="margin-top:2em;">
      <h3 style="text-align:center;">Metodos de pago</h3>
      <div class="col-xs-6">
        <h3><i class="fa fa-plus-circle iconToggle" data-toggle="collapse" href="#transferencia"></i> Transferencia en linea</h3>
        <div class="col-xs-12 collapse" id="transferencia" style="padding:2em;">
          <p class="textoPromedio">Una vez haya realizado su pago, introduzca el número de transacción en la casilla</p>
          <form method="post" action="{{ URL::to('usuario/publicaciones/pago/enviar') }}">
            <div class="col-xs-12">
              <div class="col-xs-12 formulario textoPromedio">
                <label>Banco</label>
                  <select name="banco" class="form-control">
                    <option value="">Seleccione el banco</option>
                    @foreach($bancos as $b)
                      <option value="{{ $b->id }}">{{ $b->banco.' - '.$b->num_cuenta }}</option>
                    @endforeach
                  </select>
              </div>
              <div class="col-xs-12 formulario textoPromedio">
                <label>Fecha de transacción</label>
                <input type="text" id="fecha" name="fecha" placehlder="DD-MM-YYYY" class="form-control" >
              </div>
              <div class="col-xs-12 formulario textoPromedio">
                <label>Numero de transacción</label>
                <input type="text" id="numTransVal" name="transNumber" placehlder="Numero de transaccion" class="form-control">
              </div>
                <input type="hidden" name="factId" value="{{ $id }}">
                <input type="hidden" name="total" value="{{ $total }}">
                @if ($errors->has('transNumber'))
                   @foreach($errors->get('transNumber') as $err)
                    <div class="alert alert-danger">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p class="textoPromedio">{{ $err }}</p>
                    </div>
                   @endforeach
                @endif
              <button class="btn btn-success" style="margin-top:1em;">Enviar</button>
                <a class="btn btn-primary"  data-toggle="modal" data-target="#myModalBancos" style="margin-top:1em;">CUENTAS Y ENTIDADES BANCARIAS.</a>
                
            </div>
          </form>
        </div>
      </div>
      <div class="col-xs-6">
        <h3><i class="fa fa-plus-circle iconToggle" data-toggle="collapse" href="#mpago"></i> Mercado pago</h3>
        <div class="col-xs-12 collapse" id="mpago" style="padding:2em;">
          <a href="<?php echo $preference['response']['init_point']; ?>" name="MP-Checkout" class="lightblue-M-Ov-ArOn">Pagar</a>
          <script type="text/javascript" src="https://www.mercadopago.com/org-img/jsapi/mptools/buttons/render.js"></script>
        </div>
      </div>
    </div>
    @endif
	</div>
</div>
<div class="modal fade" id="myModalBancos" tabindex="-1" role="dialog" aria-labelledby="myModalBancos" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel">Lista de bancos.</h4>
          @if(isset($bancos))
          @foreach($bancos as $b)
          <div class="col-xs-12 formulario textoPromedio">
            <label>{{ $b->banco }}</label>
            <li>Numero de cuenta: {{ $b->num_cuenta.' - Tipo de cuenta: '.$b->tipo }}</li>
            <img src="{{ URL::to('images/bancos/'.$b->imagen) }}" style="  margin: 0 auto;display: block;">
          </div>
          @endforeach
          @endif
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
</div>
@stop

@section('postscript')
<script type="text/javascript">

       $( "#fecha" ).datepicker({

      inline: true,
      showAnim: 'fadeIn',
      dateFormat: 'dd-mm-yyyy',
      minDate: 0
    });
</script>
@stop