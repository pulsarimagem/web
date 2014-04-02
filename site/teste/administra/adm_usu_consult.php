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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE usuarios SET login=%s, senha=%s, index_inc=%s, index_alt=%s, index_del=%s, temas=%s, pal_chave=%s, home=%s, ensaios=%s, cotacao=%s, cad_clientes=%s, cad_usuarios=%s, fotografos=%s, ftp=%s, enviar_msg=%s, rel_download=%s, download=%s, relatorios=%s, email=%s WHERE id_user=%s",
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
                       GetSQLValueString(isset($_POST['download']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['relatorios']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['id_login'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());
}

$colname_usuarios = "0";
if (isset($_GET['id_usuario'])) {
  $colname_usuarios = (get_magic_quotes_gpc()) ? $_GET['id_usuario'] : addslashes($_GET['id_usuario']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_usuarios = sprintf("SELECT * FROM usuarios WHERE id_user = %s", $colname_usuarios);
$usuarios = mysql_query($query_usuarios, $pulsar) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);

mysql_select_db($database_pulsar, $pulsar);
$query_lista_users = "SELECT id_user, login FROM usuarios ORDER BY login ASC";
$lista_users = mysql_query($query_lista_users, $pulsar) or die(mysql_error());
$row_lista_users = mysql_fetch_assoc($lista_users);
$totalRows_lista_users = mysql_num_rows($lista_users);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>cadastro de usu&aacute;rios</title>
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

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
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

<form name="form2">
  <span class="style18">Selecione o usu&aacute;rio: </span>
  <select name="menu1" onChange="MM_jumpMenu('parent',this,0)">
    <option value="">Selecione um Usuário</option>
    <?php
do {  
?>
    <option value="adm_usu_consult.php?id_usuario=<?php echo $row_lista_users['id_user']?>"><?php echo $row_lista_users['login']?></option>
    <?php
} while ($row_lista_users = mysql_fetch_assoc($lista_users));
  $rows = mysql_num_rows($lista_users);
  if($rows > 0) {
      mysql_data_seek($lista_users, 0);
	  $row_lista_users = mysql_fetch_assoc($lista_users);
  }
?>
  </select>
</form>
<?php if ($totalRows_usuarios > 0) { // Show if recordset not empty ?>
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <span class="style18">
  <input name="id_login" type="hidden" id="id_login" value="<?php echo $row_usuarios['id_user']; ?>">
  Login: 
  <input name="login" type="text" id="login" value="<?php echo $row_usuarios['login']; ?>">
  <br>
  <br>
  Senha: 
  <input name="senha" type="text" id="senha" value="<?php echo $row_usuarios['senha']; ?>">
  <br>
  <br>
  Email: 
  <input name="email" type="text" id="email" value="<?php echo $row_usuarios['email']; ?>">
  <br>
  <br>
  Autoriza&ccedil;&otilde;es:<br>
  </span>
  <table width="308" border="1" cellpadding="3" cellspacing="0" bordercolor="#666666">
    <tr>
      <td width="20"><input <?php if (!(strcmp($row_usuarios['index_inc'],1))) {echo "checked";} ?> name="index_inc" type="checkbox" id="index_inc" value="1"></td>
      <td width="270" class="style18"><div align="center">Indexa&ccedil;&atilde;o - Incluir </div></td>
    </tr>
    <tr>
      <td><input <?php if (!(strcmp($row_usuarios['index_alt'],1))) {echo "checked";} ?> name="index_alt" type="checkbox" id="index_alt" value="1"></td>
      <td class="style18"><div align="center">Indexa&ccedil;&atilde;o - Alterar</div></td>
    </tr>
    <tr>
      <td><input <?php if (!(strcmp($row_usuarios['index_del'],1))) {echo "checked";} ?> name="index_del" type="checkbox" id="index_del" value="1"></td>
      <td class="style18"><div align="center">Indexa&ccedil;&atilde;o - Excluir</div></td>
    </tr>
    <tr>
      <td><input <?php if (!(strcmp($row_usuarios['temas'],1))) {echo "checked";} ?> name="temas" type="checkbox" id="temas" value="1"></td>
      <td class="style18"><div align="center">Temas</div></td>
    </tr>
    <tr>
      <td><input <?php if (!(strcmp($row_usuarios['pal_chave'],1))) {echo "checked";} ?> name="pal_chave" type="checkbox" id="pal_chave" value="1"></td>
      <td class="style18"><div align="center">Palavras-chave</div></td>
    </tr>
    <tr>
      <td><input <?php if (!(strcmp($row_usuarios['home'],1))) {echo "checked";} ?> name="home" type="checkbox" id="home" value="1"></td>
      <td class="style18"><div align="center">Home</div></td>
    </tr>
    <tr>
      <td><input <?php if (!(strcmp($row_usuarios['ensaios'],1))) {echo "checked";} ?> name="ensaios" type="checkbox" id="ensaios" value="1"></td>
      <td class="style18"><div align="center">Ensaios</div></td>
    </tr>
    <tr>
      <td><input <?php if (!(strcmp($row_usuarios['cotacao'],1))) {echo "checked";} ?> name="cotacao" type="checkbox" id="cotacao" value="1"></td>
      <td class="style18"><div align="center">Cota&ccedil;&otilde;es</div></td>
    </tr>
    <tr>
      <td><input <?php if (!(strcmp($row_usuarios['cad_clientes'],1))) {echo "checked";} ?> name="cad_clientes" type="checkbox" id="cad_clientes" value="1"></td>
      <td class="style18"><div align="center">Cadastro de clientes </div></td>
    </tr>
    <tr>
      <td><input <?php if (!(strcmp($row_usuarios['cad_usuarios'],1))) {echo "checked";} ?> name="cad_usuarios" type="checkbox" id="cad_usuarios" value="1"></td>
      <td class="style18"><div align="center">Cadastro de usu&aacute;rios </div></td>
    </tr>
    <tr>
      <td><input <?php if (!(strcmp($row_usuarios['fotografos'],1))) {echo "checked";} ?> name="fotografos" type="checkbox" id="fotografos" value="1"></td>
      <td class="style18"><div align="center">Fotografos</div></td>
    </tr>
    <tr>
      <td><input <?php if (!(strcmp($row_usuarios['ftp'],1))) {echo "checked";} ?> name="ftp" type="checkbox" id="ftp" value="1"></td>
      <td class="style18"><div align="center">FTP</div></td>
    </tr>
    <tr>
      <td><input <?php if (!(strcmp($row_usuarios['enviar_msg'],1))) {echo "checked";} ?> name="enviar_msg" type="checkbox" id="enviar_msg" value="1"></td>
      <td class="style18"><div align="center">Enviar mensagem</div></td>
    </tr>
    <tr>
      <td><input <?php if (!(strcmp($row_usuarios['rel_download'],1))) {echo "checked";} ?> name="rel_download" type="checkbox" id="rel_download" value="1"></td>
      <td class="style18"><div align="center">Relat&oacute;rio de download</div></td>
    </tr>
    <tr>
      <td><input <?php if (!(strcmp($row_usuarios['relatorios'],1))) {echo "checked";} ?> name="relatorios" type="checkbox" id="relatorios" value="1"></td>
      <td class="style18"><div align="center">Relat&oacute;rios</div></td>
    </tr>
    <tr>
      <td><input <?php if (!(strcmp($row_usuarios['download'],1))) {echo "checked";} ?> name="download" type="checkbox" id="download" value="1"></td>
      <td class="style18"><div align="center">Downloads Fotos em Alta</div></td>
    </tr>
  </table>
  <br>
  <input type="submit" name="Submit" value="Alterar">
  <input type="hidden" name="MM_update" value="form1">
</form>
<?php } // Show if recordset not empty ?>
<input type="submit" name="Submit2" value="Excluir">
</body>
</html>
<?php
mysql_free_result($usuarios);

mysql_free_result($lista_users);
?>


