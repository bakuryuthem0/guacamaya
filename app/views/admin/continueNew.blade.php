@extends('layouts.admin')

@section('content')
{{ HTML::style('https://rawgit.com/enyo/dropzone/master/dist/dropzone.css') }}
<div class="row">
	<div class="container">
		<div class="col-xs-12 contCentrado contdeColor">
			<div class="col-xs-12">
				<legend>Seleccione las caracteristicas del articulo</legend>
			</div>
			<form class="formCart" method="POST">
			<div class="col-xs-6 inputForm">
				<label class="textoPromedio">Seleccione la talla</label>
				<?php $arr = array(
					'' => 'Seleccione la talla');
					 ?>
				@if(!empty($tallas) && !is_null($tallas) && count($tallas)>0)
					@foreach ($tallas as $talla)
						<?php $arr = $arr+array($talla->id => $talla->talla_nomb.' - '.$talla->talla_desc);  ?>
					@endforeach
				@endif
				{{ Form::select('talla',$arr,Input::old('talla'),array('class' => 'form-control','requied' => 'required')
					)}}
			</div>
			<div class="col-xs-6 inputForm">
				<label class="textoPromedio">Seleccione El color</label>
				<?php $arr = array(
					'' => 'Seleccione la talla');
					 ?>
				@if(!empty($colores) && !is_null($colores) && count($colores)>0)
					@foreach ($colores as $color)
						<?php $arr = $arr+array($color->id => $color->color_desc);  ?>
					@endforeach
				@endif
				{{ Form::select('color',$arr,Input::old('color'),array('class' => 'form-control','requied' => 'required')
					)}}
				<input type="hidden" name="art" value="{{ $id }}">
                <input type="hidden" name="misc" value="{{ $misc_id }}">
			</div>
			
			</form>
			<div class="col-xs-12 inputForm">
                <legend style="text-align:center;">Agregar las imágenes.</legend>
                <p class="textoPromedio">Arrastre imágenes en el cuadro o presione en él para así cargar las imágenes.</p>
                <p class="textoPromedio">Recuerde que posee un límite para 8 imágenes adicionales.</p>
                <div id="dropzone">
                    <form action="{{ URL::to('administrador/nuevo-articulo/imagenes/procesar') }}" method="POST" class="dropzone textoPromedio" id="my-awesome-dropzone">
                        <div class="dz-message">
                            Arrastre o presione aquí para subir su imagen.
                        </div>
                        <input type="hidden" name="art_id" class="art_id" value="{{ $id }}">
                        <input type="hidden" name="misc_id" class="misc_id" value="{{ $misc_id }}">
                    </form>
                    
                </div>
            </div>
			<div class="col-xs-12">
				<button class="btn btn-primary contNew">Nueva caracteristica</button>
				<button class="btn btn-success contSave">Guardar y continuar</button>
			</div>
			<div class="clearfix"></div>
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
{{ HTML::script('js/dropzone.js') }}
<script type="text/javascript">
    Dropzone.autoDiscover = false;
// or disable for specific dropzone:
// Dropzone.options.myDropzone = false;
    var myDropzone = new Dropzone("#my-awesome-dropzone");

    myDropzone.on("removedfile", function(file) {
        if(file.xhr){

            $(function() {
              // Now that the DOM is fully loaded, create the dropzone, and setup the
              // event listeners
                var url = JSON.parse(file.xhr.response);
                var imagepath = url.url;
                $.ajax({
                    url: 'publicacion/habitual/enviar/imagenes/eliminar',
                    type: 'POST)',
                    dataType: 'json',
                    data: {name :  file.name},
                    success:function(response)
                    {
                        console.log(response)
                    }
                })

                
                })
            }
    })
</script>
@stop