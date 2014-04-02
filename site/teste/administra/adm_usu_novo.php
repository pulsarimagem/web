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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO usuarios (login, senha, index_inc, index_alt, index_del, temas, pal_chave, home, ensaios, cotacao, cad_clientes, cad_usuarios, fotografos, ftp, enviar_msg, rel_download, relatorios) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString(isset($_POST['index_inc']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['index_alt']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['index_del']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['temas']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['pal_chave']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['home']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['ensaios']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['cotacao']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['cad_clientes']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['cad_usuarios']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['fotografos']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['ftp']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['enviar_msg']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['rel_download']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['relatorios']) ? "true" : "", "defined","1","0"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Cotacoes</title>
<style type="text/css">
<!--
.style18 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style25 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #FFFFFF; }
.style27 {	FONT-WEIGHT: bold; COLOR: #ffffff; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif
}
a:link {
	color: #000000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: underline;
	color: #000000;
}
a:active {
	text-decoration: none;
	color: #000000;
}
.style29 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
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
      <TD><SPAN class=style27>pulsarimagens.com.br<BR>
        cadastro de usuarios </SPAN></TD>
      <TD class=style27>
        <DIV align=right>
          <INPUT onclick="MM_goToURL('parent','administra2.php');return document.MM_returnValue" type=button value="Menu Principal" name=Button>
      </DIV></TD>
    </TR>
  </TBODY>
</TABLE>
<br>
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
<span class="style18">Login: 
<input name="login" type="text" id="login">
<br>
<br>
Senha: 
<input name="senha" type="text" id="senha">
<br>
<br>

</span><span class="style18">Autoriza&ccedil;&otilde;es:</span><br>

<table width="308" border="1" cellpadding="3" cellspacing="0" bordercolor="#666666">
  <tr>
    <td width="20"><input name="index_inc" type="checkbox" id="index_inc" value="checkbox"></td>
    <td width="270" class="style18"><div align="center">Indexa&ccedil;&atilde;o - Incluir </div></td>
  </tr>
  <tr>
    <td><input name="index_alt" type="checkbox" id="index_alt" value="checkbox"></td>
    <td class="style18"><div align="center">Indexa&ccedil;&atilde;o - Alterar</div></td>
  </tr>
  <tr>
    <td><input name="index_del" type="checkbox" id="index_del" value="checkbox"></td>
    <td class="style18"><div align="center">Indexa&ccedil;&atilde;o - Excluir</div></td>
  </tr>
  <tr>
    <td><input name="temas" type="checkbox" id="temas" value="checkbox"></td>
    <td class="style18"><div align="center">Temas</div></td>
  </tr>
  <tr>
    <td><input name="pal_chave" type="checkbox" id="pal_chave" value="checkbox"></td>
    <td class="style18"><div align="center">Palavras-chave</div></td>
  </tr>
  <tr>
    <td><input name="home" type="checkbox" id="home" value="checkbox"></td>
    <td class="style18"><div align="center">Home</div></td>
  </tr>
  <tr>
    <td><input name="ensaios" type="checkbox" id="ensaios" value="checkbox"></td>
    <td class="style18"><div align="center">Ensaios</div></td>
  </tr>
  <tr>
    <td><input name="cotacao" type="checkbox" id="cotacao" value="checkbox"></td>
    <td class="style18"><div align="center">Cota&ccedil;&otilde;es</div></td>
  </tr>
  <tr>
    <td><input name="cad_clientes" type="checkbox" id="cad_clientes" value="checkbox"></td>
    <td class="style18"><div align="center">Cadastro de clientes </div></td>
  </tr>
  <tr>
    <td><input name="cad_usuarios" type="checkbox" id="cad_usuarios" value="checkbox"></td>
    <td class="style18"><div align="center">Cadastro de usu&aacute;rios </div></td>
  </tr>
  <tr>
    <td><input name="fotografos" type="checkbox" id="fotografos" value="checkbox"></td>
    <td class="style18"><div align="center">Fotografos</div></td>
  </tr>
  <tr>
    <td><input name="ftp" type="checkbox" id="ftp" value="checkbox"></td>
    <td class="style18"><div align="center">FTP</div></td>
  </tr>
  <tr>
    <td><input name="enviar_msg" type="checkbox" id="enviar_msg" value="checkbox"></td>
    <td class="style18"><div align="center">Enviar mensagem</div></td>
  </tr>
  <tr>
    <td><input name="rel_download" type="checkbox" id="rel_download" value="checkbox"></td>
    <td class="style18"><div align="center">Relat&oacute;rio de download</div></td>
  </tr>
  <tr>
    <td><input name="relatorios" type="checkbox" id="relatorios" value="checkbox"></td>
    <td class="style18"><div align="center">Relat&oacute;rios</div></td>
  </tr>
</table>
<br>
<input type="submit" name="Submit" value="Gravar">
<input type="hidden" name="MM_insert" value="form1">
</form>
</body>
</html>


