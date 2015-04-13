@extends('layouts.admin')

@section('content')
<div class="modal fade" id="elimFac" tabindex="-1" role="dialog" aria-labelledby="modalForggo" aria-hidden="true">
	<div class="forgotPass modal-dialog imgLiderUp">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			</div>
				<div class="modal-body">
						<legend>Rechazar pago</legend>
					</div>
				<div class="modal-footer " style="text-align:center;">
					<div class="alert responseDanger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					</div>
					<p class="textoPromedio">¿Seguro que desea rechazar este pago?</p>
					<textarea name="motivo" class="form-control" id="motivo"></textarea>
					<button class="btn btn-success envReject" style="margin-top:2em;">Rechazar</button>	
				</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="container">
		<div class="col-xs-12">
			@if(Session::has('success'))
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<p class="textoPromedio">{{ Session::get('success') }}</p>
			</div>
			@endif
			<div class="alert responseDanger" style="text-align:center;">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			</div>
			<h3>Pagos realizados</h3>
			<div class="clearfix"></div>
			<table class="table table-striped table-hover" style="margin:5em 0">
				<thead>
					<tr>
						<th>Codigo de factura</th>
						<th>Numero de transacción</th>
						<th>Dirección</th>
					</tr>
				</thead>
				<tbody>
					@foreach($fac as $f)
					<tr class="textoPromedio">
						<td>{{ $f->id }}</td>
						<td>
							{{ $f->num_trans }}
						</td>
						<td>{{ $f->dir }}</td>
						<td><a href="{{ URL::to('administrador/ver-factura/'.$f->id) }}" class="btn btn-info btn-xs">Ver</a></td>
						<td><button class="btn btn-success btn-xs aprov-fac" value="{{ $f->id }}">Aprobar</button></td>
						<td><button class="btn btn-danger btn-xs reject-fac" value="{{ $f->id }}" data-toggle="modal" data-target="#elimFac">Rechazar</button></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop