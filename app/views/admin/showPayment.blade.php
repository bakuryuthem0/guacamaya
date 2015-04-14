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
						<th>email</th>
						<th>Dirección</th>
						@if(isset($type))<th>Datos del usuario</th>@endif
					</tr>
				</thead>
				<tbody>
					@foreach($fac as $f)
					<tr class="textoPromedio">
						<td>{{ $f->id }}</td>
						<td>
							{{ $f->num_trans }}
						</td>
						<td>{{ $f->email }}</td>
						<td>{{ $f->dir }}</td>
						@if(!isset($type))

						<td><a href="{{ URL::to('administrador/ver-factura/'.$f->id) }}" class="btn btn-info btn-xs">Ver</a></td>
						<td><button class="btn btn-success btn-xs aprov-fac" value="{{ $f->id }}">Aprobar</button></td>
						<td><button class="btn btn-danger btn-xs reject-fac" value="{{ $f->id }}" data-toggle="modal" data-target="#elimFac">Rechazar</button></td>
						@else
						<td class="textoMedio noMovil"><button class="btn btn-primary btn-xs ver" data-toggle="modal" data-target="#showUserData" value="{{ $f->id }}">Ver</button></td>
						<input type="hidden" class="username-{{ $f->id }}" value="{{ $f->username }}">
						<input type="hidden" class="name-{{ $f->id }}" value="{{ $f->nombre.' '.$f->apellido }}">
						<input type="hidden" class="email-{{ $f->id }}" value="{{ $f->email }}">
						<input type="hidden" class="dir-{{ $f->id }}" value="{{ $f->user_dir }}">
						<input type="hidden" class="phone-{{ $f->id }}" value="{{ $f->telefono }}">
						<input type="hidden" class="est-{{ $f->id }}" value="{{ $f->est }}">
						<input type="hidden" class="mun-{{ $f->id }}" value="{{ $f->mun }}">
						<input type="hidden" class="par-{{ $f->id }}" value="{{ $f->par }}">
						@endif
					</tr>
					@endforeach

				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="modal fade" id="showUserData" tabindex="-1" role="dialog" aria-labelledby="modalForggo" aria-hidden="true">
	<div class="forgotPass modal-dialog imgLiderUp">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Datos del usuario.</h4>
			</div>
			<div class="modal-body">
				<div class="col-xs-12" style="margin-top:3em;">
					<p class="textoPromedio"><label>Nombre de usuario</label></p>
					<p class="textoPromedio usernameModal">

					</p>
				</div>
				<div class="col-xs-12">
					<p class="textoPromedio"><label>Nombre y apellido</label></p>
					<p class="textoPromedio nameModal">

					</p>
				</div>
				<div class="col-xs-12">
					<p class="textoPromedio"><label>Email</label></p>
					<p class="textoPromedio emailModal">

					</p>
				</div>
				<div class="col-xs-12">
					<p class="textoPromedio"><label>Dirección</label></p>
					<p class="textoPromedio dirModal">

					</p>
				</div>
				<div class="col-xs-12">
					<p class="textoPromedio"><label>Telefono</label></p>
					<p class="textoPromedio phoneModal">

					</p>
				</div>
				<div class="col-xs-12">
					<p class="textoPromedio"><label>Estado</label></p>
					<p class="textoPromedio pagWebModal">

					</p>
				</div>
				<div class="col-xs-12">
					<p class="textoPromedio"><label>Municipio</label></p>
					<p class="textoPromedio carnetModal">

					</p>
				</div>
				<div class="col-xs-12">
					<p class="textoPromedio"><label>Parroquia</label></p>
					<p class="textoPromedio nitModal">

					</p>
				</div>
			</div>
			<div class="modal-footer " style="text-align:center;">
				
			</div>
		</div>
	</div>
</div>
@stop