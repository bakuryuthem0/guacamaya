
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

	$('.imgMini').on('mouseover',function() {
		var esto = $(this);
		if ($('.imgMini').length > 1) {
			$('.imgPrinc').stop().animate({
				
				'opacity':0.5},
				150, function() {
					var imgHover = esto.attr('src');
					console.log(imgHover)
					$('.imgPrinc').attr('src',imgHover);

					$('.imgPrinc').stop().animate({
						
						'opacity':1},
						150);	
				});
		}
		
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
//ajax para eliminar cosas
jQuery(document).ready(function($) {
	$('.elimBtn').click(function(event) {
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
				}
			})
			
			
		});
	});
});
jQuery(document).ready(function($) {
	$('.iconToggle').click(function(event) {
		if ($(this).hasClass('fa-plus-circle')) {
			$(this).removeClass('fa-plus-circle');
			$(this).addClass('fa-minus-circle');
		}else if($(this).hasClass('fa-minus-circle')){
			$(this).removeClass('fa-minus-circle');
			$(this).addClass('fa-plus-circle');
		}
	});;
	
});
jQuery(document).ready(function($) {
	var cat = $('.cat');
	cat.change(function(event) {
		var id = $(this).val();
		$.ajax({
			url: 'categoria/buscar-sub-categoria',
			type: 'POST',
			data: {'id': id},
			success:function(response)
			{
				$('.optionModelParr').remove();
				for (var i = 0 ; i < response.length; i++) {
					$('.subcat').append('<option class="optionModelParr" value="'+response[i].id+'">'+response[i].sub_desc+'</option>');
				};
			
			}
		})
	});
});


jQuery(document).ready(function($) {
	
	if ($(window).scrollTop()>0) {
		$('.miniBanner').stop().animate({
			'height':0},
			250);
		$('#contCarrito').stop().animate({
			'top': 140},
			250);
	}else
	{
		$('.miniBanner').stop().animate({
			'height':50},
			250);
		$('#contCarrito').stop().animate({
			'top': 195},
			250);
	}
	$(window).scroll(function(event) {
		if ($(window).scrollTop()>0) {
			$('.miniBanner').stop().animate({
				'height':0},
				250);
			$('#contCarrito').stop().animate({
				'top': 140},
				250);
		}else
		{
			$('.miniBanner').stop().animate({
				'height':50},
				250);
			$('#contCarrito').stop().animate({
				'top': 195},
				250);
		}
	});
});

jQuery(document).ready(function($) {
	function doAjax(esto)
	{
		var boton = esto;
		to = boton.attr('data-url-value');
		$.ajax({
			//casa
			url: '/guacamaya/public/'+to,
			//trabajo
			//url: '/prueba/guacamaya/public/'+to,
			type: 'POST',
			dataType: 'json',
			data: {'id':boton.val() },
			beforeSend:function()
			{
				
				boton.animate({
						'opacity': 0},
						250,function(){
							$(this).css({
								'display':'none'
							});
							$('.loading').css({
								'display': 'inline-block'
							}).animate({
								'opacity': 1},
								250);
						}
				);
				boton.after('<img src="../images/loading.gif" class="loading">');
				
			},
			success:function(response)
			{
					$('.loading').animate({
						'opacity': 0},
						250,function(){
							$(this).remove();
							boton.css({
								'display': 'inline-block'
							}).animate({
								'opacity': 1},
								250);
						});
				$('#'+response.id+'> .carItem:nth-child(3)').html(response.qty);
				$('#'+response.id+'> .carItem:nth-child(5)').html(response.subtotal);
				$('.catnArt').html(response.count)
				$('.total').html(response.total)				
			
			}
		})
	}


	function doQuitarAjax(esto)
	{
		var boton = esto;
		var to = boton.attr('data-url-value');
			$.ajax({
				//casa
				url: '/guacamaya/public/'+to,
				//trabajo
				//url: '/prueba/guacamaya/public/'+to,
				type: 'POST',
				dataType: 'json',
				data: {'id':boton.val() },
				beforeSend:function()
				{
					boton.after('<img src="../images/loading.gif" class="loading">');
					boton.animate({
							'opacity': 0},
							250,function(){
								$(this).css({
									'display':'none'
								});
								$('.loading').css({
									'display': 'inline-block'
								}).animate({
									'opacity': 1},
									250);
							}
					);
					
				},
				success:function(response)
				{
					
					$('.loading').animate({
							'opacity': 0},
							250,function(){
								$(this).remove();
								boton.css({
									'display': 'inline-block'
								}).animate({
									'opacity': 1},
									250);
							});
					
					boton.parent().parent().animate({
							'opacity':0
						},
						250, function() {
						$(this).remove();
						});
					$('.catnArt').html(response.count)
					$('.total').html(response.total)				
				}
			})
	}
	$('.btnAdd').click(function(event) {
		var esto = $(this);
		doAjax(esto);

	});
	$('.btnRestar').click(function(event) {
		var esto = $(this);
		doAjax(esto);

	});
	$('.btnQuitar').click(function(event) {
		$('.btnQuitar').unbind('click');
		var x = confirm('¿Seguro desea quitar el item?');
		if (x) {
			var esto = $(this);
			doQuitarAjax(esto);

		}
	});
	$('.btnVaciar').click(function(event) {
		var x = confirm('¿Seguro desea vaciar el carrito?');
		if (x) {
			$.ajax({
				//casa
				url: '/guacamaya/public/vaciar-carrito',
				//trabajo
				//url: '/prueba/guacamaya/public/vaciar-carrito',
				type: 'POST',
				dataType: 'json',
				beforeSend:function()
				{
					$('.btnVaciar').animate({
							'opacity': 0},
							250,function(){
								$(this).css({
									'display':'none'
								});
								$('.loading').css({
									'display': 'inline-block'
								}).animate({
									'opacity': 1},
									250);
							}
					);
					$('.btn-carrito').addClass('disabled')
					$('.btnVaciar').after('<img src="../images/loading.gif" class="loading">');
					
				},
				success:function(response)
				{
					
					$('.loading').animate({
							'opacity': 0},
							250,function(){
								$(this).remove();
								$('.btnVaciar').css({
									'display': 'inline-block'
								}).animate({
									'opacity': 1},
									250);
							});
					$('.carItems').remove();
					$('.catnArt').html(0)
					$('.total').html(0)
					
				}
			})

		}
	});
	$('.btnAgg').click(function(event) {
		$('.btn-carrito').unbind('click')
		var dataPost = {
			'id'	: $(this).val(),
			'name'  : $(this).attr('data-name-value'),
			'price' : $(this).attr('data-price-value')
		}
		$.ajax({
			url: 'agregar-al-carrito',
			type: 'POST',
			dataType: 'json',
			data: dataPost,
			beforeSend:function()
			{
				$('.btnAgg').addClass('disabled');
				$('.btnAgg').after('<img src="../images/loading.gif" class="loading">');
				$('.loading').css({
						'display': 'inline-block'
					}).animate({
						'opacity': 1},
						500);
			},
			success:function(response)
			{

				$('.btnAgg').removeClass('disabled');
				$('.loading').animate({
						'opacity': 0},
						500,function(){
							$(this).remove();
						});
				$('.catnArt').html(response.cantArt);
				$('.total').html(response.total);
				if($('#'+response.id).length<1)
				{
					var row = '<tr class="carItems">';
	                  row = row+'<td class="carItem" id="'+response.id+'">';
	                    /*casa*/
	                    //row = row+'<img src="/guacamaya/public/images/items/'+response.img+'" class="carImg">';
	                    //trabajo
	                    row = row+'<img src="/prueba/guacamaya/public/images/items/'+response.img+'" class="carImg">';
	                  row = row+'</td>';
	                  row = row+'<td class="carItem">';
	                    row = row+response.name;
	                  row = row+'</td>';
	                  row = row+'<td class="carItem">';
	                    row = row+response.qty;
	                  row = row+'</td>';
	                  row = row+'<td class="carItem">';
	                    row = row+response.price;
	                  row = row+'</td>';
	                  row = row+'<td class="carItem">';
	                    row = row+response.subtotal;
	                  row = row+'</td>';
	                  row = row+'<td class="carItem">';
	                    row = row+'<button class="btn btn-success btn-xs btnAdd btn-carrito" data-url-value="agregar-item" value="'+response.rowid+'">';
	                      row = row+'Agregar';
	                    row = row+'</button>';
	                  row = row+'</td>';
	                  row = row+'<td class="carItem">';
	                    row = row+'<button class="btn btn-warning btn-xs btnRestar btn-carrito" data-url-value="restar-item" value="'+response.rowid+'">';
	                      row = row+'Restar';
	                    row = row+'</button>';
	                  row = row+'</td>';
	                  row = row+'<td class="carItem">';
	                    row = row+'<button class="btn btn-danger btn-xs btnQuitar btn-carrito" data-url-value="quitar-item" value="'+response.rowid+'">';
	                      row = row+'Quitar';
	                    row = row+'</button>';
	                  row = row+'</td>';
	                row = row+'</tr>';
	                $('.tableCarrito').append(row);
				}else
				{
					$('#'+response.id+'> .carItem:nth-child(3)').html(response.qty);
					$('#'+response.id+'> .carItem:nth-child(5)').html(response.subtotal);
					
				}
				$('.btnAdd').click(function(event) {
					var esto = $(this);
					doAjax(esto);

				});
				$('.btnRestar').click(function(event) {
					var esto = $(this);
					doAjax(esto);

				});
				$('.btnQuitar').click(function(event) {
					var x = confirm('¿Seguro desea quitar el item?');
					if (x) {
						var esto = $(this);
						doQuitarAjax(esto);

					}
				});
			}
		})
		
	});
	$('.talla').change(function(event) {
		
	});
});

jQuery(document).ready(function($) {
	$('.btnActualizar').click(function(event) {
		var boton = $(this);
		var inp = $(boton.attr('data-field-value'))
		if (inp.val()<1) {
			var x = confirm('¿Seguro desea quitar el item?');
			if (x) {
				$.ajax({
					//casa
					url: '/guacamaya/public/quitar-item',
					//trabajo
					//url: '/prueba/guacamaya/public/quitar-item',
					type: 'POST',
					dataType: 'json',
					data: {'id':boton.val() },
					beforeSend:function()
					{
						boton.after('<img src="../images/loading.gif" class="loading">');
						boton.animate({
								'opacity': 0},
								250,function(){
									$(this).css({
										'display':'none'
									});
									$('.loading').css({
										'display': 'inline-block'
									}).animate({
										'opacity': 1},
										250);
								}
						);
						
					},
					success:function(response)
					{
						
						$('.loading').animate({
								'opacity': 0},
								250,function(){
									$(this).remove();
									boton.css({
										'display': 'inline-block'
									}).animate({
										'opacity': 1},
										250);
								});
						
						boton.parent().parent().animate({
								'opacity':0
							},
							250, function() {
							$(this).remove();
							});
						$('#'+response.id).remove();
						$('.catnArt').html(response.count)
						$('.total').html(response.total)				
					}
				})

			}
		}else
		{
			$.ajax({
					//casa
					url: '/guacamaya/public/actualizar-al-carrito',
					//trabajo
					//url: '/prueba/guacamaya/public/actualizar-al-carrito',
					type: 'POST',
					dataType: 'json',
					data: {
						'id' :boton.val(),
						'qty':inp.val() },
					beforeSend:function()
					{
						boton.after('<img src="../images/loading.gif" class="loading">');
						boton.animate({
								'opacity': 0},
								250,function(){
									$(this).css({
										'display':'none'
									});
									$('.loading').css({
										'display': 'inline-block'
									}).animate({
										'opacity': 1},
										250);
								}
						);
						
					},
					success:function(response)
					{
						
						$('.loading').animate({
								'opacity': 0},
								250,function(){
									$(this).remove();
									boton.css({
										'display': 'inline-block'
									}).animate({
										'opacity': 1},
										250);
								});
						$('#'+response.id+'> .carItem:nth-child(3)').html(response.qty);
						$('#'+response.id+'> .carItem:nth-child(5)').html(response.subtotal);
						$(boton.attr('data-field-value')+'_subtotal').html(response.subtotal);
						$('.catnArt').html(response.count)
						$('.total').html(response.total)				
					}
				})
		}
	});
});
jQuery(document).ready(function($) {
	$('.optionA').click(function(event) {
		var target = $(this).data('target');
		$('.contOptionA').animate({'opacity':0}, 500,function(){
			$(this).css({'display':'none'});
			$(target).css({'display':'block'}).animate({'opacity':1},500)
			$('.volver').css({'display':'block'}).animate({'opacity':1}, 500)
		})
	});
	$('.volver').click(function(event) {
		$(this).animate({'opacity':0}, 500,function(){
			$(this).css({'display':'none'});
			$('.contOptionA').css({'display':'block'}).animate({'opacity':1},500)
		})
		$('.imagesSlidesOption').animate({'opacity':0}, 500,function(){
			$(this).css({'display':'none'});
		})
	});
});