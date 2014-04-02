<link type="text/css" href="./css/ui-lightness/jquery-ui-1.8.22.custom.css" rel="Stylesheet" />

<script src="./js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="./js/jquery-ui-1.8.22.custom.min.js"></script>
<script src="./js/jquery.ui.datepicker-pt-BR.js"></script>

<script type="text/javascript" src="../video/jwplayer.js"></script>

<script language="JavaScript" type="text/JavaScript">
<!--
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

<!--
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

//-->
</script>
<script type="text/javascript">
	jQuery(document).ready(function() {
		$("#estado").change(function() {
			$("#pais").val("BR");
		});

		$(".calendar").datepicker($.datepicker.regional['br']);
		
	}); 
</script>