<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php

$colname_pal_chave = "";
if (isset($_POST['Pal_Chave'])) {
  $colname_pal_chave = (get_magic_quotes_gpc()) ? $_POST['Pal_Chave'] : addslashes($_POST['Pal_Chave']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_pal_chave = sprintf("SELECT * FROM pal_chave WHERE Pal_Chave = '%s'", $colname_pal_chave);
$pal_chave = mysql_query($query_pal_chave, $pulsar) or die(mysql_error());
$row_pal_chave = mysql_fetch_assoc($pal_chave);
$totalRows_pal_chave = mysql_num_rows($pal_chave);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert2"])) && ($_POST["MM_insert2"] == "form2") && false) {
  $insertSQL = sprintf("INSERT INTO pal_chave (Pal_Chave) VALUES (%s)",
                       GetSQLValueString($_POST['Pal_Chave'], "text"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && ($totalRows_pal_chave != 0)) {
/*
  $insertSQL = sprintf("INSERT INTO rel_fotos_pal_ch (id_foto, id_palavra_chave) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id_foto'], "int"),
                       GetSQLValueString($row_pal_chave['Id'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
*/  
  mysql_select_db($database_pulsar, $pulsar);
$query_incluir = sprintf("SELECT 
  *
FROM
 pal_chave
WHERE Id = %s
",
GetSQLValueString($row_pal_chave['Id'], "int"));
$incluir = mysql_query($query_incluir, $pulsar) or die(mysql_error());
$row_incluir = mysql_fetch_assoc($incluir);
$totalRows_incluir = mysql_num_rows($incluir);

?><script language="JavaScript" type="text/JavaScript">

self.opener.atualizar2('<?php echo str_replace("'","\'", $row_incluir['Pal_Chave']); ?>','<?php echo $row_incluir['Id']; ?>');

<?php
mysql_free_result($incluir);
?>
</script>
<?php
}
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
Incluir:
  <input name="Pal_Chave" type="text" id="Pal_Chave" size="50" value="<?php
if (($totalRows_pal_chave == 0) AND (isset($_POST['MM_insert']))) { // Show if recordset empty
  echo str_replace("\\","",$_POST['Pal_Chave']); 
} // Show if recordset empty ?>">
  <input name="id_foto" type="hidden" id="id_foto" value="<?php echo $_GET['Id_Foto']; ?>">
  <input name="id_pal_chave" type="hidden" id="id_pal_chave" value="<?php echo $row_pal_chave['Id']; ?>">
  <input name="tombo" type="hidden" id="tombo" value="<?php echo $_GET['tombo']; ?>">
  <input type="submit" name="Submit" value="Ok">
  <input type="hidden" name="MM_insert" value="form1">
</form>
  <?php if (($totalRows_pal_chave == 0) AND (isset($_POST['MM_insert']))) { // Show if recordset empty ?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form2" class="style1">
  PALAVRA CHAVE N&Atilde;O ENCONTRADA! <!-- <input name="Incluir" type="submit" value="Incluir">  -->
  <input name="Pal_Chave" type="hidden" id="Pal_Chave" value="<?php echo $_POST['Pal_Chave']; ?>">
  <input type="hidden" name="MM_insert2" value="form2">
  <input name="id_foto" type="hidden" id="id_foto" value="<?php echo $_GET['Id_Foto']; ?>">
  <input name="id_pal_chave" type="hidden" id="id_pal_chave" value="<?php echo $row_pal_chave['Id']; ?>">
  <input name="tombo" type="hidden" id="tombo" value="<?php echo $_GET['tombo']; ?>">
</form>
  <?php } // Show if recordset empty ?>
<script language="javascript">
var bFound = false;

  // for each form
  for (f=0; f < document.forms.length; f++)
  {
    // for each element in each form
    for(i=0; i < document.forms[f].length; i++)
    {
      // if it's not a hidden element
      if (document.forms[f][i].type != "hidden")
      {
        // and it's not disabled
        if (document.forms[f][i].disabled != true)
        {
            // set the focus to it
            document.forms[f][i].focus();
            var bFound = true;
        }
      }
      // if found in this element, stop looking
      if (bFound == true)
        break;
    }
    // if found in this form, stop looking
    if (bFound == true)
      break;
  }
</script>
</body>
</html>
<?php
mysql_free_result($pal_chave);
?>
