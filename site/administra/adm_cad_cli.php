<?php
#	BuildNav for Dreamweaver MX v0.2
#              10-02-2002
#	Alessandro Crugnola [TMM]
#	sephiroth: alessandro@sephiroth.it
#	http://www.sephiroth.it
#	
#	Function for navigation build ::
function buildNavigation($pageNum_Recordset1,$totalPages_Recordset1,$prev_Recordset1,$next_Recordset1,$separator=" | ",$max_links=10, $show_page=true)
{
                GLOBAL $maxRows_cadastro,$totalRows_cadastro;
	$pagesArray = ""; $firstArray = ""; $lastArray = "";
	if($max_links<2)$max_links=2;
	if($pageNum_Recordset1<=$totalPages_Recordset1 && $pageNum_Recordset1>=0)
	{
		if ($pageNum_Recordset1 > ceil($max_links/2))
		{
			$fgp = $pageNum_Recordset1 - ceil($max_links/2) > 0 ? $pageNum_Recordset1 - ceil($max_links/2) : 1;
			$egp = $pageNum_Recordset1 + ceil($max_links/2);
			if ($egp >= $totalPages_Recordset1)
			{
				$egp = $totalPages_Recordset1+1;
				$fgp = $totalPages_Recordset1 - ($max_links-1) > 0 ? $totalPages_Recordset1  - ($max_links-1) : 1;
			}
		}
		else {
			$fgp = 0;
			$egp = $totalPages_Recordset1 >= $max_links ? $max_links : $totalPages_Recordset1+1;
		}
		if($totalPages_Recordset1 >= 1) {
			#	------------------------
			#	Searching for $_GET vars
			#	------------------------
			$_get_vars = '';			
			if(!empty($_GET) || !empty($HTTP_GET_VARS)){
				$_GET = empty($_GET) ? $HTTP_GET_VARS : $_GET;
				foreach ($_GET as $_get_name => $_get_value) {
					if ($_get_name != "pageNum_cadastro") {
						$_get_vars .= "&$_get_name=$_get_value";
					}
				}
			}
			$successivo = $pageNum_Recordset1+1;
			$precedente = $pageNum_Recordset1-1;
			$firstArray = ($pageNum_Recordset1 > 0) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_cadastro=$precedente$_get_vars\">$prev_Recordset1</a>" :  "$prev_Recordset1";
			# ----------------------
			# page numbers
			# ----------------------
			for($a = $fgp+1; $a <= $egp; $a++){
				$theNext = $a-1;
				if($show_page)
				{
					$textLink = $a;
				} else {
					$min_l = (($a-1)*$maxRows_cadastro) + 1;
					$max_l = ($a*$maxRows_cadastro >= $totalRows_cadastro) ? $totalRows_cadastro : ($a*$maxRows_cadastro);
					$textLink = "$min_l - $max_l";
				}
				$_ss_k = floor($theNext/26);
				if ($theNext != $pageNum_Recordset1)
				{
					$pagesArray .= "<a href=\"$_SERVER[PHP_SELF]?pageNum_cadastro=$theNext$_get_vars\">";
					$pagesArray .= "$textLink</a>" . ($theNext < $egp-1 ? $separator : "");
				} else {
					$pagesArray .= "$textLink"  . ($theNext < $egp-1 ? $separator : "");
				}
			}
			$theNext = $pageNum_Recordset1+1;
			$offset_end = $totalPages_Recordset1;
			$lastArray = ($pageNum_Recordset1 < $totalPages_Recordset1) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_cadastro=$successivo$_get_vars\">$next_Recordset1</a>" : "$next_Recordset1";
		}
	}
	return array($firstArray,$pagesArray,$lastArray);
}
?><?php require_once('Connections/pulsar.php'); ?>
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

if ((isset($_POST['id_cadastro'])) && ($_POST['id_cadastro'] != "")) {
  $deleteSQL = sprintf("DELETE FROM cadastro WHERE id_cadastro=%s",
                       GetSQLValueString($_POST['id_cadastro'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
}

$maxRows_cadastro = 20;
$pageNum_cadastro = 0;
if (isset($_GET['pageNum_cadastro'])) {
  $pageNum_cadastro = $_GET['pageNum_cadastro'];
}
$startRow_cadastro = $pageNum_cadastro * $maxRows_cadastro;

mysql_select_db($database_pulsar, $pulsar);
$query_cadastro = "SELECT * FROM cadastro WHERE (temporario is null or temporario is not null) ";   // Modificacao para apresentar caadastro temporario
if (isset($_POST['filtro'])) {
	$query_cadastro .=" AND ".$_POST['por']." like '%".$_POST['filtro']."%' ";
}
if (isset($_GET['order_by'])) {
	$order_by = $_GET['order_by'];
} else {
	$order_by = "nome";
}
$query_cadastro .= " ORDER BY ".$order_by." ASC";
$query_limit_cadastro = sprintf("%s LIMIT %d, %d", $query_cadastro, $startRow_cadastro, $maxRows_cadastro);
$cadastro = mysql_query($query_limit_cadastro, $pulsar) or die(mysql_error());
$row_cadastro = mysql_fetch_assoc($cadastro);

if (isset($_GET['totalRows_cadastro'])) {
  $totalRows_cadastro = $_GET['totalRows_cadastro'];
} else {
  $all_cadastro = mysql_query($query_cadastro);
  $totalRows_cadastro = mysql_num_rows($all_cadastro);
}
$totalPages_cadastro = ceil($totalRows_cadastro/$maxRows_cadastro)-1;
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
     cadastro de clientes </td><td class="style1"><div align="right">
       <input name="Button" type="button" onClick="MM_goToURL('parent','administra2.php');return document.MM_returnValue" value="Menu Principal">
     </div></td>
   </tr>
</table>
<form action="" method="post" name="form2" class="style38">
  Filtrar por: 
  <input name="filtro" type="text" id="filtro">
  <label>
  <select name="por" id="por">
    <option value="nome">Nome</option>
    <option value="login">Login</option>
    <option value="email">Email</option>
    <option value="empresa">Empresa</option>
  </select>
  </label>
  <input type="submit" value="Ok">
  <br>
  <br>
  <label>
  <input name="Submit2" type="button" onClick="MM_openBrWindow('adm_cad_exp.php','','')" value="Exportar Tabela">
  </label>
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td bgcolor="#CCCCCC" class="style31"><span class="style36"><a href="adm_cad_cli.php?order_by=login">Login</a></span></td>
    <td bgcolor="#CCCCCC" class="style31"><span class="style36"><a href="adm_cad_cli.php?order_by=nome">Nome</a></span></td>
    <td bgcolor="#CCCCCC" class="style31"><span class="style36"><a href="adm_cad_cli.php?order_by=empresa">Empresa</a></span></td>
    <td bgcolor="#CCCCCC" class="style31"><span class="style36"><a href="adm_cad_cli.php?order_by=email">Email</a></span></td>
    <td bgcolor="#CCCCCC" class="style31"><span class="style36"><a href="adm_cad_cli.php?order_by=telefone">Telefone</a></span></td>
    <td bgcolor="#CCCCCC" class="style36">&nbsp;</td>
  </tr>
    <?php do { ?>
  <tr>
      <td class="linha"><span class="style38"><a href="adm_cad_det.php?id_cadastro=<?php echo $row_cadastro['id_cadastro']; ?>"><?php echo $row_cadastro['login']; ?></a>&nbsp;</span></td>
      <td class="linha"><span class="style38"><?php echo $row_cadastro['nome']; ?>&nbsp;</span></td>
      <td class="linha"><span class="style38"><?php echo $row_cadastro['empresa']; ?>&nbsp;</span></td>
      <td class="linha"><span class="style38"><?php echo $row_cadastro['email']; ?>&nbsp;</span></td>
      <td class="linha"><span class="style38"><?php echo $row_cadastro['telefone']; ?>&nbsp;</span></td>
      <form name="form1" method="post" action=""><td class="linha"><input name="id_cadastro" type="hidden" id="id_cadastro" value="<?php echo $row_cadastro['id_cadastro']; ?>"><input name="Submit" type="submit" class="style38" value="Del"></td></form>
  </tr>
  <?php } while ($row_cadastro = mysql_fetch_assoc($cadastro)); ?>
</table>
<br>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999">
  <tr>
    <td bordercolor="#999999" class="style38"><div align="center">
      <?php 
# variable declaration
$prev_cadastro = "« ant";
$next_cadastro = "prox »";
$separator = " | ";
$max_links = 10;
$pages_navigation_cadastro = buildNavigation($pageNum_cadastro,$totalPages_cadastro,$prev_cadastro,$next_cadastro,$separator,$max_links,false); 

print $pages_navigation_cadastro[0]; 
?>
    </div></td>
    <td bordercolor="#999999" class="style38"><div align="center"><?php print $pages_navigation_cadastro[1]; ?></div></td>
    <td bordercolor="#999999" class="style38"><div align="center"><?php print $pages_navigation_cadastro[2]; ?></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($login);

mysql_free_result($cadastro);
?>
