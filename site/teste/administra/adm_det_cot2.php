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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php

$updateSQL = "UPDATE cotacao_2 SET atendida = 1, data_hora_atendida = '".date("Y-m-d H:i:s", strtotime('now'))."',mensagem  = '".stripslashes( $_POST['FCKeditor1'] )."',respondida_por = '".$_POST["responder"]."' WHERE id_cotacao2 = ".$_POST['id_cotacao2'];

mysql_select_db($database_pulsar, $pulsar);
$Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());


$to      = $_POST['to'] . "\n";
$subject = $_POST['subject']."\n";

include('email_cotacao.php');

$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: Pulsar Imagens <".($_POST["responder"])."@pulsarimagens.com.br>\n";
$headers .= "Bcc: ".($_POST["responder"])."@pulsarimagens.com.br\n";
$headers .= "Bcc: Cotacao <cotacao@pulsarimagens.com.br>\n";
$headers .= "Return-Path: ".($_POST["responder"])."@pulsarimagens.com.br\n";

mail($to,$subject,$message,$headers);		
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>cotacao</title>
<style type="text/css">
<!--
.style1 {	FONT-WEIGHT: bold; COLOR: #ffffff; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif
}
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body>
<TABLE cellSpacing=0 cellPadding=5 width="100%" bgColor=#ff9900 border=0>
  <TBODY>
    <TR>
      <TD class="style1">pulsarimagens.com.br<BR>
        cota&ccedil;&atilde;o</TD>
      <TD class=style1><DIV align=right>
          <INPUT onclick="MM_goToURL('parent','adm_cotacao.php');return document.MM_returnValue" type=button value="Menu Cota&ccedil;&atilde;o" name=Button>
      </DIV></TD>
    </TR>
  </TBODY>
</TABLE>
<br> 
<span class="style2">Email enviado com sucesso!!!!
</span>
</body>
</html>
