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
if (isset($_POST['id_cotacao2'])) {
  $updateSQL = "UPDATE cotacao_2 SET atendida = 1, data_hora_atendida = '".date("Y-m-d H:i:s", strtotime('now'))."' WHERE id_cotacao2 = ".$_POST['id_cotacao2'];

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());
}
?>
<?php
mysql_select_db($database_pulsar, $pulsar);
$query_pendentes = "SELECT    cotacao_2.id_cotacao2,   cotacao_2.id_cadastro,   cotacao_2.distribuicao,   cotacao_2.descricao_uso,   cotacao_2.data_hora,   cotacao_2.atendida,   cadastro.nome,   cadastro.empresa,   count(cotacao_cromos.id_cromo) AS total_cromos FROM  cotacao_2  LEFT OUTER JOIN cadastro ON (cotacao_2.id_cadastro=cadastro.id_cadastro)  LEFT OUTER JOIN cotacao_cromos ON (cotacao_2.id_cotacao2=cotacao_cromos.id_cotacao2) WHERE cotacao_2.atendida=0 GROUP BY   cotacao_2.id_cotacao2,   cotacao_2.id_cadastro,   cotacao_2.distribuicao,   cotacao_2.descricao_uso,   cotacao_2.data_hora,   cotacao_2.atendida,   cadastro.nome,   cadastro.empresa";
$pendentes = mysql_query($query_pendentes, $pulsar) or die(mysql_error());
$row_pendentes = mysql_fetch_assoc($pendentes);
$totalRows_pendentes = mysql_num_rows($pendentes);

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

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>
</head>

<body>
<TABLE cellSpacing=0 cellPadding=5 width="100%" bgColor=#ff9900 border=0>
  <TBODY>
    <TR>
      <TD><SPAN class=style27>pulsarimagens.com.br<BR>
        cota&ccedil;&atilde;o</SPAN></TD>
      <TD class=style27>
        <DIV align=right>
          <INPUT onclick="MM_goToURL('parent','administra2.php');return document.MM_returnValue" type=button value="Menu Principal" name=Button>
      </DIV></TD>
    </TR>
  </TBODY>
</TABLE>
<br>
<span class="style29">Pendentes</span><br>
<br>
<table width="700" border="1" cellpadding="3" cellspacing="0" bordercolor="#666666">
  <tr bgcolor="#999999">
    <td width="20">&nbsp;</td>
    <td width="74" class="style25"><div align="center">Data</div></td>
    <td width="255"><span class="style25">Cliente</span></td>
    <td width="253"><span class="style25">Empresa</span></td>
    <td width="56"><span class="style25">Cromos </span></td>
  </tr>
  <?php if ($totalRows_pendentes > 0) { // Show if recordset not empty ?>
      <?php do { ?>
      <tr>
        <form name="form<?php echo $row_pendentes['id_cotacao2']; ?>" method="post" action="">
          <td>
            <input name="checkbox" type="checkbox" onClick="MM_callJS('document.form<?php echo $row_pendentes['id_cotacao2']; ?>.submit();')" value="checkbox">
            <input name="id_cotacao2" type="hidden" id="id_cotacao2" value="<?php echo $row_pendentes['id_cotacao2']; ?>">
          <input name="MM_Update" type="hidden" id="MM_Update" value="True"></td>
        </form>
        <td class="style18"><div align="center"><?php echo makeDateTime($row_pendentes['data_hora'], 'd-m-Y'); ?><br>
          <?php echo makeDateTime($row_pendentes['data_hora'], 'H:i:s'); ?> </div></td>
        <td class="style18"><strong><a href="adm_det_cot.php?id_cotacao2=<?php echo $row_pendentes['id_cotacao2']; ?>"><?php echo $row_pendentes['nome']; ?></a></strong></td>
        <td class="style18"><?php echo $row_pendentes['empresa']; ?>&nbsp;</td>
        <td class="style18"><div align="center"><?php echo $row_pendentes['total_cromos']; ?></div></td>
      </tr>
      <?php } while ($row_pendentes = mysql_fetch_assoc($pendentes)); ?>
  <?php } // Show if recordset not empty ?>
</table>
<br>

<br>
<input name="Submit" type="submit" onClick="MM_goToURL('parent','adm_his_cot.php');return document.MM_returnValue" value="Ver Hist&oacute;rico">
<br>
</body>
</html>
<?php
mysql_free_result($pendentes);
?>


