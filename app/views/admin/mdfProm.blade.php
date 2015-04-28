@extends('layouts.admin')

@section('content')

<div class="row">
	<div class="container">
		<div class="col-xs-12">
			<div class="col-xs-8 contCentrado">
				@if(Session::has('error'))
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					{{ Session::get('error') }}
				</div>
				@endif
				<h3>Editar promocion </h3>
				<hr>
				<form method="POST" action="{{ URL::to('administrador/nueva-promocion/procesar') }}" enctype="multipart/form-data">
					<div class="col-xs-12 formulario">
						<label class="textoPromedio">Cambiar descuento</label>
						<input type="text" name="descuento" class="form-control" placeholder="1-100%" value="{{ $prom->percent }}">
					</div>
					<div class="col-xs-12 formulario">
						<label class="textoPromedio">Cambiar imagen</label>
						<input type="file" name="img" class="textoPromedio">
					</div>
					<div class="col-xs-12 formulario">
						<label class="textoPromedio">Activar/Desactivar</label>
						<input type="checkbox" name="active" class="textoPromedio" @if($prom->active == 1) checked @endif>
					</div>
					<input type="hidden" name="pos" value="{{ $prom->id }}">
					<div class="col-xs-12 formulario">
						<button class="btn btn-success">Enviar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@stop