@extends('layouts.'.$layout)
@section('content')

<div class="row">
	<div class="container">
		<div class="col-xs-12">
			<div class="col-xs-10 contCentrado contdeColor">
				<legend>{{ $art->item_nomb.' - '.$art->item_cod }}</legend>
				<div class="col-xs-8">
					<div class="col-xs-12 imgProd">
						

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
						{{ Form::select('talla',$art->talla,Input::old('talla'), array('class' => 'form-control talla')) }}
					</div>
					<div class="col-xs-12">
						<label>Color</label>
						{{ Form::select('color',$art->color,Input::old('color'), array('class' => 'form-control color')) }}
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