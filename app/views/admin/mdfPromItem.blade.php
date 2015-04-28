@extends('layouts.admin')

@section('content')

<div class="row">
	<div class="container">
		<div class="col-xs-12">
			<div class="col-xs-8 contCentrado">
				<h3>Agregar / Quitar articulos de la promocion</h3>
				<hr>
				<br>
				<div class="alert responseDanger" style="text-align:center;">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				</div>
				<p class="bg-info textoPromedio" style="padding:0.5em;">A todos los articulos seleccionados se le aplicara un descuento de {{ $prom->percent }}%</p>
					<div class="input-group">
						<!-- USE TWITTER TYPEAHEAD JSON WITH API TO SEARCH -->
						<input class="form-control" id="buscar-usuario" name="q" placeholder="Busqueda general" required>
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-search"></i>
						</span>
					</div>
				</form>
				<table class="table table-hover textoPromedio table-list-search">
					<thead>
						<tr>
							<th>Codigo del articulos</th>
							<th>Imagen</th>
							<th>Agregar/Quitar</th>
						</tr>
					</thead>
					<tbody>
							<input type="hidden" class="promValue" value="{{ $prom->id }}">
					@foreach($items as $x => $i)
						<tr>
							<td style="vertical-align:middle;">{{ $i[$x]->item_cod }}</td>
							<td style="vertical-align:middle;"><img src="{{ asset('images/items/'.$i->img[$x]) }}" style="max-width:100px;"></td>
							<td style="vertical-align:middle;">
								<button class="btn btn-warning btn-xs btn-deactive @if($i[$x]->item_prom != 0)active@endif" value="{{ $i[$x]->id }}">
									@if($i[$x]->item_prom != 0)Desactivar @else Activar@endif</button>
							</td>
						</tr>
					@endforeach
	
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@stop