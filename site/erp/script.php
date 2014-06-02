<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="../video/jwplayer.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>

<?php echo isset($addScript)?$addScript:"";?>
<script type="text/javascript">
<?php if($print) { ?>
jQuery(document).ready(function() {
	window.print();
});
<?php } ?>
jQuery(document).ready(function() {
<?php if(isset($mens)&&$mens!="") { ?>
	alert('<?php echo $mens?>');
<?php } ?>
	$("#assunto_principal").after("<span class='contador'>100</span>");
	$("#assunto_principal").keyup(function (){
	    var len = this.value.length;
	    if (len >= 100) {
	      val.value = val.value.substring(0, 100);
	    } else {
	      $('.contador').text(100 - len);
	    }
	});

	$('.unbind_unload').click(function() {
		$(window).unbind('beforeunload');
	});

	$('.cadastrarCromo').click(function (){
		$('.formInserirCromos').hide();
		$('.formCadastrarCromos').show();
		$('#id_uso').attr('name','id_uso3');
		$('#id_uso_cadastro').attr('name','id_uso');
	});
	$('.submitOnclick').click(function (){
		$('.formOnclick').submit();
	});
	$('.confirmOnclick').click(function (){
		return confirm("Confirma exclusão?");
	});
	
	$('#btnFtpCopy').click(function () {
		$('#ftpCopy').toggle();
	});
	$('#btnFtpVideo').click(function () {
		$('#ftpVideo').toggle();
	});
	$('#btnFtpEmail').click(function () {
		$('#ftpEmail').toggle();
	});
	$('#btnFtpDelall').click(function () {
		return confirm("Deseja apagar todas?");
	});
	
	$('.showNovo').click(function () {
		$('.novo').toggle();
	});
	
	$('.showNovoContrato').click(function () {
		$('.novoContrato').show();
	});
	$('.showBaixaLote').click(function () {
		$('.showBaixaLote').hide();
		$('.baixaLote').show();
	});
	$('.checkBaixa').change(function () {
		recalculateId();
	});

	$(".checkAllBaixa").click(function() {
		var checkedStatus = this.checked;
		var checkbox = $(this).parents('table').find('tr td:first-child input:checkbox');		
		checkbox.each(function() {
			this.checked = checkedStatus;
			if (checkedStatus == this.checked) {
				$(this).closest('.checker > span').removeClass('checked');
			}
			if (this.checked) {
				$(this).closest('.checker > span').addClass('checked');
			}
		});
		recalculateId();
	});	
	
	$('.baixaBtn').click(function () {
		$('.baixaShow').hide();
		$('.baixaHide').show();
	});
	
	$('.printBtn').click(function (event) {
		var url = $(location).attr('href');
//		var url = options.url + ( ( options.url.indexOf('?') < 0 && options.data != "" ) ? '?' : '&' ) + options.data;
		url += "&print=true";
//	    alert(url);
	    var thePopup = window.open( url, "Impressão");
	});
	
	$('.novoIndioBtn').click(function () {
		$('.novoIndio').toggle();
	});

	CKEDITOR.replace( 'FCKeditor1', {
		allowedContent: true
	});
		

	$('#indexSelectAutorFotos').change(function (){
		var id=$(this).val();
		var dataString = 'action=getAutorFotos&id_autor='+id;
		$.ajax({
			type: "POST",
			url: "tool_ajax.php",
			data: dataString,
			cache: false,
			success: function(html) {
				$('#indexSelectFotos').html(html);
				$('.indexSelectFotos').show();
			} 
		});
	});

	$('#indexSelectAutorVideos').change(function (){
		var id=$(this).val();
		var dataString = 'action=getAutorVideos&id_autor='+id;
		$.ajax({
			type: "POST",
			url: "tool_ajax.php",
			data: dataString,
			cache: false,
			success: function(html) {
				$('#indexSelectVideos').html(html);
				$('.indexSelectVideos').show();
			} 
		});
	});
	
	
	$("#indexDesc2").select2({
		multiple: true,
		placeholder: '-- Escolha os Descritores --',
		minimumInputLength: 3,
		ajax: {
	        multiple: true,
	        url: "tool_ajax_desc2.php",
	        dataType: "json",
	        data: function(term, page) {
	            return {
	                term: term
	            };
	        },
	        results: function(data, page) {
		        console.log(data);
	            return { results: data.results };
	        }
	    },
        initSelection: function (element, callback) {
	        var ret = [];
	        $(element.val().split(",")).each(function () {
	        	$.getJSON("tool_ajax_desc2.php?id=" + this, null, function(data) {
    	            ret.push({id: data[0].id, text: data[0].text});
    	            callback(ret);
		        });
	        });
	        callback(ret);
        }
	});
	$("#indexDesc").select2({
		multiple: true,
		placeholder: '-- Escolha os Descritores --',
		minimumInputLength: 3,
//         data: [{id:0,text:'enhancement'},{id:1,text:'bug'},{id:2,text:'duplicate'},{id:3,text:'invalid'},{id:4,text:'wontfix'}],
//         tags: [0, 'duplicate', {id:3,text:'invalid'}],
		ajax: {
	        multiple: true,
	        url: "tool_ajax_desc2.php",
	        dataType: "json",
	        data: function(term, page) {
	            return {
	                term: term
	            };
	        },
	        results: function(data, page) {
		        console.log(data);
	            return { results: data.results };
	        }
	    },
//  	    createSearchChoice: function(term) {
// 	        return {
// 	            id: term,
// 	            text: term + ' (new)'
// 	        };
// 	    },
        createSearchChoice:function(term, data) {
            if ($(data).filter(function() {
                return term === 0;
            }).length === 0) {
                return {id:term, text: term, isNew: true};
            }
        },
        formatResult: function(term) {
            if (term.isNew) {
                return '<span class="label label-important">Nova</span> ' + term.text;
            }
            else {
                return term.text;
            }
        },
        initSelection: function (element, callback) {
//             var ids = element.val();
//             var ids_arr = ids.split(',');
//             var ret = [];
//             $.each(ids_arr, function(key, id) {
//                 alert(id);
//     	        $.getJSON("tool_ajax_desc.php?id=" + id, null, function(data) {
//         	        console.log(data);
//         	        alert(data.id);
//         	        alert(data.text);
        	        
//     	        	ret.push({id: data.id, text: data.text});
// 		        });
//             });
//             return callback(ret);
// 	        var data = [];
// 	        $(element.val().split(",")).each(function () {
// 		        pc = this.split('|');
// 	            data.push({id: pc[0], text: pc[1]});
// 	        });
// 	        callback(data);
	        var ret = [];
	        $(element.val().split(",")).each(function () {
	        	$.getJSON("tool_ajax_desc2.php?id=" + this, null, function(data) {
    	            ret.push({id: data[0].id, text: data[0].text});
    	            callback(ret);
		        });
	        });
	        callback(ret);
//             $(categories).each(function () {
//                 if (this.id == element.val()) {
//                     callback(this);
//                     return;
//                 }
//             });
        }
	});	
	$(".indexDesc").select2({
		multiple: true,
		placeholder: '-- Não mudar --',
		minimumInputLength: 3,
		ajax: {
	        multiple: true,
	        url: "tool_ajax_desc.php",
	        dataType: "json",
	        data: function(term, page) {
	            return {
	                term: term
	            };
	        },
	        results: function(data, page) {
		        console.log(data);
	            return { results: data.results };
	        }
	    },
        initSelection: function (element, callback) {
	        var ret = [];
	        $(element.val().split(",")).each(function () {
	        	$.getJSON("tool_ajax_desc.php?id=" + this, null, function(data) {
    	            ret.push({id: data[0].id, text: data[0].text});
    	            callback(ret);
		        });
	        });
	        callback(ret);
        }
	});
	
	$("#indexCidade").select2({
		multiple: false,
		placeholder: '-- Escolha cidade --',
		minimumInputLength: 3,
		ajax: {
	        multiple: true,
	        url: "tool_ajax_cidade.php",
	        dataType: "json",
	        data: function(term, page) {
	            return {
	                term: term
	            };
	        },
	        results: function(data, page) {
		        console.log(data);
	            return { results: data.results };
	        }
	    },
        createSearchChoice:function(term, data) {
            if ($(data).filter(function() {
                return term === 0;
            }).length === 0) {
                return {id:term, text: term, isNew: true};
            }
        },
        formatResult: function(term) {
            if (term.isNew) {
                return '<span class="label label-important">Nova</span> ' + term.text;
            }
            else {
                return term.text;
            }
        },
        initSelection: function (element, callback) {
	        var ret;
// 	       	$.getJSON("tool_ajax_cidade.php?id=" + element.val(), null, function(data) {
//                 ret.push({id: data[0].id, text: data[0].text});
//                 callback(ret);
// 	        });
// 			ret.push({id: 0, text: element.val()});
			ret = {id: element.val(), text: element.val()};
			callback(ret);
        }
	});
	
	$(".bt-zoom").hover(
			function () {
				$(this).children("div.mzoom").show();
				var $img = $(this).find("img");
				if($img.attr('class') == 'on-demand') {
					$img.attr('src',$img.attr('longdesc')).removeClass('on-demand');
				}
				var $jwp = $(this).children("div.mzoom").children("div");
				var $jwp_id = $jwp.attr('id').split('_')[0];
				jwplayer($jwp_id).play(true);
			},
			function () {
				$(this).children("div.mzoom").hide();
				var $jwp = $(this).children("div.mzoom").children("div");
				var $jwp_id = $jwp.attr('id').split('_')[0];
				jwplayer($jwp_id).stop(true);
			}
	);
    $('.edicao_aprovar').click(function(){
    	$.get(this.href);
   // 	$(this).css("color", "#bc690f"); 
//    	alert('Video aprovado. Aperte Finalizar quando terminar.');
		$(this).parent().parent().parent().parent().parent().parent().children('a').addClass("approved");
		$(this).parent().parent().parent().parent().parent().parent().children('a').removeClass("rejected");
    });
    $('.edicao_recusar').click(function(){
    	$.get(this.href);
 //   	$(this).css("color", "#bc690f"); 
//    	alert('Video recusado! Aperte Finalizar quando terminar.');
		$(this).parent().parent().parent().parent().parent().parent().children('a').addClass("rejected");
		$(this).parent().parent().parent().parent().parent().parent().children('a').removeClass("approved");
    });
	
//	$(".calendar").datepicker($.datepicker.regional['br']);
//	$('.calendar').datetimepicker({
//      pickTime: false
//    });
	
	$('#usuarios_cadastro').submit(function() {
		if($("input[name=password]").val() != $("input[name=passAgain]").val()) {
			alert("Senhas diferentes!");
			return false;
		}
		return true;
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
			$.ajax("tool_ajax.php?reuso="+thisCheck.attr('value')+"&val="+val+"&desc="+valDesc).done(function (){
				$(".reuso_form").submit();
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
			$.ajax("tool_ajax.php?reuso="+thisCheck.attr('value')+"&false=false&val="+val+"&desc="+valDesc).done(function (){
				$(".reuso_form").submit();
			});
//			location.reload();
		}
	});

	$('.chkIndio').click(function() {
		var thisCheck = $(this);
		if(thisCheck.is(':checked')) {
			var id = thisCheck.attr('id').split("_")[1];
			var valAddDesc = $('#valor'+id).attr('value').replace(".","").replace(",",".");
//			alert(valAddDesc);
			valAddDesc = valAddDesc*2;
//			alert(valAddDesc);
			valDesc = parseFloat(valAddDesc);
			valDesc = valDesc.toString().replace(".",",");
//			alert(valDesc);
			$('#valor'+id).attr('value',valDesc);
			var val = $('#valor'+id).attr('value');
//			alert(val);
			$.ajax("tool_ajax.php?chkIndio="+thisCheck.attr('value')+"&val="+val+"&desc="+valDesc).done(function (){
				$(".reuso_form").submit();
			});
		}
		else {
			var id = thisCheck.attr('id').split("_")[1];
			var valAddDesc = $('#valor'+id).attr('value').replace(".","").replace(",",".");
//			alert(valAddDesc);
			valAddDesc = valAddDesc/2;
//			alert(valAddDesc);
//			var valDesc = $('#desconto'+id).attr('value').replace(".","").replace(",",".");
			valDesc = parseFloat(valAddDesc);
			valDesc = valDesc.toString().replace(".",",");
//			alert(valDesc);
			$('#valor'+id).attr('value',valDesc);
			var val = $('#valor'+id).attr('value');
//			alert(val);
//			alert("tool_ajax.php?reuso="+thisCheck.attr('value')+"&false=false");
			$.ajax("tool_ajax.php?chkIndio="+thisCheck.attr('value')+"&false=false&val="+val+"&desc="+valDesc).done(function (){
				$(".reuso_form").submit();
			});
//			location.reload();
		}
	});
	
	$('#btnSaveIptc').click(function() {
		var dataString = "action=salveIPTC&idFoto=<?php echo isset($idFoto)?$idFoto:""?>&iptcPal=<?php echo isset($iptc_pal)?$iptc_pal:""?>";
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
	
	$('#btnChangeSig').click(function() {
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
	
	$("#contatoSig").change(function()	{
		var id=$(this).val();
		var dataString = 'action=set_id_contato_sig&id_contato_sig='+id+'&id_cadastro=<?php echo isset($colname_arquivos)?$colname_arquivos:""?>';
		$.ajax({
			type: "POST",
			url: "tool_ajax.php",
			data: dataString,
			cache: false,
			success: function(html) {
				location.reload();
			} 
		});
		$('.idContatoSig').val(id);
	});

	$("#clienteSig").change(function()	{
		var id=$(this).val();
		var dataString = 'action=set_id_cliente_sig&id_cliente_sig='+ id + '&id_cadastro=<?php echo isset($colname_arquivos)?$colname_arquivos:""?>';
		$.ajax({
			type: "POST",
			url: "tool_ajax.php",
			data: dataString,
			cache: false,
			success: function(html) {
	//			alert(html);
	//			$(".tamanho").html(html);
			} 
		});
		var dataString = 'action=contato&id_cliente='+ id;
		$.ajax({
			type: "POST",
			url: "tool_ajax.php",
			data: dataString,
			cache: false,
			success: function(html) {
				$("#contatoSig").html(html); // FINALIZAR!!!
				location.reload();
			} 
		});
		
	});
		
	$("#selectCliente").change(function() {
		var idContrato = <?php echo isset($id_contrato)?$id_contrato:0?>;
		var dataString = 'action=updateCliente&idContrato='+idContrato+'&idCliente='+ this.value;
		$.ajax({
			type: "POST",
			url: "tool_ajax.php",
			data: dataString,
			cache: false,
			success: function(html) {
				location.href = "administrativo_licencas_nova.php?editar=true&id_contrato="+idContrato;
			} 
		});
	});
	$("#selectContato").change(function() {
		var idContrato = <?php echo isset($id_contrato)?$id_contrato:0?>;
		var dataString = 'action=updateContato&idContrato='+idContrato+'&idContato='+ this.value;
		$.ajax({
			type: "POST",
			url: "tool_ajax.php",
			data: dataString,
			cache: false,
			success: function(html) {
//				location.href = "administrativo_licencas_nova.php?edit=true&id_contrato="+idContrato;
			} 
		});
	});
	$("#selectContrato").change(function() {
		var idContrato = <?php echo isset($id_contrato)?$id_contrato:0?>;
		var dataString = 'action=updateContrato&idContrato='+idContrato+'&idContratoDesc='+ this.value;
		$.ajax({
			type: "POST",
			url: "tool_ajax.php",
			data: dataString,
			cache: false,
			success: function(html) {
				location.href = "administrativo_licencas_nova.php?editar=true&id_contrato="+idContrato;
			} 
		});
	});
});
function countChar(val) {
    var len = val.value.length;
    if (len >= 100) {
      val.value = val.value.substring(0, 100);
    } else {
      $('#contador').text(100 - len);
    }
};

function recalculate(){
    var sum = 0;

    $("input[type=checkbox]:checked").each(function(){
      sum += parseFloat($(this).attr("value").replace(".", "").replace(",", "."));
    });
    var sum2 = addDotsComma(sum.toString());
    $('.sum_total').html("R$ "+sum2);
}

function recalculateId(){
    var sum = 0;

    $("input[type=checkbox]:checked").each(function(){
      sum += parseFloat($(this).attr("id").replace(".", "").replace(",", "."));
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
function MM_jumpMenu(targ,selObj,restore){ //v3.0
	  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
	  if (restore) selObj.selectedIndex=0;
}
</script>
<script>
var max=251; 
var ancho=300;
function progreso_tecla(obj) { 
	var progreso = document.getElementById("progreso");   
	if (obj.value.length < max) { 
		progreso.style.backgroundColor = "#006400";     
		progreso.style.backgroundImage = "url(textarea.png)";     
		progreso.style.color = "#FFFFFF"; 
		var pos = ancho-parseInt((ancho*parseInt(obj.value.length))/251); 
		progreso.style.backgroundPosition = "-"+pos+"px 0px"; 
	} else { 
		progreso.style.backgroundColor = "#FF0000";     
		progreso.style.backgroundImage = "url()";     
		progreso.style.color = "#FFFFFF"; 
	}  
	progreso.innerHTML = "("+obj.value.length+" / "+max+")"; 
} 
	
function soNums(e,args) 
{         
    // Função que permite apenas teclas numéricas e  
    // todos os caracteres que estiverem na lista 
    // de argumentos. 
    // Deve ser chamada no evento onKeyPress desta forma 
    //  onKeyPress ="return (soNums(event,'(/){,}.'));" 
    // caso queira apenas permitir caracters 

        if (document.all){var evt=event.keyCode;} // caso seja IE 
        else{var evt = e.charCode;}    // do contrário deve ser Mozilla 
        var chr= String.fromCharCode(evt);    // pegando a tecla digitada 
        // Se o código for menor que 20 é porque deve ser caracteres de controle 
        // ex.: <ENTER>, <TAB>, <BACKSPACE> portanto devemos permitir 
        // as teclas numéricas vão de 48 a 57 
        if (evt <20 || (evt >47 && evt<58) || (args.indexOf(chr)>-1 ) ){return true;} 
        return false; 
}
function confirma_exluir_preco(){
    if(confirm("Deseja realmente excluir este Preço?"))
    {
        return true;
    }else{
        return false;
    }
}

function confirma_exluir_uso(){
    if(confirm("Deseja realmente excluir este Tipo?"))
    {
        return true;
    }else{
        return false;
    }
}

function valida_uso(){
    if(document.getElementById("txttipo").value == ""){
        alert("Digite o Tipo");
        return false;
    }else{
        return true;
    }
}

function countChar(val) {
    var len = val.value.length;
    if (len >= 100) {
      val.value = val.value.substring(0, 100);
    } else {
      $('#contador').text(100 - len);
    }
};

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
	sValue = objeto.value;

	// Limpa todos os caracteres de formatação que
	// já estiverem no campo.
	sValue = sValue.toString().replace( "-", "" );
	sValue = sValue.toString().replace( "-", "" );
	sValue = sValue.toString().replace( ".", "" );
	sValue = sValue.toString().replace( ".", "" );
	sValue = sValue.toString().replace( "/", "" );
	sValue = sValue.toString().replace( "/", "" );
	sValue = sValue.toString().replace( ":", "" );
	sValue = sValue.toString().replace( ":", "" );
	sValue = sValue.toString().replace( "(", "" );
	sValue = sValue.toString().replace( "(", "" );
	sValue = sValue.toString().replace( ")", "" );
	sValue = sValue.toString().replace( ")", "" );
	sValue = sValue.toString().replace( " ", "" );
	sValue = sValue.toString().replace( " ", "" );
	fldLen = sValue.length;
	mskLen = sMask.length;

	i = 0;
	nCount = 0;
	sCod = "";
	mskLen = fldLen;

	while (i <= mskLen) {
	  bolMask = ((sMask.charAt(i) == "-") || (sMask.charAt(i) == ".") || (sMask.charAt(i) == "/") || (sMask.charAt(i) == ":"))
	  bolMask = bolMask || ((sMask.charAt(i) == "(") || (sMask.charAt(i) == ")") || (sMask.charAt(i) == " "))

	  if (bolMask) {
		sCod += sMask.charAt(i);
		mskLen++; }
	  else {
		sCod += sValue.charAt(nCount);
		nCount++;
	  }

	  i++;
	}

	objeto.value = sCod;

	if (nTecla != 8) { // backspace
	  if (sMask.charAt(i-1) == "9") { // apenas números...
		return ((nTecla > 47) && (nTecla < 58)); } 
		else { // qualquer caracter...
			return true;
		} 
	}
	else {
	  return true;
	}
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
	window.open(theURL,winName,features);
}
</script>