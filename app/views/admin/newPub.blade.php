@extends('layouts.admin')

@section('content')

<div class="row">
	<div class="container">
		<div class="col-xs-12">
			<div class="col-xs-6 contdeColor contCentrado">
				@if(Session::has('success'))
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						{{ Session::get('success') }}
					</div>
				@elseif(Session::has('danger'))
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					{{ Session::get('danger') }}
				</div>
				@endif

				<legend>Nueva Publicidad</legend>
				<p class="bg-info textoPromedio" style="padding:0.5em;">Elija la publicidad que desea editar</p>
				<p class="bg-danger textoPromedio" style="padding:0.5em;"><i class="fa fa-exclamation-triangle"></i> Recuerde que esta accion cambiara la publicidad anterior</p>
				<div class="bg-primary textoPromedio contOptionA" style="padding:0.5em;">
					<div class="col-xs-12">
						<a href="#" class="optionA" data-target=".grande" style="color:white;">Publicidad principal </a>
					</div>
					<div class="col-xs-12">
						<a href="#" class="optionA" data-target=".izquierda" style="color:white;">Publicidad izquierda </a>
					</div>
					<div class="col-xs-12">
						<a href="#" class="optionA" data-target=".derecha" style="color:white;">Publicidad derecha</a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="grande imagesSlidesOption textoPromedio">
					<form method="POST" action="{{ URL::to('administrador/nueva-publicidad/procesar') }}" enctype="multipart/form-data">
						<label>Imagen:</label>
						<input type="file" name="img">
						<br>
						<p class="bg-info " style="padding:0.5em;">Introduzca el codigo del articulo</p>
						<label>Articulo:</label>
						<input type="text" name="item" placeholder="Codigo del articulo" class="form-control">
						<button class="btn btn-success btn-xs" style="margin-top:1em;">Enviar</button>
						<input type="hidden" name="position" value="top">
					</form>
				</div>
				<div class="izquierda imagesSlidesOption textoPromedio">
					<form method="POST" action="{{ URL::to('administrador/nueva-publicidad/procesar') }}" enctype="multipart/form-data">
						<label>Imagen:</label>
						<input type="file" name="img">
						<br>
						<p class="bg-info " style="padding:0.5em;">Introduzca el codigo del articulo</p>
						<label>Articulo:</label>
						<input type="text" name="item" placeholder="Codigo del articulo" class="form-control">
						<button class="btn btn-success btn-xs" style="margin-top:1em;">Enviar</button>
						<input type="hidden" name="operation" value="left">
					</form>
				</div>
				<div class="derecha imagesSlidesOption textoPromedio">
					<form method="POST" action="{{ URL::to('administrador/nueva-publicidad/procesar') }}" enctype="multipart/form-data">
						<label>Imagen:</label>
						<input type="file" name="img">
						<br>
						<p class="bg-info " style="padding:0.5em;">Introduzca el codigo del articulo</p>
						<label>Articulo:</label>
						<input type="text" name="item" placeholder="Codigo del articulo" class="form-control">
						<button class="btn btn-success btn-xs" style="margin-top:1em;">Enviar</button>
						<input type="hidden" name="operation" value="right">
					</form>
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