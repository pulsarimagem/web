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
$query_ftps = "SELECT cadastro.login,   cadastro.id_cadastro,   cadastro.email, cadastro.nome, cadastro.temporario FROM ftp  INNER JOIN cadastro ON (ftp.id_login=cadastro.id_cadastro)";
$ftps = mysql_query($query_ftps, $pulsar) or die(mysql_error());
$row_ftps = mysql_fetch_assoc($ftps);
$totalRows_ftps = mysql_num_rows($ftps);

mysql_select_db($database_pulsar, $pulsar);
$query_emails = "SELECT * FROM usuarios";
$emails = mysql_query($query_emails, $pulsar) or die(mysql_error());
$row_emails = mysql_fetch_assoc($emails);
$totalRows_emails = mysql_num_rows($emails);

if (isset($_GET['to'])) {
  $colname_to = (get_magic_quotes_gpc()) ? $_GET['to'] : addslashes($_GET['to']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_to = sprintf("SELECT * FROM cadastro WHERE id_cadastro = %s", $colname_to);
$to = mysql_query($query_to, $pulsar) or die(mysql_error());
$row_to = mysql_fetch_assoc($to);
$totalRows_to = mysql_num_rows($to);
?>
<?php include("FCKeditor/fckeditor.php"); ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!-- saved from url=(0080)http://www.pulsarimagens.com.br/adm_det_cot.php?id_cadastro=00000000000000000020 -->
<HTML><HEAD><TITLE>FTP - Email</TITLE>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<STYLE type=text/css>
.style1 {
	FONT-WEIGHT: bold; COLOR: #ffffff; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif
}
.style4 {
	FONT-SIZE: 12px; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif
}
.style6 {
	FONT-WEIGHT: bold; FONT-SIZE: 12px; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif
}
</STYLE>

<META content="MSHTML 6.00.2800.1491" name=GENERATOR>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</HEAD>
<BODY>
<span class="style6">Enviar Email:</span>
<br>
<br>
<form name="form1" method="post" action="adm_ftp_email2.php">
<table width="700" border="1" cellpadding="3" cellspacing="0" bordercolor="#666666">
  <tr>
    <td class="style4">Enviado por :</td>
    <td><select name="responder" id="responder">
      <?php
do {  
?>
      <option value="<?php echo $row_emails['email']?>"<?php if (!(strcmp($row_emails['email'], $_SESSION['MM_Username']))) {echo "selected=\"selected\"";} ?>><?php echo $row_emails['login']?> - <?php echo $row_emails['email']?></option>
      <?php
} while ($row_emails = mysql_fetch_assoc($emails));
  $rows = mysql_num_rows($emails);
  if($rows > 0) {
      mysql_data_seek($emails, 0);
	  $row_emails = mysql_fetch_assoc($emails);
  }
?>
    </select>
      <input name="to" type="hidden" id="to" value="<?php echo $row_to['email']?>"></td>
  </tr>
  <tr>
    <td width="187" class="style4">Assunto da mensagem:</td>
    <td width="495"><input name="subject" type="text" id="subject" size="30">    </td>
  </tr>
  <tr>
    <td class="style4">Mensagem:</td>
    <td><?php
$oFCKeditor = new FCKeditor('FCKeditor1') ;
$oFCKeditor->BasePath = '/FCKeditor/';
$oFCKeditor->Value = '<br><br>Suas imagens já estão disponíveis em nosso FTP.<br><br>Para acessa-las basta seguir estes passos:<br><br>1. Clique no link <a href="http://www.pulsarimagens.com.br/login_ftp">http://www.pulsarimagens.com.br/login_ftp</a>  ou copie-o e cole no campo de endereço de seu navegador de internet. <br>2. Use seu login e senha cadastrados em nosso site para ter acesso à sua área de FTP. <br>3. Baixe e salve em seu computador as imagens solicitadas.<br><br> Todas as informações de identificação estão no site ou no File Info do Photoshop.<br>Seus arquivos estarão disponíveis por um prazo de 15 dias a partir da data deste e-mail.<br><br>Caso encontre alguma dificuldade, por favor entre em contato.<br><br><br>Obrigado.<br><br>Equipe Pulsar Imagens.<br>';
$oFCKeditor->Create() ;
	?><br>
      <font face="Verdana, Arial, Helvetica, sans-serif" color="#48493F" size="1">Pulsar Imagens<br>
        </font> <font face="Verdana, Arial, Helvetica, sans-serif" color="#999999" size="1">www.pulsarimagens.com.br<br>
      pulsar@pulsarimagens.com.br</font></td></tr>
  <tr>
    <td colspan="2"><div align="center">      
      <p><br>
          <input type="submit" name="Submit" value="Enviar">    
          <br>
          <br>
      </p>
    </div></td>
  </tr>
</table>
</form>
</BODY>
</HTML>
<?php
mysql_free_result($ftps);

mysql_free_result($emails);

mysql_free_result($to);
?>