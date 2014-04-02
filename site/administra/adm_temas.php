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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {

	$insertSQL = sprintf("INSERT INTO temas (Tema, Tema_en, Pai) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['tema'], "text"),
                       GetSQLValueString($_POST['tema_en'], "text"),
                       GetSQLValueString($_POST['pai'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
  
   if  (isset($_POST['Tema_total'])) {
  $insert2SQL = sprintf("INSERT INTO super_temas (Id, Tema_total_en, Tema_total) VALUES (%s, %s, %s)",
  						mysql_insert_id(),
  						GetSQLValueString($_POST['Tema_total_en']." - ".$_POST['tema_en'], "text"),
  						GetSQLValueString($_POST['Tema_total']." - ".$_POST['tema'], "text"));
   } else {
  $insert2SQL = sprintf("INSERT INTO super_temas (Id, Tema_total_en, Tema_total) VALUES (%s, %s, %s)",
  						mysql_insert_id(),
  						GetSQLValueString($_POST['tema_en'], "text"),
  						GetSQLValueString($_POST['tema'], "text"));
   }
  $Result2 = mysql_query($insert2SQL, $pulsar) or die(mysql_error());
	// bugfix do insert de novos temas. Aislan 20/08/09
  
mysql_select_db($database_pulsar, $pulsar);
$query_inserted = sprintf("SELECT * FROM temas WHERE Tema = %s and Tema_en = %s and Pai = %s",
                       GetSQLValueString($_POST['tema'], "text"),
                       GetSQLValueString($_POST['tema_en'], "text"),
                       GetSQLValueString($_POST['pai'], "int"));
                       
$id_inserted = mysql_query($query_inserted, $pulsar) or die(mysql_error());
$row_inserted = mysql_fetch_assoc($id_inserted);
  
  
	$insertSQL = sprintf("INSERT INTO lista_temas (id_tema, id_pai) VALUES (%s, %s)",
                       GetSQLValueString($row_inserted['Id'], "int"),
                       GetSQLValueString("0", "int"));
                       
  mysql_select_db($database_pulsar, $pulsar);
  $Result_insert1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

  $insertSQL = sprintf("INSERT INTO lista_temas (id_tema, id_pai) VALUES (%s, %s)",
                       GetSQLValueString($row_inserted['Id'], "int"),
                       GetSQLValueString($row_inserted['Id'], "int"));
                       
  mysql_select_db($database_pulsar, $pulsar);
  $Result_insert1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
  if (isset($_GET['nivel1'])) {
  
	$insertSQL = sprintf("INSERT INTO lista_temas (id_tema, id_pai) VALUES (%s, %s)",
                       GetSQLValueString($row_inserted['Id'], "int"),
                       GetSQLValueString($_GET['nivel1'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result_insert2 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
}
if (isset($_GET['nivel2'])) {

  $insertSQL = sprintf("INSERT INTO lista_temas (id_tema, id_pai) VALUES (%s, %s)",
                       GetSQLValueString($row_inserted['Id'], "int"),
                       GetSQLValueString($_GET['nivel2'], "int"));
  
  mysql_select_db($database_pulsar, $pulsar);
  $Result_insert3 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
}
if (isset($_GET['nivel3'])) {

	$insertSQL = sprintf("INSERT INTO lista_temas (id_tema, id_pai) VALUES (%s, %s)",
                       GetSQLValueString($row_inserted['Id'], "int"),
                       GetSQLValueString($_GET['nivel3'], "int"));
  
  mysql_select_db($database_pulsar, $pulsar);
  $Result_insert4 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
}
}

mysql_select_db($database_pulsar, $pulsar);
$query_nivel1 = "SELECT * FROM temas WHERE Pai = 0 ORDER BY Tema ASC";
$nivel1 = mysql_query($query_nivel1, $pulsar) or die(mysql_error());
$row_nivel1 = mysql_fetch_assoc($nivel1);
$totalRows_nivel1 = mysql_num_rows($nivel1);

$colname_nivel2 = "-1";
if (isset($_GET['nivel1'])) {
  $colname_nivel2 = (get_magic_quotes_gpc()) ? $_GET['nivel1'] : addslashes($_GET['nivel1']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_nivel2 = sprintf("SELECT * FROM temas WHERE Pai = %s ORDER BY Tema ASC", $colname_nivel2);
$nivel2 = mysql_query($query_nivel2, $pulsar) or die(mysql_error());
$row_nivel2 = mysql_fetch_assoc($nivel2);
$totalRows_nivel2 = mysql_num_rows($nivel2);

$colname_nivel3 = "-1";
if (isset($_GET['nivel2'])) {
  $colname_nivel3 = (get_magic_quotes_gpc()) ? $_GET['nivel2'] : addslashes($_GET['nivel2']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_nivel3 = sprintf("SELECT * FROM temas WHERE Pai = %s ORDER BY Tema ASC", $colname_nivel3);
$nivel3 = mysql_query($query_nivel3, $pulsar) or die(mysql_error());
$row_nivel3 = mysql_fetch_assoc($nivel3);
$totalRows_nivel3 = mysql_num_rows($nivel3);

$colname_nivel4 = "-1";
if (isset($_GET['nivel3'])) {
  $colname_nivel4 = (get_magic_quotes_gpc()) ? $_GET['nivel3'] : addslashes($_GET['nivel3']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_nivel4 = sprintf("SELECT * FROM temas WHERE Pai = %s ORDER BY Tema ASC", $colname_nivel4);
$nivel4 = mysql_query($query_nivel4, $pulsar) or die(mysql_error());
$row_nivel4 = mysql_fetch_assoc($nivel4);
$totalRows_nivel4 = mysql_num_rows($nivel4);

$colname_tematotal2 = "-1";
if (isset($_GET['nivel1'])) {
  $colname_tematotal2 = (get_magic_quotes_gpc()) ? $_GET['nivel1'] : addslashes($_GET['nivel1']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_tematotal2 = sprintf("SELECT * FROM super_temas WHERE Id = %s", $colname_tematotal2);
$tematotal2 = mysql_query($query_tematotal2, $pulsar) or die(mysql_error());
$row_tematotal2 = mysql_fetch_assoc($tematotal2);
$totalRows_tematotal2 = mysql_num_rows($tematotal2);

$colname_tematotal3 = "-1";
if (isset($_GET['nivel2'])) {
  $colname_tematotal3 = (get_magic_quotes_gpc()) ? $_GET['nivel2'] : addslashes($_GET['nivel2']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_tematotal3 = sprintf("SELECT * FROM super_temas WHERE Id = %s", $colname_tematotal3);
$tematotal3 = mysql_query($query_tematotal3, $pulsar) or die(mysql_error());
$row_tematotal3 = mysql_fetch_assoc($tematotal3);
$totalRows_tematotal3 = mysql_num_rows($tematotal3);

$colname_tematotal4 = "-1";
if (isset($_GET['nivel3'])) {
  $colname_tematotal4 = (get_magic_quotes_gpc()) ? $_GET['nivel3'] : addslashes($_GET['nivel3']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_tematotal4 = sprintf("SELECT * FROM super_temas WHERE Id = %s", $colname_tematotal4);
$tematotal4 = mysql_query($query_tematotal4, $pulsar) or die(mysql_error());
$row_tematotal4 = mysql_fetch_assoc($tematotal4);
$totalRows_tematotal4 = mysql_num_rows($tematotal4);

function DoFormatNumber($theObject,$NumDigitsAfterDecimal,$DecimalSeparator,$GroupDigits) { 
	$currencyFormat=number_format($theObject,$NumDigitsAfterDecimal,$DecimalSeparator,$GroupDigits);
	return ($currencyFormat);
}
?>
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
.style24 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8pt; color: #666666; }
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10pt; color: #666666; font-weight: bold; }
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
-->
</style>
<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
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
      temas </td>
    <td class="style1"><div align="right">
        <input name="Button" type="button" onClick="MM_goToURL('parent','administra2.php');return document.MM_returnValue" value="Menu Principal">
      </div></td>
  </tr>
</table>
<br>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td class="style27">N&iacute;vel 1 </td>
    <td class="style27">Nivel 2 </td>
    <td class="style27">N&iacute;vel 3 </td>
    <td class="style27">N&iacute;vel 4 </td>
  </tr>
    <tr>
      <td><select name="menu1" onChange="MM_jumpMenu('parent',this,0)">
          <option value="adm_temas.php" <?php if (!(strcmp("", $_GET['nivel1']))) {echo "selected=\"selected\"";} ?>>Escolha um tema</option>
          <?php
do {  
?>
          <option value="adm_temas.php?nivel1=<?php echo $row_nivel1['Id']?>"<?php if (!(strcmp($row_nivel1['Id'], $_GET['nivel1']))) {echo "selected=\"selected\"";} ?>><?php echo $row_nivel1['Tema']?></option>
          <?php
} while ($row_nivel1 = mysql_fetch_assoc($nivel1));
  $rows = mysql_num_rows($nivel1);
  if($rows > 0) {
      mysql_data_seek($nivel1, 0);
	  $row_nivel1 = mysql_fetch_assoc($nivel1);
  }
?>
        </select><?php if (isset($_GET['nivel1'])) { // Show if nivel1 was set ?>
        <input name="Submit2" type="button" onClick="MM_openBrWindow('adm_temas_alt.php?Id=<?php echo $_GET['nivel1']; ?>','','width=500,height=150')" value="Alterar"><input type="button" name="Submit3" value="Excluir" onClick="MM_openBrWindow('adm_temas_del.php?Id=<?php echo $_GET['nivel1']; ?>','','width=500,height=150')">
        <?php }; ?></td>
      <td><?php if ($totalRows_nivel2 > 0) { // Show if recordset not empty ?>
          <select name="select2" onChange="MM_jumpMenu('parent',this,0)">
            <option value="adm_temas.php?nivel1=<?php echo $_GET['nivel1']; ?>" <?php if (!(strcmp("", $_GET['nivel2']))) {echo "selected=\"selected\"";} ?>>Escolha um tema</option>
            <?php
do {  
?>
            <option value="adm_temas.php?nivel1=<?php echo $_GET['nivel1']; ?>&nivel2=<?php echo $row_nivel2['Id']?>"<?php if (!(strcmp($row_nivel2['Id'], $_GET['nivel2']))) {echo "selected=\"selected\"";} ?>><?php echo $row_nivel2['Tema']?></option>
            <?php
} while ($row_nivel2 = mysql_fetch_assoc($nivel2));
  $rows = mysql_num_rows($nivel2);
  if($rows > 0) {
      mysql_data_seek($nivel2, 0);
	  $row_nivel2 = mysql_fetch_assoc($nivel2);
  }
?>
          </select>
          <?php if (isset($_GET['nivel2'])) { // Show if nivel2 was set ?><input type="button" name="Submit22" onClick="MM_openBrWindow('adm_temas_alt.php?Id=<?php echo $_GET['nivel2']; ?>&Pai=<?php echo $_GET['nivel1']; ?>','','width=500,height=150')" value="Alterar"><input type="button" name="Submit32" value="Excluir" onClick="MM_openBrWindow('adm_temas_del.php?Id=<?php echo $_GET['nivel2']; ?>&Pai=<?php echo $_GET['nivel1']; ?>','','width=500,height=150')"><?php }; ?>
          <?php } // Show if recordset not empty ?>&nbsp;</td>
      <td><?php if ($totalRows_nivel3 > 0) { // Show if recordset not empty ?>
          <select name="select3" onChange="MM_jumpMenu('parent',this,0)">
            <option value="adm_temas.php?nivel1=<?php echo $_GET['nivel1']; ?>&nivel2=<?php echo $_GET['nivel2']; ?>" <?php if (!(strcmp("", $_GET['nivel3']))) {echo "selected=\"selected\"";} ?>>Escolha um tema</option>
            <?php
do {  
?>
            <option value="adm_temas.php?nivel1=<?php echo $_GET['nivel1']; ?>&nivel2=<?php echo $_GET['nivel2']; ?>&nivel3=<?php echo $row_nivel3['Id']?>"<?php if (!(strcmp($row_nivel3['Id'], $_GET['nivel3']))) {echo "selected=\"selected\"";} ?>><?php echo $row_nivel3['Tema']?></option>
            <?php
} while ($row_nivel3 = mysql_fetch_assoc($nivel3));
  $rows = mysql_num_rows($nivel3);
  if($rows > 0) {
      mysql_data_seek($nivel3, 0);
	  $row_nivel3 = mysql_fetch_assoc($nivel3);
  }
?>
          </select>
          <?php if (isset($_GET['nivel3'])) { // Show if nivel3 was set ?><input type="button" name="Submit222" onClick="MM_openBrWindow('adm_temas_alt.php?Id=<?php echo $_GET['nivel3']; ?>&Pai=<?php echo $_GET['nivel2']; ?>','','width=500,height=150')" value="Alterar"><input type="button" name="Submit33" value="Excluir" onClick="MM_openBrWindow('adm_temas_del.php?Id=<?php echo $_GET['nivel3']; ?>&Pai=<?php echo $_GET['nivel2']; ?>','','width=500,height=150')"><?php }; ?>
          <?php } // Show if recordset not empty ?>&nbsp;</td>
      <td><?php if ($totalRows_nivel4 > 0) { // Show if recordset not empty ?>
          <select name="select4" onChange="MM_jumpMenu('parent',this,0)">
            <option value="adm_temas.php?nivel1=<?php echo $_GET['nivel1']; ?>&nivel2=<?php echo $_GET['nivel2']; ?>&nivel3=<?php echo $_GET['nivel3']; ?>" <?php if (!(strcmp("", $_GET['nivel4']))) {echo "selected=\"selected\"";} ?>>Escolha um tema</option>
            <?php
do {  
?>
            <option value="adm_temas.php?nivel1=<?php echo $_GET['nivel1']; ?>&nivel2=<?php echo $_GET['nivel2']; ?>&nivel3=<?php echo $_GET['nivel3']; ?>&nivel4=<?php echo $row_nivel4['Id']?>"<?php if (!(strcmp($row_nivel4['Id'], $_GET['nivel4']))) {echo "selected=\"selected\"";} ?>><?php echo $row_nivel4['Tema']?></option>
            <?php
} while ($row_nivel4 = mysql_fetch_assoc($nivel4));
  $rows = mysql_num_rows($nivel4);
  if($rows > 0) {
      mysql_data_seek($nivel4, 0);
	  $row_nivel4 = mysql_fetch_assoc($nivel4);
  }
?>
          </select>
          <?php if (isset($_GET['nivel4'])) { // Show if nivel4 was set ?><input type="button" name="Submit223" onClick="MM_openBrWindow('adm_temas_alt.php?Id=<?php echo $_GET['nivel4']; ?>&Pai=<?php echo $_GET['nivel3']; ?>','','width=500,height=150')" value="Alterar"><input type="button" name="Submit34" value="Excluir" onClick="MM_openBrWindow('adm_temas_del.php?Id=<?php echo $_GET['nivel4']; ?>&Pai=<?php echo $_GET['nivel3']; ?>','','width=500,height=150')"><?php }; ?>
          <?php } // Show if recordset not empty ?>&nbsp;</td>
    </tr>
  <tr>
    <form name="form2" method="POST" action="<?php echo $editFormAction; ?>">
      <td><span class="style24">Portugu&ecirc;s:</span><br>
        <input name="tema" type="text" id="tema">
        <br>
        <span class="style24">Ingl&ecirc;s:</span><br>
        <input name="tema_en" type="text" id="tema_en">
        <br>
        <input type="submit" name="Submit" value="Incluir">
      <input name="pai" type="hidden" id="pai" value="0">      </td>
      <input type="hidden" name="MM_insert" value="form2">
    </form>
    <form name="form3" method="POST" action="<?php echo $editFormAction; ?>">
      <td><?php if (isset($_GET['nivel1'])) { // Show if nivel1 was set ?><span class="style24">Portugu&ecirc;s:</span><br>
        <input name="tema" type="text" id="tema">
        <br>
        <span class="style24">Ingl&ecirc;s:</span><br>
        <input name="tema_en" type="text" id="tema_en">
        <br>
        <input type="submit" name="Submit" value="Incluir">
      <input name="pai" type="hidden" id="pai" value="<?php echo $_GET['nivel1']; ?>">
      <?php } // Show if recordset not empty ?>&nbsp;
      <input name="Tema_total" type="hidden" id="Tema_total" value="<?php echo $row_tematotal2['Tema_total']; ?>">
	  <input name="Tema_total_en" type="hidden" id="Tema_total_en" value="<?php echo $row_tematotal2['Tema_total_en']; ?>"></td>
      <input type="hidden" name="MM_insert" value="form2">
    </form>
    <form name="form4" method="POST" action="<?php echo $editFormAction; ?>">
      <td><?php if (isset($_GET['nivel2'])) { // Show if nivel2 was set ?><span class="style24">Portugu&ecirc;s:</span><br>
        <input name="tema" type="text" id="tema">
        <br>
        <span class="style24">Ingl&ecirc;s:</span><br>
        <input name="tema_en" type="text" id="tema_en">
        <br>
        <input type="submit" name="Submit" value="Incluir">
      <input name="pai" type="hidden" id="pai" value="<?php echo $_GET['nivel2']; ?>">
      <?php } // Show if recordset not empty ?>&nbsp;
      <input name="Tema_total" type="hidden" id="Tema_total" value="<?php echo $row_tematotal3['Tema_total']; ?>">
      <input name="Tema_total_en" type="hidden" id="Tema_total_en" value="<?php echo $row_tematotal3['Tema_total_en']; ?>"></td>
      <input type="hidden" name="MM_insert" value="form2">
    </form>
    <form name="form5" method="POST" action="<?php echo $editFormAction; ?>">
      <td><?php if (isset($_GET['nivel3'])) { // Show if nivel3 was set ?><span class="style24">Portugu&ecirc;s:</span><br>
        <input name="tema" type="text" id="tema">
        <br>
        <span class="style24">Ingl&ecirc;s:</span><br>
        <input name="tema_en" type="text" id="tema_en">
        <br>
        <input type="submit" name="Submit" value="Incluir">
      <input name="pai" type="hidden" id="pai" value="<?php echo $_GET['nivel3']; ?>">
      <?php } // Show if recordset not empty ?>&nbsp;
      <input name="Tema_total" type="hidden" id="Tema_total" value="<?php echo $row_tematotal4['Tema_total']; ?>">
      <input name="Tema_total_en" type="hidden" id="Tema_total_en" value="<?php echo $row_tematotal4['Tema_total_en']; ?>"></td>
      <input type="hidden" name="MM_insert" value="form2">
    </form>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($login);

mysql_free_result($nivel1);

mysql_free_result($nivel2);

mysql_free_result($nivel3);

mysql_free_result($nivel4);

mysql_free_result($tematotal2);

mysql_free_result($tematotal3);

mysql_free_result($tematotal4);
?>
