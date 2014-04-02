<?php

$_SESSION['last_detail'] = $_SERVER['REQUEST_URI'];

# ROTINA PARA EXCLUIR VÁRIAS FOTOS DENTRO DAS PASTAS

if (( !empty ( $_POST['chkbox'] ) ) && ($_POST['opcao'] == "delete")) {

$updateSQL = "UPDATE pastas SET data_mod = '".date("Y-m-d H:i:s", strtotime('now'))."' WHERE id_pasta = ".$_GET['id_pasta'];

mysql_select_db($database_pulsar, $pulsar);
$Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());

$deleteSQL = "DELETE FROM pasta_fotos WHERE id_foto_pasta IN (".implode(",",$_POST['chkbox']).")";

mysql_select_db($database_pulsar, $pulsar);
$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());

}

# ROTINA PARA EXCLUIR FOTOS UNICAS

if ( !empty ( $_POST['who'] ) )  {

$updateSQL = "UPDATE pastas SET data_mod = '".date("Y-m-d H:i:s", strtotime('now'))."' WHERE id_pasta = ".$_GET['id_pasta'];

mysql_select_db($database_pulsar, $pulsar);
$Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());

$deleteSQL = "DELETE FROM pasta_fotos WHERE id_foto_pasta = ".$_POST['who'];

mysql_select_db($database_pulsar, $pulsar);
$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());

}

# ROTINA PARA COTAR FOTOS UNICAS

if ( !empty ( $_POST['cotar'] ) )  {

$insertSQL = "INSERT IGNORE INTO cotacao (id_cadastro, tombo, data) VALUES (".$row_top_login['id_cadastro'].",'".$_POST['cotar']."','".date("Y-m-d H:i:s", strtotime('now'))."')";

mysql_select_db($database_pulsar, $pulsar);
$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
?><script>alert('Foto adicionada com sucesso.\n**Visite a seção COTAÇÃO para concluir o processo.**');</script>
<?php
}

# ROTINA PARA COTAR FOTOS

if (( !empty ( $_POST['chkbox'] ) ) && ($_POST['opcao'] == "cotar")) {
	
	if($lingua!="br") {
		$sqlSelect = "SELECT tombo FROM pasta_fotos WHERE id_foto_pasta IN (".implode(",",$_POST['chkbox']).")";
	
		mysql_select_db($database_pulsar, $pulsar);
		$rsSelect = mysql_query($sqlSelect, $pulsar) or die(mysql_error());
		while($rowSelect = mysql_fetch_assoc($rsSelect)) {
			$_SESSION['produto']['produtos_'.$rowSelect['tombo']] = '1';
		}
	?><script>window.location.href = "carrinho.php";</script>
	<?php
	}
	else {	
		mysql_select_db($database_pulsar, $pulsar);
		$query_tombos = "SELECT tombo FROM pasta_fotos WHERE id_foto_pasta IN (".implode(",",$_POST['chkbox']).")";
		$tombos = mysql_query($query_tombos, $pulsar) or die(mysql_error());
		$row_tombos = mysql_fetch_assoc($tombos);
		$out = "";
		do {
			$out= $out."(".$row_top_login['id_cadastro'].",'".$row_tombos['tombo']."','".date("Y-m-d H:i:s", strtotime('now'))."'),";
		} while ($row_tombos = mysql_fetch_assoc($tombos));
		mysql_free_result($tombos);
		$insertSQL = "INSERT IGNORE INTO cotacao (id_cadastro, tombo, data) VALUES ".substr($out,0,strlen($out)-1) ;
		mysql_select_db($database_pulsar, $pulsar);
		$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
	?><script>alert('Foto(s) adicionada(s) com sucesso.\n**Visite a seção COTAÇÃO para concluir o processo.**');</script>
	<?php
	}
}

# ROTINA PARA MOVER FOTOS SELECIONADAS PARA AS PASTAS

if ( !empty ( $_POST['pastas']) ) {
	$Apastas = explode(",", $_POST['pastas']);
	
	mysql_select_db($database_pulsar, $pulsar);
	$query_tombos = "SELECT tombo FROM pasta_fotos WHERE id_foto_pasta IN (".implode(",",$_POST['chkbox']).")";
	$tombos = mysql_query($query_tombos, $pulsar) or die(mysql_error());
	$out = "";
	while ($line = mysql_fetch_object($tombos)) {
		foreach ($Apastas as $Apasta) {
			$out= $out."(".$Apasta.",'".$line->tombo."'),";
		}
	}
	mysql_free_result($tombos);
	$updateSQL = "UPDATE pastas SET data_mod = '".date("Y-m-d H:i:s", strtotime('now'))."' WHERE id_pasta IN (".$_POST['pastas'].")";

	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());
#echo $updateSQL;
	
	$insertSQL = "INSERT IGNORE INTO pasta_fotos (id_pasta, tombo) VALUES ".substr($out,0,strlen($out)-1) ;
	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
}



if($show_fotos) {
	$colname_nome_pasta = "1";
	if (isset($_GET['id_pasta'])) {
	  $colname_nome_pasta = (get_magic_quotes_gpc()) ? $_GET['id_pasta'] : addslashes($_GET['id_pasta']);
	}
	mysql_select_db($database_pulsar, $pulsar);
	$query_nome_pasta = sprintf("SELECT id_pasta,  nome_pasta FROM pastas WHERE pastas.id_pasta = %s", $colname_nome_pasta);
	$nome_pasta = mysql_query($query_nome_pasta, $pulsar) or die(mysql_error());
	$row_nome_pasta = mysql_fetch_assoc($nome_pasta);
	$totalRows_nome_pasta = mysql_num_rows($nome_pasta);
	
	$colname_fotos_pasta = "1";
	if (isset($_GET['id_pasta'])) {
	  $colname_fotos_pasta = (get_magic_quotes_gpc()) ? $_GET['id_pasta'] : addslashes($_GET['id_pasta']);
	}
	mysql_select_db($database_pulsar, $pulsar);
	$query_fotos_pasta = sprintf("SELECT pastas.id_pasta,   pasta_fotos.tombo,  pasta_fotos.id_foto_pasta,  pastas.nome_pasta,   cadastro.login,   fotografos.Nome_Fotografo,Fotos.Id_Foto,   Fotos.assunto_principal,   Fotos.cidade,   Estados.Estado,   Estados.Sigla,   Fotos.data_foto, paises.nome as pais FROM pasta_fotos  INNER JOIN pastas ON (pasta_fotos.id_pasta=pastas.id_pasta)  INNER JOIN cadastro ON (pastas.id_cadastro=cadastro.id_cadastro)  INNER JOIN Fotos ON (Fotos.tombo=pasta_fotos.tombo)  LEFT JOIN fotografos ON (Fotos.id_autor=fotografos.id_fotografo) LEFT JOIN Estados ON (Estados.id_estado=Fotos.id_estado) LEFT JOIN paises ON (paises.id_pais=Fotos.id_pais) WHERE pastas.id_pasta = %s ORDER BY tombo", $colname_fotos_pasta);
	$fotos_pasta = mysql_query($query_fotos_pasta, $pulsar) or die(mysql_error());
	$row_fotos_pasta = mysql_fetch_assoc($fotos_pasta);
	$totalRows_fotos_pasta = mysql_num_rows($fotos_pasta);
}

mysql_select_db($database_pulsar, $pulsar);
$query_fotos_cotacao = sprintf("SELECT   cotacao.tombo  FROM cotacao WHERE cotacao.id_cadastro = %s ORDER BY tombo", $row_top_login['id_cadastro']);
$fotos_cotacao = mysql_query($query_fotos_cotacao, $pulsar) or die(mysql_error());
$row_fotos_cotacao = mysql_fetch_assoc($fotos_cotacao);
$totalRows_fotos_cotacao = mysql_num_rows($fotos_cotacao);

if($totalRows_fotos_cotacao) {
	function isQuoting($tombo, $result) {
		mysql_data_seek($result, 0);
		while ($row = mysql_fetch_assoc($result)) {
			if($row['tombo'] == $tombo)	
				return true;	
		}
		return false;	
	}
} else {
	function isQuoting($tombo, $result) { return false; }
}

?>
<script language="JavaScript" type="text/JavaScript">
function MM_callJS(jsStr) { //v2.0
	return eval(jsStr)
}

function validate(f) {
 if (document.form1.length<2) {
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
        alert('<?php echo MINHASIMAGENS_SELECIONAR_UMA_MSG?>');
        return false;
    } else {     
	
		var agree=confirm("<?php echo MINHASIMAGENS_CONFIRMA_MSG?>");
		if (agree) {
			document.form1.submit();return true;
		}
		else
			return false ;
	}
}

function validateEnviaEmail(f) {
 if (document.form1.length<2) {
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
  for (var i = 0; i < chkbox.length; i++) {
     if (chkbox[i].checked) {
        noneChecked = false;
     	c++;
      }
   }
    if (noneChecked) {
        alert('<?php echo MINHASIMAGENS_SELECIONAR_UMA_MSG?>');
        return false;
    } else {   
		if (c == 1) {
	    	document.form1.action = "enviarporemail.php";
	    	document.form1.method = "get";
			document.form1.submit();
			return true;
		} else {
			alert('<?php echo MINHASIMAGENS_SELECIONAR_MAISDEUMA_MSG?>');
		}  
    }
}

function validate2(f) {
 if (document.form1.length<2) {
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
  for (var i = 0; i < chkbox.length; i++) {
     if (chkbox[i].checked) {
        noneChecked = false;
	 	c++;
      }
   }
    if (noneChecked) {
        alert('<?php echo MINHASIMAGENS_SELECIONAR_UMA_MSG?>');
        return false;
    } else {
		if (c == 1) {
	    	document.form1.submit(); return true;
		} else {
			alert('<?php echo MINHASIMAGENS_SELECIONAR_MAISDEUMA_MSG?>');
		}
    }
}

function validate3() {
var agree=confirm("<?php echo MINHASIMAGENS_CONFIRMA_MSG?>");
if (agree) {
	document.form1.submit();return true;
}
	else
return false ;
}

function validate4(f) {
 if (document.form1.length<2) {
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
        alert('<?php echo MINHASIMAGENS_SELECIONAR_UMA_MSG?>');
        return false;
    } else {     
		document.form1.submit();return true;
	}
}
function validate15(f) {
 if (document.form1.length<2) {
 	return false;
	}
  var chkbox = f.elements['chkbox[]'];
  var chkcounter = 0;
  if (typeof chkbox.length == 'undefined') {
    // there's only one checkbox on the form
    // normalize it to an array/collection
    chkbox = new Array(chkbox);
  }
  for (var i = 0; i < chkbox.length; i++) {
     if (chkbox[i].checked) {
    	 chkcounter += 1;
      }
   }
  if (chkcounter == 0) {
      alert('<?php echo MINHASIMAGENS_SELECIONAR_UMA_MSG?>');
      return false;
  } else if (chkcounter > 15) {
        alert('<?php echo MINHASIMAGENS_MULTIPLODOWNLOAD_WARN?>');
        return false;
    } else {     
    	document.form1.submit();return true;
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