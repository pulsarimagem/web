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

$to      = $_POST['to'] . "\n";
$subject = $_POST['subject'];
if (1==2) {
$subject = $subject."<br><strong>Atenção: utilize o login e senha abaixo.<br><br>Login:"."<br>Senha:"."</stong><br>";
}
$subject = $subject."\n";
$message = '
<html>
<head>
<title>:: Pulsar Imagens ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body topmargin="0">
<table width="534" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="1" background="http://www.pulsarimagens.com.br/images/mail_pontilhado_03.gif"><img src="images/spacer.gif" width="1" align="absmiddle"> </td>
    <td width="532"><table width="530" border="0" align="center" cellpadding="0" cellspacing="0" class="borda_tabela">
      <tr>
        <td colspan="3">
          <table width="520"  border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td background="http://www.pulsarimagens.com.br/images/mail_barra_logo.gif"><a href="http://www.pulsarimagens.com.br/" target="_blank"><img src="http://www.pulsarimagens.com.br/images/header_03.gif" width="225" height="61" border="0"></a></td>
            </tr>
            <tr>
              <td width="540" height="10"><img src="http://www.pulsarimagens.com.br/images/mail_barra_escura.gif" width="100%" height="10"></td>
            </tr>
          </table>
          <br>
          <div align="center">
            <table width="500" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><div align="left">
                  <font face="Verdana, Arial, Helvetica, sans-serif" color="#48493F" size="1">
                      <br>
                        '.stripslashes( $_POST['FCKeditor1'] ).'</font><br><br>
                         <font face="Verdana, Arial, Helvetica, sans-serif" color="#999999" size="1">www.pulsarimagens.com.br<br>
pulsar@pulsarimagens.com.br
</font></div></td>
              </tr>
            </table>
          </div>
          <br>
          <table width="530" align="center" cellpadding="00" cellspacing="0">
            <tr>
              <td width="430" height="41" background="http://www.pulsarimagens.com.br/images/mail_copyright_44.gif" >
			  
			    <table width="400" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="200" nowrap><font face="Verdana, Arial, Helvetica, sans-serif" color="#ffffff" size="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contato: 55 (11) 3875-0101 </font></td>
                  <td width="200"><font face="Verdana, Arial, Helvetica, sans-serif" color="#ffffff" size="1"><a href="mailto:pulsar@pulsarimagens.com.br"><img src="http://www.pulsarimagens.com.br/images/mail_endereco.gif" width="176" height="20" border="0"></a></font></td>
                </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="1" background="http://www.pulsarimagens.com.br/images/mail_pontilhado_03.gif"><img src="images/spacer.gif" width="1" align="absmiddle"></td>
  </tr>
</table>
<br>
</body>
</html>

';
$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: Pulsar Imagens <".($_POST["responder"]).">\n";
//$headers .= "Bcc: ".($_POST["responder"])."\n";
//$headers .= "Bcc: FTP <ftp@pulsarimagens.com.br>\n";
$headers .= "Return-Path: ".($_POST["responder"])."\n";

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
      ftp - email </TD>
      <TD class=style1><DIV align=right>
          <INPUT onclick="window.close();" type=button value="Menu ftp" name=Button>
      </DIV></TD>
    </TR>
  </TBODY>
</TABLE>
<br> 
<span class="style2">Email enviado com sucesso!!!!
</span>
</body>
</html>
