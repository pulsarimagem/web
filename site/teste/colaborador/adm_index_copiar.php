<?php require_once('Connections/pulsar.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="css.css" rel="stylesheet" type="text/css" />
</head>
<?php
if (isset($_POST['copiar'])) {
?>
<script>
<?php
	$colname_dados_foto = (get_magic_quotes_gpc()) ? $_POST['copiar'] : addslashes($_POST['copiar']);
	$is_copiar = true;
	mysql_select_db($database_pulsar, $pulsar);
	$query_temas = sprintf("SELECT   Fotos.tombo,  super_temas.Tema_total,  super_temas.Id,  rel_fotos_temas.id_rel FROM Fotos INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto) INNER JOIN super_temas ON (rel_fotos_temas.id_tema=super_temas.Id) WHERE   (Fotos.tombo = '%s') ORDER BY  super_temas.Tema_total",$colname_dados_foto);
	$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
	$totalRows_temas = mysql_num_rows($temas);
	
	if($totalRows_temas == 0) {
		$query_temas = sprintf("SELECT   Fotos_tmp.tombo,  super_temas.Tema_total,  super_temas.Id,  rel_fotos_temas_tmp.id_rel FROM Fotos_tmp INNER JOIN rel_fotos_temas_tmp ON (Fotos_tmp.Id_Foto=rel_fotos_temas_tmp.id_foto) INNER JOIN super_temas ON (rel_fotos_temas_tmp.id_tema=super_temas.Id) WHERE   (Fotos_tmp.tombo = '%s') ORDER BY  super_temas.Tema_total",$colname_dados_foto);
		$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
		$totalRows_temas = mysql_num_rows($temas);
	}
//	$row_temas = mysql_fetch_assoc($temas);

	while ($row_temas = mysql_fetch_assoc($temas)) {
?>
		self.opener.atualizar('<?php echo addslashes($row_temas['Tema_total'])?>','<?php echo $row_temas['Id']?>');
<?php
	}
?>
window.close();
</script>
<?php
}
?>
<body onload="document.forms[0].copiar.focus();"><br />
<form id="form1" name="form1" method="post" action="">
  Código a ser copiado:
  <label>
  <input name="copiar" type="text" id="copiar" />
  </label>
  <label>
  <input type="submit" name="Submit" id="button" value="Copiar"/>
  </label>
  <input name="tombo" type="hidden" id="tombo" value="<?php echo $_GET['tombo']; ?>"/>
</form>
</body>
</html>
