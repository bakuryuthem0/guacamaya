@extends('layouts.default')
@section('content')
<div class="container contenedorUnico">
	<div class="row">
		<div class="col-xs-12">
			
			<div class="col-xs-8 col-sm-offset-2 contForm contAnaranjado" style="margin-top:2em;">
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
						<legend>Formulario de registro</legend>
						<p class="textoPromedio">Llene el siguiente formulario para registrarse en ffasil.com.</p>
						<p class="textoPromedio">(*) Campos obligatorios.</p>
					</div>						
				</div>
				<form action="{{ URL::to('inicio/registro/enviar') }}" method="POST">
					<div class="col-xs-12 formulario">
						<div class="col-xs-6 inputRegister">
							<p class="textoPromedio">(*) Nombre de usuario:</p>
						</div>
						<div class="col-xs-6 inputRegister">
							{{ Form::text('username', Input::old('username'),array('class' => 'form-control','placeholder' => 'Nombre de Usuario','required' => 'required')) }}
							@if ($errors->has('username'))
								 @foreach($errors->get('username') as $err)
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
							<p class="textoPromedio">(*) Contraseña:</p>
						</div>
						<div class="col-xs-6 inputRegister">
							{{ Form::password('pass',array('class' => 'form-control','placeholder' => 'Contraseña','required' => 'required')) }}
							@if ($errors->has('pass'))
								 @foreach($errors->get('pass') as $err)
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
							<p class="textoPromedio">(*) Repita la contraseña:</p>
						</div>
						<div class="col-xs-6 inputRegister">
							{{ Form::password('pass_confirmation',array('id' => 'pass2','class' => 'form-control','placeholder' => 'Contraseña','required' => 'required')) }}
							@if ($errors->has('pass_confirmation'))
								 @foreach($errors->get('pass_confirmation') as $err)
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
							<p class="textoPromedio">(*) Email:</p>
						</div>
						<div class="col-xs-6 inputRegister">
							{{ Form::text('email', Input::old('email'),array('class' => 'form-control','placeholder' => 'Email','required' => 'required')) }}
							@if ($errors->has('email'))
								 @foreach($errors->get('email') as $err)
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
							<p class="textoPromedio">(*) Nombre:</p>
						</div>
						<div class="col-xs-6 inputRegister">
							{{ Form::text('name', Input::old('name'),array('class' => 'form-control','placeholder' => 'Nombre','required' => 'required')) }}
							@if ($errors->has('name'))
								 @foreach($errors->get('name') as $err)
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
							<p class="textoPromedio">(*) Apellido</p>
						</div>
						<div class="col-xs-6 inputRegister">
							{{ Form::text('lastname', Input::old('lastname'),array('class' => 'form-control','placeholder' => 'Apellido','required' => 'required')) }}
							@if ($errors->has('lastname'))
								 @foreach($errors->get('lastname') as $err)
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
							<p class="textoPromedio">(*) Cedula de identidad</p>
						</div>
						<div class="col-xs-6 inputRegister">
							{{ Form::text('id', Input::old('id'),array('class' => 'form-control','placeholder' => 'Carnet','required' => 'required')) }}
							@if ($errors->has('id'))
								 @foreach($errors->get('id') as $err)
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
							<p class="textoPromedio">Dirección</p>
						</div>
						<div class="col-xs-6 inputRegister">
							<textarea class="form-control" placeholder="Dirección" name="dir">{{ Input::old('dir') }}</textarea>
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
						<div class="col-xs-6 inputRegister">
							<p class="Estado">(*) Estado:</p>
						</div>
						<div class="col-xs-6 inputRegister">
							<?php $arr = array(
							'' => 'Seleccione la sub-categoría');
							 ?>
							@foreach ($estados as $estado)
								<?php $arr = $arr+array($estado->id => $estado->nombre);  ?>
							@endforeach
							{{ Form::select('estado',$arr,Input::old('estado'),array('class' => 'form-control','requied' => 'required')
								)}}
							
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
							<p class="Estado">(*) Municipio:</p>
						</div>
						<div class="col-xs-6 inputRegister">
							
							<select name="department" class="form-control" id="department" required>
								<option value="">Seleccione un departamento</option>
								
							</select>
							@if ($errors->has('department'))
								 @foreach($errors->get('department') as $err)
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
							<p class="Estado">Parroquia:</p>
						</div>
						<div class="col-xs-6 inputRegister">
							
							<select name="department" class="form-control" id="department" required>
								<option value="">Seleccione un departamento</option>
								
							</select>
							@if ($errors->has('department'))
								 @foreach($errors->get('department') as $err)
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
					
				</form>
			</div>
		</div>
	</div>
</div>
@stop