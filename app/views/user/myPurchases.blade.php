@extends('layouts.default')

@section('content')
<div class="row">
	<div class="container">
		<div class="col-xs-12">
			@if(Session::has('success'))
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<p class="textoPromedio">{{ Session::get('success') }}</p>
			</div>
			@endif
			<h3>Mis compras</h3>
			<p class="bg-info textoPromedio" style="padding:0.5em;">En este modulo usted podra ver el status de sus compras</p>
			<div class="col-xs-12">
				<legend>Leyenda</legend>
				<p class="textoPromedio">
					Aprovado: <i class="fa fa-check-circle btn-xs icon-status-success icon"></i>
					- 
					Procesando: <i class="fa fa-clock-o btn-xs icon-status-procesing icon"></i>
					-
					Pendiente: <i class="fa fa-exclamation-circle icon-status-pending icon"></i>
				</p>
			</div>
			<div class="clearfix"></div>
			<table class="table table-striped table-hover" style="margin:5em 0">
				<thead>
					<tr>
						<th>Codigo de factura</th>
						<th>Status</th>
						<th>Dirección</th>
					</tr>
				</thead>
				<tbody>
					@foreach($fac as $f)
					<tr class="textoPromedio">
						<td>{{ $f->id }}</td>
						<td>
							@if($f->pagada == 0)
								<i class="fa fa-exclamation-circle icon-status-pending icon"></i>
							@elseif($f->pagada == -1)
								<i class="fa fa-clock-o btn-xs icon-status-procesing icon"></i>
							@elseif($f->pagada == 1)
								<i class="fa fa-check-circle btn-xs icon-status-success icon"></i>
							@endif
						</td>
						<td>{{ $f->dir }}</td>
						@if($f->pagada == 0) 
							<td><a href="{{ URL::to('compra/procesar/'.$f->id) }}" class="btn btn-success btn-xs">Pagar</a></td>
						@endif
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop