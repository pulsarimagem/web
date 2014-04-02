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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE texto_inicial SET texto=%s, texto_en=%s WHERE id_texto=%s",
                       GetSQLValueString($_POST['texto'], "text"),
                       GetSQLValueString($_POST['texto_en'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());

  $updateGoTo = "administra2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST['id_foto'])) && ($_POST['id_foto'] != "")) {
  $deleteSQL = sprintf("DELETE FROM fotos_homepage WHERE id_foto=%s",
                       GetSQLValueString($_POST['id_foto'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
}

if ((isset($_POST['tombo'])) && ($_POST['tombo'] != "")) {
  $insertSQL = sprintf("INSERT INTO fotos_homepage (tombo) VALUES (%s)",
                       GetSQLValueString($_POST['tombo'], "text"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result2 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
}

mysql_select_db($database_pulsar, $pulsar);
$query_texto = "SELECT * FROM texto_inicial";
$texto = mysql_query($query_texto, $pulsar) or die(mysql_error());
$row_texto = mysql_fetch_assoc($texto);
$totalRows_texto = mysql_num_rows($texto);

mysql_select_db($database_pulsar, $pulsar);
$query_fotos = "SELECT    fotos_homepage.id_foto,   fotos_homepage.tombo,   Fotos.assunto_principal FROM  fotos_homepage  INNER JOIN Fotos ON (fotos_homepage.tombo=Fotos.tombo)";
$fotos = mysql_query($query_fotos, $pulsar) or die(mysql_error());
$row_fotos = mysql_fetch_assoc($fotos);
$totalRows_fotos = mysql_num_rows($fotos);

mysql_select_db($database_pulsar, $pulsar);
$query_fotos_home = "SELECT * FROM fotos_homepage order by tombo asc";
$fotos_home = mysql_query($query_fotos_home, $pulsar) or die(mysql_error());
$row_fotos_home = mysql_fetch_assoc($fotos_home);
$totalRows_fotos_home = mysql_num_rows($fotos_home);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Tela Inicial</title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FFFFFF;
}
.style11 {font-family: Verdana, Arial, Helvetica, sans-serif; color: #666666; font-size: 10pt; }
.style12 {
	color: #FFFFFF;
	font: bold;
}
.style13 {color: #FFFFFF}
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
<table width="100%"  border="0" cellpadding="5" cellspacing="0" bgcolor="#FF9900">
   <tr>
     <td class="style1">pulsarimagens.com.br<br>
         tela inicial </td>
     <td><div align="right">
       <input name="Button" type="button" onClick="MM_goToURL('parent','administra2.php');return document.MM_returnValue" value="Menu Principal">
     </div></td>
   </tr>
</table>
<br>
  <table width="600" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
    <tr>
	  <form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
      <td width="120" class="style11">Novidades:</td>
      <td width="10">&nbsp;</td>
      <td class="style11">
        portugu&ecirc;s:<br>
        <textarea name="texto" cols="60" rows="8" class="style11" id="texto"><?php echo $row_texto['texto']; ?></textarea>
        <input name="id" type="hidden" id="id" value="<?php echo $row_texto['id_texto']; ?>">
        ingl&ecirc;s:<br>
        <textarea name="texto_en" cols="60" rows="8" class="style11" id="texto_en"><?php echo $row_texto['texto_en']; ?></textarea>
      </td>
	  <input type="hidden" name="MM_update" value="form1">
	  </form>
    </tr>
    <tr>
      <td colspan="3"><div align="center"><span class="style11">
          <input name="Button" type="button" class="style11" onClick="MM_callJS('document.form1.submit()')" value="Gravar">
          <br>
          <br>
</span><span class="style11">
      </span></div></td>
    </tr>
</table>
  <br>
  <span class="style11">Fotos em Flash:<br>
  </span><br>
  <table width="300" border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td bgcolor="#000000" class="style11"><span class="style12">Tombo</span></td>
      <td bgcolor="#000000"><span class="style13"></span></td>
    </tr>
    <?php do { ?>
      <tr>
        <td class="style11"><?php echo $row_fotos_home['tombo']; ?></td>
        <form name="form2" method="post" action=""><td>
            <input name="id_foto" type="hidden" id="id_foto" value="<?php echo $row_fotos_home['id_foto']; ?>">
            <input type="submit" name="Submit" value="Excluir">
        </td></form>
    </tr>
      <?php } while ($row_fotos_home = mysql_fetch_assoc($fotos_home)); ?>
    <tr>
      <form name="form3" method="post" action=""><td colspan="2">
            <input name="tombo" type="text" id="tombo">
            <input type="submit" name="Submit2" value="Incluir">
      </td></form>
    </tr>
  </table>
</body>
</html>
<?php
mysql_free_result($texto);

mysql_free_result($fotos);

mysql_free_result($fotos_home);
?>
