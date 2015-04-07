@extends('layouts.'.$layout)
@section('content')

<div class="row">
	<div class="container">
		<div class="col-xs-12">
			<div class="col-xs-10 contCentrado contdeColor">
				<legend>{{ $art->item_nomb.' - '.$art->item_cod }}</legend>
				<ul id="cd-gallery-items" class="cd-container">
					<li>
						<ul class="cd-item-wrapper">
							{{ count($art->images) }}
							@for($i = 0;$i < count($art->images);$i++)
								@if($i == 0)
									<li class="cd-item-front">
										<a href="#0">
											<img src="{{ asset('images/items/'.$art->images[$i]->image) }}" alt="{{ $art->item_nomb }}">
										</a>
									</li>
								@elseif(($i+2) == count($art->images))
								<li class="cd-item-back">
									<a href="#0">
										<img src="{{ asset('images/items/'.$art->images[$i]->image) }}" alt="{{ $art->item_nomb }}">
									</a>
								</li>
								@elseif(($i+1) == count($art->images))
									<li class="cd-item-out">
										<a href="#0">
											<img src="{{ asset('images/items/'.$art->images[$i]->image) }}" alt="{{ $art->item_nomb }}">
										</a>
									</li>
								@else
									<li class="cd-item-middle cd-item-{{ $i }}">
										<a href="#0">
											<img src="{{ asset('images/items/'.$art->images[$i]->image) }}" alt="{{ $art->item_nomb }}">
										</a>
									</li>
								@endif
								
							@endfor
						</ul> <!-- cd-item-wrapper -->

						<nav>
							<ul class="cd-item-navigation">
								<li><a class="cd-img-replace" href="#0">Prev</a></li>
								<li><a class="cd-img-replace" href="#0">Next</a></li>
							</ul>
						</nav>

						<a class="cd-3d-trigger cd-img-replace" href="#0">Open</a>
					</li>
				</ul>				


				<div class="col-xs-4 textoPromedio">
					<div class="col-xs-12" style="word-break: break-all;">
						<label>Descripción</label>
						{{ $art->item_desc }}
					</div>

					<div class="col-xs-12">
						<label>Talla</label>
						<select class="form-control talla">
							@foreach($tallas as $t)
								<?php $n = 0;?>
								@foreach($art->tallas as $at)
									@if($at->item_talla == $t->id)
										<?php $n = 0;?>
										<option value="{{ $t->id }}">{{ strtoupper($t->talla_nomb).' - '.ucfirst($t->talla_desc) }}</option>
										<?php break;?>
									@else
										<?php $n = 1;?>
									@endif
								@endforeach
								@if($n == 1)
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