@extends('layouts.default')
@section('content')
<div class="modal fade" id="changePass" tabindex="-1" role="dialog" aria-labelledby="modalForggo" aria-hidden="true">
	<div class="forgotPass modal-dialog imgLiderUp">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			</div>
				<div class="modal-body">
						<legend>Recuperar Contraseña</legend>
					</div>
				<div class="modal-footer " style="text-align:center;">
					<div class="alert responseDanger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					</div>
					<form methos="POST" action="{{ URL::to('recuperar/password') }}">
						<p class="textoPromedio">Introduzca el email con el cual creó su cuenta</p>
						<input class="form-control emailForgot" name="email" placeholder="Email">
						<button class="btn btn-success envForgot" style="margin-top:2em;">Enviar</button>	
					</form>
				</div>
		</div>
	</div>
</div>

<div class="container contenedorUnico">
	<div class="row">
		<div class="col-xs-12">
			
			<div class="contCentrado col-xs-6 contdeColor" style="margin-top:2em;">
				<form action="{{ URL::to('iniciar-sesion/autenticar') }}" method="POST">
					@if (Session::has('error'))
					<div class="col-xs-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<p class="textoPromedio">{{ Session::get('error') }}</p>
						</div>
					</div>
					<div class="clearfix"></div>
					@elseif(Session::has('success'))
					<div class="col-xs-12">
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<p class="textoPromedio">{{ Session::get('success') }}</p>
						</div>
					</div>
					@endif
					<div class="col-xs-12">
						<label for="username" class="textoPromedio">Nombre de usuario:</label>
						{{ Form::text('username','', array('class'=>'form-control','required' => 'required')) }}
					</div>
					<div class="clearfix"></div>
					<div class="col-xs-12">
						<label for="pass" class="textoPromedio">Contraseña</label>
						<input type="password" name="password" class="form-control" required>
					</div>
					<div class="col-xs-12">
						<label for="pass" class="textoPromedio"><a href="#" class="forgot" data-toggle="modal" data-target="#changePass">¿Olvidó su contraseña?</a></label>
					</div>
					<div class="col-xs-12">
						<label for="remember" class="textoPromedio">¿Recordar?</label>
						<input type="checkbox" name="remember">
					</div>
					<div class="col-xs-12">
						<input type="submit" name="enviar" value="Enviar" class="btn btn-primary">
					</div>
				</form>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	
</div>
@stop