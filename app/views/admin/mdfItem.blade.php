@extends('layouts.admin')

@section('content')

<div class="row">
	<div class="container">
		<div class="col-xs-12">
			@if(Session::has('danger'))
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<p class="textoPromedio">{{ Session::get('danger') }}</p>
				</div>
			@elseif(Session::has('success'))
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<p class="textoPromedio">{{ Session::get('success') }}</p>
				</div>
			@endif
			<h3>Modificación de articulo</h3>
			<div class="col-xs-12 contdeColor" style="margin-top:2em;">
				<form method="POST" action="{{ URL::to('administrador/modificar-articulo') }}">
				<div class="col-xs-12">
					<p class="bg-info textoPromedio" style="padding:0.5em;">Información del articulo</p>
				</div>
				<div class="col-xs-6 inputForm">
					<label class="textoPromedio">(*) Codigo del articulo</label>
					<input type="text" name="item_cod" value="{{ $item->item_cod }}" class="form-control">
					@if ($errors->has('item_cod'))
						 @foreach($errors->get('item_cod') as $err)
						 	<div class="alert alert-danger">
						 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						 		<p class="textoPromedio">{{ $err }}</p>
						 	</div>
						 @endforeach
					@endif
				</div>
				<div class="col-xs-6 inputForm">
					<label class="textoPromedio">(*) Nombre de articulo</label>
					<input type="text" name="item_nomb" value="{{ $item->item_nomb }}" class="form-control">
					@if ($errors->has('item_nomb'))
						 @foreach($errors->get('item_nomb') as $err)
						 	<div class="alert alert-danger">
						 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						 		<p class="textoPromedio">{{ $err }}</p>
						 	</div>
						 @endforeach
					@endif
				</div>
				<div class="col-xs-12 inputForm">	
					<label class="textoPromedio">(*) Descripción del artículo</label>
					<textarea class="form-control editor" name="item_desc" placeholder="Descripción del artículo">{{ $item->item_desc }}</textarea>
					@if ($errors->has('item_desc'))
						 @foreach($errors->get('item_desc') as $err)
						 	<div class="alert alert-danger">
						 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						 		<p class="textoPromedio">{{ $err }}</p>
						 	</div>
						 @endforeach
					@endif
				</div>
				<div class="col-xs-12">
					<p class="bg-info textoPromedio" style="padding:0.5em;">En caso de no desear cambiar la categoria y la sub-categoria, omita estos campos</p>
				</div>
				<div class="col-xs-6 inputForm">	
					<label class="textoPromedio">(*) Categoría del artículo</label>
					<?php $arr = array(
								'' => 'Seleccione la Categoría');
								 ?>
						@foreach ($cat as $c)
							<?php $arr = $arr+array($c->id => $c->cat_desc);  ?>
						@endforeach
						
						{{ Form::select('cat',$arr,Input::old('cat'),array('class' => 'form-control catx','requied' => 'required')
							)}}
						
					@if ($errors->has('cat'))
						 @foreach($errors->get('cat') as $err)
						 	<div class="alert alert-danger">
						 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						 		<p class="textoPromedio ">{{ $err }}</p>
						 	</div>
						 @endforeach
					@endif
				</div>
				<div class="col-xs-6 inputForm">	
					<label class="textoPromedio">Sub-categoría del artículo</label>
					<select name="subcat" class="form-control subcat">
						<option value="">Seleccione la sub-categoria</option>
					</select>					
					@if ($errors->has('subcat'))
						 @foreach($errors->get('subcat') as $err)
						 	<div class="alert alert-danger">
						 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						 		<p class="textoPromedio ">{{ $err }}</p>
						 	</div>
						 @endforeach
					@endif
				</div>
				<div class="col-xs-6 inputForm">	
					<label class="textoPromedio">(*) Precio del artículo</label>
					{{ Form::text('item_precio', $item->item_precio, array('class' => 'form-control','placeholder' => 'Precio del artículo')) }}
					@if ($errors->has('item_precio'))
						 @foreach($errors->get('item_precio') as $err)
						 	<div class="alert alert-danger">
						 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						 		<p class="textoPromedio ">{{ $err }}</p>
						 	</div>
						 @endforeach
					@endif
				</div>
				<div class="col-xs-6 inputForm">	
					<label class="textoPromedio">(*) Cantidad de artículos</label>
					{{ Form::text('item_stock', $item->item_stock, array('class' => 'form-control','placeholder' => 'Cantidad de artículos')) }}
					@if ($errors->has('item_stock'))
						 @foreach($errors->get('item_stock') as $err)
						 	<div class="alert alert-danger">
						 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						 		<p class="textoPromedio ">{{ $err }}</p>
						 	</div>
						 @endforeach
					@endif
				</div>
				<div class="clearfix"></div>
				<div class="col-xs-12">
					<p class="bg-info textoPromedio" style="padding:0.5em;">Caracteristicas del articulo</p>
				</div>
				<div class="col-xs-12">
					<p class="bg-info textoPromedio" style="padding:0.5em;">En caso de no desear cambiar la talla y el color, omita estos campos</p>
				</div>
				<div class="col-xs-6 inputForm">
					<label class="textoPromedio">Seleccione la talla</label>
					<?php $arr = array(
						'' => 'Seleccione la talla');
						 ?>
					@if(!empty($tallas) && !is_null($tallas) && count($tallas)>0)
						@foreach ($tallas as $talla)
							<?php $arr = $arr+array($talla->id => strtoupper($talla->talla_nomb).' - '.ucfirst($talla->talla_desc));  ?>
						@endforeach
					@endif
					{{ Form::select('talla',$arr,Input::old('talla'),array('class' => 'form-control','requied' => 'required')
						)}}
				</div>
				<div class="col-xs-6 inputForm">
					<label class="textoPromedio">Seleccione El color</label>
					<?php $arr = array(
						'' => 'Seleccione el color');
						 ?>
					@if(!empty($colores) && !is_null($colores) && count($colores)>0)
						@foreach ($colores as $color)
							<?php $arr = $arr+array($color->id => ucfirst($color->color_desc));  ?>
						@endforeach
					@endif
					{{ Form::select('color',$arr,Input::old('color'),array('class' => 'form-control','requied' => 'required')
						)}}
					<input type="hidden" name="misc" value="{{ $item->misc->id }}">
					<input type="hidden" name="item" value="{{ $item->id }}">
				</div>
				<div class="col-xs-12">
					<button class="btn btn-success" style="margin-top:1em;">Enviar</button>
				</div>
				</form>
			</div>
			<div class="col-xs-12" style="margin-top:2em;">
				<div class="col-xs-12 contdeColor">
					<p class="bg-info textoPromedio" style="padding:0.5em;">Recuerde que para modificar las imagenes, debe de ser de una en vez. </p>
					<table class="table table-hover tablaImages">
						<tbody>
							@foreach($item->img as $i) 
							<tr>
								<td><img src="{{ asset('images/items/'.$i->image) }}"></td>
								<td><form method="POST" action="{{ URL::to('administrador/cambiar-imagen') }}" enctype="multipart/form-data"><div class="fileUpload btn btn-primary">
									    <span>Cambiar</span>
									    
									    	<input type="file" name="file" class="upload" />
									    	<input type="hidden" name="id" value="{{ $i->id }}">
									    	<input type="hidden" name="item_id" value="{{ $item->id }}">
									   
									</div> </form></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			
		</div>
	</div>
</div>

@stop
@section('postscript')
<script>

	CKEDITOR.disableAutoInline = true;

	$( document ).ready( function() {
		$( '.editor' ).ckeditor(); // Use CKEDITOR.replace() if element is <textarea>.
	} );

</script>

@stop