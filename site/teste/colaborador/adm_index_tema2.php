<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && ($_POST["Id1"] > 0)) {
mysql_select_db($database_pulsar, $pulsar);
$query_incluir = sprintf("SELECT 
 *
FROM
 super_temas
WHERE Id = %s
",
    GetSQLValueString($_POST['Id1'], "int"));
$incluir = mysql_query($query_incluir, $pulsar) or die(mysql_error());
$row_incluir = mysql_fetch_assoc($incluir);
$totalRows_incluir = mysql_num_rows($incluir);

?>
<script language="JavaScript" type="text/JavaScript">
self.opener.atualizar('<?php echo $row_incluir['Tema_total']; ?>','<?php echo $row_incluir['Id']; ?>');

<?php
mysql_free_result($incluir);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && ($_POST["Id2"] > 0)) {
mysql_select_db($database_pulsar, $pulsar);
$query_incluir = sprintf("SELECT 
 *
FROM
 super_temas
WHERE Id = %s
",
    GetSQLValueString($_POST['Id2'], "int"));
$incluir = mysql_query($query_incluir, $pulsar) or die(mysql_error());
$row_incluir = mysql_fetch_assoc($incluir);
$totalRows_incluir = mysql_num_rows($incluir);

?>
self.opener.atualizar('<?php echo $row_incluir['Tema_total']; ?>','<?php echo $row_incluir['Id']; ?>');

<?php
mysql_free_result($incluir);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && ($_POST["Id3"] > 0)) {
mysql_select_db($database_pulsar, $pulsar);
$query_incluir = sprintf("SELECT 
 *
FROM
 super_temas
WHERE Id = %s
",
    GetSQLValueString($_POST['Id3'], "int"));
$incluir = mysql_query($query_incluir, $pulsar) or die(mysql_error());
$row_incluir = mysql_fetch_assoc($incluir);
$totalRows_incluir = mysql_num_rows($incluir);

?>
self.opener.atualizar('<?php echo $row_incluir['Tema_total']; ?>','<?php echo $row_incluir['Id']; ?>');

<?php
mysql_free_result($incluir);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && ($_POST["Id4"] > 0)) {
mysql_select_db($database_pulsar, $pulsar);
$query_incluir = sprintf("SELECT 
 *
FROM
 super_temas
WHERE Id = %s
",
    GetSQLValueString($_POST['Id4'], "int"));
$incluir = mysql_query($query_incluir, $pulsar) or die(mysql_error());
$row_incluir = mysql_fetch_assoc($incluir);
$totalRows_incluir = mysql_num_rows($incluir);

?>
self.opener.atualizar('<?php echo $row_incluir['Tema_total']; ?>','<?php echo $row_incluir['Id']; ?>');

<?php
mysql_free_result($incluir);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && ($_POST["Id5"] > 0)) {
mysql_select_db($database_pulsar, $pulsar);
$query_incluir = sprintf("SELECT 
 *
FROM
 super_temas
WHERE Id = %s
",
    GetSQLValueString($_POST['Id5'], "int"));
$incluir = mysql_query($query_incluir, $pulsar) or die(mysql_error());
$row_incluir = mysql_fetch_assoc($incluir);
$totalRows_incluir = mysql_num_rows($incluir);

?>
self.opener.atualizar('<?php echo $row_incluir['Tema_total']; ?>','<?php echo $row_incluir['Id']; ?>');

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
$query_temas = "SELECT * FROM super_temas ORDER BY Tema_total ASC";
$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
$row_temas = mysql_fetch_assoc($temas);
$totalRows_temas = mysql_num_rows($temas);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Untitled Document</title>
<link href="css.css" rel="stylesheet" type="text/css" />
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
    <td width="60" class="style1">Incluir:</td>
    <td><select name="Id1" id="Id1">
      <?php
$cTemas = "<option value=0>--- EM BRANCO ---</option>\n";
do {  

    $cTemas .= "<option value=".$row_temas['Id'].">".$row_temas['Tema_total']."</option>\n";

} while ($row_temas = mysql_fetch_assoc($temas));
  echo $cTemas;
  $rows = mysql_num_rows($temas);
  if($rows > 0) {
      mysql_data_seek($temas, 0);
	  $row_temas = mysql_fetch_assoc($temas);
  }
?>
        </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><select name="Id2" class="style1"id="Id2">
      <?php
  echo $cTemas;
  ?>
        </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><select name="Id3" class="style1"id="Id3">
      <?php
  echo $cTemas;
  ?>
        </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><select name="Id4" class="style1"id="Id4">
      <?php
  echo $cTemas;
  ?>
        </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><select name="Id5" class="style1"id="Id5">
      <?php
  echo $cTemas;
  ?>
        </select></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
    
      <input type="submit" name="Submit" id="button" value="Ok" >
    </div></td>
    </tr>
</table>
  <input name="id_foto" type="hidden" id="id_foto" value="<?php echo $_GET['Id_Foto']; ?>">
  <input name="tombo" type="hidden" id="tombo" value="<?php echo $_GET['tombo']; ?>">
  
  <input type="hidden" name="MM_insert" value="form1">
  <br>
</form>
</body>
</html>
<?php
mysql_free_result($temas);
?>
