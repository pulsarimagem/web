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
$colname_cotacao = "-1";
if (isset($_GET['id_cotacao2'])) {
  $colname_cotacao = (get_magic_quotes_gpc()) ? $_GET['id_cotacao2'] : addslashes($_GET['id_cotacao2']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_cotacao = sprintf("SELECT    cotacao_2.id_cotacao2,   cadastro.nome,   cotacao_2.distribuicao,   cotacao_2.descricao_uso,   cotacao_2.data_hora,   cotacao_2.atendida,   cotacao_2.data_hora_atendida,   cotacao_2.mensagem,   cotacao_2.respondida_por,   cadastro.empresa,   cadastro.email,   cadastro.telefone FROM  cotacao_2  LEFT OUTER JOIN cadastro ON (cotacao_2.id_cadastro=cadastro.id_cadastro) WHERE id_cotacao2 = %s", $colname_cotacao);
$cotacao = mysql_query($query_cotacao, $pulsar) or die(mysql_error());
$row_cotacao = mysql_fetch_assoc($cotacao);
$totalRows_cotacao = mysql_num_rows($cotacao);

$colname_Recordset1 = "-1";
if (isset($_GET['id_cotacao2'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_GET['id_cotacao2'] : addslashes($_GET['id_cotacao2']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_Recordset1 = sprintf("SELECT * FROM cotacao_cromos WHERE id_cotacao2 = %s ORDER BY tombo ASC", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $pulsar) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cota&ccedil;&atilde;o</title>
<style type="text/css">
<!--
.style2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
-->
</style>
</head>

<body>
<table width="700" border="1">
  <tr>
    <td class="style3">Nome:</td>
    <td><span class="style2"><?php echo $row_cotacao['nome']; ?></span></td>
  </tr>
  <tr>
    <td><span class="style3">Empresa:</span></td>
    <td><span class="style2"><?php echo $row_cotacao['empresa']; ?></span></td>
  </tr>
  <tr>
    <td><span class="style3">Email:</span></td>
    <td><span class="style2"><?php echo $row_cotacao['email']; ?></span></td>
  </tr>
  <tr>
    <td><span class="style3">Telefone:</span></td>
    <td><span class="style2"><?php echo $row_cotacao['telefone']; ?></span></td>
  </tr>
  <tr>
    <td><span class="style3">Data de recebimento: </span></td>
    <td><span class="style2"><?php echo $row_cotacao['data_hora']; ?></span></td>
  </tr>
  <tr>
    <td><span class="style3">Distribui&ccedil;&atilde;o:</span></td>
    <td><span class="style2"><?php echo $row_cotacao['distribuicao']; ?></span></td>
  </tr>
  <tr>
    <td><span class="style3">Descri&ccedil;&atilde;o do uso: </span></td>
    <td><span class="style2"><?php echo $row_cotacao['descricao_uso']; ?></span></td>
  </tr>
  <tr>
    <td><span class="style3">Atendida por: </span></td>
    <td><span class="style2"><?php echo $row_cotacao['atendida']; ?> em <?php echo $row_cotacao['data_hora']; ?></span></td>
  </tr>
  <tr>
    <td><span class="style3">Mensagem:</span></td>
    <td><span class="style2"><?php echo $row_cotacao['mensagem']; ?>&nbsp;</span></td>
  </tr>
</table>
<br />
<br />
<table width="200" border="0" cellspacing="2" cellpadding="0">
  <?php do { ?>
    <tr>
      <td><img src="http://www.pulsarimagens.com.br/bancoImagens/<?php echo $row_Recordset1['tombo']; ?>p.jpg" /><br />
          <span class="style2"><?php echo $row_Recordset1['tombo']; ?></span><br />
        <br /></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($cotacao);

mysql_free_result($Recordset1);
?>
