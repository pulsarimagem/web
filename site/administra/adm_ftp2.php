<?php require_once('Connections/pulsar.php'); ?>
<?php
//session_start();
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
// Excluir Arquivos

if (isset($_POST['MM_Del'])) {
unlink($homeftp.$_POST['id_login']."/".$_POST['arquivo']);
$deleteSQL = sprintf("DELETE FROM ftp_arquivos WHERE nome = %s AND id_ftp = %s",
			GetSQLValueString($_POST['arquivo'], "text"),
			GetSQLValueString($_POST['id_login'], "int")
);
mysql_select_db($database_pulsar, $pulsar);
$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
}

// Incluir Arquivos 1

/* Defina aqui o tamanho mï¿½ximo do arquivo em bytes: */

if($_FILES['arquivo1']['size'] > 102400000) {
print "<SCRIPT> alert('Seu arquivo nï¿½o poderï¿½ ser maior que 100mb'); window.history.go(-1); </SCRIPT>\n";
exit;
}

/* Defina aqui o diretï¿½rio destino do upload */
$arquivo1 = $_FILES['arquivo1']['name'];
if (!empty($arquivo1)) {
$caminho1=$homeftp.$_POST['id_login']."/";
$caminho1=$caminho1.$arquivo1;

/* Defina aqui o tipo de arquivo suportado */
if ((eregi(".gif$", $arquivo1)) || (eregi(".jpg$", $arquivo1)) || (eregi(".tif$", $arquivo1)) || (eregi(".rar$", $arquivo1)) || (eregi(".zip$", $arquivo1))){
$copy = copy($_FILES['arquivo1']['tmp_name'],$caminho1);
print "<script>alert('Arquivo enviado com sucesso!')</script>";
}
else{
print "<script>alert('Arquivo não enviado!!!!!!! - Caminho ou nome invï¿½lido!')</script>";
}

$insertSQL = sprintf("INSERT INTO ftp_arquivos (id_ftp, data_cria,nome,tamanho,validade,observacoes) VALUES (%s,%s,%s,%s,%s,%s)",
			GetSQLValueString($_POST['id_login'], "int"),
			GetSQLValueString(date("Y-m-d h:i:s", strtotime('now')), "date"),
			GetSQLValueString($arquivo1, "text"),
			GetSQLValueString($_FILES['arquivo1']['size'], "long"),
			GetSQLValueString($_POST["validade1"], "int"),
			GetSQLValueString($_POST["observacoes1"], "text")
);

mysql_select_db($database_pulsar, $pulsar);
$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
}

// Incluir Arquivos 2

/* Defina aqui o tamanho mï¿½ximo do arquivo em bytes: */

if($_FILES['arquivo2']['size'] > 102400000) {
print "<SCRIPT> alert('Seu arquivo não poderá ser maior que 100mb'); window.history.go(-1); </SCRIPT>\n";
exit;
}

/* Defina aqui o diretï¿½rio destino do upload */
$arquivo2 = $_FILES['arquivo2']['name'];
if (!empty($arquivo2)) {
$caminho2=$homeftp.$_POST['id_login']."/";
$caminho2=$caminho2.$arquivo2;

/* Defina aqui o tipo de arquivo suportado */
if ((eregi(".gif$", $arquivo2)) || (eregi(".jpg$", $arquivo2)) || (eregi(".tif$", $arquivo2)) || (eregi(".rar$", $arquivo2)) || (eregi(".zip$", $arquivo2))){
$copy = copy($_FILES['arquivo2']['tmp_name'],$caminho2);
print "<script>alert('Arquivo enviado com sucesso!')</script>";
}
else{
print "<script>alert('Arquivo nï¿½o enviado!!!!!!! - Caminho ou nome invï¿½lido!')</script>";
}

$insertSQL = sprintf("INSERT INTO ftp_arquivos (id_ftp, data_cria,nome,tamanho,validade,observacoes) VALUES (%s,%s,%s,%s,%s,%s)",
			GetSQLValueString($_POST['id_login'], "int"),
			GetSQLValueString(date("Y-m-d h:i:s", strtotime('now')), "date"),
			GetSQLValueString($arquivo2, "text"),
			GetSQLValueString($_FILES['arquivo2']['size'], "long"),
			GetSQLValueString($_POST["validade2"], "int"),
			GetSQLValueString($_POST["observacoes2"], "text")
);

mysql_select_db($database_pulsar, $pulsar);
$Result2 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
}

// Incluir Arquivos 3

/* Defina aqui o tamanho mï¿½ximo do arquivo em bytes: */

if($_FILES['arquivo3']['size'] > 102400000) {
print "<SCRIPT> alert('Seu arquivo nï¿½o poderï¿½ ser maior que 100mb'); window.history.go(-1); </SCRIPT>\n";
exit;
}

/* Defina aqui o diretï¿½rio destino do upload */
$arquivo3 = $_FILES['arquivo3']['name'];
if (!empty($arquivo3)) {
$caminho3=$homeftp.$_POST['id_login']."/";
$caminho3=$caminho3.$arquivo3;

/* Defina aqui o tipo de arquivo suportado */
if ((eregi(".gif$", $arquivo3)) || (eregi(".jpg$", $arquivo3)) || (eregi(".tif$", $arquivo3)) || (eregi(".rar$", $arquivo3)) || (eregi(".zip$", $arquivo3))){
$copy = copy($_FILES['arquivo3']['tmp_name'],$caminho3);
print "<script>alert('Arquivo enviado com sucesso!')</script>";
}
else{
print "<script>alert('Arquivo nï¿½o enviado!!!!!!! - Caminho ou nome invï¿½lido!')</script>";
}

$insertSQL = sprintf("INSERT INTO ftp_arquivos (id_ftp, data_cria,nome,tamanho,validade,observacoes) VALUES (%s,%s,%s,%s,%s,%s)",
			GetSQLValueString($_POST['id_login'], "int"),
			GetSQLValueString(date("Y-m-d h:i:s", strtotime('now')), "date"),
			GetSQLValueString($arquivo3, "text"),
			GetSQLValueString($_FILES['arquivo3']['size'], "long"),
			GetSQLValueString($_POST["validade3"], "int"),
			GetSQLValueString($_POST["observacoes3"], "text")
);

mysql_select_db($database_pulsar, $pulsar);
$Result3 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
}

// Incluir Arquivos 4

/* Defina aqui o tamanho mï¿½ximo do arquivo em bytes: */

if($_FILES['arquivo4']['size'] > 102400000) {
print "<SCRIPT> alert('Seu arquivo nï¿½o poderï¿½ ser maior que 100mb'); window.history.go(-1); </SCRIPT>\n";
exit;
}

/* Defina aqui o diretï¿½rio destino do upload */
$arquivo4 = $_FILES['arquivo4']['name'];
if (!empty($arquivo4)) {
$caminho4=$homeftp.$_POST['id_login']."/";
$caminho4=$caminho4.$arquivo4;

/* Defina aqui o tipo de arquivo suportado */
if ((eregi(".gif$", $arquivo4)) || (eregi(".jpg$", $arquivo4)) || (eregi(".tif$", $arquivo4)) || (eregi(".rar$", $arquivo4)) || (eregi(".zip$", $arquivo4))){
$copy = copy($_FILES['arquivo4']['tmp_name'],$caminho4);
print "<script>alert('Arquivo enviado com sucesso!')</script>";
}
else{
print "<script>alert('Arquivo nï¿½o enviado!!!!!!! - Caminho ou nome invï¿½lido!')</script>";
}

$insertSQL = sprintf("INSERT INTO ftp_arquivos (id_ftp, data_cria,nome,tamanho,validade,observacoes) VALUES (%s,%s,%s,%s,%s,%s)",
			GetSQLValueString($_POST['id_login'], "int"),
			GetSQLValueString(date("Y-m-d h:i:s", strtotime('now')), "date"),
			GetSQLValueString($arquivo4, "text"),
			GetSQLValueString($_FILES['arquivo4']['size'], "long"),
			GetSQLValueString($_POST["validade4"], "int"),
			GetSQLValueString($_POST["observacoes4"], "text")
);

mysql_select_db($database_pulsar, $pulsar);
$Result4 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
}

// Incluir Arquivos 5

/* Defina aqui o tamanho mï¿½ximo do arquivo em bytes: */

if($_FILES['arquivo5']['size'] > 102400000) {
print "<SCRIPT> alert('Seu arquivo nï¿½o poderï¿½ ser maior que 100mb'); window.history.go(-1); </SCRIPT>\n";
exit;
}

/* Defina aqui o diretï¿½rio destino do upload */
$arquivo5 = $_FILES['arquivo5']['name'];
if (!empty($arquivo5)) {
$caminho5=$homeftp.$_POST['id_login']."/";
$caminho5=$caminho5.$arquivo5;

/* Defina aqui o tipo de arquivo suportado */
if ((eregi(".gif$", $arquivo5)) || (eregi(".jpg$", $arquivo5)) || (eregi(".tif$", $arquivo5)) || (eregi(".rar$", $arquivo5)) || (eregi(".zip$", $arquivo5))){
$copy = copy($_FILES['arquivo5']['tmp_name'],$caminho5);
print "<script>alert('Arquivo enviado com sucesso!')</script>";
}
else{
print "<script>alert('Arquivo nï¿½o enviado!!!!!!! - Caminho ou nome invï¿½lido!')</script>";
}

$insertSQL = sprintf("INSERT INTO ftp_arquivos (id_ftp, data_cria,nome,tamanho,validade,observacoes) VALUES (%s,%s,%s,%s,%s,%s)",
			GetSQLValueString($_POST['id_login'], "int"),
			GetSQLValueString(date("Y-m-d h:i:s", strtotime('now')), "date"),
			GetSQLValueString($arquivo5, "text"),
			GetSQLValueString($_FILES['arquivo5']['size'], "long"),
			GetSQLValueString($_POST["validade5"], "int"),
			GetSQLValueString($_POST["observacoes5"], "text")
);

mysql_select_db($database_pulsar, $pulsar);
$Result5 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
}


// ----

$colname_arquivos = "-1";
if (isset($_POST['id_login'])) {
  $colname_arquivos = (get_magic_quotes_gpc()) ? $_POST['id_login'] : addslashes($_POST['id_login']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_arquivos = sprintf("SELECT * FROM ftp_arquivos WHERE id_ftp = %s ORDER BY nome", $colname_arquivos);
$arquivos = mysql_query($query_arquivos, $pulsar) or die(mysql_error());
$row_arquivos = mysql_fetch_assoc($arquivos);
$totalRows_arquivos = mysql_num_rows($arquivos);

function DoFormatNumber($theObject,$NumDigitsAfterDecimal,$DecimalSeparator,$GroupDigits) { 
	$currencyFormat=number_format($theObject,$NumDigitsAfterDecimal,$DecimalSeparator,$GroupDigits);
	return ($currencyFormat);
}

function makeStamp($theString) {
  if (ereg("([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})", $theString, $strReg)) {
    $theStamp = mktime($strReg[4],$strReg[5],$strReg[6],$strReg[2],$strReg[3],$strReg[1]);
  } else if (ereg("([0-9]{4})-([0-9]{2})-([0-9]{2})", $theString, $strReg)) {
    $theStamp = mktime(0,0,0,$strReg[2],$strReg[3],$strReg[1]);
  } else if (ereg("([0-9]{2}):([0-9]{2}):([0-9]{2})", $theString, $strReg)) {
    $theStamp = mktime($strReg[1],$strReg[2],$strReg[3],0,0,0);
  }
  return $theStamp;
}

function makeDateTime($theString, $theFormat) {
  $theDate=date($theFormat, makeStamp($theString));
  return $theDate;
} 

?>
<?php

// REMOVER DIRETï¿½RIO ***

function ftp_rmdirr($ftp_stream, $directory) 
{ 
    // Sanity check 
    if (!is_resource($ftp_stream) || 
        get_resource_type($ftp_stream) !== 'FTP Buffer') { 
  
        return false; 
    } 
  
    // Init 
    $i             = 0; 
    $files         = array(); 
    $folders       = array(); 
    $statusnext    = false; 
    $currentfolder = $directory; 
  
    // Get raw file listing 
    $list = ftp_rawlist($ftp_stream, $directory, true); 
  
    // Iterate listing 
    foreach ($list as $current) { 
         
        // An empty element means the next element will be the new folder 
        if (empty($current)) { 
            $statusnext = true; 
            continue; 
        } 
  
        // Save the current folder 
        if ($statusnext === true) { 
            $currentfolder = substr($current, 0, -1); 
            $statusnext = false; 
            continue; 
        } 
  
        // Split the data into chunks 
        $split = preg_split('[ ]', $current, 9, PREG_SPLIT_NO_EMPTY); 
        $entry = $split[8]; 
        $isdir = ($split[0]{0} === 'd') ? true : false; 
  
        // Skip pointers 
        if ($entry === '.' || $entry === '..') { 
            continue; 
        } 
  
        // Build the file and folder list 
        if ($isdir === true) { 
            $folders[] = $currentfolder . '/' . $entry; 
        } else { 
            $files[] = $currentfolder . '/' . $entry; 
        } 
  
    } 
  
    // Delete all the files 
    foreach ($files as $file) { 
        ftp_delete($ftp_stream, $file); 
    } 
  
    // Delete all the directories 
    // Reverse sort the folders so the deepest directories are unset first 
    rsort($folders); 
    foreach ($folders as $folder) { 
        ftp_rmdir($ftp_stream, $folder); 
    } 
  
    // Delete the final folder and return its status 
    return ftp_rmdir($ftp_stream, $directory); 
} 

// REMOVER DIRETï¿½RIO ***

if (isset($_POST['diretorioxxx'])) {

			$ftproot = "/public_html/ftp/";
			$srcroot = $homeftp;        
			$srcrela = ltrim($_POST['diretorioxxx'],"0")."/";
/*
			$ftpc = ftp_connect("ftp.pulsarimagens.com.br");
			$ftpr = ftp_login($ftpc,"admpul","padm25sar");

			if ((!$ftpc) || (!$ftpr)) { echo "FTP connection not established!"; die(); }
			if (!chdir($srcroot)) { echo "Could not enter local source root directory."; die(); }
			if (!ftp_chdir($ftpc,$ftproot)) { echo "Could not enter FTP root directory."; die(); }

			ftp_rmdirr    ($ftpc,$ftproot.$srcrela);
		    // close the FTP connection
			ftp_close($ftpc);
*/
			if (rmdir($srcroot.$srcrela)) {

?><script language="JavaScript" type="text/JavaScript">
alert("Diretï¿½rio removido com sucesso!!!");
</script><?php

			} else {
				echo "Erro ao apagar diretï¿½rio!!!!"; die();
			}

			$deleteSQL = sprintf("DELETE FROM ftp WHERE id_login = %s",
                    $_POST['diretorioxxx']);
			mysql_select_db($database_pulsar, $pulsar);
			$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
			$deleteSQL = sprintf("DELETE FROM ftp_arquivos WHERE id_ftp = %s",
                    $_POST['diretorioxxx']);
			mysql_select_db($database_pulsar, $pulsar);
			$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
/*
			$deleteSQL = sprintf("DELETE FROM ftp_arquivos WHERE id_ftp = %s",
                    $_POST['diretorioxxx']);
			mysql_select_db($database_pulsar, $pulsar);
			$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
*/			
		} ;

mysql_select_db($database_pulsar, $pulsar);
$query_diretorios = "SELECT ftp.id_ftp,   cadastro.login, cadastro.empresa,   ftp.id_login, cadastro.nome, cadastro.email FROM cadastro  INNER JOIN ftp ON (cadastro.id_cadastro=ftp.id_login) ORDER BY cadastro.nome";
$diretorios = mysql_query($query_diretorios, $pulsar) or die(mysql_error());
$row_diretorios = mysql_fetch_assoc($diretorios);
$totalRows_diretorios = mysql_num_rows($diretorios);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>inclui/exclui arquivos</title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FFFFFF;
}
.style4 {
	color: #000000;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
}
.style5 {color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.style7 {
	color: #FF0000;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
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
         tela do administrador</td>
		 <TD class=style27>
        <DIV align=right>
          <INPUT onclick="MM_goToURL('parent','administra2.php');return document.MM_returnValue" type=button value="Menu Principal" name=Button>
      </DIV></TD>
   </tr>
</table>
<br>
<form name="form1" method="post" action="">
  <span class="style4">Escolha a pasta:</span> 
  <select name="id_login" id="id_login">
    <?php
do {  
?>
    <option value="<?php echo $row_diretorios['id_login']?>"<?php if (isset($_POST['id_login']) && !(strcmp($row_diretorios['id_login'], $_POST['id_login']))) {echo "selected=\"selected\"";} ?>><?php echo $row_diretorios['nome']?>/<?php echo $row_diretorios['empresa']?></option>
    <?php
} while ($row_diretorios = mysql_fetch_assoc($diretorios));
  $rows = mysql_num_rows($diretorios);
  if($rows > 0) {
      mysql_data_seek($diretorios, 0);
	  $row_diretorios = mysql_fetch_assoc($diretorios);
  }
?>
  </select>
  <input type="submit" name="Submit" value="confirma">
  <input name="Submit2" type="button" onClick="MM_openBrWindow('adm_ftp_pesq.php','','scrollbars,width=700,height=500')" value="cadastrar novo">
  <input name="Cleanup" type="button" onClick="MM_openBrWindow('CleanFTP.php','','scrollbars,width=700,height=500')" value="Limpar Arquivos Antigos">
</form>
  <?php if (isset($_POST['id_login'])) {
if ($totalRows_arquivos > 0) { // Show if recordset not empty ?>
    <span class="style5">Arquivos:</span><br>
    <br>
    <table width="550" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td bgcolor="#CCCCCC" class="style4"><strong>Arquivo</strong></td>
        <td bgcolor="#CCCCCC" class="style5"><div align="right">Tamanho</div></td>
        <td bgcolor="#CCCCCC" class="style5"><div align="center">Data Upload </div></td>
        <td bgcolor="#CCCCCC" class="style5"><div align="center">Validade</div></td>
        <td bgcolor="#CCCCCC" class="style4">&nbsp;</td>
      </tr>
      <?php do { ?>
      <tr>
        <td class="style4"><?php echo $row_arquivos['nome']; ?></td>
        <td class="style4"><div align="right"><?php 
        $tamanho = DoFormatNumber($row_arquivos['tamanho'], 0, ',', '.');
        if($tamanho == 0) {
			if($row_arquivos['flag'] == "VS")
				$tamanho = "SD";
			else if($row_arquivos['flag'] == "VH")
				$tamanho = "HD";
		}
        echo $tamanho; 
        ?></div></td>
        <td class="style4"><div align="center"><?php echo makeDateTime($row_arquivos['data_cria'], 'd/m/y'); ?>-<?php echo makeDateTime($row_arquivos['data_cria'], 'H:i:s'); ?></div></td>
        <td class="style4"><div align="center"><?php echo $row_arquivos['validade']; ?></div></td>
        <form name="delete" action="adm_ftp2.php" method="post" >
		<td><input type="submit" name="Submit3" value="Del">
        <input name="id_login" type="hidden" id="id_login" value="<?php echo $_POST['id_login']; ?>">
        <input name="arquivo" type="hidden" id="arquivo" value="<?php echo $row_arquivos['nome']; ?>">
        <input name="MM_Del" type="hidden" id="MM_Del" value="delete"></td></form>
      </tr>
        <?php } while ($row_arquivos = mysql_fetch_assoc($arquivos)); ?>
</table>
    <?php } else { ?>
	<span class="style7">Diretório vazio!!! </span><?php }; ?>
	<br>
	<br>
<form name="form2" method="post" action="">
	  <input type="button" name="Submit6" value="Copiar arquivo de Alta" onClick="MM_openBrWindow('adm_ftp_copy.php?id=<?php echo $_POST['id_login']; ?>','','width=800,height=250')">
	  <input type="button" name="Submit7" value="Copiar Videos" onClick="MM_openBrWindow('adm_ftp_video.php?id=<?php echo $_POST['id_login']; ?>','','width=800,height=250')">
	  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <input <?php if ($totalRows_arquivos > 0) { // Show if recordset not empty ?>disabled <?php } ?>type="submit" name="Submit4" value="remover pasta">
      <input name="diretorioxxx" type="hidden" id="diretorioxxx" value="<?php echo $_POST['id_login']; ?>">
      <label>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="button" name="Submit5" value="enviar email" onClick="MM_openBrWindow('adm_ftp_email3.php?to=<?php echo $_POST['id_login']; ?>','','width=720,height=450')">
      </label>
</form>
	<form name="upload" action="adm_ftp2.php" method="post" enctype="multipart/form-data" >
	  <table width="550" border="2" cellpadding="0" cellspacing="0" bordercolor="#666666">
        <tr>
          <td class="style4"><table width="100%" border="0" cellspacing="0" cellpadding="2">
            <tr>
              <td class="style4">Arquivo1:</td>
              <td><input name="arquivo1" type="file" id="arquivo1" size="60"></td>
            </tr>
            <tr>
              <td class="style4">Validade: </td>
              <td><input name="validade1" type="text" id="validade1" value="15" size="5">
                  <span class="style4"> dias </span></td>
            </tr>
            <tr>
              <td valign="top" class="style4">Observa&ccedil;&otilde;es:</td>
              <td><input name="observacoes1" type="text" id="observacoes1" value="" size="60"></td>
            </tr>
            
          </table></td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
            <tr>
              <td class="style4">Arquivo2:</td>
              <td><input name="arquivo2" type="file" id="arquivo2" size="60"></td>
            </tr>
            <tr>
              <td class="style4">Validade: </td>
              <td><input name="validade2" type="text" id="validade2" value="15" size="5">
                  <span class="style4"> dias </span></td>
            </tr>
            <tr>
              <td valign="top" class="style4">Observa&ccedil;&otilde;es:</td>
              <td><input name="observacoes2" type="text" id="observacoes2" value="" size="60"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
            <tr>
              <td class="style4">Arquivo3:</td>
              <td><input name="arquivo3" type="file" id="arquivo3" size="60"></td>
            </tr>
            <tr>
              <td class="style4">Validade: </td>
              <td><input name="validade3" type="text" id="validade3" value="15" size="5">
                  <span class="style4"> dias </span></td>
            </tr>
            <tr>
              <td valign="top" class="style4">Observa&ccedil;&otilde;es:</td>
              <td><input name="observacoes3" type="text" id="observacoes3" value="" size="60"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
            <tr>
              <td class="style4">Arquivo4:</td>
              <td><input name="arquivo4" type="file" id="arquivo4" size="60"></td>
            </tr>
            <tr>
              <td class="style4">Validade: </td>
              <td><input name="validade4" type="text" id="validade4" value="15" size="5">
                  <span class="style4"> dias </span></td>
            </tr>
            <tr>
              <td valign="top" class="style4">Observa&ccedil;&otilde;es:</td>
              <td><input name="observacoes4" type="text" id="observacoes4" value="" size="60"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
            <tr>
              <td class="style4">Arquivo5:</td>
              <td><input name="arquivo5" type="file" id="arquivo5" size="60"></td>
            </tr>
            <tr>
              <td class="style4">Validade: </td>
              <td><input name="validade5" type="text" id="validade5" value="15" size="5">
                  <span class="style4"> dias </span></td>
            </tr>
            <tr>
              <td valign="top" class="style4">Observa&ccedil;&otilde;es:</td>
              <td><input name="observacoes5" type="text" id="observacoes5" value="" size="60"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><div align="center">
            <input name="id_login" type="hidden" id="id_login" value="<?php echo $_POST['id_login']; ?>">
            <input type="submit" name="enviar" value="Upload!">
          </div></td>
        </tr>
      </table>
	  <br>
</form>

<?php }; ?>
</body>
</html>
<?php
mysql_free_result($diretorios);

mysql_free_result($arquivos);
?>
