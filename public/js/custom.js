jQuery(document).ready(function($) {
	/*-------------------------------------------registro de usuario-------------------------------------------*/
	var estado = $('#estado');
	estado.change(function(event) {
		if ($(this).val() != "") {
			var id = estado.val();
			$.ajax({
				url: 'registro/buscar-municipio',
				type: 'POST',
				data: {'id': id},
				success:function(response)
				{
					$('.optionModel').remove();
					for (var i = 0 ; i < response.length; i++) {
						$('#municipio').append('<option class="optionModel" value="'+response[i].id+'">'+response[i].nombre+'</option>');
					};

					var mun = $('#municipio');
					mun.change(function(event) {
						var id = $(this).val();
						$.ajax({
							url: 'registro/buscar-parroquia',
							type: 'POST',
							data: {'id': id},
							success:function(response)
							{
								$('.optionModelParr').remove();
								for (var i = 0 ; i < response.length; i++) {
									$('#parroquia').append('<option class="optionModelParr" value="'+response[i].id+'">'+response[i].nombre+'</option>');
								};
							
							}
						})
					});
				}
			})

			
		}
	});
	/*$('#enviar').click(function(event) {
		function alerta(esto,msg)
		{
			$(esto).focus();
			$(esto).css({'box-shadow':'0px 0px 1px 1px red'});
			$(esto).after('<p class="erroneo textoPromedio">'+msg+'</p>');
		}

	});*/
});

/*olvide la contraseña esto me ayuda*/
jQuery(document).ready(function($) {
	$('.forgot').click(function(event) {
		$('.myModal').css({
			'display': 'block'
		}).animate({
			'opacity': 1},
			500);
		$('.cerrar').click(function(event) {
			$('.myModal').stop().animate({
				'opacity':0},
				500, function() {
				$(this).css({
					display: 'none'
				});
				$('body').css({
					'overflow': 'scroll'
				});
				$('.responseDanger').animate({
					'opacity': 0},
					500,function(){
						$(this).css({
							'display': 'none'
						});
				});
			});
			
		});
		$('body').css({
			'overflow': 'hidden'
		});
		$('.emailForgot').focus(function(event) {
			$('.responseDanger').animate({
					'opacity': 0},
					500,function(){
						$(this).css({
							'display': 'none'
						});
				});
		});
		$('.envForgot').click(function(event) {
			var email = $('.emailForgot').val();
			var boton = $(this);
			event.preventDefault();
			boton.prop({
				'disabled': true
			})
			$.ajax({
				url: 'chequear/email',
				type: 'POST',
				dataType: 'json',
				data: {'email': email},
				beforeSend:function()
				{
					$('.envForgot').after('<img src="images/loading.gif" class="loading">');
					$('.loading').css({
						'display': 'block',
						'margin': '2em auto'
					}).animate({
						'opacity': 1},
						500);
				},
				success:function(response){
					$('.loading').animate({
						'opacity': 0},
						500,function(){
							$(this).remove();
						});
					$('.responseDanger').removeClass('alert-danger');
					$('.responseDanger').removeClass('alert-success');
					$('.responseDanger').stop().css({'display':'block'}).addClass('alert-'+response.type).html('<p class="textoPromedio">'+response.msg+'</p>').animate({
						'opacity': 1},
						500);
					if (response.type == 'danger') {
						event.preventDefault();
					}
					boton.prop({
						'disabled': false,
					})
				},error:function()
				{
					console.log('error');
				}
			})
			
		});

	});

});


jQuery(document).ready(function($) {
	var id = $('.art_id').val(),misc = $('.misc_id').val();
	$('.contNew').click(function(event) {
		$('.formCart').prop({
			'action': '../enviar/'+id+'/'+misc,
		})
		$('.formCart').submit();
	});
	$('.contSave').click(function(event) {
		$('.formCart').prop({
			'action': '../guardar-cerrar/'+id+'/'+misc,
		})
		$('.formCart').submit();
	});
});

jQuery(document).ready(function($) {
	var imgPrinc = $('.imgPrinc').attr('src');
	$('.imgMini').on('mouseover',function() {
		var imgHover = $(this).attr('src');
		$('.imgPrinc').attr('src',imgHover);
	});
});
jQuery(document).ready(function($) {
	$('#enviar').click(function(event) {
		event.preventDefault();
		$('.errorText').remove();
		function alerta(esto){
			esto.css({
				'box-shadow': '0px 0px 1px 1px red'
			});
			esto.after('<p class="textoPromedio errorText">Debe llenar este campo</p>')
		}
		$('.inputForm').click(function(event) {
			$(this).css({
				'box-shadow': '0px 0px 1px 1px rgba(0,0,0,0)'
			});
			$(this).next('p').remove()
		});
		$('.inputForm').each(function(){
			if ($(this).val() == "") {
				alerta($(this))
			}

		})
		if ($('.cat_nomb').val() != "" && $('.cat_desc').val() != "") {
			$('#formRegister').submit();
		}
	});
});

jQuery(document).ready(function($) {
	$('.elimCat').click(function(event) {
		var boton = $(this);
		$('.responseDanger').removeClass('alert-danger');
		$('.responseDanger').removeClass('alert-success');
		$('.responseDanger').css({
			'display': 'none',
			'opacity': 0
		});
		$('.close').click(function(event) {
			$('.responseDanger').removeClass('alert-danger');
			$('.responseDanger').removeClass('alert-success');	
			$('.responseDanger').css({
				'display': 'none',
				'opacity': 0
			});
			$('.envElim').removeClass('disabled')
		});
		$('.envElim').val($(this).val());
		$('.envElim').click(function(event) {

			$(this).unbind('click');
			$.ajax({
				url: 'eliminar',
				type: 'POST',
				dataType: 'json',
				data: {id: $(this).val()},
				beforeSend:function()
				{
					$('.envElim').before('<img src="../images/loading.gif" class="loading">');
					$('.loading').css({
						'display': 'block',
						'margin': '2em auto'
					}).animate({
						'opacity': 1},
						500);
					$('.envElim').addClass('disabled');
				},
				success:function(response)
				{
					$('.envElim').removeClass('disabled');
					$('.loading').animate({
						'opacity': 0},
						500,function(){
							$(this).remove();
						});
					if (response.type == 'success') {

						boton.parent().parent().remove();
					};
					$('.responseDanger').addClass('alert-'+response.type).html(response.msg).css({
						'display': 'block'
					}).animate({
						'opacity': 1},
						500);
					console.log(response)
				}
			})
			
			
		});
	});
});
jQuery(document).ready(function($) {
	$('.elimColor').click(function(event) {
		var boton = $(this);
		$('.responseDanger').removeClass('alert-danger');
		$('.responseDanger').removeClass('alert-success');
		$('.responseDanger').css({
			'display': 'none',
			'opacity': 0
		});
		$('.close').click(function(event) {
			$('.responseDanger').removeClass('alert-danger');
			$('.responseDanger').removeClass('alert-success');	
			$('.responseDanger').css({
				'display': 'none',
				'opacity': 0
			});
			$('.envElim').removeClass('disabled')
		});
		$('.envElim').val($(this).val());
		$('.envElim').click(function(event) {

			$(this).unbind('click');
			$.ajax({
				url: 'eliminar',
				type: 'POST',
				dataType: 'json',
				data: {id: $(this).val()},
				beforeSend:function()
				{
					$('.envElim').before('<img src="../images/loading.gif" class="loading">');
					$('.loading').css({
						'display': 'block',
						'margin': '2em auto'
					}).animate({
						'opacity': 1},
						500);
					$('.envElim').addClass('disabled');
				},
				success:function(response)
				{
					$('.envElim').removeClass('disabled');
					$('.loading').animate({
						'opacity': 0},
						500,function(){
							$(this).remove();
						});
					if (response.type == 'success') {

						boton.parent().parent().remove();
					};
					$('.responseDanger').addClass('alert-'+response.type).html(response.msg).css({
						'display': 'block'
					}).animate({
						'opacity': 1},
						500);
					console.log(response)
				}
			})
			
			
		});
	});
});