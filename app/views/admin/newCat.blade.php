@extends('layouts.admin')

@section('content')

<div class="container contenedorUnico">
	<div class="row">
		<div class="col-xs-12">
			
			<div class="col-xs-8 contForm contdeColor contCentrado" style="margin-top:2em;">
				@if (Session::has('error'))
				<div class="col-xs-6">
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<p class="textoPromedio">{{ Session::get('error') }}</p>
					</div>
				</div>
				<div class="clearfix"></div>
				@endif
				<div class="col-xs-12">
					<div class="col-xs-12">
						<legend>Nueva categoria</legend>
						<p class="textoPromedio">Llene el siguiente formulario para registrar una nueva categorias.</p>
						<hr>
					</div>						
				</div>
				<form action="{{ URL::to('categoria/nueva/enviar') }}" id="formRegister" method="POST">
					<div class="col-xs-12 formulario">
						<div class="col-xs-12 inputRegister">
							<p class="textoPromedio">Nombre de la categoria:</p>
							<p class="bg-info textoPromedio" style="padding:0.5em;text-align:center;">* Nombre para las busquedas(sin acento)</p>
						</div>
						<div class="col-xs-12 inputRegister">
							{{ Form::text('name_cat', Input::old('name_cat'),array('data-trigger' => "blur",'class' => 'form-control cat_nomb inputForm inputFondoNegro','placeholder' => 'Nombre de la categoria',)) }}
							@if ($errors->has('name_cat'))
								 @foreach($errors->get('name_cat') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
						</div>
					</div>
					<div class="col-xs-12 formulario">
						<div class="col-xs-12 inputRegister">
							<p class="textoPromedio">Título de la categoría:</p>
							<p class="bg-info textoPromedio" style="padding:0.5em;text-align:center;">* Título para mostrar la categoria (puede tener acento)</p>
						</div>
						<div class="col-xs-12 inputRegister">
							{{ Form::text('desc_cat',Input::old('desc_cat'),array('class' => 'form-control inputForm cat_desc inputFondoNegro','placeholder' => 'Título de la categoría')) }}
							@if ($errors->has('desc_cat'))
								 @foreach($errors->get('desc_cat') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
						</div>
					</div>

					<div class="col-xs-12 formulario">
						<div class="col-xs-6 imgLiderUp">
							<input type="submit" id="enviar" name="enviar" value="Enviar" class="btn btn-success btnAlCien">
							<input type="reset" value="Borrar" class="btn btn-warning btnWarningRegister btnAlCien" >
						</div>
					</div>
					<div class="clearfix"></div>
				</form>
			</div>
		</div>
	</div>
</div>
@stop