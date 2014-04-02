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
                GLOBAL $maxRows_palavra_chave,$totalRows_palavra_chave;
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
					if ($_get_name != "pageNum_palavra_chave") {
						$_get_vars .= "&$_get_name=$_get_value";
					}
				}
			}
			$successivo = $pageNum_Recordset1+1;
			$precedente = $pageNum_Recordset1-1;
			$firstArray = ($pageNum_Recordset1 > 0) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_palavra_chave=$precedente$_get_vars\">$prev_Recordset1</a>" :  "$prev_Recordset1";
			# ----------------------
			# page numbers
			# ----------------------
			for($a = $fgp+1; $a <= $egp; $a++){
				$theNext = $a-1;
				if($show_page)
				{
					$textLink = $a;
				} else {
					$min_l = (($a-1)*$maxRows_palavra_chave) + 1;
					$max_l = ($a*$maxRows_palavra_chave >= $totalRows_palavra_chave) ? $totalRows_palavra_chave : ($a*$maxRows_palavra_chave);
					$textLink = "$min_l - $max_l";
				}
				$_ss_k = floor($theNext/26);
				if ($theNext != $pageNum_Recordset1)
				{
					$pagesArray .= "<a href=\"$_SERVER[PHP_SELF]?pageNum_palavra_chave=$theNext$_get_vars\">";
					$pagesArray .= "$textLink</a>" . ($theNext < $egp-1 ? $separator : "");
				} else {
					$pagesArray .= "$textLink"  . ($theNext < $egp-1 ? $separator : "");
				}
			}
			$theNext = $pageNum_Recordset1+1;
			$offset_end = $totalPages_Recordset1;
			$lastArray = ($pageNum_Recordset1 < $totalPages_Recordset1) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_palavra_chave=$successivo$_get_vars\">$next_Recordset1</a>" : "$next_Recordset1";
		}
	}
	return array($firstArray,$pagesArray,$lastArray);
}
?>
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

if ((isset($_GET['Id'])) && ($_GET['Id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM pal_chave WHERE Id=%s",
                       GetSQLValueString($_GET['Id'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
  $deleteSQL = sprintf("DELETE FROM rel_fotos_pal_ch WHERE id_palavra_chave=%s",
                       GetSQLValueString($_GET['Id'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());

}

$maxRows_palavra_chave = 30;
$pageNum_palavra_chave = 0;
if (isset($_GET['pageNum_palavra_chave'])) {
  $pageNum_palavra_chave = $_GET['pageNum_palavra_chave'];
}
$startRow_palavra_chave = $pageNum_palavra_chave * $maxRows_palavra_chave;

$colname_palavra_chave = "0-9";
if (isset($_GET['inicial'])) {
  $colname_palavra_chave = (get_magic_quotes_gpc()) ? $_GET['inicial'] : addslashes($_GET['inicial']);
}

$query_palavra_chave = sprintf("SELECT pal_chave.Id, pal_chave.Pal_Chave, count(rel_fotos_pal_ch.id_rel) AS total FROM pal_chave INNER JOIN rel_fotos_pal_ch ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave) WHERE (pal_chave regexp('^[%s]')) GROUP BY pal_chave.Id, pal_chave.Pal_Chave ORDER BY pal_chave.Pal_Chave", $colname_palavra_chave);

// Modificacao Aislan - Busca de palavras chaves
if (isset($_GET['busca'])) {
	$colname_palavra_chave = (get_magic_quotes_gpc()) ? $_GET['busca'] : addslashes($_GET['busca']);
	$query_palavra_chave = sprintf("SELECT pal_chave.Id, pal_chave.Pal_Chave, count(rel_fotos_pal_ch.id_rel) AS total FROM pal_chave INNER JOIN rel_fotos_pal_ch ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave) WHERE pal_chave LIKE '%s' GROUP BY pal_chave.Id, pal_chave.Pal_Chave ORDER BY pal_chave.Pal_Chave", $colname_palavra_chave);
}

if (isset($_GET['todas'])) {
	$colname_palavra_chave = (get_magic_quotes_gpc()) ? $_GET['busca'] : addslashes($_GET['busca']);
	$query_palavra_chave = sprintf("SELECT pal_chave.Id, pal_chave.Pal_Chave, Id AS total  FROM pal_chave ORDER BY pal_chave.Pal_Chave");
echo $query_palavra_chave;
	$palavra_chave = mysql_query($query_palavra_chave, $pulsar) or die(mysql_error());
	$row_palavra_chave = mysql_fetch_assoc($palavra_chave);
}

if (isset($_GET['inicial']) || isset($_GET['busca'])) {
	mysql_select_db($database_pulsar, $pulsar);
	$query_limit_palavra_chave = sprintf("%s LIMIT %d, %d", $query_palavra_chave, $startRow_palavra_chave, $maxRows_palavra_chave);
	$palavra_chave = mysql_query($query_limit_palavra_chave, $pulsar) or die(mysql_error());
	$row_palavra_chave = mysql_fetch_assoc($palavra_chave);
	
	if (isset($_GET['totalRows_palavra_chave'])) {
	  $totalRows_palavra_chave = $_GET['totalRows_palavra_chave'];
	} else {
	  $all_palavra_chave = mysql_query($query_palavra_chave);
	  $totalRows_palavra_chave = mysql_num_rows($all_palavra_chave);
	}
	$totalPages_palavra_chave = ceil($totalRows_palavra_chave/$maxRows_palavra_chave)-1;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>palavras-chave</title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FFFFFF;
}
.style4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; }
.style6 {font-size: 9px}
.style7 {color: #333333}
.style8 {font-size: 9pt}
a:link {
	color: #333333;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #333333;
}
a:hover {
	text-decoration: none;
	color: #333333;
}
a:active {
	text-decoration: none;
	color: #333333;
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

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
function confirmSubmit()
{
var agree=confirm("Confirma exclusao?");
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
     <td class="style1">pulsarimagens.com.br<br>
         palavras-chave</td>
     <td class="style1"><div align="right">
       <input name="Button" type="button" onClick="MM_goToURL('parent','administra2.php');return document.MM_returnValue" value="Menu Principal">
     </div></td>
   </tr>
</table>
<br>
<table width="600" border="1">
  <tr class="style1">
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=0-9">0-9</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=a%E1%E0%E2">A</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=b">B</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=c">C</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=d">D</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=e%E9%EA">E</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=f">F</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=g">G</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=h">H</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=i%ED">I</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=j">J</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=k">K</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=l">L</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=m">M</a></div></td>
  </tr>
  <tr class="style1">
    <td>&nbsp;</td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=n">N</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=o%F3%F4">O</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=p">P</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=q">Q</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=r">R</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=s">S</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=t">T</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=u%FC">U</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=v">V</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=w">W</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=x">X</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=y">Y</a></div></td>
    <td><div align="center" class="style7"><a href="adm_palavras.php?inicial=z">Z</a></div></td>
  </tr>
</table>
<br>
<form name="formBusca" action="adm_palavras.php" method="get" >
Busca: <input name="busca" type="text" id="busca">
</form>
<br>
<br>
<?php if (isset($_GET['inicial']) || isset($_GET['busca']) || isset($_GET['todas'])) {?>
<table width="600" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td class="style1 style7 style8">Palavra-Chave (ocorr&ecirc;ncias)</td>
    <td colspan="3"><div align="center">&nbsp;&nbsp;</div>      </td>
  </tr>
  <?php do { ?>
  <tr><form name="form1" method="get" action="">
<?php if(isset($_GET['todas'])) { ?>  
    <td class="style4"><a href="../listing.php?query=<?php echo $row_palavra_chave['Pal_Chave']; ?>&pc_action=Ir&type=pc&tipo=inc_pc.php&pc_action=Ir" target="_blank"><?php echo $row_palavra_chave['Pal_Chave']; ?></a></td>
<?php } else { ?>
    <td class="style4"><a href="../listing.php?query=<?php echo $row_palavra_chave['Pal_Chave']; ?>&pc_action=Ir&type=pc&tipo=inc_pc.php&pc_action=Ir" target="_blank"><?php echo $row_palavra_chave['Pal_Chave']; ?> (<?php echo $row_palavra_chave['total'];?>)</a>
      <input name="Id" type="hidden" id="Id" value="<?php echo $row_palavra_chave['Id']; ?>">
</td>
    <td width="60"><div align="center" class="style6">
        <input name="Button" type="button" class="style6" onClick="MM_openBrWindow('adm_palavras_alt.php?Id=<?php echo $row_palavra_chave['Id']; ?>&inicial=<?php echo $colname_palavra_chave ?>&pageNum_palavra_chave=<?php echo $pageNum_palavra_chave ?>','','width=450,height=50')" value="Alterar">
    </div></td>
    <td width="60"><div align="center" class="style6">
<input name="Button" type="button" class="style6" onClick="MM_openBrWindow('adm_palavras_cop.php?Id=<?php echo $row_palavra_chave['Id']; ?>&inicial=<?php echo $colname_palavra_chave ?>&pageNum_palavra_chave=<?php echo $pageNum_palavra_chave ?>','','width=450,height=50')" value="Copiar">    </div></td>
    <td width="60"><div align="center"><span class="style6">
        <input name="Button" type="submit" class="style6" onClick="return confirmSubmit()" value="Excluir">
    </span></div></td>
<?php } ?>
    </form>
  </tr>
  <?php } while ($row_palavra_chave = mysql_fetch_assoc($palavra_chave)); ?>
</table>
<br>
<table width="600" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
<span class="style4">
<?php 
# variable declaration
$prev_palavra_chave = "<< anterior ";
$next_palavra_chave = " pr&oacute;xima >>";
$separator = " | ";
$max_links = 30;
$pages_navigation_palavra_chave = buildNavigation($pageNum_palavra_chave,$totalPages_palavra_chave,$prev_palavra_chave,$next_palavra_chave,$separator,$max_links,false); 

print $pages_navigation_palavra_chave[0]; 
?>
<?php print $pages_navigation_palavra_chave[1]; ?> <?php print $pages_navigation_palavra_chave[2]; ?></span></td>
  </tr>
</table>
<?php }?>
</body>
</html>
<?php
if (isset($_GET['inicial']) || isset($_GET['busca'])) {
	mysql_free_result($palavra_chave);
}
?>
