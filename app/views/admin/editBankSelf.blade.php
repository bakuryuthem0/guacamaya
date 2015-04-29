@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="container">
		<div class="col-xs-8 contCentrado contdeColor">
			<h3>Nuevo banco</h3>
			<form method="POST" action="{{ URL::to('administrador/editar-bancos/enviar/'.$banco->id) }}" enctype="multipart/form-data">
				<div class="col-xs-12 formulario textoPromedio">
					<label>Banco</label>
					<input type="text" name="banco" class="form-control" value="{{ $banco->banco }}">
				</div>
				<div class="col-xs-12 formulario textoPromedio">
					<label>Numero de cuenta</label>
					<input type="text" name="numCuenta" class="form-control" value="{{ $banco->num_cuenta }}">
				</div>
				<div class="col-xs-12 formulario textoPromedio">
					<label>Tipo de cuenta</label>
					<input type="text" name="tipoCuenta" class="form-control" value="{{ $banco->tipo }}">
				</div>
				<div class="col-xs-12 formulario textoPromedio">
					<p class="bg-warning" style="padding:0.5em;"><i class="fa fa-exclamation-triangle"></i> En caso de no desear cambiar la imagen, omita este campo</p>
					<label>Imagen del banco</label>
					<input type="file" name="img">
				</div>
				<div class="col-xs-12 formulario">
					<button class="btn btn-success">
						Enviar
					</button>
				</div>
			</form>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
@stop