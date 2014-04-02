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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE temas SET Tema=%s, Tema_en=%s WHERE Id=%s",
                       GetSQLValueString($_POST['tema'], "text"),
                       GetSQLValueString($_POST['tema_en'], "text"),
                       GetSQLValueString($_POST['Id'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());
  
  if (($_POST["Tema_total"])!="") {
  $update2SQL = sprintf("UPDATE super_temas SET Tema_total=%s, Tema_total_en=%s WHERE Id=%s",
                       GetSQLValueString($_POST['Tema_total']." - ".$_POST['tema'], "text"),
                       GetSQLValueString($_POST['Tema_total_en']." - ".$_POST['tema_en'], "text"),
                       GetSQLValueString($_POST['Id'], "int"));
	} else {
  $update2SQL = sprintf("UPDATE super_temas SET Tema_total=%s, Tema_total_en=%s WHERE Id=%s",
                       GetSQLValueString($_POST['tema'], "text"),
                       GetSQLValueString($_POST['tema_en'], "text"),
                       GetSQLValueString($_POST['Id'], "int"));
	}

  mysql_select_db($database_pulsar, $pulsar);
  $Result2 = mysql_query($update2SQL, $pulsar) or die(mysql_error());

?><script>self.opener.document.location.reload(); window.close();</script>
<?php
}

$colname_tema = "-1";
if (isset($_GET['Id'])) {
  $colname_tema = (get_magic_quotes_gpc()) ? $_GET['Id'] : addslashes($_GET['Id']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_tema = sprintf("SELECT * FROM temas WHERE Id = %s", $colname_tema);
$tema = mysql_query($query_tema, $pulsar) or die(mysql_error());
$row_tema = mysql_fetch_assoc($tema);
$totalRows_tema = mysql_num_rows($tema);

$colname_super_temas = "-1";
if (isset($_GET['Pai'])) {
  $colname_super_temas = (get_magic_quotes_gpc()) ? $_GET['Pai'] : addslashes($_GET['Pai']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_super_temas = sprintf("SELECT * FROM super_temas WHERE Id = %s", $colname_super_temas);
$super_temas = mysql_query($query_super_temas, $pulsar) or die(mysql_error());
$row_super_temas = mysql_fetch_assoc($super_temas);
$totalRows_super_temas = mysql_num_rows($super_temas);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style>
</head>

<body>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <span class="style1">Tema:</span> 
  <input name="tema" type="text" id="tema" value="<?php echo $row_tema['Tema']; ?>" size="50" />
  <input type="submit" name="Submit" value="Atualizar" /><br />
  <span class="style3">Ingl&ecirc;s:</span>
  <input name="tema_en" type="text" id="tema_en" value="<?php echo $row_tema['Tema_en']; ?>" size="50" />
  <input name="Id" type="hidden" id="Id" value="<?php echo $row_tema['Id']; ?>" />
  <input name="Tema_total" type="hidden" id="Tema_total" value="<?php echo $row_super_temas['Tema_total']; ?>" />
  <input name="Tema_total_en" type="hidden" id="Tema_total_en" value="<?php echo $row_super_temas['Tema_total_en']; ?>" />
  <input type="hidden" name="MM_update" value="form1">
</form>
</body>
</html>
<?php
mysql_free_result($tema);

mysql_free_result($super_temas);
?>
