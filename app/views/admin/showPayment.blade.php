@extends('layouts.admin')

@section('content')
<div class="modal fade" id="rejectFac" tabindex="-1" role="dialog" aria-labelledby="modalForggo" aria-hidden="true">
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
<div class="modal fade" id="elimFac" tabindex="-1" role="dialog" aria-labelledby="modalForggo" aria-hidden="true">
	<div class="forgotPass modal-dialog imgLiderUp">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			</div>
				<div class="modal-body">
						<legend>Eliminar factura</legend>
					</div>
				<div class="modal-footer " style="text-align:center;">
					<div class="alert responseDanger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					</div>
					<p class="textoPromedio">¿Seguro que desea eliminar esta factura?</p>
					<textarea name="motivo" class="form-control" id="motivoElim"></textarea>
					<button class="btn btn-success envElim" style="margin-top:2em;">Eliminar</button>	
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
					<tr>
						<th>Codigo de factura</th>
						<th>Banco</th>
						<th>Numero de transacción</th>
						<th>Fecha de transacción</th>
						<th>email</th>
						<th>Dirección</th>
						<th>Ver Factura</th>
						@if(isset($type))<th>Datos del usuario</th>@endif
					</tr>
				</thead>
				<tbody>
					@foreach($fac as $f)
					<tr class="textoPromedio">
						<td>{{ $f->id }}</td>
						<td>{{ $f->banco }}</td>
						<td>
							{{ $f->num_trans }}
						</td>
						<td>{{ $f->fech_trans }}</td>
						<td>{{ $f->email }}</td>
						<td class="dirShow" data-toggle="modal" data-target="#showDirData">{{ $f->dir_name }}</td>
						<td><a target="_blank" href="{{ URL::to('administrador/ver-factura/'.$f->id) }}" class="btn btn-info btn-xs">Ver</a></td>
						@if(!isset($type))

						<td><button class="btn btn-success btn-xs aprov-fac" value="{{ $f->id }}">Aprobar</button></td>
						<td><button class="btn btn-danger btn-xs reject-fac" value="{{ $f->id }}" data-toggle="modal" data-target="#rejectFac">Rechazar</button></td>
						@endif
						<td class="textoMedio"><button class="btn btn-primary btn-xs ver" data-toggle="modal" data-target="#showUserData" value="{{ $f->id }}">Ver</button></td>
						<input type="hidden" class="username-{{ $f->id }}" value="{{ $f->username }}">
						<input type="hidden" class="name-{{ $f->id }}" value="{{ $f->nombre.' '.$f->apellido }}">
						<input type="hidden" class="email-{{ $f->id }}" value="{{ $f->email }}">
						<input type="hidden" class="cedula-{{ $f->id }}" value="{{ $f->cedula }}">
						<input type="hidden" class="dir-{{ $f->id }}" value="{{ $f->user_dir }}">
						<input type="hidden" class="phone-{{ $f->id }}" value="{{ $f->telefono }}">
						<input type="hidden" class="est-{{ $f->id }}" value="{{ $f->est }}">
						<input type="hidden" class="mun-{{ $f->id }}" value="{{ $f->mun }}">
						<input type="hidden" class="par-{{ $f->id }}" value="{{ $f->par }}">
					</tr>
					@endforeach

				</tbody>
			</table>

			@if(isset($facNot) && count($facNot)>0)
				<div class="formulario" style="margin-top:5em;">
					<legend>Facturas no pagadas</legend>
					<table id="tablesorter" class="tablesorter table table-striped table-condensed table-vertical-middle table-super-condensed table-bordered table-list-search table-hover">
					<thead>
						<tr>
							<th>Codigo de factura</th>
							<th>email</th>
							<th>Dirección</th>
							<th>Ver Factura</th>
							@if(isset($type))<th>Datos del usuario</th>@endif
						</tr>
					</thead>
					<tbody>
						@foreach($facNot as $f)
						<tr class="textoPromedio">
							<td>{{ $f->id }}</td>
							<td>{{ $f->email }}</td>
							<td class="dirShow" data-toggle="modal" data-target="#showDirData">{{ $f->dir_name }}</td>
							<td><a target="_blank" href="{{ URL::to('administrador/ver-factura/'.$f->id) }}" class="btn btn-info btn-xs">Ver</a></td>
							@if(!isset($type))
							<td><button class="btn btn-danger btn-xs elim-fac" value="{{ $f->id }}" data-toggle="modal" data-target="#elimFac">Eliminar</button></td>
							@endif
							<td class="textoMedio"><button class="btn btn-primary btn-xs ver" data-toggle="modal" data-target="#showUserData" value="{{ $f->id }}">Ver</button></td>
							<input type="hidden" class="username-{{ $f->id }}" value="{{ $f->username }}">
							<input type="hidden" class="name-{{ $f->id }}" value="{{ $f->nombre.' '.$f->apellido }}">
							<input type="hidden" class="cedula-{{ $f->id }}" value="{{ $f->cedula }}">
							<input type="hidden" class="email-{{ $f->id }}" value="{{ $f->email }}">
							<input type="hidden" class="dir-{{ $f->id }}" value="{{ $f->user_dir }}">
							<input type="hidden" class="phone-{{ $f->id }}" value="{{ $f->telefono }}">
							<input type="hidden" class="est-{{ $f->id }}" value="{{ $f->est }}">
							<input type="hidden" class="mun-{{ $f->id }}" value="{{ $f->mun }}">
							<input type="hidden" class="par-{{ $f->id }}" value="{{ $f->par }}">
						</tr>
						@endforeach

					</tbody>
				</table>
				@endif
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="showDirData" tabindex="-1" role="dialog" aria-labelledby="modalForggo" aria-hidden="true">
	<div class="forgotPass modal-dialog imgLiderUp">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Dirección de envio.</h4>
			</div>
			<div class="modal-body">
				<div class="dirBody textoPromedio"></div>
			</div>
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
					<p class="textoPromedio"><label>Cedula</label></p>
					<p class="textoPromedio cedulaModal">

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