@extends('layouts.default')

@section('content')

<div class="container contenedorUnico">
	<div class="row">
		
		<div class="col-xs-12 formContactUs contAnaranjado" style="margin-top:2em;">
			@if(Session::has('success'))
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<p class="textoPromedio">{{ Session::get('success') }}</p>
			</div>
			@endif
			<div class="col-xs-12" style="text-align:center;">
				<legend>Contáctenos</legend>
				<p class="textoPromedio">Si desea contactar con nuestro equipo, puede hacerlo mediante algunos de los métodos que le ofrecemos a continuación</p>
			</div>
			<div class="clearfix"></div>

			<div class="col-xs-6 contCentrado contdeColor" style="margin-top:2em;">
				<legend>Formulario de contacto</legend>
				<p class="textoPromedio">Llene el siguiente formulario y en breve nuestro personal se pondrá en contacto con usted.</p>
				<form method="POST" action="{{ URL::to('contactenos') }}">
				<div class="col-xs-12">
					<label for="nombre" class="textoPromedio">Nombre</label>
					{{ Form::text('nombre', Input::old('nombre'),array('class' => 'form-control','placeholder' => 'Nombre')) }}
					@if ($errors->has('nombre'))
						 @foreach($errors->get('nombre') as $err)
						 	<div class="alert alert-danger">
						 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						 		<p class="textoPromedio">{{ $err }}</p>
						 	</div>
						 @endforeach
					@endif
				</div>
				<hr>
				<div class="col-xs-12">
					<label for="asunto" class="textoPromedio">Asunto</label>
					{{ Form::text('asunto', Input::old('asunto'),array('class' => 'form-control','placeholder' => 'Asunto')) }}
					@if ($errors->has('asunto'))
						 @foreach($errors->get('asunto') as $err)
						 	<div class="alert alert-danger">
						 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						 		<p class="textoPromedio">{{ $err }}</p>
						 	</div>
						 @endforeach
					@endif
				</div>
				<div class="col-xs-12">
					<label for="email" class="textoPromedio">Email</label>
					{{ Form::text('email', Input::old('email'),array('class' => 'form-control','placeholder' => 'Email')) }}
					@if ($errors->has('email'))
						 @foreach($errors->get('email') as $err)
						 	<div class="alert alert-danger">
						 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						 		<p class="textoPromedio">{{ $err }}</p>
						 	</div>
						 @endforeach
					@endif
				</div>
				<div class="col-xs-12">
					<label for="mensaje" class="textoPromedio">Mensaje</label>
					{{ Form::textarea('mensaje', Input::old('mensaje'),array('class' => 'form-control','placeholder' => 'Mensaje')) }}
					@if ($errors->has('mensaje'))
						 @foreach($errors->get('mensaje') as $err)
						 	<div class="alert alert-danger">
						 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						 		<p class="textoPromedio">{{ $err }}</p>
						 	</div>
						 @endforeach
					@endif
				</div>
				<div class="col-xs-12">
					<input type="submit" name="enviar" value="enviar" class="btn btn-success" style="margin-top:2em;">
				</div>
				</form>
				<div class="clearfix"></div>

			</div>
		</div>
	</div>
</div>
@stop