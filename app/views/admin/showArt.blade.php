@extends('layouts.admin')

@section('content')

<div class="row">
	<div class="container">
		<div class="col-xs-12">
		@if(Session::has('success'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			{{ Session::get('success') }}
		</div>
		@endif
			<div class="alert responseDanger textoPromedio" style="text-align:center;">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			</div>
			<form action="#" method="get">
				<div class="input-group">
					<!-- USE TWITTER TYPEAHEAD JSON WITH API TO SEARCH -->
					<input class="form-control" id="buscar-usuario" name="q" placeholder="Busqueda general" required>
					<span class="input-group-addon">
						<i class="glyphicon glyphicon-search"></i>
					</span>
				</div>
			</form>
			<table id="tablesorter" class="tablesorter table table-striped table-condensed table-vertical-middle table-super-condensed table-bordered table-list-search table-hover">
				<thead>
					<tr class="textoNegro">
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
						<td class="textoNegro">{{ $a->item_cod }}</td>
						<td class="textoNegro">{{ $a->item_nomb }}</td>
						<td class="textoNegro">{{ $a->item_stock }}</td>
						<td><a class="btn btn-xs btn-success" href="{{ URL::to('administrador/ver-articulo/'.$a->id) }}">Ver</a></td>
						<td><a href="{{ URL::to('administrador/editar-articulo/'.$a->id) }}" class="btn btn-xs btn-warning btnMdfItem">Modificar</a></td>
						<td><button class="btn btn-xs btn-danger btnElimItem" data-toggle="modal" data-target="#elimModal" value="{{ $a->id }}">Eliminar</button></td>
					</tr>
					@endforeach
				</tbody>
			</table>
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