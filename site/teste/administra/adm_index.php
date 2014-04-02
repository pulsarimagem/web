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

if(isset($_POST['tombo']))
	$_POST['tombo'] = strtoupper($_POST['tombo']);
if(isset($_GET['tombo']))
	$_GET['tombo'] = strtoupper($_GET['tombo']);

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
	
	
	// ROTINA DE PEGAR AS DIMENSOES DA FOTO
	
	$orientacao = 'H';
	$width = 0;
	$height = 0;
	
	$file = "/var/fotos_alta/".$_POST['tombo'].".jpg";
	
	if (!file_exists($file)) {				// check se o arquivo existe com extensao jpg e JPG
		$file = "/var/fotos_alta/".$_POST['tombo'].".JPG";
	}
	
	if (file_exists($file)) {				// se existir, abre e imprime a resolucao
		$getimgsize = getimagesize($file);
	
		if ($getimgsize) {
			list($width, $height, $type, $attr) = $getimgsize; 
	                
			if($height > $width) {
				$orientacao = 'V';
			}
		}
	}
	
  $direito_img = $_POST['dir_img'];
	
  $updateSQL = sprintf("UPDATE Fotos SET tombo=%s, id_autor=%s, data_foto=%s, cidade=%s, id_estado=%s, id_pais=%s, orientacao=%s, assunto_principal=%s, dim_a=%s, dim_b=%s, direito_img=%s, extra=%s WHERE Id_Foto=%s",
                       GetSQLValueString($_POST['tombo'], "text"),
					   GetSQLValueString($_POST['autor'], "int"),
                       GetSQLValueString($_POST['data'], "text"),
                       GetSQLValueString($_POST['cidade'], "text"),
                       GetSQLValueString($_POST['estado'], "int"),
                       GetSQLValueString($_POST['pais'], "text"),
                       GetSQLValueString($orientacao, "text"),
                       GetSQLValueString($_POST['assunto_principal'], "text"),
                       GetSQLValueString($width, "int"),
                       GetSQLValueString($height, "int"),
                       GetSQLValueString($direito_img, "int"),
                       GetSQLValueString($_POST['extra'], "text"),
                       GetSQLValueString($_POST['Id_Foto'], "int"));

mysql_select_db($database_pulsar, $pulsar);
$Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());
  $deleteextraSQL = sprintf("DELETE from Fotos_extra WHERE tombo=%s",
                       GetSQLValueString($_POST['tombo'], "text"));
					   
mysql_select_db($database_pulsar, $pulsar);
$Result2 = mysql_query($deleteextraSQL, $pulsar) or die(mysql_error());
/*
  $updateextraSQL = sprintf("UPDATE Fotos_extra SET extra=%s WHERE tombo=%s",
                       GetSQLValueString($_POST['extra'], "text"),
                       GetSQLValueString($_POST['tombo'], "text"));
	*/
if($_POST['extra'] != "") {

$updateextraSQL = sprintf("INSERT INTO Fotos_extra (tombo, extra) VALUES (%s, %s)",
                       GetSQLValueString($_POST['tombo'], "text"),
                       GetSQLValueString($_POST['extra'], "text"));

mysql_select_db($database_pulsar, $pulsar);
$Result3 = mysql_query($updateextraSQL, $pulsar) or die(mysql_error());
}
/*
  $insertextraSQL = sprintf("INSERT INTO Fotos_extra (tombo, extra) VALUES (%s, %s)",
                       GetSQLValueString($_POST['tombo'], "text"),
                       GetSQLValueString($_POST['extra'], "text"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result2 = mysql_query($insertextraSQL, $pulsar) or die(mysql_error());
*/

// Insere o IPTC no arquivo
include('../toolkit/inc_IPTC4.php');
$tombo = $_POST['tombo'];
$path = $thumbpop;
$dest_file = $path."/".$tombo.".jpg";
coloca_iptc($tombo, $dest_file, $database_pulsar, $pulsar);
$dest_file = $path."/".$tombo."p.jpg";
coloca_iptc($tombo, $dest_file, $database_pulsar, $pulsar);

$insertGoTo = "adm_index.php";
header(sprintf("Location: %s", $insertGoTo));
//echo $updateSQL;
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form4")) {
	
	$orientacao = 'H';
	$width = 0;
	$height = 0;
	
	$file = "/var/fotos_alta/".$_POST['tombo'].".jpg";
	
	if (!file_exists($file)) {				// check se o arquivo existe com extensao jpg e JPG
		$file = "/var/fotos_alta/".$_POST['tombo'].".JPG";
	}
	
	if (file_exists($file)) {				// se existir, abre e imprime a resolucao
		$getimgsize = getimagesize($file);
	
		if ($getimgsize) {
			list($width, $height, $type, $attr) = $getimgsize; 
	                
			if($height > $width) {
				$orientacao = 'V';
			}
		}
	}
	
  $direito_img = $_POST['dir_img'];
	
	
  $insertSQL = sprintf("INSERT INTO Fotos (tombo, id_autor, data_foto, cidade, id_estado, id_pais, orientacao, assunto_principal, dim_a, dim_b, direito_img, extra) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['tombo'], "text"),
                       GetSQLValueString($_POST['autor'], "int"),
                       GetSQLValueString($_POST['data'], "text"),
                       GetSQLValueString($_POST['cidade'], "text"),
                       GetSQLValueString($_POST['estado'], "int"),
                       GetSQLValueString($_POST['pais'], "text"),
                       GetSQLValueString($orientacao, "text"),
                       GetSQLValueString($_POST['assunto_principal'], "text"),
                       GetSQLValueString($width, "int"),
                       GetSQLValueString($height, "int"),
                       GetSQLValueString($direito_img, "int"),
                       GetSQLValueString($_POST['extra'], "text"));
                       
  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
if($_POST['extra'] != "") {
  $insertextraSQL = sprintf("INSERT INTO Fotos_extra (tombo, extra) VALUES (%s, %s)",
                       GetSQLValueString($_POST['tombo'], "text"),
                       GetSQLValueString($_POST['extra'], "text"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result2 = mysql_query($insertextraSQL, $pulsar) or die(mysql_error());
}
  $insertGoTo = "adm_index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST['del_cromo'])) && ($_POST['del_cromo'] != "")) {
  $deleteSQL = sprintf("DELETE FROM Fotos WHERE Id_Foto=%s",
                       GetSQLValueString($_POST['del_cromo'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
  
  $deleteSQL = sprintf("DELETE FROM rel_fotos_temas WHERE id_foto=%s",
                       GetSQLValueString($_POST['del_cromo'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());

  $deleteSQL = sprintf("DELETE FROM rel_fotos_pal_ch WHERE id_foto=%s",
                       GetSQLValueString($_POST['del_cromo'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());

  header("Location: adm_index.php");
}

if ((isset($_POST['descritor'])) && ($_POST['descritor'] != "") && ($_POST['excluir'] == "descritor")) {
$descr = $_POST['descritor'];
foreach ($descr as $d) {
  $deleteSQL = sprintf("DELETE FROM rel_fotos_pal_ch WHERE id_rel=%s",
                       GetSQLValueString($d, "int"));
  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
}
  header("Location: adm_index.php?tombo=".$_POST['tombo']);
}

if ((isset($_POST['tema'])) && ($_POST['tema'] != "") && ($_POST['excluir'] == "tema")) {
  $deleteSQL = sprintf("DELETE FROM rel_fotos_temas WHERE id_rel=%s",
                       GetSQLValueString($_POST['tema'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
  header("Location: adm_index.php?tombo=".$_POST['tombo']);
}

$colname_dados_foto = "0";
if (isset($_GET['tombo'])) {
  $colname_dados_foto = (get_magic_quotes_gpc()) ? $_GET['tombo'] : addslashes($_GET['tombo']);
}
if (isset($_POST['tombo'])) {
  $colname_dados_foto = (get_magic_quotes_gpc()) ? $_POST['tombo'] : addslashes($_POST['tombo']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_dados_foto = sprintf("SELECT * FROM Fotos WHERE tombo = '%s'", $colname_dados_foto);
$dados_foto = mysql_query($query_dados_foto, $pulsar) or die(mysql_error());
$row_dados_foto = mysql_fetch_assoc($dados_foto);
$totalRows_dados_foto = mysql_num_rows($dados_foto);

mysql_select_db($database_pulsar, $pulsar);
$query_extra_foto = sprintf("SELECT * FROM Fotos_extra WHERE tombo = '%s'", $colname_dados_foto);
$extra_foto = mysql_query($query_extra_foto, $pulsar) or die(mysql_error());
$row_extra_foto = mysql_fetch_assoc($extra_foto);
$totalRows_extra_foto = mysql_num_rows($extra_foto);

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

mysql_select_db($database_pulsar, $pulsar);
$query_descritore = sprintf("SELECT    Fotos.tombo,   pal_chave.Id,   pal_chave.Pal_Chave,  rel_fotos_pal_ch.id_rel FROM  rel_fotos_pal_ch  INNER JOIN Fotos ON (rel_fotos_pal_ch.id_foto=Fotos.Id_Foto)  INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave) WHERE   (Fotos.tombo = '%s') ORDER BY pal_chave.Pal_Chave",$row_dados_foto['tombo']);
$descritore = mysql_query($query_descritore, $pulsar) or die(mysql_error());
$row_descritore = mysql_fetch_assoc($descritore);
$totalRows_descritore = mysql_num_rows($descritore);

mysql_select_db($database_pulsar, $pulsar);
$query_temas = sprintf("SELECT   Fotos.tombo,  super_temas.Tema_total,  super_temas.Id,  rel_fotos_temas.id_rel FROM Fotos INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto) INNER JOIN super_temas ON (rel_fotos_temas.id_tema=super_temas.Id) WHERE   (Fotos.tombo = '%s') ORDER BY  super_temas.Tema_total",$row_dados_foto['tombo']);
$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
$row_temas = mysql_fetch_assoc($temas);
$totalRows_temas = mysql_num_rows($temas);

// Deteccao de fotografo
$inicial = strtoupper(ereg_replace("[^A-Za-z]","", $_GET['tombo']));
mysql_select_db($database_pulsar, $pulsar);
$query_ini_fotografo = sprintf("SELECT * FROM fotografos WHERE Iniciais_Fotografo = '%s'", $inicial);
$ini_fotografo = mysql_query($query_ini_fotografo, $pulsar) or die(mysql_error());
$row_ini_fotografo = mysql_fetch_assoc($ini_fotografo);
$totalRows_ini_fotografo = mysql_num_rows($ini_fotografo);

$autor_encontrado = false;
if($totalRows_ini_fotografo > 0) {
	$autor_encontrado = true;
}

if(strlen($_GET['tombo']) > 4) {
	if(!file_exists($fotosalta.$_GET['tombo'].".jpg") && !file_exists($fotosalta.$_GET['tombo'].".JPG")) {
?>
<script>
alert('Tombo <?php echo $_GET['tombo']?> não presente no <?php echo $fotosalta?>');
</script>
<?php 
	}
}

// se ï¿½ nova indexaï¿½ï¿½o vai para outra tela
if ($totalRows_dados_foto == 0) { 
  if (($_GET['tombo'] != "") && ($_POST['del_cromo'] == "") && ($row_login['index_inc']==1)) {
    header(sprintf("Location: adm_index_inc.php?tombo=%s", $_GET['tombo']));
  }
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Indexa&ccedil;&atilde;o</title>
<!-- 
<?php 
echo "*".$fotosalta.$_GET['tombo'].".jpg\n";
echo "**".$fotosalta.$_GET['tombo'].".JPG\n";
echo "$";
echo !file_exists($fotosalta.$_GET['tombo'].".jpg");
echo "$$";
echo !file_exists($fotosalta.$_GET['tombo'].".JPG");
?>
-->
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FFFFFF;
}
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10pt;
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

function atualizar(tela,valor) {

	var combo = document.form2.tema;
	//alert(combo.options.length);
	combo.options[combo.options.length]=new Option(tela, valor);

}

function atualizar2(tela,valor) {

	var combo = document.form2.descritor;
	//alert(combo.options.length);
	combo.options[combo.options.length]=new Option(tela, valor);

}

<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
function confirmSubmit()
{
var agree=confirm("Confirma exclusão?");
if (agree)
	document.form2.submit();
else
	return false ;
}
function confirmSubmit2()
{
var agree=confirm("Confirma exclusão do cromo?");
if (agree)
	document.form3.submit();
else
	return false ;
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function fix_data() {
if (document.form2.data_tela.value.length == 0) {
	document.form2.data.value = document.form2.data_tela.value;
	}
if (document.form2.data_tela.value.length == 4) {
	document.form2.data.value = document.form2.data_tela.value;
	}
if (document.form2.data_tela.value.length == 7) {
	document.form2.data.value = document.form2.data_tela.value.substring(3,7)+document.form2.data_tela.value.substring(0,2);
	}
if (document.form2.data_tela.value.length == 10) {
	document.form2.data.value = document.form2.data_tela.value.substring(6,10)+document.form2.data_tela.value.substring(3,5)+document.form2.data_tela.value.substring(0,2);
	}

}
function fix_data2() {
if (document.form4.data_tela.value.length == 4) {
	document.form4.data.value = document.form4.data_tela.value;
	}
if (document.form4.data_tela.value.length == 7) {
	document.form4.data.value = document.form4.data_tela.value.substring(3,7)+document.form4.data_tela.value.substring(0,2);
	}
if (document.form4.data_tela.value.length == 10) {
	document.form4.data.value = document.form4.data_tela.value.substring(6,10)+document.form4.data_tela.value.substring(3,5)+document.form4.data_tela.value.substring(0,2);
	}

}
//-->
</script>
</head>

<body>
<table width="100%"  border="0" cellpadding="5" cellspacing="0" bgcolor="#FF9900">
   <tr>
     <td class="style1">pulsarimagens.com.br<br>
         indexa&ccedil;&atilde;o</td>
     <td class="style1"><div align="right">
       <input name="Button" type="button" onClick="MM_goToURL('parent','administra2.php');return document.MM_returnValue" value="Menu Principal">
     </div></td>
   </tr>
</table>
<form action="" method="get" name="form1" class="style2">
   Tombo: 
   <input name="tombo" type="text" id="tombo" value="<?php
if (isset($_GET['tombo'])) { echo $_GET['tombo']; }
if (isset($_POST['tombo'])) { echo $_POST['tombo']; }

 ?>">
   <input type="submit" name="Submit" value="Consultar">
</form>
<?php if ($totalRows_dados_foto > 0) { // Show if recordset not empty ?>
<form name="form2" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="750" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="style2"><div align="center"><img src="http://www.pulsarimagens.com.br/bancoImagens/<?php echo $row_dados_foto['tombo']; ?>p.jpg" align="middle" onclick="MM_openBrWindow('http://www.pulsarimagens.com.br/bancoImagens/<?php echo $row_dados_foto['tombo']; ?>.jpg','','resizable=yes,width=550,height=550')"><br>
        <br>
      <input type="button" name="botao" value="Extra IPTC" align="middle" onclick="MM_openBrWindow('<?=$homeurl ?>toolkit/Example.php?jpeg_fname=<?php echo $row_dados_foto['tombo']; ?>','','scrollbars=yes,resizable=yes,width=600,height=800')"><br>
      </div></td>
      <td class="style2">
	<IFRAME ID=IFrame1 FRAMEBORDER=0 SCROLLING=YES SRC="iptc.php?foto=<?php echo $row_dados_foto['tombo']; ?>"></IFRAME>	  	
	  </td>
    </tr>
    <tr>
      <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="1">
        <tr>
          <td class="style2">Tombo:</td>
          <td class="style6"><label class="style6">
            <input name="tombo" type="text" id="tombo" value="<?php echo $row_dados_foto['tombo']; ?>">
          </label></td>
        </tr>
        <tr>
          <td width="150" class="style2">Assunto Principal: </td>
          <td class="style6"><input name="assunto_principal" type="text" id="assunto_principal" value="<?php echo $row_dados_foto['assunto_principal']; ?>" size="70" maxlength="100">
            <input name="Id_Foto" type="hidden" id="Id_Foto" value="<?php echo $row_dados_foto['Id_Foto']; ?>"></td>
        </tr>
        <tr>
          <td width="150" class="style2">Informa&ccedil;&atilde;o Adicional: </td>
          <td class="style6"><input name="extra" type="text" id="extra" value="<?php echo $row_extra_foto['extra']; ?>" size="70">
            <input name="Id_Foto" type="hidden" id="Id_Foto" value="<?php echo $row_dados_foto['Id_Foto']; ?>"></td>
        </tr>
        <tr>
          <td width="150" class="style2">Uso de Imagem: </td>
<!--           <td class="style2"><input name="dir_img" type="checkbox" id="dir_img" value="<?php echo $row_dados_foto['direito_img']; ?>"></td> -->
          <td class="style6"><input name="dir_img" type="radio" id="dir_img" value="0" <?php echo ($row_dados_foto['direito_img'] != 1 && $row_dados_foto['direito_img'] != 2 ? "checked":"");?>>Nenhum
          <input name="dir_img" type="radio" id="dir_img" value="1" <?php echo ($row_dados_foto['direito_img'] == 1 ? "checked":"");?>>Uso Autorizado 
          <input name="dir_img" type="radio" id="dir_img" value="2" <?php echo ($row_dados_foto['direito_img'] == 2 ? "checked":"");?>>Autorizado+Acréscimo de 100%</td>
        </tr>
        <tr>
          <td width="150" class="style2">Autor:</td>
          <td class="style6"><select name="autor" id="autor" <?php if ($autor_encontrado) { ?>disabled="disabled" <?php } ?>>
            <?php
do {  
?>
            <option value="<?php echo $row_fotografos['id_fotografo']?>"<?php if (!(strcmp($row_fotografos['id_fotografo'], $row_dados_foto['id_autor']))) {echo "SELECTED";} ?>><?php echo $row_fotografos['Nome_Fotografo']?></option>
            <?php
} while ($row_fotografos = mysql_fetch_assoc($fotografos));
  $rows = mysql_num_rows($fotografos);
  if($rows > 0) {
      mysql_data_seek($fotografos, 0);
	  $row_fotografos = mysql_fetch_assoc($fotografos);
  }
?>
          </select>
<?php if ($autor_encontrado) { ?>          
			<input name="autor" type="hidden" id="autor" value="<?php echo $row_dados_foto['id_autor']; ?>"/>
<?php } ?>			
          </td>
        </tr>
        <tr>
          <td width="150" class="style2">Data:</td>
          <td class="style6"><input name="data_tela" type="text" id="data_tela" onBlur="MM_callJS('fix_data()')" value="<?php if (strlen($row_dados_foto['data_foto']) == 4) {
			echo $row_dados_foto['data_foto'];
		} elseif (strlen($row_dados_foto['data_foto']) == 6) {
			echo substr($row_dados_foto['data_foto'],4,2).'/'.substr($row_dados_foto['data_foto'],0,4);
		} elseif (strlen($row_dados_foto['data_foto']) == 8) {
			echo substr($row_dados_foto['data_foto'],6,2).'/'.substr($row_dados_foto['data_foto'],4,2).'/'.substr($row_dados_foto['data_foto'],0,4);
		} ?>">
            <input name="data" type="hidden" id="data" value="<?php echo $row_dados_foto['data_foto']; ?>"></td>
        </tr>
        <tr>
          <td width="150" class="style2">Cidade:</td>
          <td class="style6"><input name="cidade" type="text" id="cidade" value="<?php echo $row_dados_foto['cidade']; ?>" size="70"></td>
        </tr>
        <tr>
          <td width="150" class="style2">Estado:</td>
          <td class="style6"><select name="estado" id="estado">
            <option value="" <?php if (!(strcmp("", $row_dados_foto['id_estado']))) {echo "SELECTED";} ?>>---
            em branco ---</option>
            <?php
do {  
?>
            <option value="<?php echo $row_estado['id_estado']?>"<?php if (!(strcmp($row_estado['id_estado'], $row_dados_foto['id_estado']))) {echo "SELECTED";} ?>><?php echo $row_estado['Estado']?></option>
            <?php
} while ($row_estado = mysql_fetch_assoc($estado));
  $rows = mysql_num_rows($estado);
  if($rows > 0) {
      mysql_data_seek($estado, 0);
	  $row_estado = mysql_fetch_assoc($estado);
  }
?>
          </select></td>
        </tr>
        <tr>
          <td width="150" class="style2">Pa&iacute;s:</td>
          <td class="style6"><select name="pais" id="pais">
            <option value="" <?php if (!(strcmp("", $row_dados_foto['id_pais']))) {echo "SELECTED";} ?>>---
            em branco ---</option>
            <?php
do {  
?>
            <option value="<?php echo $row_pais['id_pais']?>"<?php if (!(strcmp($row_pais['id_pais'], $row_dados_foto['id_pais']))) {echo "SELECTED";} ?>><?php echo $row_pais['nome']?></option>
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
          <td width="150" class="style2">Orienta&ccedil;&atilde;o:</td>
          <td class="style6"><select name="orientacao" id="orientacao">
            <option value="H" <?php if (!(strcmp("H", $row_dados_foto['orientacao']))) {echo "SELECTED";} ?>>Horizontal</option>
            <option value="V" <?php if (!(strcmp("V", $row_dados_foto['orientacao']))) {echo "SELECTED";} ?>>Vertical</option>
          </select></td>
        </tr>
        <tr>
          <td width="150" class="style2">Temas:</td>
          <td class="style6">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td rowspan="2"><select name="tema" size="5" id="tema">
                  <?php
do {  
?>
                  <option value="<?php echo $row_temas['id_rel']?>"><?php echo $row_temas['Tema_total']?></option>
                  <?php
} while ($row_temas = mysql_fetch_assoc($temas));
  $rows = mysql_num_rows($temas);
  if($rows > 0) {
      mysql_data_seek($temas, 0);
	  $row_temas = mysql_fetch_assoc($temas);
  }
?>
                                                </select></td>
                <td valign="bottom"><?php if ($row_login['index_alt']==1) {?><input name="Button" type="button" onClick="MM_openBrWindow('adm_index_tema.php?Id_Foto=<?php echo $row_dados_foto['Id_Foto']; ?>&tombo=<?php echo $row_dados_foto['tombo']; ?>','','width=680,height=140,top=400,left=250')" value="Incluir Tema"><?php } ?></td>
              </tr>
              <tr>
                <td valign="top"><?php if ($row_login['index_alt']==1) {?><input type="button" name="Button" onClick="document.form2.excluir.value = 'tema'; return confirmSubmit()" value="Excluir Tema"><?php } ?>                  </td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td class="style2">Descritores:</td>
          <td class="style6"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td rowspan="2"><select name="descritor[]" size="5" multiple id="descritor">
                <?php
do {  
?>
                <option value="<?php echo $row_descritore['id_rel']?>"><?php echo $row_descritore['Pal_Chave']?></option>
                <?php
} while ($row_descritore = mysql_fetch_assoc($descritore));
  $rows = mysql_num_rows($descritore);
  if($rows > 0) {
      mysql_data_seek($descritore, 0);
	  $row_descritore = mysql_fetch_assoc($descritore);
  }
?>
                            </select></td>
              <td valign="bottom"><?php if ($row_login['index_alt']==1) {?><input name="Button" type="button" onClick="MM_openBrWindow('adm_index_desc.php?Id_Foto=<?php echo $row_dados_foto['Id_Foto']; ?>&tombo=<?php echo $row_dados_foto['tombo']; ?>','','scrollbars=yes,width=470,height=80,top=500,left=250')" value="Incluir Descritor"><?php } ?></td>
            </tr>
            <tr>
              <td valign="top"><?php if ($row_login['index_alt']==1) {?><input type="button" name="Button" onClick="document.form2.excluir.value = 'descritor'; return confirmSubmit()" value="Excluir Descritor"><?php } ?></td>
            </tr>
          </table></td>
        </tr>
		<?php if ($row_login['index_alt']==1) {?>
        <tr>
          <td colspan="2" class="style6"><div align="center"><br>
                <input name="excluir" type="hidden" id="excluir" value = "">
                <input type="submit" name="Submit" value="Gravar" onClick="document.form2.excluir.value = ''">
          </div></td>
          </tr>
		  <?php } ?>
      </table></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form2"></form>
<?php if ($row_login['index_del']==1) {?>
<table width="600"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><form name="form3" method="post" action="">
      <div align="center">
        <input name="Button" type="button" onClick="MM_callJS('confirmSubmit2();')" value="Excluir Cromo">
        <input name="del_cromo" type="hidden" id="del_cromo" value="<?php echo $row_dados_foto['Id_Foto']; ?>">
</div>
    </form></td>
  </tr>
</table>
<?php
  } 
} else {
?>
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
<?php } ?>
</body>
</html>
<?php
mysql_free_result($dados_foto);

mysql_free_result($fotografos);

mysql_free_result($estado);

mysql_free_result($pais);

mysql_free_result($descritore);

mysql_free_result($temas);

mysql_free_result($login);

?>