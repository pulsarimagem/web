<link type="text/css" href="./css/ui-lightness/jquery-ui-1.8.22.custom.css" rel="Stylesheet" />
<link type="text/css" href="./css/mbTooltip.css" rel="Stylesheet" />

<script src="./js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="./js/jquery-ui-1.8.22.custom.min.js"></script>
<script src="./js/jquery.ui.datepicker-pt-BR.js"></script>
	
<script>
jQuery(document).ready(function() {
	$("#contato").change(function()	{
		var id=$(this).val();
		var dataString = 'action=set_id_contato_sig&id_contato_sig='+id+'&id_cadastro=<?php echo isset($colname_arquivos)?$colname_arquivos:""?>';
		$.ajax({
			type: "POST",
			url: "tool_ajax.php",
			data: dataString,
			cache: false,
			success: function(html) {
			} 
		});
		$('.id_contato_sig').val(id);
	});
	
	$('#btn_change').click(function() {
		var dataString = 'action=clean_id_cliente_sig&id_cadastro=<?php echo isset($colname_arquivos)?$colname_arquivos:""?>';
		$.ajax({
			type: "POST",
			url: "tool_ajax.php",
			data: dataString,
			cache: false,
			success: function(html) {
//				alert(html);
				location.reload();
//				$(".tamanho").html(html);
			} 
		});
	});
});

	(function( $ ) {
		$.widget( "ui.combobox", {
			_create: function() {
				var input,
					self = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "",
					wrapper = this.wrapper = $( "<span>" )
						.addClass( "ui-combobox" )
						.insertAfter( select );

				input = $( "<input>" )
					.appendTo( wrapper )
					.val( value )
					.addClass( "ui-state-default ui-combobox-input" )
					.autocomplete({
						delay: 0,
						minLength: 2,
						source: function( request, response ) {
							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( select.children( "option" ).map(function() {
								var text = $( this ).text();
								var value = $( this ).val();
								if ( this.value && ( !request.term || matcher.test(text) ) )
									return {
										label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<strong>$1</strong>" ),
										value: text,
										id: value,
										option: this
									};
							}) );
						},
						select: function( event, ui ) {
							ui.item.option.selected = true;
							self._trigger( "selected", event, {
								item: ui.item.option
							});
							$(".id_cliente_sig").val(ui.item.id);

							var dataString = 'action=set_id_cliente_sig&id_cliente_sig='+ ui.item.id + '&id_cadastro=<?php echo isset($colname_arquivos)?$colname_arquivos:""?>';
							$.ajax({
								type: "POST",
								url: "tool_ajax.php",
								data: dataString,
								cache: false,
								success: function(html) {
//									alert(html);
//									$(".tamanho").html(html);
								} 
							});

							var dataString = 'action=contato&id_cliente='+ ui.item.id;
							$.ajax({
								type: "POST",
								url: "tool_ajax.php",
								data: dataString,
								cache: false,
								success: function(html) {
									$("#contato").html(html); // FINALIZAR!!!
								} 
							});
												
						},
						change: function( event, ui ) {
							if ( !ui.item ) {
								var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
									valid = false;
								select.children( "option" ).each(function() {
									if ( $( this ).text().match( matcher ) ) {
										this.selected = valid = true;
										return false;
									}
								});
								if ( !valid ) {
									// remove invalid value, as it didn't match anything
									$( this ).val( "" );
									select.val( "" );
									input.data( "autocomplete" ).term = "";
									return false;
								}
							}
						}
					})
					.addClass( "ui-widget ui-widget-content ui-corner-left" );

				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li></li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "</a>" )
						.appendTo( ul );
				};

				$( "<a>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Show All Items" )
					.appendTo( wrapper )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "ui-corner-right ui-combobox-toggle" )
					.click(function() {
						// close if already visible
						if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
							input.autocomplete( "close" );
							return;
						}

						// work around a bug (likely same cause as #5265)
						$( this ).blur();

						// pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
						input.focus();
					});
			},

			destroy: function() {
				this.wrapper.remove();
				this.element.show();
				$.Widget.prototype.destroy.call( this );
			}
		});
	})( jQuery );

	$(function() {
		$( "#combobox" ).combobox();
		$( "#toggle" ).click(function() {
			$( "#combobox" ).toggle();
		});
	});
	</script>