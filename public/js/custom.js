jQuery(document).ready(function($) {
	$('.iniciar-sesion').popover('show');
	$('.iniciar-sesion').click(function(){
		$('.popover').remove();
	})
});
jQuery(document).ready(function($) {
	$('.logout').click(function(event) {
		var x = confirm('¿Seguro desea salir?');
		if (!x) {
			event.preventDefault();
		}
	});	
});
jQuery(document).ready(function($) {
	$('.btnShowInfoItem').click(function(event) {
		var x = $(this);
		$('.itemNameModal').html('<label>Articulo: </label><p>'+x.attr('data-name'))
		$('.itemTallaModal').html('<label>Talla: </label><p>'+x.attr('data-talla')+'</p>')
		$('.itemColorModal').html('<label>Color: </label><p>'+x.attr('data-color')+'</p>')
		$('.itemPrecioModal').html('<label>Precio: </label><p>'+x.attr('data-precio')+'</p>')
		$('.itemSubtotalModal').html('<label>Sub-Total: </label><p>'+x.attr('data-subtotal')+'</p>')
		$('.itemQtylModal').html('<label>Cantidad: </label><p>'+x.attr('data-qty')+'</p>')
	});
});
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
jQuery(document).ready(function($) {
	$('.choose').change(function(event) {
		var id = $(this).val();
		var item_id = $('.values').val();
		if (id == "") {
			$('.removable').remove();
			$('.colores').append('<li class="removable">Elija una talla</li>')
		}else
		{
			$.ajax({
				url: 'buscar/colores',
				type: 'POST',
				dataType: 'json',
				data: {'id': id,'item_id':item_id},
				beforeSend:function(){
					$('.choose').after('<img src="../images/loading.gif" class="loading">');
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
					if (response != "undefined" && response.length > 0) {
						$('.removable').remove();
						for(var i = 0;i<response.length;i++)
						{
							$('.colores').append('<li class="removable">'+response[i].color_desc+' - '+response[i].item_stock+'</li>')
						}	
					};
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
	$('.imgPrincSelf').hover(function(event) {
		$('.zoomed').attr('src', $(this).attr('src'));
		$('.zoomed').css({
			'display':'block',
			'height' : $(this).css('height')
		}).stop().animate({'opacity':1}, 250)
		$(this).stop().animate({'opacity':0}, 250)
		$(this).mousemove(function(event) {
			var x = event.pageX - $(this).offset().left -100;
			var y = event.pageY - $(this).offset().top  -100;

			$('.zoomed').css({
				'transform-origin': x+'px '+y+'px'
			});
			
		});
	}, function(event) {
		$('.zoomed').stop().animate({'opacity':0}, 250,function()
		{
			$(this).css({
				'display':'none'
			})
		})
		$(this).stop().animate({'opacity':1}, 250)
	});
	$('.imgMini').on('mouseover',function() {
		var esto = $(this);
		if ($('.imgMini').length > 1) {
			$('.imgPrincSelf').stop().animate({
				
				'opacity':0.5},
				150, function() {
					var imgHover = esto.attr('src');
					console.log(imgHover)
					$('.imgPrincSelf').attr('src',imgHover);

					$('.imgPrincSelf').stop().animate({
						
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
	});
	
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
			//url: '/guacamaya/public/'+to,
			//trabajo
			url: '/prueba/guacamaya/public/'+to,
			//serv
			//url:'/'+to,
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
				$('#'+response.id+'> .carItem:nth-child(5)').html(response.qty);
				$('#'+response.id+'> .carItem:nth-child(7)').html(response.subtotal);
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
				//url: '/guacamaya/public/'+to,
				//trabajo
				url: '/prueba/guacamaya/public/'+to,
				//serv
				//url:'/'+to,
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
					if($('.carItems').length < 1)
					{
						$('.btn-comprar').removeClass('btn-comprar').addClass('btn-no');
					}
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
				//url: '/guacamaya/public/vaciar-carrito',
				//trabajo
				url: '/prueba/guacamaya/public/vaciar-carrito',
				//serv
				//url:'/'+to,
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
		$(this).unbind('click');

		$('.btnAdd')
			var id		= $(this).val();
			var name  	= $(this).attr('data-name-value');
			var price 	= $(this).attr('data-price-value');

		jQuery(document).ready(function($) {
		$('.chooseModal').change(function(event) {
			var id = $(this).val();
			var item_id = $('.values').val();
			if (id == "" || $('.colorModal').val() == "") {
				$('.btnAddCart').addClass('disabled')
			}else
			{
				$('.disabled').removeClass('disabled');
			}
			if (id == "") {
				$('.removable').remove();
				$('.colores').append('<option class="removable">Elija una talla</option>')
			}else
			{
				$.ajax({
					url: 'buscar/colores',
					type: 'POST',
					dataType: 'json',
					data: {'id': id,'item_id':item_id},
					beforeSend:function(){
						$('.chooseModal').after('<img src="../images/loading.gif" class="loading">');
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
						if (response != "undefined" && response.length > 0) {
							$('.removable').remove();
							for(var i = 0;i<response.length;i++)
							{
								$('.colorModal').append('<option class="removable" value="'+response[i].id+'">'+response[i].color_desc+' - '+response[i].item_stock+'</option>')
							}	
						};

					}
				})		
			}
		});
		$('.colorModal').change(function(event) {
			if ($(this).val() == "" || $('.chooseModal').val() == "") {
				$('.btnAddCart').addClass('disabled')
			}else
			{
				$('.disabled').removeClass('disabled');
			}
		});
		$('.btnAddCart').click(function(event) {
			if ($('.colorModal').val() == "" || $('.chooseModal').val() == "") {
				alert('Debes elegir la talla y el color.')
			}else
			{
				var talla = $('.chooseModal').val();
				var color = $('.colorModal').val();
				dataPost = 
				{
					'id'		: id,
					'name'  	: name,
					'price' 	: price,
					'talla'		: talla,
					'color'		: color
				}
				$.ajax({
					url: 'agregar-al-carrito',
					type: 'POST',
					dataType: 'json',
					data: dataPost,
					beforeSend:function()
					{
						$('.btnAddCart').addClass('disabled');
						$('.btnAddCart').before('<img src="../images/loading.gif" class="loading">');
						$('.loading').css({
								'display': 'inline-block'
							}).animate({
								'opacity': 1},
								500);
					},
					success:function(response)
					{
						
						$('.carritoAgregado').popover('show');
						$('.carritoAgregado').click(function(){
							$('.popover').remove();
						})
						$('.btnAddCart').removeClass('disabled');
						$('.loading').animate({
								'opacity': 0},
								500,function(){
									$(this).remove();
								});
						$('.catnArt').html(response.cantArt);
						$('.total').html(response.total);
						if($('.btn-no').length > 0)
						{
							$('.btn-no').addClass('btn-comprar').removeClass('btn-no');
						}
						if($('#'+response.rowid).length<1)
						{
							var row = '<tr class="carItems" id="'+response.rowid+'">';
			                  row = row+'<td class="carItem" id="'+response.id+'">';
			                    //casa
			                    //row = row+'<img src="/guacamaya/public/images/items/'+response.img+'" class="carImg">';
			                    //trabajo
			                  	row = row+'<img src="/prueba/guacamaya/public/images/items/'+response.img+'" class="carImg">';
			                  	//serv
								//row = row+'<img src="/images/items/'+response.img+'" class="carImg">';
			                  row = row+'</td>';
			                  row = row+'<td class="carItem">';
			                    row = row+response.name;
			                  row = row+'</td>';
			                   row = row+'<td class="carItem">';
			                    row = row+response.talla;
			                  row = row+'</td>';
			                   row = row+'<td class="carItem">';
			                    row = row+response.color;
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
							$('#'+response.id+'> .carItem:nth-child(5)').html(response.qty);
							$('#'+response.id+'> .carItem:nth-child(7)').html(response.subtotal);
							
						}
						window.location.reload();
					}
				})
			}
		});
	});
		
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
					//url: '/guacamaya/public/quitar-item',
					//trabajo
					url: '/prueba/guacamaya/public/quitar-item',
					//serv
					//url:'/'+to,
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
					//url: '/guacamaya/public/actualizar-al-carrito',
					//trabajo
					url: '/prueba/guacamaya/public/actualizar-al-carrito',
					//serv
					//url:'/'+to,
					type: 'POST',
					dataType: 'json',
					data: {
						'id' :boton.val(),
						'qty':inp.val(),
						'talla':boton.attr('data-talla'),
						'color':boton.attr('data-color'),
						'item_id':boton.attr('data-id') },
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
						if (response.type == "success") {
							$('#'+response.id+'> .carItem:nth-child(5)').html(response.qty);
							$('#'+response.id+'> .carItem:nth-child(7)').html(response.subtotal);
							$(boton.attr('data-field-value')+'_subtotal').html(response.subtotal);
							$('.catnArt').html(response.count)
							$('.total').html(response.total)				

						}else{
							alert('No hay inventario suficiente para abarcar esta solicitud');
						}
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
			setTimeout(function(){
				$('.error').animate({
					'opacity':0},
					500);
			},5000)
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

jQuery(document).ready(function($) {
	$('.refresh').click(function(event) {
		var id = $(this).val(),status = $(this).data('status');
		var boton = $(this);
		$.ajax({
			url: 'editar-slides/actualizar',
			type: 'POST',
			dataType: 'json',
			data: {'id': id,'status':status},
			beforeSend:function () {
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
			},success:function(response) {
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
				if (boton.hasClass('active')) {
					boton.removeClass('active')
					boton.html('Activar')
				}else
				{
					boton.addClass('active')
					boton.html('Desactivar')
				}
				
				$('.responseDanger').removeClass('alert-danger');
					$('.responseDanger').removeClass('alert-success');
					$('.responseDanger').stop().css({'display':'block'}).addClass('alert-'+response.type).html('<p class="textoPromedio">'+response.msg+'</p>').animate({
						'opacity': 1},
						500);
				setTimeout(function(){ 
					$('.responseDanger').animate({
						'opacity':0},
						400, function() {
						$(this).css({
							
							'display':'none'
						});
					});
				}, 3000);
			}
		})
		
	});
	$('.deleteSlide').click(function(event) {
		$('.envElim').removeClass('disabled');
		var id = $(this).val();
		var fila = $(this);
		$('.envElim').val(id);
		$('.envElim').click(function(event) {
			var boton = $(this);
			$.ajax({
				url: 'editar-slides/eliminar',
				type: 'POST',
				dataType: 'json',
				data: {'id': id},
				beforeSend:function() {
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
				},success:function() {
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
					fila.parent().parent().remove();
					$('.responseDanger').removeClass('alert-danger');
						$('.responseDanger').removeClass('alert-success');
						$('.responseDanger').stop().css({'display':'block'}).addClass('alert-'+response.type).html('<p class="textoPromedio">'+response.msg+'</p>').animate({
							'opacity': 1},
							500);
					$('#elimModal').modal('hide')
					$('.envElim').addClass('disabled')
					setTimeout(function(){ 
						$('.responseDanger').animate({
							'opacity':0},
							400, function() {
							$(this).css({
								
								'display':'none'
							});
						});
					}, 3000);
				}
			})
			
		});
	});
	$('#formSlides').submit(function(event) {
		return false;
	});
});
jQuery(document).ready(function($) {
	$('.btnElimItem').click(function(event) {
		var boton = $(this);
		$('.responseDanger').removeClass('alert-danger');
		$('.responseDanger').removeClass('alert-success');
		$('.responseDanger').css({
			'display': 'none',
			'opacity': 0
		});
		
		$('.envElim').val($(this).val());
		$('.envElim').click(function(event) {
			$.ajax({
				url: 'ver-articulo/eliminar',
				type: 'POST',
				dataType: 'json',
				data: {'id': $(this).val()},
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
	$('.slick-prev').html('<i class="fa fa-caret-left"></i>');
	$('.slick-next').html('<i class="fa fa-caret-left"></i>');
});

jQuery(document).ready(function($) {
	/*-------------------------------------------registro de usuario-------------------------------------------*/
	var estado = $('#estado2');
	estado.change(function(event) {
		if ($(this).val() != "") {
			var id = estado.val();
			$.ajax({
				url: '../registro/buscar-municipio',
				type: 'POST',
				data: {'id': id},
				success:function(response)
				{
					$('.optionModel').remove();
					for (var i = 0 ; i < response.length; i++) {
						$('#municipio2').append('<option class="optionModel" value="'+response[i].id+'">'+response[i].nombre+'</option>');
					};

					var mun = $('#municipio2');
					mun.change(function(event) {
						var id = $(this).val();
						$.ajax({
							url: '../registro/buscar-parroquia',
							type: 'POST',
							data: {'id': id},
							success:function(response)
							{
								$('.optionModelParr').remove();
								for (var i = 0 ; i < response.length; i++) {
									$('#parroquia2').append('<option class="optionModelParr" value="'+response[i].id+'">'+response[i].nombre+'</option>');
								};
							
							}
						})
					});
				}
			})

			
		}
	});
});
jQuery(document).ready(function($) {
	$('.upload').click(function(event) {
		var boton = $(this).parent();
		boton.css({'display':'none'});
		$(this).parent().after('<button class="btn btn-success btn-work" style="margin-right:1em;">Enviar</button><input type="reset" class="btn-work btn btn-warning btn-cancel" value="Cancelar">')
		$('.btn-cancel').click(function(event) {
			$('.btn-work').remove();
			boton.css({'display':'inline-block'});	
		});
	});
	var cat = $('.catx');
	cat.change(function(event) {
		var id = $(this).val();
		$.ajax({
			url: '../categoria/buscar-sub-categoria',
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
	$('.aprov-fac').click(function(event) {
		var boton = $(this);
		
		$.ajax({
			//casa
			url: 'ver-pagos/aprovar',
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
					$('.responseDanger').removeClass('alert-danger');
					$('.responseDanger').removeClass('alert-success');
					$('.responseDanger').stop().css({'display':'block'}).addClass('alert-'+response.type).html('<p class="textoPromedio">'+response.msg+'</p>').animate({
						'opacity': 1},
						500);
					if (response.type == 'success') {
						boton.parent().parent().remove();
						
					};
			}
		})
	});
	$('.reject-fac').click(function(event) {
		var boton = $(this);
		$('.responseDanger').removeClass('alert-danger');
		$('.responseDanger').removeClass('alert-success');
		$('.responseDanger').css({
			'display': 'none',
			'opacity': 0
		});
		$('.envReject').val(boton.val());
		$('.envReject').click(function(event) {
			var boton2 = $(this);
			var motivo = $('#motivo').val();
			$.ajax({
				url: 'ver-pagos/rechazar',
				type: 'POST',
				dataType: 'json',
				data: {'id': $(this).val(),'motivo': motivo},
				beforeSend:function()
				{
					boton2.before('<img src="../images/loading.gif" class="loading">');
					$('.loading').css({
						'display': 'block',
						'margin': '2em auto'
					}).animate({
						'opacity': 1},
						500);
					boton2.addClass('disabled');
				},
				success:function(response)
				{
					boton2.removeClass('disabled');
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
$('.elim-fac').click(function(event) {
		var boton = $(this);
		$('.responseDanger').removeClass('alert-danger');
		$('.responseDanger').removeClass('alert-success');
		$('.responseDanger').css({
			'display': 'none',
			'opacity': 0
		});
		$('.envElim').val(boton.val());
		$('.envElim').click(function(event) {
			var boton2 = $(this);
			var motivo = $('#motivoElim').val();
			$.ajax({
				url: 'ver-pagos/eliminar',
				type: 'POST',
				dataType: 'json',
				data: {'id': $(this).val(),'motivo': motivo},
				beforeSend:function()
				{
					boton2.before('<img src="../images/loading.gif" class="loading">');
					$('.loading').css({
						'display': 'block',
						'margin': '2em auto'
					}).animate({
						'opacity': 1},
						500);
					boton2.addClass('disabled');
				},
				success:function(response)
				{
					boton2.removeClass('disabled');
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

$(document).ready(function() {
    var activeSystemClass = $('.list-group-item.active');

    //something is entered in search form
    $('#buscar-usuario').keyup( function() {
       var that = $(this);
        // affect all table rows on in systems table
        var tableBody = $('.table-list-search tbody');
        var tableRowsClass = $('.table-list-search tbody tr');
        $('.search-sf').remove();
        tableRowsClass.each( function(i, val) {
        
            //Lower text for case insensitive
            var rowText = $(val).text().toLowerCase();
            var inputText = that.val().toLowerCase();
            if(inputText != '')
            {
                $('.search-query-sf').remove();
                tableBody.prepend('<tr class="search-query-sf"><td colspan="100"><strong>Buscando por: "'
                    + that.val()
                    + '"</strong></td></tr>');
            }
            else
            {
                $('.search-query-sf').remove();
            }

            if( rowText.indexOf( inputText ) == -1 )
            {
                //hide rows
                tableRowsClass.eq(i).hide();
                
            }
            else
            {
                $('.search-sf').remove();
                tableRowsClass.eq(i).show();
            }
        });
        //all tr elements are hidden
        if(tableRowsClass.children(':visible').length == 0)
        {
            tableBody.append('<tr class="search-sf"><td class="text-muted" colspan="100">No se encontraron resultados.</td></tr>');
        }
    });
});

jQuery(document).ready(function($) {
	$('.ver').click(function(event) {
		var id = $(this).val();
		var username = $('.username-'+id).val();
		var name = $('.name-'+id).val();
		var email = $('.email-'+id).val();
		var phone = $('.phone-'+id).val();
		var dir = $('.dir-'+id).val();
		var pagWeb = $('.est-'+id).val();
		var carnet = $('.mun-'+id).val();
		var nit = $('.par-'+id).val();
		$('.usernameModal').html(username);
		$('.nameModal').html(name);
		$('.emailModal').html(email);
		$('.dirModal').html(dir);
		$('.phoneModal').html(phone);
		$('.pagWebModal').html(pagWeb);
		$('.carnetModal').html(carnet);
		$('.nitModal').html(nit);
	});
});
jQuery(document).ready(function($) {
	$('.btn-elim-img').click(function(event) {
		var boton = $(this);
		var id = $(this).val();
		var x = confirm('¿Seguro desea eliminar la imagen? Esta acción es irreversible');
		if (x) {
			$.ajax({
				url: 'eliminar-imagen',
				type: 'POST',
				dataType: 'json',
				data: {'id': id},
				beforeSend:function()
				{
					boton.before('<img src="../images/loading.gif" class="loading">');
					$('.loading').css({
						'display': 'block',
						'margin': '2em auto'
					}).animate({
						'opacity': 1},
						500,function(){
							boton.css({
								'display':'none'
							});
						});
				},
				success:function(response)
				{
					$('.loading').animate({
						'opacity': 0},
						500,function(){
							boton.css({
								'display':'block'
							});
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
					setTimeout(function(){

						$('.responseDanger').removeClass('success')
						$('.responseDanger').removeClass('danger')
						$('.responseDanger').stop().animate({
							'opacity':0},
							500, function() {
							$(this).css({
								'display':'none'
							});
						});
					},6000);
				}
			})		
		};
	});
});
jQuery(document).ready(function($) {
	$('#continuar').on('shown.bs.collapse',function(){
		var pos = $('.continuar').position();
		$(window).scrollTop(pos.top)
	})
});
jQuery(document).ready(function($) {
	$('.btnElimBank').click(function(event) {
		var id = $(this).val();
		var boton = $(this);
		var x = confirm('¿Seguro desea eliminar el banco? Esta acción es irreversible');
		if (x) {
			$.ajax({
				url: 'editar-bancos/eliminar',
				type: 'POST',
				dataType: 'json',
				data: {'id': id},
				beforeSend:function()
				{
					boton.before('<img src="../images/loading.gif" class="loading">');
					$('.loading').css({
						'display': 'block',
						'margin': '2em auto'
					}).animate({
						'opacity': 1},
						500,function(){
							boton.css({
								'display':'none'
							});
						});
				},
				success:function(response)
				{
					$('.loading').animate({
						'opacity': 0},
						500,function(){
							boton.css({
								'display':'block'
							});
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
					setTimeout(function(){

						$('.responseDanger').removeClass('success')
						$('.responseDanger').removeClass('danger')
						$('.responseDanger').stop().animate({
							'opacity':0},
							500, function() {
							$(this).css({
								'display':'none'
							});
						});
					},6000);
				}
			})		
		};
	});
});
jQuery(document).ready(function($) {
	$('.dirShow').click(function(event) {
		$('.dirBody').html($(this).html());
	});
});
jQuery(document).ready(function($) {
	$('.btn-deactive').click(function(event) {
		var id = $(this).val(),prom = $('.promValue').val(),val,boton = $(this);
		if ($(this).hasClass('active')) {
			val = 0;
		}else
		{
			val = prom;
		}
		$.ajax({
			url: 'enviar',
			type: 'POST',
			dataType: 'json',
			data: {'id': id,'val':val},
			beforeSend:function () {
				boton.after('<img src="../../../images/loading.gif" class="loading">');
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
			},success:function(response) {
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
				if (boton.hasClass('active')) {
					boton.removeClass('active')
					boton.html('Activar')
				}else
				{
					boton.addClass('active')
					boton.html('Desactivar')
				}
				
				$('.responseDanger').removeClass('alert-danger');
					$('.responseDanger').removeClass('alert-success');
					$('.responseDanger').stop().css({'display':'block'}).addClass('alert-'+response.type).html('<p class="textoPromedio">'+response.msg+'</p>').animate({
						'opacity': 1},
						500);
				setTimeout(function(){ 
					$('.responseDanger').animate({
						'opacity':0},
						400, function() {
						$(this).css({
							
							'display':'none'
						});
					});
				}, 3000);
			}
		})
	});
});
/*Plugin*/
jQuery(document).ready(function($){
	var visionTrigger = $('.cd-3d-trigger'),
		galleryItems = $('.no-touch #cd-gallery-items').children('li'),
		galleryNavigation = $('.cd-item-navigation a');

	//on mobile - start/end 3d vision clicking on the 3d-vision-trigger
	visionTrigger.on('click', function(){
		$this = $(this);
		if( $this.parent('li').hasClass('active') ) {
			$this.parent('li').removeClass('active');
			hideNavigation($this.parent('li').find('.cd-item-navigation'));
		} else {
			$this.parent('li').addClass('active');
			updateNavigation($this.parent('li').find('.cd-item-navigation'), $this.parent('li').find('.cd-item-wrapper'));
		}
	});

	//on desktop - update navigation visibility when hovering over the gallery images
	galleryItems.hover(
		//when mouse enters the element, show slider navigation
		function(){
			$this = $(this).children('.cd-item-wrapper');
			updateNavigation($this.siblings('nav').find('.cd-item-navigation').eq(0), $this);
		},
		//when mouse leaves the element, hide slider navigation
		function(){
			$this = $(this).children('.cd-item-wrapper');
			hideNavigation($this.siblings('nav').find('.cd-item-navigation').eq(0));
		}
	);

	//change image in the slider
	galleryNavigation.on('click', function(){
		var navigationAnchor = $(this);
			direction = navigationAnchor.text(),
			activeContainer = navigationAnchor.parents('nav').eq(0).siblings('.cd-item-wrapper');
		
		( direction=="Next") ? showNextSlide(activeContainer) : showPreviousSlide(activeContainer);
		updateNavigation(navigationAnchor.parents('.cd-item-navigation').eq(0), activeContainer);
	});
});

function showNextSlide(container) {
	var itemToHide = container.find('.cd-item-front'),
		itemToShow = container.find('.cd-item-middle'),
		itemMiddle = container.find('.cd-item-back'),
		itemToBack = container.find('.cd-item-out').eq(0);

	itemToHide.addClass('move-right').removeClass('cd-item-front').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
		itemToHide.addClass('hidden');
	});
	itemToShow.addClass('cd-item-front').removeClass('cd-item-middle');
	itemMiddle.addClass('cd-item-middle').removeClass('cd-item-back');
	itemToBack.addClass('cd-item-back').removeClass('cd-item-out');
}

function showPreviousSlide(container) {
	var itemToMiddle = container.find('.cd-item-front'),
		itemToBack = container.find('.cd-item-middle'),
		itemToShow = container.find('.move-right').slice(-1),
		itemToOut = container.find('.cd-item-back');

	itemToShow.removeClass('hidden').addClass('cd-item-front');
	itemToMiddle.removeClass('cd-item-front').addClass('cd-item-middle');
	itemToBack.removeClass('cd-item-middle').addClass('cd-item-back');
	itemToOut.removeClass('cd-item-back').addClass('cd-item-out');

	//wait until itemToShow does'n have the 'hidden' class, then remove the move-right class 
	//in this way, transition works also in the way back
	var stop = setInterval(checkClass, 100);
	
	function checkClass(){
		if( !itemToShow.hasClass('hidden') ) {
			itemToShow.removeClass('move-right');
			window.clearInterval(stop);
		}
	}
}

function updateNavigation(navigation, container) {
	var isNextActive = ( container.find('.cd-item-middle').length > 0 ) ? true : false,
		isPrevActive = 	( container.children('li').eq(0).hasClass('cd-item-front') ) ? false : true;
	(isNextActive) ? navigation.find('a').eq(1).addClass('visible') : navigation.find('a').eq(1).removeClass('visible');
	(isPrevActive) ? navigation.find('a').eq(0).addClass('visible') : navigation.find('a').eq(0).removeClass('visible');
}

function hideNavigation(navigation) {
	navigation.find('a').removeClass('visible');
}
