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
  $updateSQL = sprintf("UPDATE cadastro SET nome=%s, empresa=%s, cargo=%s, cpf_cnpj=%s, endereco=%s, cep=%s, cidade=%s, estado=%s, pais=%s, telefone=%s, email=%s, login=%s, tipo=%s WHERE id_cadastro=%s",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['empresa'], "text"),
                       GetSQLValueString($_POST['cargo'], "text"),
                       GetSQLValueString($_POST['cpf_cnpj'], "text"),
                       GetSQLValueString($_POST['endereco'], "text"),
                       GetSQLValueString($_POST['cep'], "text"),
                       GetSQLValueString($_POST['cidade'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['pais'], "text"),
                       GetSQLValueString($_POST['telefone'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['id_cadastro'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());

  $updateGoTo = "adm_cad_cli.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_cadastro = "-1";
if (isset($_GET['id_cadastro'])) {
  $colname_cadastro = (get_magic_quotes_gpc()) ? $_GET['id_cadastro'] : addslashes($_GET['id_cadastro']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_cadastro = sprintf("SELECT * FROM cadastro WHERE id_cadastro = %s ORDER BY nome ASC", $colname_cadastro);
$cadastro = mysql_query($query_cadastro, $pulsar) or die(mysql_error());
$row_cadastro = mysql_fetch_assoc($cadastro);
$totalRows_cadastro = mysql_num_rows($cadastro);

mysql_select_db($database_pulsar, $pulsar);
$query_estados = "SELECT * FROM Estados";
$estados = mysql_query($query_estados, $pulsar) or die(mysql_error());
$row_estados = mysql_fetch_assoc($estados);
$totalRows_estados = mysql_num_rows($estados);

mysql_select_db($database_pulsar, $pulsar);
$query_paises = "SELECT * FROM paises ORDER BY nome ASC";
$paises = mysql_query($query_paises, $pulsar) or die(mysql_error());
$row_paises = mysql_fetch_assoc($paises);
$totalRows_paises = mysql_num_rows($paises);

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
<br>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>administra&ccedil;&atilde;o</title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FFFFFF;
}
a:link {
	color: #666666;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #666666;
}
a:hover {
	text-decoration: underline;
	color: #666666;
}
a:active {
	text-decoration: none;
	color: #666666;
}
.style36 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 11px; }
.style38 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.linha {
	border-bottom: 1px solid #000000;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
function confirmSubmit()
{
var agree=confirm("Confirma exclusão?");
if (agree)
	document.form1.submit();
else
	return false ;
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
     <td class="style1">pulsarimagens.com.br<br>
     cadastro de clientes - detalhe </td>
	 <td class="style1"><div align="right">
       <input name="Button" type="button" onClick="MM_goToURL('parent','adm_cad_cli.php');return document.MM_returnValue" value="Menu Principal">
     </div></td>
   </tr>
</table><br>
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="600" border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td width="100" class="style36">Login</td>
      <td width="494" class="style38"><input name="login" type="text" id="login" value="<?php echo $row_cadastro['login']; ?>" size="25"></td>
    </tr>
    <tr>
      <td class="style36">Email</td>
      <td class="style38"><input name="email" type="text" id="email" value="<?php echo $row_cadastro['email']; ?>" size="40"></td>
    </tr>
    <tr>
      <td class="style36">Nome</td>
      <td class="style38"><input name="nome" type="text" id="nome" value="<?php echo $row_cadastro['nome']; ?>" size="50"></td>
    </tr>
    <tr>
      <td class="style36">Empresa</td>
      <td class="style38"><input name="empresa" type="text" id="empresa" value="<?php echo $row_cadastro['empresa']; ?>" size="50"></td>
    </tr>
    <tr>
      <td class="style36">Cargo</td>
      <td class="style38"><input name="cargo" type="text" id="cargo" value="<?php echo $row_cadastro['cargo']; ?>" size="50"></td>
    </tr>
    <tr>
      <td class="style36">Telefone</td>
      <td class="style38"><input name="telefone" type="text" id="telefone" value="<?php echo $row_cadastro['telefone']; ?>" size="25"></td>
    </tr>
    <tr>
      <td class="style36">CPF / CNPJ </td>
      <td class="style38"><input name="cpf_cnpj" type="text" id="cpf_cnpj" value="<?php echo $row_cadastro['cpf_cnpj']; ?>" size="30"></td>
    </tr>
    <tr>
      <td class="style36">Endere&ccedil;o</td>
      <td class="style38"><input name="endereco" type="text" id="endereco" value="<?php echo $row_cadastro['endereco']; ?>" size="75"></td>
    </tr>
    <tr>
      <td class="style36">Cidade</td>
      <td class="style38"><input name="cidade" type="text" id="cidade" value="<?php echo $row_cadastro['cidade']; ?>" size="50"></td>
    </tr>
    <tr>
      <td class="style36">Estado</td>
      <td class="style38"><select name="estado" id="estado">
        <?php
do {  
?>
        <option value="<?php echo $row_estados['Sigla']?>"<?php if (!(strcmp($row_estados['Sigla'], $row_cadastro['estado']))) {echo "selected=\"selected\"";} ?>><?php echo $row_estados['Estado']?></option>
        <?php
} while ($row_estados = mysql_fetch_assoc($estados));
  $rows = mysql_num_rows($estados);
  if($rows > 0) {
      mysql_data_seek($estados, 0);
	  $row_estados = mysql_fetch_assoc($estados);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td class="style36">Pa&iacute;s</td>
      <td class="style38"><select name="pais" id="pais">
        <?php
do {  
?>
        <option value="<?php echo $row_paises['id_pais']?>"<?php if (!(strcmp($row_paises['id_pais'], $row_cadastro['pais']))) {echo "selected=\"selected\"";} ?>><?php echo $row_paises['nome']?></option>
        <?php
} while ($row_paises = mysql_fetch_assoc($paises));
  $rows = mysql_num_rows($paises);
  if($rows > 0) {
      mysql_data_seek($paises, 0);
	  $row_paises = mysql_fetch_assoc($paises);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td class="style36">CEP</td>
      <td class="style38"><input name="cep" type="text" id="cep" value="<?php echo $row_cadastro['cep']; ?>" size="10"></td>
    </tr>
    <tr>
      <td class="style36">Tipo</td>
      <td class="style38"><select name="tipo" id="tipo">
        <option value="F" <?php if (!(strcmp("F", $row_cadastro['tipo']))) {echo "selected=\"selected\"";} ?>>Pessoa F&iacute;sica</option>
        <option value="J" <?php if (!(strcmp("J", $row_cadastro['tipo']))) {echo "selected=\"selected\"";} ?>>Pessoa Jur&iacute;dica</option>
      </select></td>
    </tr>
    <tr>
      <td class="style36">Data Cadastro </td>
      <td class="style38"><?php echo makeDateTime($row_cadastro['data_cadastro'], 'd/m/Y'); ?></td>
    </tr>
    <tr>
      <td colspan="2" class="style36"><div align="center">
        <input type="submit" name="Submit" value="Gravar">
        <input name="id_cadastro" type="hidden" id="id_cadastro" value="<?php echo $row_cadastro['id_cadastro']; ?>">
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
</form>
<br>
</body>
</html>
<?php
mysql_free_result($login);

mysql_free_result($cadastro);

mysql_free_result($estados);

mysql_free_result($paises);
?>
