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
mysql_select_db($database_pulsar, $pulsar);
$query_log = "SELECT    log_download.id_log,   log_download.arquivo,   log_download.data_hora,   log_download.ip,   cadastro.nome,   cadastro.email,   cadastro.login,   cadastro.telefone,   cadastro.empresa FROM  log_download  INNER JOIN cadastro ON (log_download.id_login=cadastro.id_cadastro) ORDER BY log_download.id_log  DESC";
$log = mysql_query($query_log, $pulsar) or die(mysql_error());
$row_log = mysql_fetch_assoc($log);
$totalRows_log = mysql_num_rows($log);

function makeStamp($theString) {
  if (ereg("([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})", $theString, $strReg)) {
    $theStamp = mktime($strReg[4],$strReg[5],$strReg[6],$strReg[2],$strReg[3],$strReg[1]);
  } else if (ereg("([0-9]{4})-([0-9]{2})-([0-9]{2})", $theString, $strReg)) {
    $theStamp = mktime(0,0,0,$strReg[2],$strReg[3],$strReg[1]);
  } else if (ereg("([0-9]{2}):([0-9]{2}):([0-9]{2})", $theString, $strReg)) {
    $theStamp = mktime($strReg[1],$strReg[2],$strReg[3],0,0,0);
  }
  return $theStamp;
}

function makeDateTime($theString, $theFormat) {
  $theDate=date($theFormat, makeStamp($theString));
  return $theDate;
} 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Administra&ccedil;&atilde;o - ftp</title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FFFFFF;
}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style32 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body>
<table width="100%"  border="0" cellpadding="5" cellspacing="0" bgcolor="#FF9900">
   <tr>
     <td><span class="style1">pulsarimagens.com.br<br>
ftp - log download </span></td>
		 <TD class=style27>
        <DIV align=right>
          <INPUT onclick="MM_goToURL('parent','adm_ftp.php');return document.MM_returnValue" type=button value="Menu FTP" name=Button>
      </DIV></TD>
   </tr>
</table>
<br>
<br>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <?php do { ?>
    <tr>
      <td><span class="style32"><?php echo $row_log['id_log']; ?></span></td>
      <td><span class="style32"><?php echo $row_log['arquivo']; ?></span></td>
      <td><span class="style32"><?php echo makeDateTime($row_log['data_hora'], 'd/m/y'); ?>-<?php echo makeDateTime($row_log['data_hora'], 'H:i:s'); ?></span></td>
      <td><span class="style32"><?php echo $row_log['ip']; ?></span></td>
      <td><span class="style32"><?php echo $row_log['nome']; ?></span></td>
      <td><span class="style32"><?php echo $row_log['email']; ?></span></td>
      <td><span class="style32"><?php echo $row_log['login']; ?></span></td>
      <td><span class="style32"><?php echo $row_log['telefone']; ?>&nbsp;</span></td>
      <td><span class="style32"><?php echo $row_log['empresa']; ?>&nbsp;</span></td>
    </tr>
    <?php } while ($row_log = mysql_fetch_assoc($log)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($log);

{
mysql_free_result($login);
}
?>
