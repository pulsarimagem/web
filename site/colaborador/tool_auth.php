<?php
session_cache_expire(9999);
//session_start();
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

$MM_restrictGoTo = "login.php";
$MM_trocaGoTo = "alterar_senha.php?first=\"true\"";
if (!((isset($_SESSION['MM_Username_Fotografo'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username_Fotografo'], $_SESSION['MM_UserGroup_Fotografo'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);

  $_SESSION['PrevUrl'] = $_SESSION['this_uri'];
  
  header("Location: ". $MM_restrictGoTo); 
  exit;
} else {
	if (isset($_SESSION['MM_Username_Fotografo'])) {
	  $colname_login = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username_Fotografo'] : addslashes($_SESSION['MM_Username_Fotografo']);
	}
	mysql_select_db($database_pulsar, $pulsar);
	$query_altera_senha = sprintf("SELECT trocar_senha FROM fotografos WHERE Iniciais_Fotografo like '%s'", $colname_login);
	$altera_senha = mysql_query($query_altera_senha, $pulsar) or die(mysql_error());
	$row_altera_senha = mysql_fetch_assoc($altera_senha);
	$totalRows_altera_senha = mysql_num_rows($altera_senha);
	if($row_altera_senha['trocar_senha'] == '1' && !isset($_GET['first']) && !strstr($_SERVER['PHP_SELF'],"alterar_senha.php")) {
		header("Location: ". $MM_trocaGoTo);
	}
}
?>