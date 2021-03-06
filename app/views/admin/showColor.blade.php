@extends('layouts.admin')

@section('content')

<div class="row">
	<div class="container">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-hover textoPromedio">
					<thead>
						<tr class="textoNegro">
							<th>Código</th>
							<th>Nombre</th>
							<th>Título</th>
							<th>Modificar</th>
							<th>Eliminar</th>
						</tr>
					</thead>
					<tbody>
						@foreach($color as $c)
						<tr>
							<td class="textoNegro">{{ $c->id }}</td>
							<td class="textoNegro">{{ ucfirst(strtolower($c->color_nomb)) }}</td>
							<td class="textoNegro">{{ ucfirst(strtolower($c->color_desc)) }}</td>
							<td class="textoNegro"><a class="btn btn-xs btn-warning" href="{{ URL::to('administrador/ver-color/'.$c->id) }}">Modificar</a></td>
							<td class="textoNegro"><button class="btn btn-xs btn-danger elimBtn" value="{{ $c->id }}" data-toggle="modal" data-target="#elimModal">Eliminar</button></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="elimModal" tabindex="-1" role="dialog" aria-labelledby="modalForggo" aria-hidden="true">
	<div class="forgotPass modal-dialog imgLiderUp">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<legend>¿Seguro desea eliminar al usuario?</legend>
			</div>
				<div class="modal-body">
					<p class="textoPromedio">Esta acción es irreversible, si desea continuar precione eliminar</p>
											
				</div>
				<div class="modal-footer " style="text-align:center;">
					<div class="alert responseDanger textoPromedio">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					</div>
					
					<button class="btn btn-danger envElim" name="eliminar" value="" style="margin-top:2em;">Eliminar</button>	
					
				</div>
		</div>
	</div>
</div>
@stop