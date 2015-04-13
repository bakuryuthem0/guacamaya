@extends('layouts.default')
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
						<legend>Formulario de registro</legend>
						<p class="textoPromedio">Llene el siguiente formulario para registrarse en guacamastores.com.ve.</p>
						<p class="textoPromedio">(*) Campos obligatorios.</p>
						<hr>
					</div>						
				</div>
				<form action="{{ URL::to('registro/enviar') }}" id="formRegister" method="POST">
					<div class="col-xs-12 formulario">
						<div class="col-xs-6 inputRegister">
							<p class="textoPromedio">(*) Nombre de usuario:</p>
						</div>
						<div class="col-xs-6 inputRegister">
							{{ Form::text('username', Input::old('username'),array('data-trigger' => "blur",'class' => 'form-control inputFondoNegro','placeholder' => 'Nombre de Usuario','required' => 'required')) }}
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
							{{ Form::password('pass',array('class' => 'form-control inputFondoNegro','placeholder' => 'Contraseña','required' => 'required')) }}
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
							{{ Form::password('pass_confirmation',array('id' => 'pass2','class' => 'form-control inputFondoNegro','placeholder' => 'Contraseña','required' => 'required')) }}
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
							{{ Form::text('email', Input::old('email'),array('class' => 'form-control inputFondoNegro','placeholder' => 'Email','required' => 'required')) }}
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
							{{ Form::text('name', Input::old('name'),array('class' => 'form-control inputFondoNegro','placeholder' => 'Nombre','required' => 'required')) }}
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
							{{ Form::text('lastname', Input::old('lastname'),array('class' => 'form-control inputFondoNegro','placeholder' => 'Apellido','required' => 'required')) }}
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
							<p class="textoPromedio">(*)Dirección</p>
						</div>
						<div class="col-xs-6 inputRegister">
							<textarea class="form-control inputFondoNegro" placeholder="Dirección" name="dir">{{ Input::old('dir') }}</textarea>
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
							<p class="textoPromedio">Telefono</p>
						</div>
						<div class="col-xs-6 inputRegister">
							{{ Form::text('telefono', Input::old('telefono'),array('class' => 'form-control inputFondoNegro','placeholder' => 'Telefono')) }}
							@if ($errors->has('telefono'))
								 @foreach($errors->get('telefono') as $err)
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
							<?php $arr = array(
							'' => 'Seleccione la sub-categoría');
							 ?>
							@foreach ($estados as $estado)
								<?php $arr = $arr+array($estado->id => $estado->nombre);  ?>
							@endforeach
							{{ Form::select('estado',$arr,'',array('class' => 'form-control inputFondoNegro','id' => 'estado','requied' => 'required')
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
							<p class="textoPromedio">(*) Municipio:</p>
						</div>
						<div class="col-xs-6 inputRegister">
							
							<select name="municipio" class="form-control inputFondoNegro" id="municipio" required>
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
						<div class="col-xs-6 inputRegister">
							
							<select name="parroquia" class="form-control inputFondoNegro" id="parroquia">
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
							<p class="textoPromedio">captcha:</p>
						</div>
						<div class="col-xs-6 inputRegister">
							
							<div class="g-recaptcha" data-sitekey="6LeqSAUTAAAAAES98bSzQFzMWkQDlbednSpve05r"></div>
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

@section('postscript')
<script type="text/javascript">
	$("#formRegister").validate();

</script>
@stop