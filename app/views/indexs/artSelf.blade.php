@extends('layouts.'.$layout)
@section('content')

<div class="row">
	<div class="container">
		<div class="col-xs-12">
			<div class="col-xs-10 contCentrado contdeColor">
				<legend>{{ $art->item_nomb.' - '.$art->item_cod }}</legend>
				<div class="col-xs-8">
					<div class="col-xs-12 imgProd">
						<img src="{{ asset('images/items/'.$art->img_1) }}" class="imgPrinc" style="">
					</div>
					<div class="col-xs-12 minis">
						@if(!empty($art->img_1))
						<img src="{{ asset('images/items/'.$art->img_1) }}" class="imgMini">
						@endif
						@if(!empty($art->img_2))
						<img src="{{ asset('images/items/'.$art->img_2) }}" class="imgMini">
						@endif
						@if(!empty($art->img_3))
						<img src="{{ asset('images/items/'.$art->img_3) }}" class="imgMini">
						@endif
						@if(!empty($art->img_4))
						<img src="{{ asset('images/items/'.$art->img_4) }}" class="imgMini">
						@endif
						@if(!empty($art->img_5))
						<img src="{{ asset('images/items/'.$art->img_5) }}" class="imgMini">
						@endif
						@if(!empty($art->img_6))
						<img src="{{ asset('images/items/'.$art->img_6) }}" class="imgMini">
						@endif
						@if(!empty($art->img_7))
						<img src="{{ asset('images/items/'.$art->img_7) }}" class="imgMini">
						@endif
						@if(!empty($art->img_8))
						<img src="{{ asset('images/items/'.$art->img_8) }}" class="imgMini">
						@endif
					</div>
				</div>
				<div class="col-xs-4 textoPromedio">
					<div class="col-xs-12">
						<label>Descripción</label>
						{{ $art->item_desc }}
					</div>

					<div class="col-xs-12">
						<label>Talla</label>
						{{ $art->talla_nomb.' - '.$art->talla_desc }}
					</div>
					<div class="col-xs-12">
						<label>Color</label>
						{{ $art->color_desc }}
					</div>
					<div class="col-xs-12">
						<label>Cantidad</label>
						{{ $art->item_stock }}
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>

@stop