@extends('layouts.'.$layout)
@section('content')

<div class="row">
	<div class="container">
		<div class="col-xs-12">
			<div class="col-xs-10 contCentrado contdeColor">
				<legend>{{ $art->item_nomb.' - '.$art->item_cod }}</legend>
				<div class="col-xs-8">
					<div class="col-xs-12 imgProd">

						<img src="{{ asset('images/items/'.$art->img[$art->misc]['img_1']) }}" class="imgPrinc">
					</div>
					<div class="col-xs-12 minis">
						@foreach($art->img as $img)
							@foreach($img as $i)
							@if(!empty($i))
								<img src="{{ asset('images/items/'.$i) }}" class="imgMini">
							@endif
							@endforeach
						@endforeach
					</div>
				</div>
				<div class="col-xs-4 textoPromedio">
					<div class="col-xs-12">
						<label>Descripción</label>
						{{ $art->item_desc }}
					</div>

					<div class="col-xs-12">
						<label>Talla</label>
						<select class="form-control talla">
							@foreach($tallas as $t)
								@if($t->talla_nomb.' - '.$t->talla_desc == $art->talla[$art->misc])
									<option value="{{ $t->id }}" selected>{{ $t->talla_nomb.' - '.$t->talla_desc }}</option>
								@else
									<option value="{{ $t->id }}">{{ $t->talla_nomb.' - '.$t->talla_desc }}</option>
								@endif
							@endforeach
						</select>
					</div>
					<div class="col-xs-12">
						<label>Color</label>
						<select class="form-control color">
							@foreach($colores as $c)
								@if($c->color_desc == $art->color[$art->misc])
									<option value="{{ $c->id }}" selected> {{$c->color_desc }} </option>
								@else
									<option value="{{ $c->id }}">{{$c->color_desc }}</option>
								@endif
							@endforeach
						</select>
					</div>
					<div class="col-xs-12">
						<label>Cantidad</label>
						{{ $art->item_stock }}
						<input type="hidden" class="values" data-art-id="{{ $art->id }}" data-misc-id="{{ $art->misc }}">
					</div>
					@if(Auth::check() && Auth::user()->role != 1)
					<div class="col-xs-12">
						<form method="POST" action="{{ URL::to('agregar-al-carrito') }}">
							<button class="btn btn-warning">Agregar al carrito.</button>
							<input type="hidden" name="id" value="{{ $art->id }}">
							<input type="hidden" name="nombre" value="{{ $art->item_nomb}}">
							<input type="hidden" name="precio" value="{{ $art->item_precio}}">
							<input type="hidden" name="stock" value="{{ $art->item_stock }}">
						</form>
					</div>
					@endif
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>

@stop