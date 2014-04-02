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
$colname_cliente = "-1";
if (isset($_POST['login'])) {

	$colname_cliente = (get_magic_quotes_gpc()) ? $_POST['login'] : addslashes($_POST['login']);

	mysql_select_db($database_pulsar, $pulsar);
	$query_cliente = sprintf("SELECT * FROM cadastro WHERE login = '%s'", $colname_cliente);
	$cliente = mysql_query($query_cliente, $pulsar) or die(mysql_error());
	$row_cliente = mysql_fetch_assoc($cliente);
	$totalRows_cliente = mysql_num_rows($cliente);

	if (isset($_POST["MM_Go"]) && ($_POST["MM_Go"]=='Go') ) {

		$query_ftp = sprintf("SELECT * FROM ftp WHERE id_login = %s", $row_cliente['id_cadastro']);
		$ftp = mysql_query($query_ftp, $pulsar) or die(mysql_error());
		$row_ftp = mysql_fetch_assoc($ftp);
		$totalRows_ftp = mysql_num_rows($ftp);

		if ($totalRows_ftp == 0) { 

			$ftproot = "/public_html/ftp/";
			$srcroot = "/var/www/public_html/ftp/";        
			$srcrela = ltrim($row_cliente['id_cadastro'],"0")."/";

			$ftpc = ftp_connect("ftp.pulsarimagens.com.br");
			$ftpr = ftp_login($ftpc,"admpul","padm25sar");

			if ((!$ftpc) || (!$ftpr)) { echo "FTP connection not established!"; die(); }
			if (!chdir($srcroot)) { echo "Could not enter local source root directory."; die(); }
			if (!ftp_chdir($ftpc,$ftproot)) { echo "Could not enter FTP root directory."; die(); }

			ftp_mkdir    ($ftpc,$ftproot.$srcrela);
			//chmod($srcroot.$srcrela,0777);
			//ftp_chmod ($ftpc, 0777, $ftproot.$srcrela);  
			$chmod_cmd="CHMOD 0777 ".$ftproot.$srcrela; 
			$chmod=ftp_site($ftpc, $chmod_cmd); 
?><script language="JavaScript" type="text/JavaScript">
alert("Diretório criado com sucesso!!!");
</script><?php
   // close the FTP connection
			ftp_close($ftpc);
			$insertSQL = sprintf("INSERT INTO ftp (id_login, data_cria) VALUES (%s,%s)",
                    GetSQLValueString($row_cliente['id_cadastro'], "int"),
					GetSQLValueString(date("Y-m-d h:i:s", strtotime('now')), "date"));

			mysql_select_db($database_pulsar, $pulsar);
			$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
		} else {
?><script language="JavaScript" type="text/JavaScript">
alert("Diretório já existe!!!");
</script><?php 
		};
		mysql_free_result($ftp);
	};
};
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Administra&ccedil;&atilde;o - ftp</title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FFFFFF;
}
.style19 {font-size: 12}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style28 {font-size: 12px; }
.style29 {font-size: 10px}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function atualizar(valor) {

	//var combo = document.form2.tema;
	//alert(valor);
	document.form1.login.value=valor;

}
//-->
</script>
</head>

<body>
<table width="100%"  border="0" cellpadding="5" cellspacing="0" bgcolor="#FF9900">
   <tr>
     <td><span class="style1">pulsarimagens.com.br<br>
ftp - incluir diret&oacute;rio </span></td>
		 <TD class=style27>
        <DIV align=right>
          <INPUT onclick="MM_goToURL('parent','adm_ftp.php');return document.MM_returnValue" type=button value="Menu FTP" name=Button>
      </DIV></TD>
   </tr>
</table>
<br>
<form name="form1" method="post" action="">
  <table width="550" border="0" cellspacing="0" cellpadding="5">
    <tr>
      <td class="style19"><span class="style27">Login do cliente: </span></td>
      <td class="style28"><input name="login" type="text" id="login" value="<?php echo $_POST['login']; ?>"> <input name="Submit" type="submit" value="verificar" onClick="document.form1.MM_Go.value='no_go'">
        <input name="id_cadastro" type="hidden" id="id_cadastro" value="<?php echo $row_cliente['id_cadastro']; ?>">
        <input name="Submit2" type="button" onClick="MM_openBrWindow('adm_ftp_pesq.php','','')" value="procurar"></td>
    </tr>
<?php if ($totalRows_cliente > 0) { // Show if recordset not empty ?>
    <tr>
      <td class="style28">&nbsp;</td>
      <td class="style27 style29">
          <strong>Nome:</strong> <?php echo $row_cliente['nome']; ?> <br>
          <strong>Empresa:</strong> <?php echo $row_cliente['empresa']; ?><br>
          <strong>Email:</strong> <?php echo $row_cliente['email']; ?><br>
          <strong>Telefone:</strong>        <?php echo $row_cliente['telefone']; ?></tr>
    <tr>
      <td colspan="2" class="style28"><div align="center">
        <input type="submit" name="Submit" value="Criar FTP">
      </div></td>
    </tr>        <input name="MM_Go" type="hidden" id="MM_Go" value="Go">
<?php } // Show if recordset not empty ?>
  </table>
</form>

</body>
</html>
<?php
if (isset($_POST['login'])) {
	mysql_free_result($cliente);
}
?>
