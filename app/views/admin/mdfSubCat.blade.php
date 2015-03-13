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
						<legend>Modificación de la sub-categoría</legend>
						<p class="textoPromedio">Llene el siguiente formulario para modificar la sub-categorías.</p>
						<hr>
					</div>						
				</div>
				<form action="{{ URL::to('administrador/ver-sub-categoria/modificar/'.$subcat->id) }}" id="formRegister" method="POST">
					<div class="col-xs-12 formulario">
						<div class="col-xs-12 inputRegister">
							<p class="textoPromedio">Categoría:</p>
						</div>
						<div class="col-xs-12 inputRegister">
							<select name="cat" class="form-control cat inputForm inputFondoNegro" required>
								<option value="">Seleccione una categoría</option>
								@foreach($cat as $c)
									@if($subcat->cat_id == $c->id)
									<option value="{{ $c->id }}" selected>{{ $c->cat_desc }}</option>
									@else
									<option value="{{ $c->id }}">{{ $c->cat_desc }}</option>
									@endif
								@endforeach
							</select>
							@if ($errors->has('name_color'))
								 @foreach($errors->get('name_color') as $err)
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
							<p class="textoPromedio">Nombre de la sub-categoría:</p>
							<p class="bg-info textoPromedio" style="padding:0.5em;text-align:center;">* Nombre para las busquedas(sin acentro)</p>
						</div>
						<div class="col-xs-12 inputRegister">
							{{ Form::text('name_subcat', $subcat->sub_nomb,array('data-trigger' => "blur",'class' => 'form-control cat_nomb inputForm inputFondoNegro','placeholder' => 'Nombre de la categoria',)) }}
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
							<p class="textoPromedio">Título de la sub-categoría:</p>
							<p class="bg-info textoPromedio" style="padding:0.5em;text-align:center;">* Título para mostrar la sub-categoría (puede tener acentro)</p>
						</div>
						<div class="col-xs-12 inputRegister">
							{{ Form::text('desc_subcat',$subcat->sub_desc,array('class' => 'form-control inputForm cat_desc inputFondoNegro','placeholder' => 'Título de la categoría')) }}
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