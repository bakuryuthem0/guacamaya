@extends('layouts.admin')

@section('content')
{{ HTML::style('https://rawgit.com/enyo/dropzone/master/dist/dropzone.css') }}
<div class="row">
	<div class="container">
		<div class="col-xs-12 contCentrado contdeColor">
			<legend>Nuevo articulo</legend>
			<p class="textoPromedio">(*) Campo obligatorio</p>
			<hr>
			<div class="col-xs-6 inputForm">
				<label class="textoPromedio">(*) Código del artículo</label>
				{{ Form::text('item_id', Input::old('item_id'), array('class' => 'form-control','placeholder' => 'Código del artículo')) }}
			</div>
			<div class="col-xs-6 inputForm">	
				<label class="textoPromedio">(*) Nombre del artículo</label>
				{{ Form::text('item_nomb', Input::old('item_nomb'), array('class' => 'form-control','placeholder' => 'Nombre del artículo')) }}
			</div>
			<div class="col-xs-12 inputForm">	
				<label class="textoPromedio">(*) Descripción del artículo</label>
				<textarea class="form-control editor" name="item_desc" placeholder="Descripción del artículo">{{ Input::old('item_desc') }}</textarea>
			</div>
			<div class="col-xs-12 inputForm">	
				<label class="textoPromedio">(*) Cantidad de artículos</label>
				{{ Form::text('item_nomb', Input::old('item_nomb'), array('class' => 'form-control','placeholder' => 'Nombre del artículo')) }}
			</div>
			<div class="col-xs-12 inputForm">
				<label class="textoPromedio">Seleccione las imagenes para su artículo</label>
				<p class="bg-info textoPromedio" style="padding:0.5em;text-align:center;">Posee un máximo de 8 imágenes</p>
				 <form action="{{ URL::to('publicacion/habitual/enviar/imagenes/procesar') }}" method="POST" class="dropzone textoPromedio" id="my-awesome-dropzone">
                    <div class="dz-message">
                        Arrastre o presione aquí para subir su imagen.
                    </div>
                </form>
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