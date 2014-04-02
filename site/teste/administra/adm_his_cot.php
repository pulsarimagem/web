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

$colname_ordem = "data_hora DESC";
if (isset($_GET['ordem'])) {
  $colname_ordem = (get_magic_quotes_gpc()) ? $_GET['ordem'] : addslashes($_GET['ordem']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_atendidas = sprintf("SELECT    cotacao_2.id_cotacao2,   cadastro.nome,   cadastro.empresa,   cotacao_2.data_hora,   cotacao_2.data_hora_atendida FROM  cotacao_2  INNER JOIN cadastro ON (cotacao_2.id_cadastro=cadastro.id_cadastro) WHERE  cotacao_2.atendida = 1 ORDER BY %s",$colname_ordem);
$atendidas = mysql_query($query_atendidas, $pulsar) or die(mysql_error());
$row_atendidas = mysql_fetch_assoc($atendidas);
$totalRows_atendidas = mysql_num_rows($atendidas);

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
<title>Cotacoes - Historico</title>
<style type="text/css">
<!--
.style18 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style25 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #FFFFFF; }
.style27 {FONT-WEIGHT: bold; COLOR: #ffffff; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif
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
      <TD class="style27">pulsarimagens.com.br<BR>
        cota&ccedil;&atilde;o</TD>
      <TD class=style27>
        <DIV align=right>
          <INPUT onclick="MM_goToURL('parent','administra2.php');return document.MM_returnValue" type=button value="Menu Principal" name=Button>
      </DIV></TD>
    </TR>
  </TBODY>
</TABLE>
<br>

<a href="adm_cotacao.php" class="style18"><strong>Voltar para cota&ccedil;&otilde;es</strong></a><br>
<br>
<span class="style18">Organizar por:</span>
  <select name="organizar" onChange="MM_jumpMenu('parent',this,0)">
    <option value="adm_his_cot.php?ordem=data_hora%20DESC" <?php if (!(strcmp("data_hora DESC", $_GET['ordem']))) {echo "selected=\"selected\"";} ?>>Data de recebimento</option>
    <option value="adm_his_cot.php?ordem=nome" <?php if (!(strcmp("nome", $_GET['ordem']))) {echo "selected=\"selected\"";} ?>>Cliente</option>
    <option value="adm_his_cot.php?ordem=empresa" <?php if (!(strcmp("empresa", $_GET['ordem']))) {echo "selected=\"selected\"";} ?>>Empresa</option>
    <option value="adm_his_cot.php?ordem=data_hora_atendida%20DESC" <?php if (!(strcmp("data_hora_atendida DESC", $_GET['ordem']))) {echo "selected=\"selected\"";} ?>>Data de resposta</option>
  </select>
<br>
<br>
<table width="700" border="1" cellspacing="0" cellpadding="3">
  <tr bgcolor="#999999">
    <td width="86" class="style25"><div align="center">Data de recebimento</div></td>
    <td width="245" class="style25">Cliente</td>
    <td width="245" class="style25">Empresa</td>
    <td width="90" class="style25"><div align="center">Data de resposta </div></td>
  </tr>
  <?php if ($totalRows_atendidas > 0) { // Show if recordset not empty ?>
  <?php do { ?>
  <tr>
    <td class="style18"><div align="center"><?php echo makeDateTime($row_atendidas['data_hora'], 'd/m/Y'); ?><br>
        <?php echo makeDateTime($row_atendidas['data_hora'], 'H:i:s'); ?> </div></td>
    <td class="style18"><a href="adm_his_det.php?id_cotacao2=<?php echo $row_atendidas['id_cotacao2']; ?>" target="_blank"><strong><?php echo $row_atendidas['nome']; ?></strong></a></td>
    <td class="style18"><?php echo $row_atendidas['empresa']; ?>&nbsp;</td>
    <td class="style18"><div align="center"><?php echo makeDateTime($row_atendidas['data_hora_atendida'], 'd/m/Y'); ?><br>
      <?php echo makeDateTime($row_atendidas['data_hora_atendida'], 'H:i:s'); ?>    </div></td>
  </tr>
  <?php } while ($row_atendidas = mysql_fetch_assoc($atendidas)); ?>
  <?php } // Show if recordset not empty ?>
</table>
<br>
<br> 
<input name="Submit" type="submit" onClick="MM_goToURL('parent','adm_cotacao.php');return document.MM_returnValue" value="Voltar p/Cota&ccedil;&otilde;es">
</body>
</html>
<?php
mysql_free_result($atendidas);
?>


