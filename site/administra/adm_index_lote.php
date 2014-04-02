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
?><?php
mysql_select_db($database_pulsar, $pulsar);
$query_temas = "SELECT * FROM super_temas ORDER BY Tema_total ASC";
$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
$row_temas = mysql_fetch_assoc($temas);
$totalRows_temas = mysql_num_rows($temas);

mysql_select_db($database_pulsar, $pulsar);
$query_fotografos = "SELECT * FROM fotografos ORDER BY Nome_Fotografo ASC";
$fotografos = mysql_query($query_fotografos, $pulsar) or die(mysql_error());
$row_fotografos = mysql_fetch_assoc($fotografos);
$totalRows_fotografos = mysql_num_rows($fotografos);

mysql_select_db($database_pulsar, $pulsar);
$query_estado = "SELECT * FROM Estados ORDER BY Estado ASC";
$estado = mysql_query($query_estado, $pulsar) or die(mysql_error());
$row_estado = mysql_fetch_assoc($estado);
$totalRows_estado = mysql_num_rows($estado);

mysql_select_db($database_pulsar, $pulsar);
$query_pais = "SELECT * FROM paises ORDER BY nome ASC";
$pais = mysql_query($query_pais, $pulsar) or die(mysql_error());
$row_pais = mysql_fetch_assoc($pais);
$totalRows_pais = mysql_num_rows($pais);
?>
<head>
<title>Indexa&ccedil;&atilde;o por Lote</title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FFFFFF;
}
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12pt;
	font-weight: bold;
}
.style6 {font-size: 10pt; font-family: Verdana, Arial, Helvetica, sans-serif; }
.style8 {font-size: 10pt; font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; }
#Layer1 {
	position:absolute;
	left:484px;
	top:168px;
	width:114px;
	height:24px;
	z-index:1;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
</script>
</head>

<body>
<table width="100%"  border="0" cellpadding="5" cellspacing="0" bgcolor="#FF9900">
   <tr>
     <td class="style1">pulsarimagens.com.br<br>
         indexa&ccedil;&atilde;o por lote</td>
     <td class="style1"><div align="right">
       <input name="Button" type="button" onClick="MM_goToURL('parent','administra2.php');return document.MM_returnValue" value="Menu Principal">
     </div></td>
   </tr>
</table>

<p class="style2">Selecione o lote:</p>
<form id="form1" name="form1" method="get" action="adm_index_lote2.php">
<table width="750" border="0">
  <tr>
    <td>
  <span class="style6">1. Por tema:  </span>
      <?php
$cTemas = "<option value=0>--- EM BRANCO ---</option>\n";
do {  

    $cTemas .= "<option value=".$row_temas['Id'].">".$row_temas['Tema_total']."</option>\n";

} while ($row_temas = mysql_fetch_assoc($temas));
  $rows = mysql_num_rows($temas);
  if($rows > 0) {
      mysql_data_seek($temas, 0);
	  $row_temas = mysql_fetch_assoc($temas);
  }
?>
<select name="tema" id="tema">
	<?php
  echo $cTemas;
  ?>
</select></td>
  </tr>
  <tr>
    <td><span class="style6">2a. Por palavra-chave: </span>
      <input type="text" name="palavra1" id="palavra1" /></td>
  </tr>
  <tr>
    <td><span class="style6">2b. Por palavra-chave: </span>
      <input type="text" name="palavra2" id="palavra2" /></td>
  </tr>
  <tr>
    <td><span class="style6">2c. Por palavra-chave: </span>
      <input type="text" name="palavra3" id="palavra3" /></td>
  </tr>
  <tr>
    <td>
      <span class="style6">3. Por autor:  </span>
<select name="autor" id="autor">
	<option value="0">--- TODOS ---</option>
            <?php
do {  
?>
            <option value="<?php echo $row_fotografos['id_fotografo']; ?>"><?php echo $row_fotografos['Nome_Fotografo']; ?></option>
            <?php
} while ($row_fotografos = mysql_fetch_assoc($fotografos));
  $rows = mysql_num_rows($fotografos);
  if($rows > 0) {
      mysql_data_seek($fotografos, 0);
	  $row_fotografos = mysql_fetch_assoc($fotografos);
  }
?>
  </select></td>
  </tr>
  <tr>
    <td>  <span class="style6">4. Por local:  </span>
  <input type="text" name="cidade" id="cidade" />
<select name="estado" id="estado">
            <option value="">--- em branco ---</option>
            <?php
do {  
?>
            <option value="<?php echo $row_estado['id_estado']?>"><?php echo $row_estado['Estado']?></option>
            <?php
} while ($row_estado = mysql_fetch_assoc($estado));
  $rows = mysql_num_rows($estado);
  if($rows > 0) {
      mysql_data_seek($estado, 0);
	  $row_estado = mysql_fetch_assoc($estado);
  }
?>
  </select>  <select name="pais" id="pais">
            <option value="">--- em branco ---</option>
            <?php
do {  
?>
            <option value="<?php echo $row_pais['id_pais']?>"><?php echo $row_pais['nome']?></option>
            <?php
} while ($row_pais = mysql_fetch_assoc($pais));
  $rows = mysql_num_rows($pais);
  if($rows > 0) {
      mysql_data_seek($pais, 0);
	  $row_pais = mysql_fetch_assoc($pais);
  }
?>
          </select></td>
  </tr>
  <tr>
    <td>  <span class="style6">5. Por assunto principal:  </span>
  <input name="assunto" type="text" id="assunto" size="50" /></td>
  </tr>
  <tr>
    <td>  <span class="style6">6. Por assunto extra:  </span>
  <input name="assuntoextra" type="text" id="assuntoextra" size="50" /></td>
  </tr>
  <tr>
    <td><div align="center">
      <input type="submit" name="button4" id="button4" value="Pesquisar" />
    </div></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
mysql_free_result($temas);

mysql_free_result($fotografos);
?>