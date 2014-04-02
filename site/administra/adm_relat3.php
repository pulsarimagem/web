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
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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
}
?>
<?php
$colname_pcs1 = "2006-01-01";
if (isset($_POST['data1'])) {
  $colname_pcs1 = (get_magic_quotes_gpc()) ? $_POST['data1'] : addslashes($_POST['data1']);
}
$colname_pcs2 = "2020-12-31";
if (isset($_POST['data2'])) {
  $colname_pcs2 = (get_magic_quotes_gpc()) ? $_POST['data2'] : addslashes($_POST['data2']);
}

mysql_select_db($database_pulsar, $pulsar);
$query_pcs = sprintf("SELECT 
  pesquisa_tema.tema,
  super_temas.Tema_total,
  round(avg(pesquisa_tema.retorno)) as med_retorno,
  max(pesquisa_tema.retorno) as retorno,
  count(pesquisa_tema.id_tm) as total
FROM
 pesquisa_tema
 INNER JOIN super_temas ON (pesquisa_tema.tema=super_temas.Id)
WHERE
  pesquisa_tema.datahora >= %s AND
  pesquisa_tema.datahora <= %s
GROUP BY
  pesquisa_tema.tema
ORDER BY
  total DESC", GetSQLValueString($colname_pcs1, "date"), GetSQLValueString($colname_pcs2, "date"));
$pcs = mysql_query($query_pcs, $pulsar) or die(mysql_error());
$row_pcs = mysql_fetch_assoc($pcs);
$totalRows_pcs = mysql_num_rows($pcs);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>administra&ccedil;&atilde;o - estat&iacute;sticas</title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FFFFFF;
}
a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #000000;
}
a:visited {
	color: #000000;
	text-decoration: none;
}
a:hover {
	color: #000000;
	text-decoration: underline;
}
a:active {
	color: #000000;
	text-decoration: none;
}
a:link {
	text-decoration: none;
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
//-->
</script>
<link rel="stylesheet" type="text/css" href="epoch_styles.css" />
<script type="text/javascript" src="epoch_classes.js"></script>
<script type="text/javascript">
/*You can also place this code in a separate file and link to it like epoch_classes.js*/
	var dp_cal1,dp_cal2;      
window.onload = function () {
	dp_cal1  = new Epoch('cal1','popup',document.getElementById('data1'));
	dp_cal2  = new Epoch('cal2','popup',document.getElementById('data2'));
};
</script>
</head>

<body>
<table width="100%"  border="0" cellpadding="5" cellspacing="0" bgcolor="#FF9900">
   <tr>
     <td class="style1">pulsarimagens.com.br<br>
         pesquisas</td>
     <td><div align="right">
       <input name="Button" type="button" onClick="MM_goToURL('parent','adm_relat.php');return document.MM_returnValue" value="Menu Estat&iacute;sticas">
     </div></td>
   </tr>
</table>
<form name="form1" method="post" action="">
Per&iacute;odo: de
<label>
<input name="data1" type="text" id="data1" value="<?php echo $_POST['data1']; ?>">
</label>
a
<label>
<input name="data2" type="text" id="data2" value="<?php echo $_POST['data2']; ?>">
</label>
<label>
<input type="submit" name="Submit" value="Consultar">
</label>
</form>
<p><strong>Temas </strong></p>
<table width="720" border="1">
  <tr>
    <td>Tema</td>
    <td><div align="center">Retornos med (m&aacute;x)</div></td>
    <td><div align="center">Total de Pesquisas</div></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_pcs['Tema_total']; ?></td>
      <td><div align="center">&nbsp;<?php echo $row_pcs['med_retorno'].' ('.$row_pcs['retorno'].')'; ?></div></td>
      <td><div align="center">&nbsp;<?php echo $row_pcs['total']; ?></div></td>
    </tr>
    <?php } while ($row_pcs = mysql_fetch_assoc($pcs)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($pcs);

mysql_free_result($login);
?>
