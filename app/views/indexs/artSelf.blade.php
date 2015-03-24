@extends('layouts.'.$layout)
@section('content')

<div class="row">
	<div class="container">
		<div class="col-xs-12">
			<div class="col-xs-10 contCentrado contdeColor">
				<legend>{{ $art->item_nomb.' - '.$art->item_cod }}</legend>
				<div class="col-xs-8">
					<div class="col-xs-12 imgProd">
						<input type="hidden" id="art_id" value="{{ $art->id }}">
						<img src="{{ asset('images/items/'.$art->images[0]->image) }}" class="imgPrinc">
					</div>
					<div class="col-xs-12 minis">
						@foreach($art->images as $a)
							<img src="{{ asset('images/items/'.$a->image) }}" class="imgMini">
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
								<?php $nop = 1;?>
								@foreach($art->tallas as $at)
									@if($at->id == $t->id)
										<?php $nop = 0;?>
									@endif
								@endforeach

								@if($nop == 0)
									<option value="{{ $t->id }}">{{ strtoupper($t->talla_nomb).' - '.ucfirst($t->talla_desc) }}</option>
								@else
									<option class="disabled" disabled value="{{ $t->id }}">{{ strtoupper($t->talla_nomb).' - '.ucfirst($t->talla_desc) }}</option>
								@endif
							@endforeach
						</select>
					</div>
					<div class="col-xs-12">
						<label>Color</label>
						<select class="form-control color">
							@foreach($colores as $c)
								<?php $nop = 1;?>

								@foreach($art->colores as $ac)
									@if($ac->id == $c->id)
										<?php $nop = 0;?>
									@endif
								@endforeach

								@if($nop == 0)
									<option value="{{ $c->id }}">{{ ucfirst($c->color_desc) }}</option>
								@else
									<option class="disabled" disabled>{{ ucfirst($c->color_desc) }}</option>
								@endif

							@endforeach
						</select>
					</div>
					<div class="col-xs-12">
						<label>Cantidad</label>
						{{ $art->item_stock }}
						<input type="hidden" class="values" data-art-id="{{ $art->id }}" data-misc-id="">
					</div>
					@if(Auth::check() && Auth::user()->role != 1)
					<div class="col-xs-12">
						
							<button class="btn btn-warning btnAgg" data-price-value="{{ $art->item_precio}}" data-name-value="{{ $art->item_nomb }}" value="{{ $art->id }}">Agregar al carrito.</button>
					</div>
					@endif
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>

@stop