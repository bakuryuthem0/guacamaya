@extends('layouts.default')
@section('content')
<div class="container contenedorUnico">
	<div class="row">
		<div class="col-xs-12 cont" style="margin-top:1em;">
			<div class="col-xs-8 contdeColor contCentrado">
				@if (Session::has('error'))
				<div class="col-xs-6">
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<p class="textoPromedio">{{ Session::get('error') }}</p>
					</div>
				</div>
				@elseif (Session::has('success'))
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<p class="textoPromedio">{{ Session::get('success') }}</p>
					</div>
				<div class="clearfix"></div>
				@endif
				<form action="{{ URL::to('usuario/perfil/enviar') }}" method="POST">
					<div class="col-xs-12 formulario">
						<div class="col-xs-6 inputRegister">
							<p class="textoPromedio"><strong>Nombre:</strong></p>
						</div>
						<div class="col-xs-6 inputRegister">
							<p class="textoPromedio">{{ $user->nombre }}</p>
						</div>
					</div>
					<div class="col-xs-12 formulario">
						<div class="col-xs-6 inputRegister">
							<p class="textoPromedio"><strong>Apellido</strong></p>
						</div>
						<div class="col-xs-6 inputRegister">
							<p class="mdfInfo textoPromedio">{{ $user->lastname }}</p>
						</div>
					</div>
					<div class="col-xs-12 formulario">
						<div class="col-xs-6 inputRegister">
							<p class="textoPromedio"><strong>Teléfono</strong></p>
						</div>
						<div class="col-xs-6 inputRegister">
							<input type="text" name="phone" class="form-control mdfForm" placeholder="Telefono" id="phone" value="{{ $user->phone }}">
							@if ($errors->has('phone'))
								 @foreach($errors->get('phone') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
						</div>
					</div>				
					<div class="col-xs-12 formulario">
						<div class="col-xs-6 inputRegister">
							<p class="textoPromedio">(*) Estado:</p>
						</div>
						<div class="col-xs-6 inputRegister">
							<select name="estado" class="form-control" id="estado2">
								<option value="">Seleccione un estado</option>
								@foreach($estados as $e)
									<option value="{{ $e->id }}">{{ $e->nombre }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-xs-12 formulario">
						<div class="col-xs-6 inputRegister">
							<p class="textoPromedio">(*) Municipio:</p>
						</div>
						<div class="col-xs-6 inputRegister">
							
							<select name="municipio" class="form-control" id="municipio2" required>
								<option value="" >Seleccione un municipio</option>
								
							</select>
							@if ($errors->has('municipio'))
								 @foreach($errors->get('municipio') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
						</div>
					</div>
					<div class="col-xs-12 formulario">
						<div class="col-xs-6 inputRegister">
							<p class="textoPromedio">Parroquia:</p>
						</div>
						<div class="col-xs-6">
							
							<select name="parroquia" class="form-control" id="parroquia2">
								<option value="">Seleccione una parroquia</option>
								
							</select>
							@if ($errors->has('parroquia'))
								 @foreach($errors->get('parroquia') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
						</div>
					</div>
					<div class="col-xs-12 formulario">
						<div class="col-xs-6 inputRegister">
							<p class="textoPromedio"><strong>Dirección:</strong></p>
						</div>
						<div class="col-xs-6 inputRegister">
							<textarea name="dir" class="form-control mdfForm" placeholder="Dirección" id="zip_cod"> {{ $user->dir }}</textarea>
							@if ($errors->has('dir'))
								 @foreach($errors->get('dir') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
						</div>
					</div>				
					<div class="col-xs-12 formulario">
						<div class="col-xs-12">
							<input type="reset" name="reset" value="Resetear" class="btn btn-warning mdfForm mdfSub botones inputRegister" style="margin-left:1em;margin-right:1em;">
							<input type="submit" name="enviar" value="Enviar" class="btn btn-success mdfForm  botones inputRegister">
						</div>
					</div>
					
				</form>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
@stop