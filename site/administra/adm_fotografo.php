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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_inc")) {
	$trocar = (isset($_POST['trocar'])?1:0);
	
  $insertSQL = sprintf("INSERT INTO fotografos (Nome_Fotografo, Iniciais_Fotografo, senha, trocar_senha, email) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['iniciais'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($trocar, "int"),
                       GetSQLValueString($_POST['email'], "text"));
                       
  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
  
  $data = file_get_contents($cloud_server.'create_ftp_user.php?user='.$_POST['iniciais'].'&pass='.$_POST['senha']);
  
}

if ((isset($_POST["MM_alter"])) && ($_POST["MM_alter"] == "form_alt")) {
	$trocar = (isset($_POST['trocar'])?1:0);
	
  $insertSQL = sprintf("UPDATE fotografos SET Nome_Fotografo=%s, Iniciais_Fotografo=%s, senha=%s, trocar_senha=%s, email=%s WHERE id_fotografo=%s",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['iniciais'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($trocar, "int"),
                       GetSQLValueString($_POST['email'], "text"),
  					   GetSQLValueString($_POST['id_fotografo'], "int"));
                       
  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
  
  $data = file_get_contents($cloud_server.'create_ftp_user.php?user='.$_POST['iniciais'].'&pass='.$_POST['senha'].'&change=true');
  
?>
<script language="JavaScript" type="text/JavaScript">
self.opener.location.reload();
window.close();
</script>
<?php 
}

if ((isset($_POST['del_fotografo'])) && ($_POST['del_fotografo'] != "")) {
  $deleteSQL = sprintf("DELETE FROM fotografos WHERE id_fotografo=%s",
                       GetSQLValueString($_POST['del_fotografo'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());

  $deleteSQL = sprintf("DELETE FROM Fotos WHERE id_autor=%s",
                       GetSQLValueString($_POST['del_fotografo'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
}

$alterar = false;
if ((isset($_GET['id_fotografo'])) && ($_GET['id_fotografo'] != "")) {
	$alterar = true;
}

mysql_select_db($database_pulsar, $pulsar);
$query_fotografos = "SELECT * FROM fotografos";
if ($alterar) {
	$query_fotografos .= " WHERE id_fotografo = ".$_GET['id_fotografo'];
}
$query_fotografos .= " ORDER BY Nome_Fotografo ASC";
$fotografos = mysql_query($query_fotografos, $pulsar) or die(mysql_error());
$row_fotografos = mysql_fetch_assoc($fotografos);
$totalRows_fotografos = mysql_num_rows($fotografos);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Administra&ccedil;&atilde;o de Fot&oacute;grafos</title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FFFFFF;
}
.style12 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style17 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #FFFFFF; font-weight: bold; }
.linhao {
	border-top-width: thin;
	border-right-width: thin;
	border-bottom-width: thin;
	border-left-width: thin;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: none;
	border-top-color: #000000;
	border-right-color: #000000;
	border-bottom-color: #000000;
	border-left-color: #000000;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
// Nannette Thacker http://www.shiningstar.net
function confirmSubmit()
{
var agree=confirm("Confirma exclusão do fotógrafo?");
if (agree)
	return true ;
else
	return false ;
}
//-->
</script>
</head>

<body>
<table width="100%"  border="0" cellpadding="5" cellspacing="0" bgcolor="#FF9900">
   <tr>
     <td><span class="style1">pulsarimagens.com.br<br>
Administra&ccedil;&atilde;o de Fot&oacute;grafos </span></td>
        <td class="style1"><div align="right">
       <input name="Button" type="button" onClick="MM_goToURL('parent','administra2.php');return document.MM_returnValue" value="Menu Principal">
     </div></td>
   </tr>
</table>
<br>
<table width="600" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#333333">
    <td><span class="style17">Nome do Fot&oacute;grafo </span></td>
    <td><div align="center"><span class="style17">Iniciais</span></div></td>
    <td><div align="center"><span class="style17">Senha</span></div></td>
    <td><div align="center"><span class="style17">Trocar Senha?</span></div></td>
    <td><div align="center"><span class="style17">Email</span></div></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <?php do { ?>
  <tr>
    <td height="22" class="linhao"><span class="style12"><?php echo $nome = $row_fotografos['Nome_Fotografo']; ?></span></td>
    <td height="22" class="linhao"><div align="center"><span class="style12"><?php echo $inicial = $row_fotografos['Iniciais_Fotografo']; ?></span></div></td>
    <td height="22" class="linhao"><div align="center"><span class="style12"><?php echo $senha = $row_fotografos['senha']; ?></span></div></td>
    <td height="22" class="linhao"><div align="center"><span class="style12"><?php echo $trocar = ($row_fotografos['trocar_senha'] == 1? "Sim":"Não"); ?></span></div></td>
    <td height="22" class="linhao"><div align="center"><span class="style12"><?php echo $email = $row_fotografos['email']; ?></span></div></td>
    <td height="22" class="linhao"><div align="right"><span class="style12">
<?php  $id = $row_fotografos['id_fotografo']; 
	if(!$alterar) {?>
    <input name="Button" type="button" class="style12" onClick="MM_openBrWindow('adm_fotografo.php?id_fotografo=<?php echo $id?>','','width=800,height=200')" value="Alterar">
<?php }?>
        </span>
        <span class="style12">
    </span></div></td><form name="form_exc" method="post" action="">
    <td height="22" class="linhao">        
<div align="right"><span class="style12">
    </span>
        <span class="style12">        </span>
          <span class="style12">
<?php if(!$alterar) {?>
          <input name="Submit" type="submit" class="style12" value="Excluir" onclick="return confirmSubmit()">
<?php }?>
          <input name="del_fotografo" type="hidden" id="del_fotografo" value="<?php echo $row_fotografos['id_fotografo']; ?>">
          </span>
        </div>        
</td></form>
  </tr>
  <?php //echo $data = file_get_contents($cloud_server.'create_ftp_user.php?user='.$row_fotografos['Iniciais_Fotografo'].'&pass='.$row_fotografos['senha']);?>
  <?php //echo $data = file_get_contents($cloud_server.'create_ftp_user.php?user='.$row_fotografos['Iniciais_Fotografo'].'&pass='.$row_fotografos['senha'].'&change=true');?>
  <?php } while ($row_fotografos = mysql_fetch_assoc($fotografos)); ?>
  <form name="form_inc" method="POST" action="<?php echo $editFormAction; ?>">
  <tr>
    <td><input name="nome" type="text" id="nome" size="50" <?php if ($alterar) echo "value='".$nome."'"?>></td>
    <td><div align="center">
      <input name="iniciais" type="text" id="iniciais" size="5" <?php if ($alterar) echo "value='".$inicial."'"?>>
    </div></td>
    <td><div align="center">
      <input name="senha" type="text" id="senha" size="15" <?php if ($alterar) echo "value='".$senha."'"?>>
    </div></td>
    <td><div align="center">
      <input name="trocar" type="checkbox" id="trocar" size="5" <?php if ($alterar) echo ($trocar=="Sim"?"Checked":"")?>>
    </div></td>
    <td><div align="center">
      <input name="email" type="text" id="email" size="15" <?php if ($alterar) echo "value='".$email."'"?>>
    </div></td>
    <td colspan="2">
        <div align="center">
<?php if ($alterar)  { ?>
          <input name="Submit" type="submit" class="style12" value="Alterar">
      </div></td><input type="hidden" name="MM_alter" value="form_alt">
      <input type="hidden" name="id_fotografo" value="<?php echo $id;?>">
<?php } else { ?>       
          <input name="Submit" type="submit" class="style12" value="Incluir">
      </div></td><input type="hidden" name="MM_insert" value="form_inc">
<?php }?>         
  </tr>
  </form>
</table>
<form name="form1" method="post" action="">
</form>
</body>
</html>
<?php
mysql_free_result($fotografos);
?>
