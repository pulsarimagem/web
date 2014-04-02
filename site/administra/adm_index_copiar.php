<?php require_once('Connections/pulsar.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<?php
$return = "adm_index_inc.php";
if (isset($_GET['return'])) {
	$return=$_GET['return'];
}
$action="copiar";
if (isset($_GET['action'])) {
	$action=$_GET['action'];
}


if (isset($_POST['copiar'])) {
	$action="copiar";
	if (isset($_POST['action'])) {
		$action=$_POST['action'];
	}
?>
<script>
<?php
	if($action == "copiar_tema") {
		$colname_dados_foto = (get_magic_quotes_gpc()) ? $_POST['copiar'] : addslashes($_POST['copiar']);
		$is_copiar = true;
		mysql_select_db($database_pulsar, $pulsar);
		$query_temas = sprintf("SELECT   Fotos.tombo,  super_temas.Tema_total,  super_temas.Id,  rel_fotos_temas.id_rel FROM Fotos INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto) INNER JOIN super_temas ON (rel_fotos_temas.id_tema=super_temas.Id) WHERE   (Fotos.tombo = '%s') ORDER BY  super_temas.Tema_total",$colname_dados_foto);
		$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
		$totalRows_temas = mysql_num_rows($temas);
//		$row_temas = mysql_fetch_assoc($temas);
	
	//	$colname_dados_foto = (get_magic_quotes_gpc()) ? $_GET['copiar_desc'] : addslashes($_GET['copiar_desc']);
	//	$is_copiar = true;
		mysql_select_db($database_pulsar, $pulsar);
		$query_descritore = sprintf("SELECT    Fotos.tombo,   pal_chave.Id,   pal_chave.Pal_Chave,  rel_fotos_pal_ch.id_rel FROM  rel_fotos_pal_ch  INNER JOIN Fotos ON (rel_fotos_pal_ch.id_foto=Fotos.Id_Foto)  INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave) WHERE   (Fotos.tombo = '%s') ORDER BY pal_chave.Pal_Chave",$colname_dados_foto);
		$descritore = mysql_query($query_descritore, $pulsar) or die(mysql_error());
//		$totalRows_descritore = mysql_num_rows($descritore);
		
		while ($row_temas = mysql_fetch_assoc($temas)) {
?>
			self.opener.atualizar('<?php echo addslashes($row_temas['Tema_total'])?>','<?php echo $row_temas['Id']?>');
<?php
		}
		while ($row_descritore = mysql_fetch_assoc($descritore)) {
?>
			self.opener.atualizar2('<?php echo addslashes($row_descritore['Pal_Chave'])?>','<?php echo $row_descritore['Id']?>');
<?php 
		}
	} 
	else {
?>
		self.opener.location = '<?php echo $return;?>?tombo=<?php echo $_POST['tombo']; ?>&<?php echo $action?>=<?php echo $_POST['copiar']; ?>';
<?php 
	}
?>
window.close();

</script>
<?php
}
?>
<body onload="document.forms[0].copiar.focus();">
<form id="form1" name="form1" method="post" action="">
  Tombo a ser copiado:
  <label>
  <input name="copiar" type="text" id="copiar" />
  </label>
  <label>
  <input type="submit" name="Submit" value="Copiar"/>
  <input type="hidden" name="action" value="<?php echo $action;?>"/>
  </label>
  <input name="tombo" type="hidden" id="tombo" value="<?php echo $_GET['tombo']; ?>"/>
</form>
</body>
</html>
