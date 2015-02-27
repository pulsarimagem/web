<?php
$editFormAction = $_SERVER['PHP_SELF'];
$show_alteracao = false;
$tombo = "";
if (isset($_GET['tombo'])) { 
	$show_alteracao = true;
	$tombo = $_GET['tombo']; 
}
if (isset($_POST['tombo'])) { 
	$show_alteracao = true;
	$tombo = $_POST['tombo']; 
}
if (isset($_GET['tombo2'])&&($_GET['tombo2']!="")) { 
	$show_alteracao = true;
	$tombo = $_GET['tombo2']; 
	$_GET['tombo'] = $_GET['tombo2'];
}


if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if(isset($_POST['tombo']))
	$_POST['tombo'] = strtoupper($_POST['tombo']);
if(isset($_GET['tombo']))
	$_GET['tombo'] = strtoupper($_GET['tombo']);

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
	
	
	// ROTINA DE PEGAR AS DIMENSOES DA FOTO
	
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
	
	
	
  $updateSQL = sprintf("UPDATE Fotos_tmp SET tombo=%s, id_autor=%s, data_foto=%s, cidade=%s, id_estado=%s, id_pais=%s, orientacao=%s, assunto_principal=%s, dim_a=%s, dim_b=%s, extra=%s, pal_chave=%s WHERE Id_Foto=%s",
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
                       GetSQLValueString($_POST['descritor'], "text"),
                       GetSQLValueString($_POST['Id_Foto'], "int"));

mysql_select_db($database_pulsar, $pulsar);
$Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());
/*
  $updateextraSQL = sprintf("UPDATE Fotos_extra SET extra=%s WHERE tombo=%s",
                       GetSQLValueString($_POST['extra'], "text"),
                       GetSQLValueString($_POST['tombo'], "text"));
	*/
/*
  $insertextraSQL = sprintf("INSERT INTO Fotos_extra (tombo, extra) VALUES (%s, %s)",
                       GetSQLValueString($_POST['tombo'], "text"),
                       GetSQLValueString($_POST['extra'], "text"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result2 = mysql_query($insertextraSQL, $pulsar) or die(mysql_error());
*/
/*
// Insere o IPTC no arquivo
include('../toolkit/inc_IPTC4.php');
$tombo = $_POST['tombo'];
$path = $thumbpop;
$dest_file = $path."/".$tombo.".jpg";
coloca_iptc($tombo, $dest_file, $database_pulsar, $pulsar);
$dest_file = $path."/".$tombo."p.jpg";
coloca_iptc($tombo, $dest_file, $database_pulsar, $pulsar);
*/
$insertGoTo = "adm_index.php";
header(sprintf("Location: %s", $insertGoTo));
//echo $updateSQL;
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form4")) {
	
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
	
	
  $insertSQL = sprintf("INSERT INTO Fotos_tmp (tombo, id_autor, data_foto, cidade, id_estado, id_pais, orientacao, assunto_principal, dim_a, dim_b, extra) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
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
                       GetSQLValueString($_POST['extra'], "text"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
  $insertGoTo = "adm_index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST['del_cromo'])) && ($_POST['del_cromo'] != "")) {
  $deleteSQL = sprintf("DELETE FROM Fotos_tmp WHERE Id_Foto=%s",
                       GetSQLValueString($_POST['del_cromo'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
  
  $deleteSQL = sprintf("DELETE FROM rel_fotos_temas_tmp WHERE id_foto=%s",
                       GetSQLValueString($_POST['del_cromo'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());

  $deleteSQL = sprintf("DELETE FROM rel_fotos_pal_ch_tmp WHERE id_foto=%s",
                       GetSQLValueString($_POST['del_cromo'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());

  header("Location: adm_index.php");
}

if ((isset($_POST['descritor'])) && ($_POST['descritor'] != "") && ($_POST['excluir'] == "descritor")) {
$descr = $_POST['descritor'];
foreach ($descr as $d) {
  $deleteSQL = sprintf("DELETE FROM rel_fotos_pal_ch_tmp WHERE id_rel=%s",
                       GetSQLValueString($d, "int"));
  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
}
  header("Location: adm_index.php?tombo=".$_POST['tombo']);
}

if ((isset($_POST['tema'])) && ($_POST['tema'] != "") && ($_POST['excluir'] == "tema")) {
  $deleteSQL = sprintf("DELETE FROM rel_fotos_temas_tmp WHERE id_rel=%s",
                       GetSQLValueString($_POST['tema'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
  header("Location: adm_index.php?tombo=".$_POST['tombo']);
}

$colname_dados_foto = "0";
if (isset($_GET['tombo'])) {
  $colname_dados_foto = (get_magic_quotes_gpc()) ? $_GET['tombo'] : addslashes($_GET['tombo']);
}
if (isset($_POST['tombo'])) {
  $colname_dados_foto = (get_magic_quotes_gpc()) ? $_POST['tombo'] : addslashes($_POST['tombo']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_dados_foto = sprintf("SELECT * FROM Fotos_tmp WHERE tombo = '%s'", $colname_dados_foto);
$dados_foto = mysql_query($query_dados_foto, $pulsar) or die(mysql_error());
$row_dados_foto = mysql_fetch_assoc($dados_foto);
$totalRows_dados_foto = mysql_num_rows($dados_foto);

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

mysql_select_db($database_pulsar, $pulsar);
$query_descritore = sprintf("SELECT    Fotos_tmp.tombo,   pal_chave.Id,   pal_chave.Pal_Chave,  rel_fotos_pal_ch_tmp.id_rel FROM  rel_fotos_pal_ch_tmp  INNER JOIN Fotos_tmp ON (rel_fotos_pal_ch_tmp.id_foto=Fotos_tmp.Id_Foto)  INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch_tmp.id_palavra_chave) WHERE   (Fotos_tmp.tombo = '%s') ORDER BY pal_chave.Pal_Chave",$row_dados_foto['tombo']);
$descritore = mysql_query($query_descritore, $pulsar) or die(mysql_error());
$row_descritore = mysql_fetch_assoc($descritore);
$totalRows_descritore = mysql_num_rows($descritore);

mysql_select_db($database_pulsar, $pulsar);
$query_temas = sprintf("SELECT   Fotos_tmp.tombo,  super_temas.Tema_total,  super_temas.Id,  rel_fotos_temas_tmp.id_rel FROM Fotos_tmp INNER JOIN rel_fotos_temas_tmp ON (Fotos_tmp.Id_Foto=rel_fotos_temas_tmp.id_foto) INNER JOIN super_temas ON (rel_fotos_temas_tmp.id_tema=super_temas.Id) WHERE   (Fotos_tmp.tombo = '%s') ORDER BY  super_temas.Tema_total",$row_dados_foto['tombo']);
$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
$row_temas = mysql_fetch_assoc($temas);
$totalRows_temas = mysql_num_rows($temas);

mysql_select_db($database_pulsar, $pulsar);
$query_toindex = sprintf("SELECT * FROM tombos_toindex WHERE id_autor=%s ORDER BY tombo ASC LIMIT 20",$row_login['id_fotografo']);
$toindex = mysql_query($query_toindex, $pulsar) or die(mysql_error());
$row_toindex = mysql_fetch_assoc($toindex);
$totalRows_toindex = mysql_num_rows($toindex);
if($totalRows_toindex == 0 && !isset($_GET['updated']) && !isset($_GET['tombo']))
	header("Location: function_tombos_toindex.php");


// se ï¿½ nova indexaï¿½ï¿½o vai para outra tela
if ($totalRows_dados_foto == 0) { 
  if ((isset($_GET['tombo']) && ($_GET['tombo'] != "")) && ($_POST['del_cromo'] == "")) {
    header(sprintf("Location: adm_index_inc.php?tombo=%s", $_GET['tombo']));
  }
}
if(isset($_GET['tombo'])) {
	$inicial = strtoupper(ereg_replace("[^A-Za-z]","", $_GET['tombo']));
	if(strcmp($inicial, $row_login['Iniciais_Fotografo']) != 0) {
		  header(sprintf("Location: adm_index.php?noautor=".$_GET['tombo'], $insertGoTo));
	//echo "alert('".$inicial." != ".$row_login['Iniciais_Fotografo']."');";
//	echo "<script>alert(' Autor:".$inicial." != Usuario: ".$row_login['Iniciais_Fotografo']."');</script>";
	}
}
// Se nao existir foto alta, imprime mensagem
if(isset($_GET['tombo']) && strlen($_GET['tombo']) > 4) {
	$orig = "/tmp/".$_GET['tombo'].".jpg";
	if(!file_exists($orig)) {
		$cmd = "aws --profile pulsar s3 cp s3://pulsar-media/fotos/orig/".$_GET['tombo'].".jpg $orig";
		shell_exec($cmd);
	}
	if(!file_exists($orig)) {
?>
<script>
alert('Tombo <?php echo $_GET['tombo']?> não presente no <?php echo $fotosalta?>');
</script>
<?php 
	}
}

if(isset($_GET['noautor'])) {
?>
<script>
alert('Tombo <?php echo $_GET['noautor']?> não é de sua autoria!');
</script>
<?php 
}
?>
