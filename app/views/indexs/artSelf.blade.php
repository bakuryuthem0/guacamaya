@extends('layouts.'.$layout)
@section('content')

<div class="row">
	<div class="container">
		<div class="col-xs-12">
			<div class="col-xs-12 contCentrado contdeColor">
				<legend>{{ $art->item_nomb.' - '.$art->item_cod }}</legend>
				<div class="col-xs-4 textoPromedio">
					<div class="col-xs-12" style="word-break: break-word;">
						<label class="description">Descripción</label>
						{{ $art->item_desc }}
						<div id="fb-root"></div>
						<div style="margin-top:2em;margin-bottom:2em;"
						  class="fb-like"
						  data-share="true"
						  data-width="450"
						  data-show-faces="true">
						</div>
						<a href="{{ URL::previous() }}" class="btn btn-volver">Volver</a>
					</div>
				</div>
				<div class="col-xs-4">
					<ul id="cd-gallery-items" class="cd-container">
						<li>
							<ul class="cd-item-wrapper">
								<?php 
									$k = 0; 
									$c = count($art->images);
									$total = 0;
									if ($c>1)
									{
										foreach ($art->images as $a)
										{
											$total += count($a);
										}
									}else
									{
										$total = count($art->images[0]);
									}
									for($i = 0;$i<count($art->images);$i++)
									{
										for ($j=0; $j <count($art->images[$i]) ; $j++) { 
											$l = $art->images[$i][$j];
								?>
										<li class="
										@if($k == 0) 
											cd-item-front 
										@elseif($k == 1)
											cd-item-middle 
										@elseif($k+1 == $total)
											cd-item-back 
										@else cd-item-out cd-item-{{ $k }} @endif">
											<a href="#0">
												<img src="{{ asset('images/items/'.$l->image) }}" alt="{{ $art->item_nomb }}">
											</a>
										</li>
								<?php
											$k++;
										}
									}
								?>
								
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
						<label>PRECIO EN GUACAMAYA STORES:</label>

							@if(isset($art->percent))
								<h3 class="precio">Precio Actual: Bs. {{ $art->item_precio-($art->item_precio*$art->percent/100) }}</h3>
								<li class="disabled">Precio Anterior: Bs. {{ $art->item_precio }}</li>
							@else
								<h3 class="precio">Bs. {{ $art->item_precio }}</h3>
							@endif

					</div>
					<div class="col-xs-12 formulario">
						<label>Talla</label>
						<select class="choose form-control">
							<option value="">Seleccione una talla</option>
							@foreach($tallas as $t)
								<?php $n = 0;?>
								@foreach($art->tallas as $at)
									@if($at->item_talla == $t->id || $at->item_talla == "all")
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
					<div class="col-xs-12 formulario">
						<label>Color</label>
						<ul class="colores">
							<li class="removable">Elija una talla</li>
						</ul>
						<input type="hidden" class="values" value="{{ $art->id }}" data-misc-id="">
					</div>
					
					@if(Auth::check() && Auth::user()->role != 1)
					<div class="col-xs-12 formulario">
						@if(isset($art->percent))
							<button class="btn btn-danger btnAgg" data-toggle="modal" data-target="#addCart" data-cod-value="{{ $art->item_cod }}" data-price-value="{{ $art->item_precio-($art->item_precio*$art->percent/100) }}" data-name-value="{{ $art->item_nomb }}" value="{{ $art->id }}">Agregar al carrito.</button>
						@else
							<button class="btn btn-danger btnAgg" data-toggle="modal" data-target="#addCart" data-cod-value="{{ $art->item_cod }}" data-price-value="{{ $art->item_precio}}" data-name-value="{{ $art->item_nomb }}" value="{{ $art->id }}">Agregar al carrito.</button>
						@endif
					</div>
					@else
					<div class="col-xs-12 formulario">
							<button class="btn btn-danger" data-toggle="modal" data-target="#loginModal">Agregar al carrito.</button>
					</div>
					@endif

					<div class="col-xs-12 formulario">
						<div class="col-xs-4 fa-container"><i class="fa fa-credit-card"></i><br><p>Tarjeta de Credito</p></div>
						<div class="col-xs-4 fa-container"><i class="fa fa-refresh"></i><br><p>Transferencia y Depósito Bancario</p></div>
						<div class="col-xs-4 fa-container"><i class="fa fa-truck"></i><br><p>Envios Gratis a Todo el Pais</p></div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="addCart" tabindex="-1" role="dialog" aria-labelledby="modalForggo" aria-hidden="true">
          <div class="forgotPass modal-dialog imgLiderUp">
            <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				</div>
        		<div class="">
                    <h3>Agregar al carrito </h3>
              	</div>
               	<div class="col-xs-12 formulario textoPromedio">
						<label>Talla</label>
						<select class="chooseModal form-control">
							<option value="">Seleccione una talla</option>
							@foreach($tallas as $t)
								<?php $n = 0;?>
								@foreach($art->tallas as $at)
									@if($at->item_talla == $t->id || $at->item_talla == "all")
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
					<div class="col-xs-12 formulario textoPromedio">
						<label>Color</label>
						<select class="colorModal form-control">
							<option value="">Seleccione un color</option>
						</select>
						<input type="hidden" class="values" value="{{ $art->id }}" data-misc-id="">
					</div>
					<div class="clearfix"></div>
					<div class="modal-footer">
						<button class="btn btn-danger btnAddCart disabled">Agregar</button>
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