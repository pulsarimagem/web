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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && ($_POST["Id1"] > 0)) {
  $insertSQL = sprintf("INSERT INTO rel_fotos_temas (id_foto, id_tema) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_foto'], "int"),
                       GetSQLValueString($_POST['Id1'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());


?>
<script language="JavaScript" type="text/JavaScript">
self.opener.atualizar('<?php echo $row_incluir['Tema_total']; ?>','<?php echo $row_incluir['id_rel']; ?>');
<?php
mysql_free_result($incluir);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && ($_POST["Id2"] > 0)) {
  $insertSQL = sprintf("INSERT INTO rel_fotos_temas (id_foto, id_tema) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_foto'], "int"),
                       GetSQLValueString($_POST['Id2'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

mysql_select_db($database_pulsar, $pulsar);
$query_incluir = sprintf("SELECT 
  rel_fotos_temas.id_rel,
  rel_fotos_temas.id_foto,
  rel_fotos_temas.id_tema,
  super_temas.Tema_total
FROM
 rel_fotos_temas
 INNER JOIN super_temas ON (rel_fotos_temas.id_tema=super_temas.Id)
WHERE (rel_fotos_temas.id_foto = %s AND rel_fotos_temas.id_tema = %s)
 ORDER BY id_rel DESC
 limit 1",
                        GetSQLValueString($_POST['id_foto'], "int"),
                       GetSQLValueString($_POST['Id2'], "int"));
$incluir = mysql_query($query_incluir, $pulsar) or die(mysql_error());
$row_incluir = mysql_fetch_assoc($incluir);
$totalRows_incluir = mysql_num_rows($incluir);

?>

self.opener.atualizar('<?php echo $row_incluir['Tema_total']; ?>','<?php echo $row_incluir['id_rel']; ?>');

<?php
mysql_free_result($incluir);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && ($_POST["Id3"] > 0)) {
  $insertSQL = sprintf("INSERT INTO rel_fotos_temas (id_foto, id_tema) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_foto'], "int"),
                       GetSQLValueString($_POST['Id3'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

mysql_select_db($database_pulsar, $pulsar);
$query_incluir = sprintf("SELECT 
  rel_fotos_temas.id_rel,
  rel_fotos_temas.id_foto,
  rel_fotos_temas.id_tema,
  super_temas.Tema_total
FROM
 rel_fotos_temas
 INNER JOIN super_temas ON (rel_fotos_temas.id_tema=super_temas.Id)
WHERE (rel_fotos_temas.id_foto = %s AND rel_fotos_temas.id_tema = %s)
 ORDER BY id_rel DESC
 limit 1",
                        GetSQLValueString($_POST['id_foto'], "int"),
                       GetSQLValueString($_POST['Id3'], "int"));
$incluir = mysql_query($query_incluir, $pulsar) or die(mysql_error());
$row_incluir = mysql_fetch_assoc($incluir);
$totalRows_incluir = mysql_num_rows($incluir);

?>

self.opener.atualizar('<?php echo $row_incluir['Tema_total']; ?>','<?php echo $row_incluir['id_rel']; ?>');

<?php
mysql_free_result($incluir);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && ($_POST["Id4"] > 0)) {
  $insertSQL = sprintf("INSERT INTO rel_fotos_temas (id_foto, id_tema) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_foto'], "int"),
                       GetSQLValueString($_POST['Id4'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

mysql_select_db($database_pulsar, $pulsar);
$query_incluir = sprintf("SELECT 
  rel_fotos_temas.id_rel,
  rel_fotos_temas.id_foto,
  rel_fotos_temas.id_tema,
  super_temas.Tema_total
FROM
 rel_fotos_temas
 INNER JOIN super_temas ON (rel_fotos_temas.id_tema=super_temas.Id)
WHERE (rel_fotos_temas.id_foto = %s AND rel_fotos_temas.id_tema = %s)
 ORDER BY id_rel DESC
 limit 1",
                        GetSQLValueString($_POST['id_foto'], "int"),
                       GetSQLValueString($_POST['Id4'], "int"));
$incluir = mysql_query($query_incluir, $pulsar) or die(mysql_error());
$row_incluir = mysql_fetch_assoc($incluir);
$totalRows_incluir = mysql_num_rows($incluir);

?>

self.opener.atualizar('<?php echo $row_incluir['Tema_total']; ?>','<?php echo $row_incluir['id_rel']; ?>');

<?php
mysql_free_result($incluir);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && ($_POST["Id5"] > 0)) {
  $insertSQL = sprintf("INSERT INTO rel_fotos_temas (id_foto, id_tema) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_foto'], "int"),
                       GetSQLValueString($_POST['Id5'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

mysql_select_db($database_pulsar, $pulsar);
$query_incluir = sprintf("SELECT 
  rel_fotos_temas.id_rel,
  rel_fotos_temas.id_foto,
  rel_fotos_temas.id_tema,
  super_temas.Tema_total
FROM
 rel_fotos_temas
 INNER JOIN super_temas ON (rel_fotos_temas.id_tema=super_temas.Id)
WHERE (rel_fotos_temas.id_foto = %s AND rel_fotos_temas.id_tema = %s)
 ORDER BY id_rel DESC
 limit 1",
                        GetSQLValueString($_POST['id_foto'], "int"),
                       GetSQLValueString($_POST['Id5'], "int"));
$incluir = mysql_query($query_incluir, $pulsar) or die(mysql_error());
$row_incluir = mysql_fetch_assoc($incluir);
$totalRows_incluir = mysql_num_rows($incluir);

?>

self.opener.atualizar('<?php echo $row_incluir['Tema_total']; ?>','<?php echo $row_incluir['id_rel']; ?>');

<?php
mysql_free_result($incluir);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
?>
window.close();

</script>
<?php
}

mysql_select_db($database_pulsar, $pulsar);
$query_autores = "SELECT * FROM fotografos ORDER BY Nome_Fotografo ASC";
$autores = mysql_query($query_autores, $pulsar) or die(mysql_error());
$row_autores = mysql_fetch_assoc($autores);
$totalRows_autores = mysql_num_rows($autores);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10pt;
}
-->
</style>
</head>
<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="style1">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="60" class="style1">Novo autor:</td>
    <td><select name="Id1" class="style1" id="Id1">
      <?php
$cAutor = "";
do {  

    $cAutor .= "<option value=".$row_autores['id_fotografo'].">".$row_autores['Nome_Fotografo']."</option>\n";

} while ($row_autores = mysql_fetch_assoc($autores));
  echo $cAutor;
  $rows = mysql_num_rows($autores);
  if($rows > 0) {
      mysql_data_seek($autores, 0);
	  $row_autores = mysql_fetch_assoc($autores);
  }
?>
        </select>
      <input type="submit" name="Submit" value="Ok" ></td>
  </tr>
</table>
<br />
<br />
  
  <input name="id_foto" type="hidden" id="id_foto" value="<?php echo $_GET['Id_Foto']; ?>">
  <input name="tombo" type="hidden" id="tombo" value="<?php echo $_GET['tombo']; ?>">
  <input type="hidden" name="MM_insert" value="form1">
  <br>
</form>
</body>
</html>
<?php
mysql_free_result($autores);
?>
