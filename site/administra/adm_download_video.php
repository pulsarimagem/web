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

// ----

$colname_arquivos = "-1";
if (isset($_POST['id_login'])) {
  $colname_arquivos = (get_magic_quotes_gpc()) ? $_POST['id_login'] : addslashes($_POST['id_login']);
}
if (isset($_POST['periodo'])) {
  $colname_arquivos = (get_magic_quotes_gpc()) ? $_POST['periodo'] : addslashes($_POST['periodo']);
}

mysql_select_db($database_pulsar, $pulsar);
if (isset($_POST['periodo'])) {
//	$query_arquivos = sprintf("SELECT * FROM log_download2 WHERE date_format(data_hora, '%%m/%%Y') = '%s' GROUP BY arquivo, EXTRACT(DAY FROM data_hora) order by data_hora desc", $colname_arquivos);
//	$query_arquivos = sprintf("SELECT * FROM log_download2,cadastro WHERE date_format(data_hora, '%%m/%%Y') = '%s' and cadastro.id_cadastro = log_download2.id_login GROUP BY arquivo, EXTRACT(DAY FROM data_hora) order by usuario", $colname_arquivos);
// Sem group by
	$query_arquivos = sprintf("SELECT * FROM log_download2,cadastro WHERE date_format(data_hora, '%%m/%%Y') = '%s' and cadastro.id_cadastro = log_download2.id_login and arquivo  RLIKE '^[A-Z]' GROUP BY arquivo,projeto,EXTRACT(DAY FROM data_hora) order by usuario", $colname_arquivos);
} else {
//	$query_arquivos = sprintf("SELECT * FROM log_download2 WHERE id_login = '%s' GROUP BY arquivo, EXTRACT(DAY FROM data_hora) order by data_hora desc", $colname_arquivos);
// Sem group by
	$query_arquivos = sprintf("SELECT * FROM log_download2 WHERE id_login = '%s' and arquivo  RLIKE '^[A-Z]' GROUP BY arquivo,projeto,EXTRACT(DAY FROM data_hora) order by data_hora desc", $colname_arquivos);
}

if (isset($_POST['alterando'])) {
$query_altera = "UPDATE cadastro SET limite = '".$_POST['limite']."' WHERE id_cadastro = ".$_POST['id_login'];
$ResultAlt = mysql_query($query_altera, $pulsar) or die(mysql_error());
//echo 'trocou...';
}

$arquivos = mysql_query($query_arquivos, $pulsar) or die(mysql_error());
$row_arquivos = mysql_fetch_assoc($arquivos);
$totalRows_arquivos = mysql_num_rows($arquivos);

$query_periodo = "SELECT date_format(data_hora,'%m/%Y') as mes_ano FROM log_download2 group by mes_ano order by data_hora desc";
$periodo = mysql_query($query_periodo, $pulsar) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

$periodo1 = $row_periodo['mes_ano'];
$row_periodo = mysql_fetch_assoc($periodo);
$periodo2 = $row_periodo['mes_ano'];

$periodo_tabela1 =  substr($periodo1,3,4).substr($periodo1,0,2);
$periodo_tabela2 = substr($periodo2,3,4).substr($periodo2,0,2);

$query_tabela1 = "SELECT
count(data_hora) as total,
sum(faturado) as faturados,
nome,
empresa,
arquivo
 FROM
(SELECT
  cadastro.nome,
  cadastro.empresa,
  log_download2.arquivo,
  log_download2.data_hora,
  log_download2.faturado
FROM
  cadastro
  INNER JOIN log_download2 ON (cadastro.id_cadastro = log_download2.id_login)
WHERE	
 EXTRACT(YEAR_MONTH FROM data_hora) = '".$periodo_tabela1."'
		and arquivo  RLIKE '^[A-Z]'  
 GROUP BY arquivo,projeto,EXTRACT(DAY FROM data_hora)
) AS TABELAO
GROUP BY nome";
//GROUP BY   arquivo, nome

$tabela1 = mysql_query($query_tabela1, $pulsar) or die(mysql_error());
$row_tabela1 = mysql_fetch_assoc($tabela1);
$totalRows_tabela1 = mysql_num_rows($tabela1);

$query_tabela2 = "SELECT
count(data_hora) as total,
sum(faturado) as faturados,
nome,
empresa,
arquivo
 FROM
(SELECT
  cadastro.nome,
  cadastro.empresa,
  log_download2.arquivo,
  log_download2.data_hora,
  log_download2.faturado
FROM
  cadastro
  INNER JOIN log_download2 ON (cadastro.id_cadastro = log_download2.id_login)
WHERE
 EXTRACT(YEAR_MONTH FROM data_hora) = '".$periodo_tabela2."' 
			and arquivo  RLIKE '^[A-Z]' 
 GROUP BY arquivo,projeto,EXTRACT(DAY FROM data_hora)
) AS TABELAO
GROUP BY nome";
//GROUP BY   arquivo, nome
$tabela2 = mysql_query($query_tabela2, $pulsar) or die(mysql_error());
$row_tabela2 = mysql_fetch_assoc($tabela2);
$totalRows_tabela2 = mysql_num_rows($tabela2);

function DoFormatNumber($theObject,$NumDigitsAfterDecimal,$DecimalSeparator,$GroupDigits) { 
	$currencyFormat=number_format($theObject,$NumDigitsAfterDecimal,$DecimalSeparator,$GroupDigits);
	return ($currencyFormat);
}

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

mysql_select_db($database_pulsar, $pulsar);
$query_diretorios = "SELECT * FROM cadastro WHERE download RLIKE 'V' ORDER BY cadastro.nome";
$diretorios = mysql_query($query_diretorios, $pulsar) or die(mysql_error());
$row_diretorios = mysql_fetch_assoc($diretorios);
$totalRows_diretorios = mysql_num_rows($diretorios);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Relat&oacute;rio de Download</title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FFFFFF;
}
.style4 {
	color: #000000;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
}
.style5 {color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.style7 {
	color: #FF0000;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body>
<table width="100%"  border="0" cellpadding="5" cellspacing="0" bgcolor="#FF9900">
   <tr>
     <td class="style1">pulsarimagens.com.br<br>
         tela do administrador</td>
		 <TD class=style27>
        <DIV align=right>
          <INPUT onclick="MM_goToURL('parent','administra2.php');return document.MM_returnValue" type=button value="Menu Principal" name=Button>
      </DIV></TD>
   </tr>
</table>
<br>
<form name="form1" method="post" action="">
  <span class="style4">Usu&aacute;rios autorizados:</span> 
  <select name="id_login" id="id_login">
  <option value="-1">--- TODOS ---</option>
    <?php
do {  
?>
    <option value="<?php echo $row_diretorios['id_cadastro']?>"<?php if (isset($_POST['id_login']) && !(strcmp($row_diretorios['id_cadastro'], $_POST['id_login']))) {$limite = $row_diretorios['limite']; echo "selected=\"selected\"";} ?>><?php echo $row_diretorios['nome']?> / <?php echo $row_diretorios['empresa']?></option>
    <?php
} while ($row_diretorios = mysql_fetch_assoc($diretorios));
  $rows = mysql_num_rows($diretorios);
  if($rows > 0) {
      mysql_data_seek($diretorios, 0);
	  $row_diretorios = mysql_fetch_assoc($diretorios);
  }
?>
  </select>
  <input type="submit" name="Submit" value="confirma">
  <input name="Submit2" type="button" onClick="MM_openBrWindow('adm_down_pesq.php','','width=700,height=500')" value="cadastrar novo">
</form>

<form name="form2" method="post" action="">
  <span class="style4">Per&iacute;odo do download:</span> 
  <select name="periodo" id="periodo">
    <?php
do {  
?>
    <option value="<?php echo $row_periodo['mes_ano']; ?>"<?php if (isset($_POST['periodo']) && !(strcmp($row_periodo['mes_ano'], $_POST['periodo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_periodo['mes_ano']?></option>
    <?php
} while ($row_periodo = mysql_fetch_assoc($periodo));
?>
  </select>
  <input type="submit" name="Submit" value="consultar">
</form>
<?php
if (! (isset($_POST['id_login']) or isset($_POST['periodo']))  || ($colname_arquivos == "-1")) { ?>
<span class="style5">Mês Atual: </span>
<table width="750" border="0">
  <tr class="style5">
    <td bgcolor="#CCCCCC">Nome</td>
    <td bgcolor="#CCCCCC">Empresa</td>
    <td bgcolor="#CCCCCC"><div align="center">Downloads</div></td>
    <td bgcolor="#CCCCCC"><div align="center">Faturados</div></td>
  </tr>
<?php	   do { ?>
  <tr class="style4">
    <td class="style4"><?php echo $row_tabela1['nome']; ?>&nbsp;</td>
    <td class="style4"><?php echo $row_tabela1['empresa']; ?>&nbsp;</td>
    <td class="style4"><div align="center"><?php echo $row_tabela1['total']; ?>&nbsp;</div></td>
    <td class="style4"><div align="center"><?php echo $row_tabela1['faturados']; ?>&nbsp;</div></td>
  </tr>
<?php } while ($row_tabela1 = mysql_fetch_assoc($tabela1));  ?>
  <tr class="style5">
    <td colspan="2" bgcolor="#CCCCCC">Total:</td>
    <td bgcolor="#CCCCCC"><div align="center"></div></td>
    <td bgcolor="#CCCCCC"><div align="center"></div></td>
  </tr>
</table>
<br />
<span class="style5">Mês Anterior: </span>
<table width="750" border="0">
  <tr class="style5">
    <td bgcolor="#CCCCCC">Nome</td>
    <td bgcolor="#CCCCCC">Empresa</td>
    <td bgcolor="#CCCCCC"><div align="center">Downloads</div></td>
    <td bgcolor="#CCCCCC"><div align="center">Faturados</div></td>
  </tr>
<?php	   do { ?>
  <tr class="style4">
    <td class="style4"><?php echo $row_tabela2['nome']; ?>&nbsp;</td>
    <td class="style4"><?php echo $row_tabela2['empresa']; ?>&nbsp;</td>
    <td class="style4"><div align="center"><?php echo $row_tabela2['total']; ?>&nbsp;</div></td>
    <td class="style4"><div align="center"><?php echo $row_tabela2['faturados']; ?></div></td>
  </tr>
<?php } while ($row_tabela2 = mysql_fetch_assoc($tabela2));  ?>
  <tr class="style5">
    <td colspan="2" bgcolor="#CCCCCC">Total:</td>
    <td bgcolor="#CCCCCC"><div align="center"></div></td>
    <td bgcolor="#CCCCCC"><div align="center"></div></td>
  </tr>
</table>

<?php } ?>

  <?php if (isset($_POST['id_login'])) { ?>
<form name="altera" method="post" >
<span class="style5">Limite di&aacute;rio:
<input name="limite" type="text" id="limite" value="<?php echo $limite; ?>" size="5" maxlength="3"> 
</span>
<input type="submit" name="alterar" id="alterar" value="Alterar">
<input type="hidden" name="id_login" value="<?php echo $_POST['id_login']; ?>">
<input type="hidden" name="alterando" value="1">
<br>
</form>
<?php
if ($totalRows_arquivos > 0) { // Show if recordset not empty ?>
    <span class="style5">Arquivos retirados:</span><br>
    <br>
    <table width="550" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td bgcolor="#CCCCCC" class="style5"><div align="center">Tombo</div></td>
        <td bgcolor="#CCCCCC" class="style5"><div align="center">Data Retirada </div></td>
        <td bgcolor="#CCCCCC" class="style5"><div align="center">Usu&aacute;rio </div></td>
        <td bgcolor="#CCCCCC" class="style5"><div align="center">IP</div></td>
      </tr>
      <?php
	  
 	  $mes = makeDateTime($row_arquivos['data_hora'], 'm/Y');
	  $contador = 0;

	   do {
	   if ($mes != makeDateTime($row_arquivos['data_hora'], 'm/Y')) {
	
		  ?>
        <tr>
            <td colspan="4" bgcolor="#CCCCCC" class="style5"><div align="left"><a href="#" onClick="MM_openBrWindow('adm_down_misc.php?id_login=<?php echo $colname_arquivos ;?>&data=<?php echo $mes; ?>','','')">Total de downloads do m&ecirc;s <?php echo $mes; ?>: <?php echo $contador;?></a></div></td>
         </tr>
	   <?php
	   
  	 	  $mes = makeDateTime($row_arquivos['data_hora'], 'm/Y');

		  $contador = 0;
	   }	   
	   ?>
      <tr>
        <td class="style4"><div align="center"><?php echo $row_arquivos['arquivo']; ?></div></td>
        <td class="style4"><div align="center"><?php echo makeDateTime($row_arquivos['data_hora'], 'd/m/y'); ?>-<?php echo makeDateTime($row_arquivos['data_hora'], 'H:i:s'); ?></div></td>
        <td class="style4"><div align="center"><?php echo $row_arquivos['usuario']; ?></div></td>
        <form name="delete" action="adm_ftp2.php" method="post" >
		<td class="style4"><div align="center"><?php echo $row_arquivos['ip']; ?></div>
        <input name="id_login" type="hidden" id="id_login" value="<?php echo $_POST['id_login']; ?>"></td></form>
      </tr>
        <?php 	   $contador = $contador + 1;
} while ($row_arquivos = mysql_fetch_assoc($arquivos)); ?>
      <tr>
         <td colspan="4" bgcolor="#CCCCCC" class="style5"><div align="left"><a href="#"onClick="MM_openBrWindow('adm_down_misc.php?id_login=<?php echo $colname_arquivos ;?>&data=<?php echo $mes; ?>','','')">Total de downloads do m&ecirc;s <?php echo $mes; ?>: <?php echo $contador;?></a></div></td>
      </tr>
</table>
<?php } else { ?>
	<span class="style7">Sem arquivos retirados!!! </span><?php }; ?>
	<br>
	<br>
<?php }; ?>


  <?php if (isset($_POST['periodo']) ) { ?>
<br>
<?php
if ($totalRows_arquivos > 0) { // Show if recordset not empty ?>
    <span class="style5">Arquivos retirados:</span><br>
    <br>
    <table width="700" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td bgcolor="#CCCCCC" class="style5"><div align="center">Tombo</div></td>
        <td bgcolor="#CCCCCC" class="style5"><div align="center">Data Retirada </div></td>
        <td bgcolor="#CCCCCC" class="style5"><div align="center">Usu&aacute;rio</div></td>
        <td bgcolor="#CCCCCC" class="style5"><div align="center">Empresa</div></td>
        <td bgcolor="#CCCCCC" class="style4">&nbsp;</td>
      </tr>
      <?php
	  
 	  $mes = makeDateTime($row_arquivos['data_hora'], 'm/Y');
	  $contador = 0;

	   do {
	   if ($mes != makeDateTime($row_arquivos['data_hora'], 'm/Y')) {
	
		  ?>
        <tr>
            <td colspan="4" bgcolor="#CCCCCC" class="style5"><div align="left"><a href="#" onClick="MM_openBrWindow('adm_down_misc.php?id_login=<?php echo $colname_arquivos ;?>&data=<?php echo $mes; ?>','','')">Total de downloads do m&ecirc;s <?php echo $mes; ?>: <?php echo $contador;?></a></div></td>
         </tr>
	   <?php
	   
  	 	  $mes = makeDateTime($row_arquivos['data_hora'], 'm/Y');

		  $contador = 0;
	   }	   
	   ?>
      <tr>
        <td class="style4"><div align="center"><?php echo $row_arquivos['arquivo']; ?></div></td>
        <td class="style4"><div align="center"><?php echo makeDateTime($row_arquivos['data_hora'], 'd/m/y'); ?>-<?php echo makeDateTime($row_arquivos['data_hora'], 'H:i:s'); ?></div></td>
        <td class="style4"><div align="center"><?php echo $row_arquivos['usuario']; ?></div></td>
        <td class="style4"><div align="center"><?php echo $row_arquivos['empresa']; ?></div></td>
        <form name="delete" action="adm_ftp2.php" method="post" >
		<td>
        <input name="id_login" type="hidden" id="id_login" value="<?php echo $_POST['id_login']; ?>">        </td></form>
      </tr>
        <?php 	   $contador = $contador + 1;
} while ($row_arquivos = mysql_fetch_assoc($arquivos)); ?>
      <tr>
         <td colspan="4" bgcolor="#CCCCCC" class="style5"><div align="left"><a href="#" onClick="MM_openBrWindow('adm_down_misc.php?id_login=<?php echo $colname_arquivos ;?>&data=<?php echo $mes; ?>','','')">Total de downloads do m&ecirc;s <?php echo $mes; ?>: <?php echo $contador;?></a></div></td>
      </tr>
</table>
<?php } else { ?>
	<span class="style7">Sem arquivos retirados!!! </span><?php }; ?>
	<br>
	<br>
<?php }; ?>
</body>
</html>
<?php
mysql_free_result($diretorios);

mysql_free_result($arquivos);

mysql_free_result($periodo);

mysql_free_result($login);
?>
