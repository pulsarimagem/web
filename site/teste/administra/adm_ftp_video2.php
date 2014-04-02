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
/*
include("../toolkit/inc_IPTC4.php");

$file = $_POST['tombo'].'.jpg';
$source_file = '/var/fotos_alta/'.$file; 
$dest_file = $homeftp.$_POST['diretorio'].'/'.$file; 

if (!copy($source_file, $dest_file)) {
	$file = $_POST['tombo'].'.JPG';
	$source_file = '/var/fotos_alta/'.$file; 
	$dest_file = $homeftp.$_POST['diretorio'].'/'.$file; 
	if (!copy($source_file, $dest_file)) {
		$erro = "nok";
	} else {
		$erro = "ok";
		$fp = fopen($dest_file, "r");
		$s_array=fstat($fp);
		$tamanho = $s_array["size"];
		fclose($fp); 
	}
} else {
	$erro = "ok";
	$fp = fopen($dest_file, "r");
	$s_array=fstat($fp);
	$tamanho = $s_array["size"];
	fclose($fp); 
}

coloca_iptc($_POST['tombo'], $dest_file, $database_pulsar, $pulsar);
*/
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

$insertSQL = sprintf("INSERT INTO ftp_arquivos (id_ftp, data_cria,nome,tamanho,validade,observacoes,flag) VALUES (%s,%s,%s,%s,%s,%s,%s)",
			GetSQLValueString($_POST['diretorio'], "int"),
			GetSQLValueString(date("Y-m-d h:i:s", strtotime('now')), "date"),
			GetSQLValueString($_POST["tombo"], "text"),
			GetSQLValueString(0, "long"),
			GetSQLValueString($_POST["validade"], "int"),
			GetSQLValueString($_POST["observacoes"], "text"),
			GetSQLValueString("VH", "text")
);

mysql_select_db($database_pulsar, $pulsar);
$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

$insertSQL = sprintf("INSERT INTO log_download2 (arquivo, data_hora, ip, id_login, usuario, projeto, formato, uso, obs) VALUES ('%s','%s','%s',%s,'%s','%s','%s','%s','%s')",
		$file,
		date("Y-m-d h:i:s", strtotime('now')),
		"FTP",
		$_POST['diretorio'],
		$row_login['login'],
		$_POST['titulo'],
		$_POST['tamanho'],
		$_POST['uso'],
		$_POST['observacoes']
);
mysql_select_db($database_pulsar, $pulsar);
//	echo $insertSQL;
$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error())


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Copiar arquivos</title>
</head>
<script>
self.opener.document.form1.submit();
window.close();
</script>
<body>

</body>

</html>
