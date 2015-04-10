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
							<p class="textoPromedio"><strong>Estado:</strong></p>
						</div>
						<div class="col-xs-6 inputRegister">
							<select name="estado" class="form-control">
								<option>Seleccione el estado</option>
								@foreach($est as $e)
									@if($e->id == $user->estado)
										<option value="{{ $e->id }}" selected>{{ $e->nombre }}</option>
									@else
										<option value="{{ $e->id }}">{{ $e->nombre }}</option>
									@endif
								@endforeach
							</select>
							@if ($errors->has('estado'))
								 @foreach($errors->get('estado') as $err)
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
							<p class="textoPromedio"><strong>Municipio:</strong></p>
						</div>
						<div class="col-xs-6 inputRegister">
							<select name="municipio" class="form-control">
								<option>Seleccione el municipio</option>
								@foreach($mun as $m)
									@if($m->id == $user->municipio)
										<option value="{{ $m->id }}" selected>{{ $m->nombre }}</option>
									@else
										<option value="{{ $m->id }}">{{ $m->nombre }}</option>
									@endif
								@endforeach
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
							<p class="textoPromedio"><strong>Parroquia:</strong></p>
						</div>
						<div class="col-xs-6 inputRegister">
							<select name="parroquia" class="form-control">
								<option>Seleccione la parroquia</option>
								@foreach($par as $p)
									@if($e->id == $user->parroquia)
										<option value="{{ $p->id }}" selected>{{ $p->nombre }}</option>
									@else
										<option value="{{ $p->id }}">{{ $p->nombre }}</option>
									@endif
								@endforeach
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