<?php

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$updateSQL = sprintf("UPDATE texto_inicial SET texto=%s, texto_en=%s WHERE id_texto=%s",
			GetSQLValueString($_POST['texto'], "text"),
			GetSQLValueString($_POST['texto_en'], "text"),
			GetSQLValueString($_POST['id'], "int"));

	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());

	$updateGoTo = "administra2.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_GET['delete'])) && ($_GET['delete'] != "")) {
	$deleteSQL = sprintf("DELETE FROM fotos_homepage WHERE id_foto=%s",
			GetSQLValueString($_GET['delete'], "int"));

	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
	$msg = "Excluído com sucesso!";
}

if ((isset($_POST['tombo'])) && ($_POST['tombo'] != "")) {

	if(strlen($_POST['tombo']) > 4) {
		if(!file_exists($fotosalta.$_POST['tombo'].".jpg") && !file_exists($fotosalta.$_POST['tombo'].".JPG")) {
			?>
	<script>
	alert('Tombo <?php echo $_POST['tombo']?> não presente no <?php echo $fotosalta?>');
	</script>
	<?php 
		}
		else {
		  $insertSQL = sprintf("INSERT INTO fotos_homepage (tombo) VALUES (%s)",
		                       GetSQLValueString($_POST['tombo'], "text"));
		
		  mysql_select_db($database_pulsar, $pulsar);
		  $Result2 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
		  $msg = "Incluído com sucesso!";
		}
	}
}

mysql_select_db($database_pulsar, $pulsar);
$query_texto = "SELECT * FROM texto_inicial";
$texto = mysql_query($query_texto, $pulsar) or die(mysql_error());
$row_texto = mysql_fetch_assoc($texto);
$totalRows_texto = mysql_num_rows($texto);

mysql_select_db($database_pulsar, $pulsar);
$query_fotos = "SELECT    fotos_homepage.id_foto,   fotos_homepage.tombo,   Fotos.assunto_principal FROM  fotos_homepage  INNER JOIN Fotos ON (fotos_homepage.tombo=Fotos.tombo)";
$fotos = mysql_query($query_fotos, $pulsar) or die(mysql_error());
$row_fotos = mysql_fetch_assoc($fotos);
$totalRows_fotos = mysql_num_rows($fotos);

mysql_select_db($database_pulsar, $pulsar);
$query_fotos_home = "SELECT * FROM fotos_homepage order by tombo asc";
$fotos_home = mysql_query($query_fotos_home, $pulsar) or die(mysql_error());
$totalRows_fotos_home = mysql_num_rows($fotos_home);
?>