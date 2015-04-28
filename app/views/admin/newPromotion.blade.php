@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="container">
		<div class="col-xs-12">
			<div class="col-xs-6 contdeColor contCentrado">
				@if(Session::has('success'))
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<p class="textoPromedio">{{ Session::get('success') }}</p>
					</div>
				@elseif(Session::has('danger'))
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<p class="textoPromedio">{{ Session::get('danger') }}</p>
				</div>
				@endif
				<legend>Nueva Publicidad</legend>
				<p class="bg-info textoPromedio" style="padding:0.5em;">Elija la publicidad que desea editar</p>
				<p class="bg-danger textoPromedio" style="padding:0.5em;"><i class="fa fa-exclamation-triangle"></i> Recuerde que esta accion cambiara la promocion anterior</p>
				<div class="bg-primary textoPromedio contOptionA" style="padding:0.5em;">
					<div class="col-xs-12">
						<a href="{{ URL::to('administrador/editar-promocio/first') }}" style="color:white;">Promocion superior </a>
					</div>
					<div class="col-xs-12">
						<a href="{{ URL::to('administrador/editar-promocio/second') }}" style="color:white;">Promocion inferior </a>
					</div>
					
					<div class="clearfix"></div>
				</div>


				</div>
				
				<div class="bg-primary textoPromedio volver" style="padding:0.5em;margin-top:1em;">
					
					<div class="col-xs-12">
						<a href="#"style="color:white;">Volver</a>
					</div>
					<div class="clearfix"></div>
				</div>

			</div>
		</div>
	</div>
</div>
@stop