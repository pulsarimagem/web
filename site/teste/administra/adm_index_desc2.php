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

$colname_pal_chave = "";
$multiInsert = false;
$multiReturn = "";

if (isset($_POST['Pal_Chave']) || isset($_GET['Pal_Chave'])) {
  // Alteracao para incluir direto via GET
  if(isset($_GET['Pal_Chave'])) {
  	$_POST['Pal_Chave'] = $_GET['Pal_Chave'];
  }
	
	//Modificacao do Zoca para incluir multiplas palavras chaves ao mesmo tempo.
  if(strrchr($_POST['Pal_Chave'],";")||strrchr($_POST['Pal_Chave'],",")) {
    $multiInsert = true;
  }
  
  $colname_pal_chave = (get_magic_quotes_gpc()) ? $_POST['Pal_Chave'] : addslashes($_POST['Pal_Chave']);
}

if($multiInsert) {
	$pal_chave_arr = explode(";",str_replace(",",";",$_POST['Pal_Chave']));
  
  	$editFormAction = $_SERVER['PHP_SELF'];
  	
	if (isset($_SERVER['QUERY_STRING'])) {
//	  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
	}
  
  foreach($pal_chave_arr as $pc) {
    $pc = trim($pc);
    if($pc == "")
    	continue;
    $pc = (get_magic_quotes_gpc()) ? $pc : addslashes($pc);
	mysql_select_db($database_pulsar, $pulsar);
	$query_pal_chave = sprintf("SELECT * FROM pal_chave WHERE Pal_Chave = '%s'", $pc);
	$pal_chave = mysql_query($query_pal_chave, $pulsar) or die(mysql_error());
	$row_pal_chave = mysql_fetch_assoc($pal_chave);
	$totalRows_pal_chave = mysql_num_rows($pal_chave);
	
	if($totalRows_pal_chave != 0) {
	
		// Zoca: Verifica se a palavra chave jah esta relacionada com o tombo. Para evitar repeticao.
		
		mysql_select_db($database_pulsar, $pulsar);
		$query_incluir = sprintf("SELECT 
		  rel_fotos_pal_ch.id_rel,
		  rel_fotos_pal_ch.id_foto,
		  rel_fotos_pal_ch.id_palavra_chave,
		  pal_chave.Pal_Chave
		FROM
		 rel_fotos_pal_ch
		 INNER JOIN pal_chave ON (rel_fotos_pal_ch.id_palavra_chave=pal_chave.Id)
		WHERE (rel_fotos_pal_ch.id_foto = %s AND rel_fotos_pal_ch.id_palavra_chave = %s)
		ORDER BY rel_fotos_pal_ch.id_rel DESC
		LIMIT 1",
							   GetSQLValueString($_POST['id_foto'], "int"),
							   GetSQLValueString($row_pal_chave['Id'], "int"));
		$incluir = mysql_query($query_incluir, $pulsar) or die(mysql_error());
		$row_incluir = mysql_fetch_assoc($incluir);
		$totalRows_incluir = mysql_num_rows($incluir);

		// Se nao tiver a palavra chave na lista de relacao, incluir ela.
		
		if($totalRows_incluir == 0) {
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
			
//			$multiReturn.="<br>Palavra chave (".$pc.") relacionada ok!<br>";
?>
  	<script language="JavaScript" type="text/JavaScript">
  	self.opener.atualizar2('<?php echo str_replace("'","\'", $row_incluir['Pal_Chave']); ?>','<?php echo $row_incluir['Id']; ?>');
	</script>

<?php
			
		}
		else {
			$multiReturn.="<br>Palavra chave (".$pc.") j&aacute; relacionada!<br>";
		}

    }
	else {
		
	$multiReturn.="<form action=".$editFormAction." method=\"POST\" name=\"form2\" class=\"style1\" target=\"_blank\">
  PALAVRA CHAVE (".$pc.") N&Atilde;O ENCONTRADA! 
  <input name=\"Pal_Chave\" type=\"hidden\" id=\"Pal_Chave\" value=".$_POST['Pal_Chave'].">
  <input type=\"hidden\" name=\"MM_insert2\" value=\"form2\">
  <input name=\"id_foto\" type=\"hidden\" id=\"id_foto\" value=".$_GET['Id_Foto'].">
  <input name=\"id_pal_chave\" type=\"hidden\" id=\"id_pal_chave\" value=".$row_pal_chave['Id'].">
  <input name=\"tombo\" type=\"hidden\" id=\"tombo\" value=".$_GET['tombo'].">
  </form>";
	//<input name=\"Incluir\" type=\"submit\" value=\"Incluir\">
	}
  }
}


//Caso de palavras chaves simples
else {

mysql_select_db($database_pulsar, $pulsar);
$query_pal_chave = sprintf("SELECT * FROM pal_chave WHERE Pal_Chave = '%s'", $colname_pal_chave);
$pal_chave = mysql_query($query_pal_chave, $pulsar) or die(mysql_error());
$row_pal_chave = mysql_fetch_assoc($pal_chave);
$totalRows_pal_chave = mysql_num_rows($pal_chave);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert2"])) && ($_POST["MM_insert2"] == "form2")) {
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
}
// Fim multiInsert else

echo $multiReturn;

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
  <?php if (($totalRows_pal_chave == 0) AND (isset($_POST['MM_insert'])) && !$multiInsert) { // Show if recordset empty ?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form2" class="style1">
  PALAVRA CHAVE N&Atilde;O ENCONTRADA! <input name="Incluir" type="submit" value="Incluir">
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
