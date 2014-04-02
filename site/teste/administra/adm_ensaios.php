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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE ensaios SET titulo=%s, texto=%s,titulo_en=%s, texto_en=%s WHERE id_ensaio=%s",
                       GetSQLValueString($_POST['textfield'], "text"),
                       GetSQLValueString($_POST['textarea'], "text"),
                       GetSQLValueString($_POST['textfield2'], "text"),
                       GetSQLValueString($_POST['textarea2'], "text"),
                       GetSQLValueString($_POST['id_ensaio'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_ins")) {
  $insertSQL = sprintf("INSERT INTO fotos_ensaio (id_ensaio, id_foto) VALUES (%s, (SELECT Id_Foto FROM Fotos WHERE tombo=%s))",
                       GetSQLValueString($_POST['id_ensaio'], "int"),
                       GetSQLValueString($_POST['tombo'], "text"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE ensaios SET titulo=%s, texto=%s WHERE id_ensaio=%s",
                       GetSQLValueString($_POST['textfield'], "text"),
                       GetSQLValueString($_POST['textarea'], "text"),
                       GetSQLValueString($_POST['id_ensaio'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());
}

if ((isset($_POST['id_foto_ensaio'])) && ($_POST['id_foto_ensaio'] != "")) {
  $deleteSQL = sprintf("DELETE FROM fotos_ensaio WHERE id_foto_ensaio=%s",
                       GetSQLValueString($_POST['id_foto_ensaio'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
}

if ((isset($_POST['del_ensaio'])) && ($_POST['del_ensaio'] != "")) {
  $deleteSQL = sprintf("DELETE FROM ensaios WHERE id_ensaio=%s",
                       GetSQLValueString($_POST['del_ensaio'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());

  $deleteSQL = sprintf("DELETE FROM fotos_ensaio WHERE id_ensaio=%s",
                       GetSQLValueString($_POST['del_ensaio'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
  
}

mysql_select_db($database_pulsar, $pulsar);
$query_ensaios = "SELECT * FROM ensaios";
$ensaios = mysql_query($query_ensaios, $pulsar) or die(mysql_error());
$row_ensaios = mysql_fetch_assoc($ensaios);
$totalRows_ensaios = mysql_num_rows($ensaios);

$colname_ensaio_selec = "0";
if (isset($_GET['ensaio'])) {
  $colname_ensaio_selec = (get_magic_quotes_gpc()) ? $_GET['ensaio'] : addslashes($_GET['ensaio']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_ensaio_selec = sprintf("SELECT * FROM ensaios WHERE id_ensaio = %s", $colname_ensaio_selec);
$ensaio_selec = mysql_query($query_ensaio_selec, $pulsar) or die(mysql_error());
$row_ensaio_selec = mysql_fetch_assoc($ensaio_selec);
$totalRows_ensaio_selec = mysql_num_rows($ensaio_selec);

$colname_rel_fotos = "0";
if (isset($_GET['ensaio'])) {
  $colname_rel_fotos = (get_magic_quotes_gpc()) ? $_GET['ensaio'] : addslashes($_GET['ensaio']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_rel_fotos = sprintf("SELECT    fotos_ensaio.id_ensaio,   fotos_ensaio.id_foto_ensaio,   Fotos.tombo,   Fotos.assunto_principal FROM  fotos_ensaio  INNER JOIN Fotos ON (fotos_ensaio.id_foto=Fotos.Id_Foto) WHERE id_ensaio = %s", $colname_rel_fotos);
$rel_fotos = mysql_query($query_rel_fotos, $pulsar) or die(mysql_error());
$row_rel_fotos = mysql_fetch_assoc($rel_fotos);
$totalRows_rel_fotos = mysql_num_rows($rel_fotos);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Ensaios</title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FFFFFF;
}
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10pt; }
.style10 {font-size: 10pt}
.style11 {font-size: 8pt}
.style12 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8pt; }
.style14 {font-size: 12px}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
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
     <td><span class="style1">pulsarimagens.com.br<br>
         ensaios</span></td>
     <td><div align="right">
       <input name="Button" type="button" onClick="MM_goToURL('parent','administra2.php');return document.MM_returnValue" value="Menu Principal">
     </div></td>
   </tr>
</table>
<br>
<form name="form1" method="POST">
  <font face="Verdana, Arial, Helvetica, sans-serif">Selecione um ensaio: 
  <select name="menu1" onChange="MM_jumpMenu('parent',this,0)">
    <option value="adm_ensaios.php" <?php if (!(strcmp("", $_GET['ensaio']))) {echo "SELECTED";} ?>>SELECIONE UM ENSAIO</option>
    <?php
do {  
?>
    <option value="adm_ensaios.php?ensaio=<?php echo $row_ensaios['id_ensaio']?>"<?php if (!(strcmp($row_ensaios['id_ensaio'], $_GET['ensaio']))) {echo "SELECTED";} ?>><?php echo $row_ensaios['titulo']?></option>
    <?php
} while ($row_ensaios = mysql_fetch_assoc($ensaios));
  $rows = mysql_num_rows($ensaios);
  if($rows > 0) {
      mysql_data_seek($ensaios, 0);
	  $row_ensaios = mysql_fetch_assoc($ensaios);
  }
?>
  </select>
  <input name="Submit" type="submit" onClick="MM_openBrWindow('adm_ensaios_novo.php','','')" value="Inserir Novo">
</font>
</form>
<?php if ($totalRows_ensaio_selec > 0) { // Show if recordset not empty ?>
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <form action="<?php echo $editFormAction; ?>" name="form2" method="POST">
  <tr>
    <td width="105" height="80"><span class="style9">T&iacute;tulo:</span></td>
    <td height="80"><span class="style14">Portugu&ecirc;s</span>
      <input name="textfield" type="text" value="<?php echo $row_ensaio_selec['titulo']; ?>" size="60"> <span class="style14"><br/>
	    Ingl&ecirc;s
	    <input name="textfield2" type="text" value="<?php echo $row_ensaio_selec['titulo_en']; ?>" size="60">
      </span>
      <input name="id_ensaio" type="hidden" id="id_ensaio" value="<?php echo $row_ensaio_selec['id_ensaio']; ?>"></td>
  </tr>
  <tr>
    <td width="105"><span class="style9">Texto:</span></td>
    <td><span class="style9">
      </span>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><span class="style14">Portugu&ecirc;s</span></td>
          <td><span class="style14">Ingl&ecirc;s</span></td>
          </tr>
        <tr>
          <td><span class="style9">
            <textarea name="textarea" cols="50" rows="8"><?php echo $row_ensaio_selec['texto']; ?></textarea>
          </span></td>
          <td><span class="style9">
            <textarea name="textarea2" cols="50" rows="8"><?php echo $row_ensaio_selec['texto_en']; ?></textarea>
          </span></td>
          </tr>
      </table>
      <span class="style9">
      <input type="hidden" name="MM_update" value="form2">
      </span></td>
  </tr>
  <input type="hidden" name="MM_update" value="form2">
  </form>
  <tr>
    <td width="105">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="105"><span class="style9">Fotos:</span></td>
    <td><table width="500" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
      <tr>
        <td><div align="center" class="style9">Tombo</div></td>
        <td><div align="center" class="style9">Descri&ccedil;&atilde;o</div></td>
        <td>&nbsp;</td>
      </tr>
      <?php do { ?><form name="foto" type="text" id="tombo" method="POST">
        <?php if ($totalRows_rel_fotos > 0) { // Show if recordset not empty ?>
        <tr>
            <td class="style9 style11"><?php echo $row_rel_fotos['tombo']; ?>
              <input name="id_foto_ensaio" type="hidden" id="id_foto_ensaio" value="<?php echo $row_rel_fotos['id_foto_ensaio']; ?>"></td>
            <td class="style12"><?php echo $row_rel_fotos['assunto_principal']; ?></td>
            <td><input type="submit" name="Submit" value="Del"></td>
        </tr>
        <?php } // Show if recordset not empty ?>
      </form>
      <?php } while ($row_rel_fotos = mysql_fetch_assoc($rel_fotos)); ?>
      <tr><form action="<?php echo $editFormAction; ?>" name="form_ins" method="POST">
        <td><input name="tombo" type="text" id="tombo">
          <input name="id_ensaio" type="hidden" id="id_ensaio" value="<?php echo $row_ensaio_selec['id_ensaio']; ?>">
          <input type="submit" name="Submit" value="Inserir"></td>
        <td colspan="2">&nbsp;</td>
        <input type="hidden" name="MM_insert" value="form_ins">
      </form>
      </tr>
    </table>      
    <span class="style10"></span></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">&nbsp;</div></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center"><span class="style10">
</span>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%"><div align="center">
              <input name="Button" type="button" onClick="MM_callJS('document.form2.submit();')" value="Gravar">
            </div></td><form name="form3" method="post" action="">
            <td>
              <div align="center">
                <input type="submit" name="Submit" value="Excluir Ensaio">
                <input name="del_ensaio" type="hidden" id="del_ensaio" value="<?php echo $row_ensaio_selec['id_ensaio']; ?>">          
                </div>
            </td></form>
          </tr>
        </table>
        <span class="style10">    </span></div></td>
  </tr>
</table>
<?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysql_free_result($rel_fotos);

mysql_free_result($ensaios);

mysql_free_result($ensaio_selec);
?>
