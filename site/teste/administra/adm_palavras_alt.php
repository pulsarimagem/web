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
  $updateSQL = sprintf("UPDATE pal_chave SET Pal_Chave=%s WHERE Id=%s",
                       GetSQLValueString($_POST['textfield'], "text"),
                       GetSQLValueString($_POST['hiddenField'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());?>
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
Alterar:
<input name="textfield" type="text" value="<?php echo $row_palavra['Pal_Chave']; ?>" size="50">
  <input name="hiddenField" type="hidden" value="<?php echo $row_palavra['Id']; ?>">
  <input type="submit" name="Submit" value="Ok">
  <input type="hidden" name="MM_update" value="form1">
</form>
</body>
</html>
<?php
mysql_free_result($palavra);
?>
