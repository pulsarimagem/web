<?php
function fix_iptc_date($iptcDate) {
	if (strlen($iptcDate) == 0) {
		return $iptcDate;
	}
	else if (strlen($iptcDate) == 4) {
		return $iptcDate;
	}
	else if (strlen($iptcDate) == 7) {
		return substr($iptcDate, 3,4).substr($iptcDate, 0,2);
	}
	else if (strlen($iptcDate) == 10) {
		return substr($iptcDate, 6,4).substr($iptcDate, 3,2).substr($iptcDate, 0,2);
	}
	return strlen($iptcDate);
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if(isset($_POST['tombo']))
	$_POST['tombo'] = strtoupper($_POST['tombo']);
if(isset($_GET['tombo']))
	$_GET['tombo'] = strtoupper($_GET['tombo']);

$tombo = $_GET['tombo'];

// INSERIR NA TABELA FOTO
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
	
	$orientacao = 'H';
	$width = 0;
	$height = 0;
	
	$file = "/var/fotos_alta/".$_POST['tombo'].".jpg";
	
	if (!file_exists($file)) {				// check se o arquivo existe com extensao jpg e JPG
		$file = "/var/fotos_alta/".$_POST['tombo'].".JPG";
	}
	
	if (file_exists($file)) {				// se existir, abre e imprime a resolucao
		$getimgsize = getimagesize($file);
	
		if ($getimgsize) {
			list($width, $height, $type, $attr) = $getimgsize; 
	                
			if($height > $width) {
				$orientacao = 'V';
			}
		}
	}
	
  $insertSQL = sprintf("INSERT INTO Fotos_tmp (tombo, id_autor, data_foto, cidade, id_estado, id_pais, orientacao, assunto_principal, dim_a, dim_b, extra, pal_chave) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['tombo'], "text"),
                       GetSQLValueString($_POST['autor'], "int"),
                       GetSQLValueString($_POST['data'], "text"),
                       GetSQLValueString($_POST['cidade'], "text"),
                       GetSQLValueString($_POST['estado'], "int"),
                       GetSQLValueString($_POST['pais'], "text"),
                       GetSQLValueString($orientacao, "text"),
                       GetSQLValueString($_POST['assunto_principal'], "text"),
                       GetSQLValueString($width, "int"),
                       GetSQLValueString($height, "int"),
                       GetSQLValueString($_POST['extra'], "text"),
                       GetSQLValueString($_POST['descritor'], "text"));
                       
  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

  $Ultimo_Id = mysql_insert_id();
  
  
// INSERIR OS TEMAS

  $Array_t = explode(",",$_POST["todos_temas"]);

  $insertSQLt = "INSERT INTO rel_fotos_temas_tmp (id_foto,id_tema) VALUES ($Ultimo_Id,".implode("),($Ultimo_Id,",$Array_t).")";
//  echo $insertSQLt;
  mysql_select_db($database_pulsar, $pulsar);
  $Result2 = mysql_query($insertSQLt, $pulsar) or die(mysql_error());

// INSERIR AS PALAVRAS-CHAVES  
/*
  $Array_d = explode(",",$_POST["todos_descritores"]);

  $insertSQLp = "INSERT INTO rel_fotos_pal_ch_tmp (id_foto,id_palavra_chave) VALUES ($Ultimo_Id,".implode("),($Ultimo_Id,",$Array_d).")";
  echo $insertSQLp;
  mysql_select_db($database_pulsar, $pulsar);
  $Result3 = mysql_query($insertSQLp, $pulsar) or die(mysql_error());
*/  
  
// Remove dos fotos to index
	mysql_select_db($database_pulsar, $pulsar);
	$query_delete_toindex = sprintf("DELETE FROM tombos_toindex WHERE tombo = '%s'", $_POST['tombo']);
	$result_delete_toindex = mysql_query($query_delete_toindex, $pulsar) or die(mysql_error());
  
  $insertGoTo = "adm_index.php";
//  if (isset($_SERVER['QUERY_STRING'])) {
//    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
//    $insertGoTo .= $_SERVER['QUERY_STRING'];
//  }

  header(sprintf("Location: %s", $insertGoTo));

}

$colname_dados_foto = "0";
if (isset($_GET['copiar'])) {
  $colname_dados_foto = (get_magic_quotes_gpc()) ? $_GET['copiar'] : addslashes($_GET['copiar']);
}

/*
mysql_select_db($database_pulsar, $pulsar);
$query_dados_foto = sprintf("SELECT * FROM Fotos_tmp WHERE tombo = '%s'", $colname_dados_foto);
$dados_foto = mysql_query($query_dados_foto, $pulsar) or die(mysql_error());
$row_dados_foto = mysql_fetch_assoc($dados_foto);
$totalRows_dados_foto = mysql_num_rows($dados_foto);
*/
mysql_select_db($database_pulsar, $pulsar);
$query_fotografos = "SELECT * FROM fotografos ORDER BY Nome_Fotografo ASC";
$fotografos = mysql_query($query_fotografos, $pulsar) or die(mysql_error());
$row_fotografos = mysql_fetch_assoc($fotografos);
$totalRows_fotografos = mysql_num_rows($fotografos);

mysql_select_db($database_pulsar, $pulsar);
$query_estado = "SELECT * FROM Estados ORDER BY Estado ASC";
$estado = mysql_query($query_estado, $pulsar) or die(mysql_error());
$row_estado = mysql_fetch_assoc($estado);
$totalRows_estado = mysql_num_rows($estado);

mysql_select_db($database_pulsar, $pulsar);
$query_pais = "SELECT * FROM paises ORDER BY nome ASC";
$pais = mysql_query($query_pais, $pulsar) or die(mysql_error());
$row_pais = mysql_fetch_assoc($pais);
$totalRows_pais = mysql_num_rows($pais);
/*
mysql_select_db($database_pulsar, $pulsar);
$query_descritore = sprintf("SELECT    Fotos_tmp.tombo,   pal_chave.Id,   pal_chave.Pal_Chave,  rel_fotos_pal_ch_tmp.id_rel FROM  rel_fotos_pal_ch_tmp  INNER JOIN Fotos_tmp ON (rel_fotos_pal_ch_tmp.id_foto=Fotos_tmp.Id_Foto)  INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch_tmp.id_palavra_chave) WHERE   (Fotos_tmp.tombo = '%s') ORDER BY pal_chave.Pal_Chave",$row_dados_foto['tombo']);
$descritore = mysql_query($query_descritore, $pulsar) or die(mysql_error());
$row_descritore = mysql_fetch_assoc($descritore);
$totalRows_descritore = mysql_num_rows($descritore);
*/
mysql_select_db($database_pulsar, $pulsar);
$query_temas = sprintf("SELECT   Fotos_tmp.tombo,  super_temas.Tema_total,  super_temas.Id,  rel_fotos_temas_tmp.id_rel FROM Fotos_tmp INNER JOIN rel_fotos_temas_tmp ON (Fotos_tmp.Id_Foto=rel_fotos_temas_tmp.id_foto) INNER JOIN super_temas ON (rel_fotos_temas_tmp.id_tema=super_temas.Id) WHERE   (Fotos_tmp.tombo = '%s') ORDER BY  super_temas.Tema_total",$colname_dados_foto);
$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
$row_temas = mysql_fetch_assoc($temas);
$totalRows_temas = mysql_num_rows($temas);
if($totalRows_temas == 0) {
mysql_select_db($database_pulsar, $pulsar);
	$query_temas = sprintf("SELECT   Fotos.tombo,  super_temas.Tema_total,  super_temas.Id,  rel_fotos_temas.id_rel FROM Fotos INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto) INNER JOIN super_temas ON (rel_fotos_temas.id_tema=super_temas.Id) WHERE   (Fotos.tombo = '%s') ORDER BY  super_temas.Tema_total",$colname_dados_foto);
	$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
	$row_temas = mysql_fetch_assoc($temas);
	$totalRows_temas = mysql_num_rows($temas);
}
mysql_select_db($database_pulsar, $pulsar);
$query_toindex = sprintf("SELECT * FROM tombos_toindex WHERE id_autor=%s ORDER BY tombo ASC LIMIT 20",$row_login['id_fotografo']);
$toindex = mysql_query($query_toindex, $pulsar) or die(mysql_error());
$row_toindex = mysql_fetch_assoc($toindex);
$totalRows_toindex = mysql_num_rows($toindex);

// Deteccao de fotografo
$inicial = strtoupper(ereg_replace("[^A-Za-z]","", $_GET['tombo']));
mysql_select_db($database_pulsar, $pulsar);
$query_ini_fotografo = sprintf("SELECT * FROM fotografos WHERE Iniciais_Fotografo = '%s'", $inicial);
$ini_fotografo = mysql_query($query_ini_fotografo, $pulsar) or die(mysql_error());
$row_ini_fotografo = mysql_fetch_assoc($ini_fotografo);
$totalRows_ini_fotografo = mysql_num_rows($ini_fotografo);
if(strcmp($inicial, $_SESSION['MM_Username']) != 0) {
//	  header(sprintf("Location: adm_index.php?noautor=".$_GET['tombo'], $insertGoTo));
echo "<script>alert(' Autor:".$inicial." != Usuario: ".$_SESSION['MM_Username']."');</script>";
}

// Se imagem jah tiver sido indexada imprime mensagem e atualiza tabela
if(isset($_GET['tombo'])) {
	$tombo_foto_toindex = $_GET['tombo'];
	mysql_select_db($database_pulsar, $pulsar);
	$query_check_foto = sprintf("SELECT * FROM Fotos WHERE tombo = '%s'", $tombo_foto_toindex);
	$check_foto = mysql_query($query_check_foto, $pulsar) or die(mysql_error());
	$row_check_foto = mysql_fetch_assoc($check_foto);
	$totalRows_check_foto = mysql_num_rows($check_foto);
	
	if($totalRows_check_foto > 0) {
		$query_delete_foto = sprintf("DELETE FROM tombos_toindex WHERE tombo = '%s'", $tombo_foto_toindex);
		$delete_foto = mysql_query($query_delete_foto, $pulsar) or die(mysql_error());
		
?>
<script>
alert('Tombo <?php echo $_GET['tombo']?> já foi indexado no site!');
location.href='adm_index.php';
</script>
<?php 
//		header("Location: function_tombos_toindex.php");
		$totalRows_dados_foto = 0;
	}
}

if(strlen($_GET['tombo']) > 4) {
	if(!file_exists($fotosalta.$_GET['tombo'].".jpg") && !file_exists($fotosalta.$_GET['tombo'].".JPG")) {
?>
<script>
alert('Tombo <?php echo $_GET['tombo']?> não presente no <?php echo $fotosalta?>');
</script>
<?php 
	}
}

?>