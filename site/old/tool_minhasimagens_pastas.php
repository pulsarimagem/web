<?php
$rename_id = 0;
$rename_name = "";
$has_msg = false;
$msg = "";

if(isset($_GET['msg'])) {
	$has_msg = true;
	if($_GET['msg'] == "cadastro") {
		$msg = "Alteração de cadastro realizada com sucesso!";
	}
}


# ROTINA PARA EXCLUIR PASTAS E FOTOS DENTRO DAS PASTAS

if (( !empty ( $_POST['chkbox'] ) ) && ($_POST['opcao'] == "delete")) {

	$deleteSQL = "DELETE FROM pastas WHERE id_pasta IN (".implode(",",$_POST['chkbox']).")";
	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());

	$deleteSQL = "DELETE FROM pasta_fotos WHERE id_pasta IN (".implode(",",$_POST['chkbox']).")";

	$Result2 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
	$has_msg = true;
	$msg = "Pasta(s) deletadas com sucesso!";
}

# Rotina para renomear pastas

if (( !empty ( $_POST['chkbox'] ) ) && ($_POST['opcao'] == "rename")) {
	$query_nome_pasta = sprintf("SELECT nome_pasta FROM pastas WHERE id_pasta = ".implode(",",$_POST['chkbox']));
	$nome_pasta = mysql_query($query_nome_pasta, $pulsar) or die(mysql_error());
	$row_nome_pasta = mysql_fetch_assoc($nome_pasta);
	
	$rename_id = implode(",",$_POST['chkbox']);
	$rename_name = $row_nome_pasta['nome_pasta'];
	$opcao = "rename";
}

if ((!empty ($_POST['rename_id']))) {
	if($_POST['rename'] == "") {
		$rename_id = $_POST['rename_id'];
	}
	else { 
	  $updateSQL = sprintf("UPDATE pastas SET nome_pasta=%s WHERE id_pasta=%s",
	                       GetSQLValueString($_POST['rename'], "text"),
	                       GetSQLValueString($_POST['rename_id'], "int"));
	
	  mysql_select_db($database_pulsar, $pulsar);
	  $Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());
	  
	  $has_msg = true;
	  if(!empty ($_POST['msgopcao'])) {
	  	if($_POST['msgopcao'] == "new") {
		  	$msg = "Pasta criada com sucesso!";
	  	}	
	  	else if($_POST['msgopcao'] == "merge") {
	  		$msg = "Pasta mesclada com sucesso!";
	  	}
	  	else if($_POST['msgopcao'] == "rename") {
		  	$msg = "Pasta renomeada com sucesso!";
	  	}
	  } 
	  else { 
	  	$msg = "Pasta renomeada com sucesso!";
	  }
	  
	}
}
  
# Rotina para nova pasta

if (!empty ( $_POST['opcao']) && ($_POST['opcao'] == "new")) {
	$insertSQL = sprintf("INSERT INTO pastas (id_cadastro, nome_pasta, data_cria, data_mod) VALUES (%s, %s, now(),now())", $row_top_login['id_cadastro'], "' Pasta Nova'");
	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

	$query_id_pasta = sprintf("SELECT id_pasta FROM pastas WHERE id_cadastro = %s ORDER BY id_pasta DESC", $row_top_login['id_cadastro']);
	$id_pasta = mysql_query($query_id_pasta, $pulsar) or die(mysql_error());
	$row_id_pasta = mysql_fetch_assoc($id_pasta);

	$rename_id = $row_id_pasta['id_pasta'];
	$rename_name = "Pasta Nova";
	$opcao = "new";
}


# ROTINA PARA MESCLAR PASTAS

if (( !empty ( $_POST['chkbox'] ) ) && ($_POST['opcao'] == "mesclar")) {


	$insertSQL = sprintf("INSERT INTO pastas (id_cadastro, nome_pasta, data_cria, data_mod) VALUES (%s, %s, now(),now())", $row_top_login['id_cadastro'], "' Pasta Mesclada'");
	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

	$query_id_pasta = sprintf("SELECT id_pasta FROM pastas WHERE id_cadastro = %s ORDER BY id_pasta DESC", $row_top_login['id_cadastro']);
	$id_pasta = mysql_query($query_id_pasta, $pulsar) or die(mysql_error());
	$row_id_pasta = mysql_fetch_assoc($id_pasta);

	$insertSQL = "INSERT IGNORE INTO pasta_fotos (id_pasta, tombo) SELECT ".$row_id_pasta['id_pasta']." as id_pasta, pasta_fotos.tombo FROM pasta_fotos WHERE pasta_fotos.id_pasta IN (".implode(",",$_POST['chkbox']).")";

	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

	$rename_id = $row_id_pasta['id_pasta'];
	$rename_name = "Pasta Unida";
	$has_msg = false;
//	$has_msg = true;
//	$msg = "Pastas unidas com sucesso!";
	$opcao = "merge";
}

# ROTINA PARA COTAR PASTAS

if (( !empty ( $_POST['chkbox'] ) ) && ($_POST['opcao'] == "quote")) {

	$insertSQL = "INSERT IGNORE INTO cotacao (id_pasta, tombo, id_cadastro, data) SELECT id_pasta, tombo, ".$row_top_login['id_cadastro'].", now() FROM pasta_fotos WHERE pasta_fotos.id_pasta IN (".implode(",",$_POST['chkbox']).")";

	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

		$has_msg = true;
	$msg = "Pasta adicionada com sucesso. Visite a seção COTAÇÃO para concluir o processo.";
/*	
	?>
<script>alert('Pasta encaminhada à Área de Cotação.');</script>
	<?php*/
}


if($show_pastas) {
	$colname_pastas = "1";
	if (isset($_SESSION['MM_Username'])) {
		$colname_pastas = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
	}
	
	$desc = false;
	$sort = "nome";
	$ordem = "pastas.nome_pasta";
	if(isset($_GET['ordem'])) {
		if($_GET['ordem'] == "nome") {
			$ordem = "pastas.nome_pasta";
			$sort = "nome";
			$_SESSION['ordem'] = "nome";
		}
		else if($_GET['ordem'] == "fotos") {
			$ordem = "num_fotos";
			$sort = "fotos";
			$_SESSION['ordem'] = "fotos";
		}
		else if($_GET['ordem'] == "datacriacao") {
			$ordem = "pastas.data_cria";
			$sort = "criacao";
			$_SESSION['ordem'] = "datacriacao";
		}
		else if($_GET['ordem'] == "dataedicao") {
			$ordem = "pastas.data_mod";
			$sort = "edicao";
			$_SESSION['ordem'] = "dataedicao";
		}
		if(!isset($_GET['rev']))
			$_SESSION['rev'] = false; 
	}
	else if(isset($_SESSION['ordem'])) {
		if($_SESSION['ordem'] == "nome") {
			$ordem = "pastas.nome_pasta";
			$sort = "nome";
		}
		else if($_SESSION['ordem'] == "fotos") {
			$ordem = "num_fotos";
			$sort = "fotos";
		}
		else if($_SESSION['ordem'] == "datacriacao") {
			$ordem = "pastas.data_cria";
			$sort = "criacao";
		}
		else if($_SESSION['ordem'] == "dataedicao") {
			$ordem = "pastas.data_mod";
			$sort = "edicao";
		}
	}
	if(isset($_GET['rev'])) {
		$ordem .= " DESC";
		$desc = true;
		$_SESSION['rev'] = true;
	}
	else if(isset($_SESSION['rev']) && $_SESSION['rev']) {
		$ordem .= " DESC";
		$desc = true;
	}
	
	mysql_select_db($database_pulsar, $pulsar);
	$query_pastas = sprintf("SELECT pastas.id_pasta,   pastas.id_cadastro,   pastas.nome_pasta,   pastas.data_cria,   pastas.data_mod,   cadastro.login,   pasta_fotos.tombo,   count(pasta_fotos.tombo) as num_fotos FROM cadastro  INNER JOIN pastas ON (cadastro.id_cadastro=pastas.id_cadastro) LEFT JOIN pasta_fotos ON (pasta_fotos.id_pasta=pastas.id_pasta) WHERE (cadastro.login LIKE '%s') GROUP BY pastas.id_pasta ORDER BY %s", $colname_pastas, $ordem);
	$pastas = mysql_query($query_pastas, $pulsar) or die(mysql_error());
	$row_pastas = mysql_fetch_assoc($pastas);
	$totalRows_pastas = mysql_num_rows($pastas);
}


?>

<script language="JavaScript" type="text/JavaScript">
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}

function validate(f) {
 if (document.form1.length<3) {
 	return false;
	}
  var chkbox = f.elements['chkbox[]'];
  var noneChecked = true;
  if (typeof chkbox.length == 'undefined') {
    // there's only one checkbox on the form
    // normalize it to an array/collection
    chkbox = new Array(chkbox);
  }
  for (var i = 0; i < chkbox.length; i++) {
     if (chkbox[i].checked) {
        noneChecked = false;
        break;
      }
   }
    if (noneChecked) {
        alert('Você deve selecionar pelo menos uma pasta!');
        return false;
    } else {
		var agree=confirm("Confirma exclusão?");
		if (agree) {
			document.form1.submit();return true;
		}
		else
			return false ;
    }
}

function validate2(f) {
 if (document.form1.length<3) {
 	return false;
	}
  var chkbox = f.elements['chkbox[]'];
  var noneChecked = true;
  if (typeof chkbox.length == 'undefined') {
    // there's only one checkbox on the form
    // normalize it to an array/collection
    chkbox = new Array(chkbox);
  }
  var c = 0;
  var pasta = 0;
  for (var i = 0; i < chkbox.length; i++) {
     if (chkbox[i].checked) {
	 	c++;
        noneChecked = false;
		pasta = chkbox[i].value;
      }
   }
    if (noneChecked) {
        alert('Você deve selecionar pelo menos uma pasta!');
        return false;
    } else {
		if (c == 1) {
//			MM_openBrWindow('pastaRenomear.php?id_pasta='+pasta,'','width=300,height=236');
	     document.form1.submit(); return true;
		} else {
			alert('Renomeie somente uma pasta por vez!');
		}
    }
}

function validate3(f) {
 if (document.form1.length<3) {
 	return false;
	}
  var chkbox = f.elements['chkbox[]'];
  var noneChecked = true;
  if (typeof chkbox.length == 'undefined') {
    // there's only one checkbox on the form
    // normalize it to an array/collection
    chkbox = new Array(chkbox);
  }
  var c = 0;
  var pasta = 0;
  for (var i = 0; i < chkbox.length; i++) {
     if (chkbox[i].checked) {
	 	c++;
        noneChecked = false;
		pasta = chkbox[i].value;
      }
   }
    if (noneChecked) {
        alert('Você deve selecionar pelo menos uma pasta!');
        return false;
    } else {
		if (c == 1) {
			window.open('enviarpastaemail.php?id_pasta='+pasta,'_self'); return true;
//			MM_openBrWindow('pastaRenomear.php?id_pasta='+pasta,'','width=300,height=236');
//	    	document.form1.submit(); return true;
		} else {
			alert('Envie somente uma pasta por vez!');
		}
    }
}

function validate4(f) {
 if (document.form1.length<3) {
 	return false;
	}
  var chkbox = f.elements['chkbox[]'];
  var noneChecked = true;
  if (typeof chkbox.length == 'undefined') {
    // there's only one checkbox on the form
    // normalize it to an array/collection
    chkbox = new Array(chkbox);
  }
  for (var i = 0; i < chkbox.length; i++) {
     if (chkbox[i].checked) {
        noneChecked = false;
        break;
      }
   }
    if (noneChecked) {
        alert('Você deve selecionar pelo menos uma pasta!');
        return false;
    } else {
			document.form1.submit();return true;
    }
}

function validate5(f) {
 if (document.form1.length<3) {
 	return false;
	}
  var chkbox = f.elements['chkbox[]'];
  var noneChecked = true;
  var c = 0;
  if (typeof chkbox.length == 'undefined') {
    // there's only one checkbox on the form
    // normalize it to an array/collection
    chkbox = new Array(chkbox);
  }
  for (var i = 0; i < chkbox.length; i++) {
     if (chkbox[i].checked) {
 	 	c++;
         noneChecked = false;
 		pasta = chkbox[i].value;
     }
   }
    if (c > 1) {
		document.form1.submit();return true;
    } else {
        alert('Você deve selecionar pelo duas uma pasta!');
        return false;
    }
}

function checkAll(f)
{
var chkbox = f.elements['chkbox[]'];
for (i = 0; i < chkbox.length; i++)
//	chkbox[i].checked = true ;
	chkbox[i].checked = document.form1.checkbox1.checked ;
	document.form1.checkbox2.checked = document.form1.checkbox1.checked;
}

function checkAll2(f)
{
var chkbox = f.elements['chkbox[]'];
for (i = 0; i < chkbox.length; i++)
//	chkbox[i].checked = true ;
	chkbox[i].checked = document.form1.checkbox2.checked ;
	document.form1.checkbox1.checked = document.form1.checkbox2.checked;
}
</script>