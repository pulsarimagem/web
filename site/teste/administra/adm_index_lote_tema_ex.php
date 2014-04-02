<?php require_once('Connections/pulsar.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "administra.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
$colname_login = "0";
if (isset($_SESSION['MM_Username'])) {
  $colname_login = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_login = sprintf("SELECT * FROM usuarios WHERE login like '%s'", $colname_login);
$login = mysql_query($query_login, $pulsar) or die(mysql_error());
$row_login = mysql_fetch_assoc($login);
$totalRows_login = mysql_num_rows($login);

?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && ($_POST["Id1"] > 0)) {
  $insertSQL = sprintf("DELETE FROM rel_fotos_temas WHERE id_tema = %s AND id_foto in (SELECT Id_Foto from Fotos where tombo in (%s))",
  					   GetSQLValueString($_POST['Id1'], "int"),
                       str_replace("\\","",$_POST['tombo']));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
//  echo $insertSQL;
  $insert_msg = "Excluido! <br>";
  
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
?>
<script language="JavaScript" type="text/JavaScript">
self.opener.location.reload();</script>
<?php
//self.opener.history.go(-1);
//window.close();
//</script>
}

mysql_select_db($database_pulsar, $pulsar);
$query_temas = "SELECT * FROM super_temas ORDER BY Tema_total ASC";
$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
$row_temas = mysql_fetch_assoc($temas);
$totalRows_temas = mysql_num_rows($temas);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Excluir Tema em Lote</title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10pt;
}
-->
</style>
<script type="text/javascript">
<!--
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
function carrega() {
	var max = window.opener.document.form3.vai.length;
	var commax = 0;
	var tombos = '';
	if (max) {
		for (var idx = 0; idx < max; idx++) {
		if (eval("window.opener.document.form3.vai[" + idx + "].checked") == true) {
			if (commax == 1) {
				tombos += ',';
				}
			tombos += '"'+eval("window.opener.document.form3.vai[" + idx + "].value")+'"';
			commax = 1;
			}
		}
	} else {
		tombos +='"'+eval("window.opener.document.form3.vai.value")+'"';
	}
	document.form2.tombo.value = tombos;

	return
}
//-->
</script>
</head>
<body onLoad="MM_callJS('carrega()');">
<form action="<?php echo $editFormAction; ?>" method="POST" name="form2" class="style1">
<?php echo $insert_msg;?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="60" class="style1">Excluir:</td>
    <td><select name="Id1" class="style1" id="Id1">
      <?php
$cTemas = "<option value=0>--- EM BRANCO ---</option>\n";
do {  

    $cTemas .= "<option value=".$row_temas['Id'].">".$row_temas['Tema_total']."</option>\n";

} while ($row_temas = mysql_fetch_assoc($temas));
  echo $cTemas;
  $rows = mysql_num_rows($temas);
  if($rows > 0) {
      mysql_data_seek($temas, 0);
	  $row_temas = mysql_fetch_assoc($temas);
  }
?>
        </select></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <input type="submit" name="Submit" value="Ok" >
    </div></td>
    </tr>
</table>
<br />
<br /> 
  <input name="tombo" type="hidden" id="tombo" value="">
  <input type="hidden" name="MM_insert" value="form1">
  <br>
</form>
</body>
</html>
<?php
mysql_free_result($temas);
?>
