@extends('layouts.admin')

@section('content')

<div class="row">
	<div class="container">
		<div class="col-xs-12">
			<div class="alert responseDanger textoPromedio" style="text-align:center;">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			</div>
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>Código</th>
							<th>Nombre</th>
							<th>Inventario</th>
							<th>Ver</th>
							<th>Modificar</th>
							<th>Eliminar</th>
						</tr>
					</thead>
					<tbody>
						@foreach($art as $a)
						<tr>
							<td>{{ $a->item_cod }}</td>
							<td>{{ $a->item_nomb }}</td>
							<td>{{ $a->item_stock }}</td>
							<td><a class="btn btn-xs btn-primary" href="{{ URL::to('administrador/ver-articulo/'.$a->id) }}">Ver</a></td>
							<td><a href="{{ URL::to('administrador/editar-articulo/'.$a->id) }}" class="btn btn-xs btn-warning btnMdfItem">Modificar</a></td>
							<td><button class="btn btn-xs btn-danger btnElimItem" data-toggle="modal" data-target="#elimModal" value="{{ $a->id }}">Eliminar</button></td>
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