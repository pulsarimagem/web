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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2") && ($_POST['extra'] != "")) {
  $updateSQL = sprintf("UPDATE Fotos_extra SET extra='%s' WHERE tombo IN (%s)",
                       str_replace("\\","",$_POST['extra']),
                       str_replace("\\","",$_POST['tombo']));
	

//echo $updateSQL;
mysql_select_db($database_pulsar, $pulsar);
$Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());
}
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
.style2 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12pt;
	font-weight: bold;
}
-->
</style>
<script type="text/javascript">
<!--
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
function fix_data() {
if (document.form2.data_tela.value.length == 4) {
	document.form2.data.value = document.form2.data_tela.value;
	}
if (document.form2.data_tela.value.length == 7) {
	document.form2.data.value = document.form2.data_tela.value.substring(3,7)+document.form2.data_tela.value.substring(0,2);
	}
if (document.form2.data_tela.value.length == 10) {
	document.form2.data.value = document.form2.data_tela.value.substring(6,10)+document.form2.data_tela.value.substring(3,5)+document.form2.data_tela.value.substring(0,2);
	}

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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="60" class="style1">Novo Assunto Extra:</td>
    <td><span class="style2">
      <input name="extra" type="text" id="extra" value="">
    </span><span class="style2">
      </span>
      <input type="submit" name="Submit" value="Ok" ></td>
  </tr>
</table>
<br />
<br />
  
  <input name="tombo" type="hidden" id="tombo" value="">
  <input type="hidden" name="MM_insert" value="form2">
  <br>
</form>
</body>
</html>
<?php
mysql_free_result($login);
if (isset($_POST["MM_insert"])) {
	if ($siteDebug) {
		echo "<strong>MM_insert: </strong>".$_POST["MM_insert"]."<br>";
		echo "<strong>Data: </strong>".$_POST['data']."<br>";
		echo "<strong>Tombo: </strong>".$_POST['tombo']."<br><br>";
		echo "<strong>QuerySQL: </strong>".$updateSQL."<br>";
	}
	else {
		echo "<script>window.close();</script>";
	}
}
?>

