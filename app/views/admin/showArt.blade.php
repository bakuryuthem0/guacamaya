@extends('layouts.admin')

@section('content')

<div class="row">
	<div class="container">
		<div class="col-xs-12">
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
							<td><button class="btn btn-xs btn-warning">Modificar</button></td>
							<td><button class="btn btn-xs btn-danger">Eliminar</button></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@stop