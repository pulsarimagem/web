<?php require_once('Connections/pulsar.php'); ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST['destino'])) {
  $colname_palavra2 = (get_magic_quotes_gpc()) ? $_POST['destino'] : addslashes($_POST['destino']);
  mysql_select_db($database_pulsar, $pulsar);
  $query_palavra2 = sprintf("SELECT * FROM pal_chave WHERE BINARY pal_chave = '%s'", $colname_palavra2);
  $palavra2 = mysql_query($query_palavra2, $pulsar) or die(mysql_error());
  $row_palavra2 = mysql_fetch_assoc($palavra2);
  $totalRows_palavra2 = mysql_num_rows($palavra2);
}
if ($totalRows_palavra2 > 0) {
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE rel_fotos_pal_ch SET id_palavra_chave=%s WHERE BINARY id_palavra_chave=%s",
                       GetSQLValueString($row_palavra2['Id'], "int"),
					   GetSQLValueString($_POST['id_antigo'], "int"));
  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());
  };
?>
<script language="JavaScript" type="text/JavaScript">
self.opener.location.href="adm_palavras.php?inicial=<?php echo $_GET['inicial'] ?>&pageNum_palavra_chave=<?php echo $_GET['pageNum_palavra_chave'] ?>";window.close();
</script>
<?php 
}

$colname_palavra = "1";
if (isset($_GET['Id'])) {
  $colname_palavra = (get_magic_quotes_gpc()) ? $_GET['Id'] : addslashes($_GET['Id']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_palavra = sprintf("SELECT * FROM pal_chave WHERE Id = %s", $colname_palavra);
$palavra = mysql_query($query_palavra, $pulsar) or die(mysql_error());
$row_palavra = mysql_fetch_assoc($palavra);
$totalRows_palavra = mysql_num_rows($palavra);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10pt;
}
-->
</style>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="style1">
Copiar cromos para:
<input name="destino" type="text" id="destino" size="50">
  <input name="id_antigo" type="hidden" id="id_antigo" value="<?php echo $row_palavra['Id']; ?>">
  <input type="submit" name="Submit" value="Ok">
  <input type="hidden" name="MM_update" value="form1">
  <br>
  <?php if (($totalRows_palavra2 == 0) and (isset($_POST['destino']))) { // Show if recordset empty ?>
  DESTINO N&Atilde;O ENCONTRADO - DIGITE NOVAMENTE.
  <?php } // Show if recordset empty ?>
</form>
</body>
</html>
<?php
mysql_free_result($palavra);
if (isset($_GET['destino'])) {
mysql_free_result($palavra2);
}
?>
