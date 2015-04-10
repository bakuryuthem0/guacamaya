@extends('layouts.'.$layout)
@section('content')

<div class="row">
	<div class="container">
		<div class="col-xs-12">
			<div class="col-xs-12 contCentrado contdeColor">
				<legend>{{ $art->item_nomb.' - '.$art->item_cod }}</legend>
				<div class="col-xs-4 textoPromedio">
					<div class="col-xs-12" style="word-break: break-all;">
						<label>Descripción</label>
						{{ $art->item_desc }}
						<div id="fb-root"></div>
						<div
						  class="fb-like"
						  data-share="true"
						  data-width="450"
						  data-show-faces="true">
						</div>
					</div>
				</div>
				<div class="col-xs-4">
					<ul id="cd-gallery-items" class="cd-container">
						<li>
							<ul class="cd-item-wrapper">
								@for($i = 0;$i < count($art->images);$i++)
									@if(count($art->images)>4)
										@if($i == 0)
											<li class="cd-item-front">
												<a href="#0">
													<img src="{{ asset('images/items/'.$art->images[$i]->image) }}" data-zoom-image="{{ asset('images/items/'.$art->images[$i]->image) }}" class="zoom_item" alt="{{ $art->item_nomb }}">
												</a>
											</li>
										@elseif(($i+2) == count($art->images))
										<li class="cd-item-back">
											<a href="#0">
												<img src="{{ asset('images/items/'.$art->images[$i]->image) }}" data-zoom-image="{{ asset('images/items/'.$art->images[$i]->image) }}" class="zoom_item" alt="{{ $art->item_nomb }}">
											</a>
										</li>
										@elseif(($i+1) == count($art->images))
											<li class="cd-item-out">
												<a href="#0">
													<img src="{{ asset('images/items/'.$art->images[$i]->image) }}" data-zoom-image="{{ asset('images/items/'.$art->images[$i]->image) }}" class="zoom_item" alt="{{ $art->item_nomb }}">
												</a>
											</li>
										@else
											<li class="cd-item-middle cd-item-{{ $i }}">
												<a href="#0">
													<img src="{{ asset('images/items/'.$art->images[$i]->image) }}" data-zoom-image="{{ asset('images/items/'.$art->images[$i]->image) }}" class="zoom_item" alt="{{ $art->item_nomb }}">
												</a>
											</li>
										@endif
									@else
										@if($i == 0)
											<li class="cd-item-front">
												<a href="#0">
													<img src="{{ asset('images/items/'.$art->images[$i]->image) }}" data-zoom-image="{{ asset('images/items/'.$art->images[$i]->image) }}" class="zoom_item" alt="{{ $art->item_nomb }}">
												</a>
											</li>
										@elseif(($i+2) == count($art->images))
											<li class="cd-item-back">
												<a href="#0">
													<img src="{{ asset('images/items/'.$art->images[$i]->image) }}" data-zoom-image="{{ asset('images/items/'.$art->images[$i]->image) }}" class="zoom_item" alt="{{ $art->item_nomb }}">
												</a>
											</li>
										@else
											<li class="cd-item-middle cd-item-{{ $i }}">
												<a href="#0">
													<img src="{{ asset('images/items/'.$art->images[$i]->image) }}" data-zoom-image="{{ asset('images/items/'.$art->images[$i]->image) }}" class="zoom_item" alt="{{ $art->item_nomb }}">
												</a>
											</li>
										@endif
									@endif
								@endfor
							</ul> <!-- cd-item-wrapper -->

							<nav>
								<ul class="cd-item-navigation">
									<li><a class="cd-img-replace" href="#0"><i class="fa fa-caret-right navItemIcon"></i><span class="navButtom">Prev</span></a></li>
									<li><a class="cd-img-replace" href="#0"><i class="fa fa-caret-right navItemIcon"></i><span class="navButtom">Next</span></a></li>
								</ul>
							</nav>

							<a class="cd-3d-trigger cd-img-replace" href="#0">Open</a>
						</li>
					</ul>				
				</div>

				<div class="col-xs-4 textoPromedio">
					<div class="col-xs-12">
						<label>Precio en tienda:</label>

						<h3 class="precio">Bs. {{ $art->item_precio }}</h3>
					</div>
					<div class="col-xs-12">
						<label>Talla</label>
						<ul>
							@foreach($tallas as $t)
								<?php $n = 0;?>
								@foreach($art->tallas as $at)
									@if($at->item_talla == $t->id)
										<?php $n = 0;?>
										<li value="{{ $t->id }}">{{ strtoupper($t->talla_nomb).' - '.ucfirst($t->talla_desc) }}</li>
										<?php break;?>
									@else
										<?php $n = 1;?>
									@endif
								@endforeach
								@if($n == 1)
								<li class="disabled" disabled value="{{ $t->id }}">{{ strtoupper($t->talla_nomb).' - '.ucfirst($t->talla_desc) }}</li>
								@endif
							@endforeach
						</ul>
					</div>
					<div class="col-xs-12">
						<label>Color</label>
						<ul>
							@foreach($colores as $c)
								<?php $nop = 1;?>

								@foreach($art->colores as $ac)
									@if($ac->id == $c->id)
										<?php $nop = 0;?>
									@endif
								@endforeach

								@if($nop == 0)
									<li value="{{ $c->id }}">{{ ucfirst($c->color_desc) }}</li>
								@else
									<li class="disabled" disabled>{{ ucfirst($c->color_desc) }}</li>
								@endif

							@endforeach
						</ul>
					</div>
					
					@if(Auth::check() && Auth::user()->role != 1)
					<div class="col-xs-12">
							<button class="btn btn-warning btnAgg" data-price-value="{{ $art->item_precio}}" data-name-value="{{ $art->item_nomb }}" value="{{ $art->id }}">Agregar al carrito.</button>
					</div>
					@endif
					<div class="col-xs-12">
						<label>Disponibles es stock: </label>
						<h3 style="  display: inline-block;">{{ $art->item_stock }}</h3>
						<input type="hidden" class="values" data-art-id="{{ $art->id }}" data-misc-id="">
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>

@stop

@section('postscript')
<script type="text/javascript">
	//	$(".zoom_item").elevateZoom({scrollZoom : true});
</script>
@stop