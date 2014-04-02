<link type="text/css" href="./css/ui-lightness/jquery-ui-1.8.22.custom.css" rel="Stylesheet" />
<link type="text/css" href="./css/mbTooltip.css" rel="Stylesheet" />

<script src="./js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="./js/jquery-ui-1.8.22.custom.min.js"></script>
<script src="./js/jquery.ui.datepicker-pt-BR.js"></script>
<!-- 
<script src="js/mbTooltip.js" type="text/javascript"></script>
<script src="js/jquery.dropshadow.js" type="text/javascript"></script>
<script src="js/jquery.timers.js" type="text/javascript"></script>
 -->
<script type="text/JavaScript">
<?php if($print) { ?>
jQuery(document).ready(function() {
	window.print();
});
<?php } ?>

jQuery(document).ready(function() {
	$('.unbind_unload').click(function() {
		$(window).unbind('beforeunload');
	});
	
	recalculate();
	$('.editavel').hide();
	
	$('.gimefocus').focus();

	$("input[type=checkbox]").change(function(){
		recalculate();
	});
	var id_uso_change = 0;

	$('#id_uso').change(function() {
		id_uso_change = 1;
	});

	$('.cromo_submit').click(function () {
		if(id_uso_change == 0) {
			alert("Selecione uso!");
			return false;
		}
	});

	$('.reuso').click(function() {
		var thisCheck = $(this);
		if(thisCheck.is(':checked')) {
			var id = thisCheck.attr('id').split("_")[1];
			var valAddDesc = $('#valor'+id).attr('value').replace(".","").replace(",",".");
//			alert(valAddDesc);
			valAddDesc = valAddDesc*0.3;
//			alert(valAddDesc);
			var valDesc = $('#desconto'+id).attr('value').replace(".","").replace(",",".");
			valDesc = parseFloat(valDesc) + parseFloat(valAddDesc);
			valDesc = valDesc.toString().replace(".",",");
//			alert(valDesc);
			$('#desconto'+id).attr('value',valDesc);
			var val = $('#desconto'+id).attr('value');
//			alert(val);
			$.ajax("tool_ajax.php?reuso="+thisCheck.attr('value')).done(function (){
				atualiza_valor_cromo();
			});
		}
		else {
			var id = thisCheck.attr('id').split("_")[1];
			var valAddDesc = $('#valor'+id).attr('value').replace(".","").replace(",",".");
//			alert(valAddDesc);
			valAddDesc = valAddDesc*0.3;
//			alert(valAddDesc);
			var valDesc = $('#desconto'+id).attr('value').replace(".","").replace(",",".");
			valDesc = parseFloat(valDesc) - parseFloat(valAddDesc);
			valDesc = valDesc.toString().replace(".",",");
//			alert(valDesc);
			$('#desconto'+id).attr('value',valDesc);
			var val = $('#desconto'+id).attr('value');
//			alert(val);
//			alert("tool_ajax.php?reuso="+thisCheck.attr('value')+"&false=false");
			$.ajax("tool_ajax.php?reuso="+thisCheck.attr('value')+"&false=false").done(function (){
				atualiza_valor_cromo();
			});
//			location.reload();
		}
	});
	
	$("#tipo_contrato").change(function()	{
		var id=$(this).val();
		var dataString = 'action=get_uso&id_contrato='+ id;

		$.ajax({
			type: "POST",
			url: "tool_ajax.php",
			data: dataString,
			cache: false,
			success: function(html) {
				$("#id_uso").html(html);
			} 
		});
	});
	$('.editBtn').click(function (event) {
		$('.fixo').hide();
		$('.editavel').show();
	});
	
	$('.copyBtn').click(function (event) {
		window.location = "consulta_contrato_visualiza.php?copy=true&editaDesCont=sim&editaCromo=sim";
	});
	
	$('.confirm_del').click(function (event) {
		return confirm("Deseja mesmo excluir?");
	});
	
	$('.printBtn').click(function (event) {
		var url = $(location).attr('href');
//		var url = options.url + ( ( options.url.indexOf('?') < 0 && options.data != "" ) ? '?' : '&' ) + options.data;
		url += "&print=true";
//	    alert(url);
	    var thePopup = window.open( url, "Impressão");
	});
	$('#btn_editaCromo').click(function (event) {
		$('#input_editaCromo').val("sim");
		$('#form_send').submit();
	});
	$('#btn_cromoNaoCad').click(function (event) {
		$('#cromo_nao_cadastrado').val("s");
		$('#form_send').unbind('submit');
		document.getElementById("form_send").onsubmit = null;
		$('#form_send').attr('method','post');
		$('#form_send').attr('action','tool_contrato_gravar.php');
		$('#cromo_nao_cadastrado').attr('value','s');
		$('#cromo_nao_cadastrado').val('s');
		$('#form_send').submit();
	});
	$(".calendar").datepicker($.datepicker.regional['br']);
/*
	$(".tooltipme").mbTooltip({ // also $([domElement]).mbTooltip  >>  in this case only children element are involved
		opacity : .85,       //opacity
		wait:10,           //before show
		cssClass:"default",  // default = default
		timePerWord: 1000,      //time to show in milliseconds per word
		hasArrow:false,			// if you whant a little arrow on the corner
		hasShadow:false,
		imgPath:"images/",
		anchor:"mouse", //"parent"  you can anchor the tooltip to the mouse position or at the bottom of the element
		shadowColor:"black", //the color of the shadow
		mb_fade:10 //the time to fade-in
	});
*/
	$('.block_edit').click(function() {
		alert("Tipo de contrato já em uso, não pode ser alterado.");
		return false;
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
//					.button({
//						icons: {
//							primary: "ui-icon-triangle-1-s"
//						},
//						text: false
//					})
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
	
});

function recalculate(){
    var sum = 0;

    $("input[type=checkbox]:checked").each(function(){
      sum += parseFloat($(this).attr("value").replace(".", "").replace(",", "."));
    });
    var sum2 = addDotsComma(sum.toString());
    $('.sum_total').html("R$ "+sum2);
}

function addDotsComma(nStr) {
	nStr = nStr.replace(".",",");
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + '.' + '$2');
    }
    return x1 + x2;
}
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr);
}

function atualizar(tela,valor) {

	var combo = document.form2.tema;
	//alert(combo.options.length);
	combo.options[combo.options.length]=new Option(tela, valor);

}

function atualizar2(tela,valor) {

	var combo = document.form2.descritor;
	//alert(combo.options.length);
	combo.options[combo.options.length]=new Option(tela, valor);

}

function alterarValor(campo,valor) {

	alert(campo + ' - ' + valor);

	var form_campo = document.form2.elements[campo];
	form_campo.value = valor;
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function confirmSubmit()
{
var agree=confirm("Confirma exclusão?");
if (agree)
	document.form2.submit();
else
	return false ;
}
function confirmSubmit2()
{
var agree=confirm("Confirma exclusão do cromo?");
if (agree)
	document.form3.submit();
else
	return false ;
}

function fix_data() {
if (document.form2.data_tela.value.length == 0) {
	document.form2.data.value = document.form2.data_tela.value;
	}
if (document.form2.data_tela.value.length == 4) {
	document.form2.data.value = document.form2.data_tela.value;
	}
if (document.form2.data_tela.value.length == 7) {
	document.form2.data.value = document.form2.data_tela.value.substring(3,7)+document.form2.data_tela.value.substring(0,2);
	}
if (document.form2.data_tela.value.length == 10) {
	document.form2.data.value = document.form2.data_tela.value.substring(6,10)+document.form2.data_tela.value.substring(3,5)+document.form2.data_tela.value.substring(0,2);
	}

}
function fix_data2() {
if (document.form4.data_tela.value.length == 4) {
	document.form4.data.value = document.form4.data_tela.value;
	}
if (document.form4.data_tela.value.length == 7) {
	document.form4.data.value = document.form4.data_tela.value.substring(3,7)+document.form4.data_tela.value.substring(0,2);
	}
if (document.form4.data_tela.value.length == 10) {
	document.form4.data.value = document.form4.data_tela.value.substring(6,10)+document.form4.data_tela.value.substring(3,5)+document.form4.data_tela.value.substring(0,2);
	}

}

function removeMe() {
	var boxLength = document.form2.descritor.length;
	arrSelected = new Array();
	var count = 0;
	for (i = 0; i < boxLength; i++) {
		if (document.form2.descritor.options[i].selected) {
			arrSelected[count] = document.form2.descritor.options[i].value;
		}
		count++;
	}
	var x;
	for (i = 0; i < boxLength; i++) {
		for (x = 0; x < arrSelected.length; x++) {
			if (document.form2.descritor.options[i].value == arrSelected[x]) {
				document.form2.descritor.options[i] = null;
			}
		}
	}
}
function excluir(indice) {

alert(indice);
//	document.form2.descritor.remove(indice);
}

function excluir2(indice) {

	document.form2.tema.remove(indice);

}

function copiarDados() {

	MM_openBrWindow('adm_index_copiar.php?tombo='+document.form2.tombo.value,'','width=380,height=30');

	//alert(document.form2.tombo.value);

}


function txtBoxFormat(objeto, sMask, evtKeyPress) {
	var i, nCount, sValue, fldLen, mskLen,bolMask, sCod, nTecla;

	if(document.all) { // Internet Explorer
		nTecla = evtKeyPress.keyCode;
	} else if(document.layers) { // Nestcape
		nTecla = evtKeyPress.which;
	} else {
		nTecla = evtKeyPress.which;
	}
	if (nTecla == 8) {
    	return true;
	}
}



function grava() {

	multi_select = document.form2.tema;
	todos_t = "";
	if(multi_select.length == 0) {
		alert("Favor selecionar ao menos um tema para imagem");
	}
	todos_t += multi_select.options[0].value;
	for(x=1;x<multi_select.length;x++){

	  todos_t += ",";
	  todos_t += multi_select.options[x].value;

	}

	document.form2.todos_temas.value = todos_t;

//	multi_select = document.form2.descritor;
//	todos_d = "";
//	todos_d += multi_select.options[0].value;
//	for(x=1;x<multi_select.length;x++){

//	  todos_d += ",";
//	  todos_d += multi_select.options[x].value;

//	}

//	document.form2.todos_descritores.value = todos_d;

	document.form2.submit();

}
</script>