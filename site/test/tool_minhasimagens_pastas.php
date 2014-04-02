<?php
// $type must equal 'GET' or 'POST'
function curl_request_async($url, $params, $type='POST')
{
	foreach ($params as $key => &$val) {
		if (is_array($val)) $val = implode(',', $val);
		$post_params[] = $key.'='.urlencode($val);
	}
	$post_string = implode('&', $post_params);

	$parts=parse_url($url);

	$fp = fsockopen($parts['host'],
			isset($parts['port'])?$parts['port']:80,
			$errno, $errstr, 30);

	// Data goes in the path for a GET request
	if('GET' == $type) $parts['path'] .= '?'.$post_string;

	$out = "$type ".$parts['path']." HTTP/1.1\r\n";
	$out.= "Host: ".$parts['host']."\r\n";
	$out.= "Content-Type: application/x-www-form-urlencoded\r\n";
	$out.= "Content-Length: ".strlen($post_string)."\r\n";
	$out.= "Connection: Close\r\n\r\n";
	// Data goes in the request body for a POST request
	if ('POST' == $type && isset($post_string)) $out.= $post_string;
	//echo $out."<br>";
	fwrite($fp, $out);
	fclose($fp);
}

$rename_id = 0;
$rename_name = "";
$has_msg = false;
$msg = "";

if(isset($_GET['msg'])) {
	$has_msg = true;
	if($_GET['msg'] == "cadastro") {
		$msg = MINHASPASTAS_ALTERARCADASTRO_MSG;
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
	$msg = MINHASPASTAS_PASTALDEL_MSG;
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
		  	$msg = PASTAS_CRIAR_PASTA;
	  	}	
	  	else if($_POST['msgopcao'] == "merge") {
	  		$msg = PASTAS_MESCLAR_PASTA;
	  	}
	  	else if($_POST['msgopcao'] == "rename") {
		  	$msg = PASTAS_RENOMEAR_PASTA;
	  	}
	  } 
	  else { 
	  	$msg = PASTAS_RENOMEAR_PASTA;
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
	$rename_name = MINHASPASTAS_PASTANOVA;
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
	$rename_name = MINHASPASTAS_PASTAUNIDA;
	$has_msg = false;
//	$has_msg = true;
//	$msg = "Pastas unidas com sucesso!";
	$opcao = "merge";
}

# ROTINA PARA COTAR PASTAS

if (( !empty ( $_POST['chkbox'] ) ) && ($_POST['opcao'] == "quote")) {

	if($lingua!="br") { 
		$sqlSelect = "SELECT id_pasta, tombo, ".$row_top_login['id_cadastro'].", now() FROM pasta_fotos WHERE pasta_fotos.id_pasta IN (".implode(",",$_POST['chkbox']).")";
	
		mysql_select_db($database_pulsar, $pulsar);
		$rsSelect = mysql_query($sqlSelect, $pulsar) or die(mysql_error());
		while($rowSelect = mysql_fetch_assoc($rsSelect)) {
			$_SESSION['produto']['produtos_'.$rowSelect['tombo']] = '1';
		}
		$has_msg = true;
		$msg = MINHASPASTAS_CARRINHO_MSG;
	}
	else {
		$insertSQL = "INSERT IGNORE INTO cotacao (id_pasta, tombo, id_cadastro, data) SELECT id_pasta, tombo, ".$row_top_login['id_cadastro'].", now() FROM pasta_fotos WHERE pasta_fotos.id_pasta IN (".implode(",",$_POST['chkbox']).")";
		
		mysql_select_db($database_pulsar, $pulsar);
		$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
		
		$has_msg = true;
		$msg = MINHASPASTAS_COTAR_MSG;
	}
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
        alert('<?php echo MINHASPASTAS_SELECIONAR_UMA_MSG?>');
        return false;
    } else {
		var agree=confirm("<?php echo MINHASPASTAS_CONFIRMA_MSG?>");
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
        alert('<?php echo MINHASPASTAS_SELECIONAR_UMA_MSG?>');
        return false;
    } else {
		if (c == 1) {
//			MM_openBrWindow('pastaRenomear.php?id_pasta='+pasta,'','width=300,height=236');
	     document.form1.submit(); return true;
		} else {
			alert('<?php echo MINHASPASTAS_RENOMEIE_UMA_MSG?>');
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
        alert('<?php echo MINHASPASTAS_SELECIONAR_UMA_MSG?>');
        return false;
    } else {
		if (c == 1) {
			window.open('enviarpastaemail.php?id_pasta='+pasta,'_self'); return true;
//			MM_openBrWindow('pastaRenomear.php?id_pasta='+pasta,'','width=300,height=236');
//	    	document.form1.submit(); return true;
		} else {
			alert('<?php echo MINHASPASTAS_ENVIARUMA_MSG?>');
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
        alert('<?php echo MINHASPASTAS_SELECIONAR_UMA_MSG?>');
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
        alert('<?php echo MINHASPASTAS_SELECIONAR_DUAS_MSG?>');
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