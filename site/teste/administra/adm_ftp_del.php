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

if (isset($_POST['diretorio'])) {

			$ftproot = "/public_html/ftp/";
			$srcroot = "/var/www/public_html/ftp/";        
			$srcrela = ltrim($_POST['diretorio'],"0")."/";

			$ftpc = ftp_connect("ftp.pulsarimagens.com.br");
			$ftpr = ftp_login($ftpc,"admpul","padm25sar");

			if ((!$ftpc) || (!$ftpr)) { echo "FTP connection not established!"; die(); }
			if (!chdir($srcroot)) { echo "Could not enter local source root directory."; die(); }
			if (!ftp_chdir($ftpc,$ftproot)) { echo "Could not enter FTP root directory."; die(); }

			ftp_rmdirr    ($ftpc,$ftproot.$srcrela);
?><script language="JavaScript" type="text/JavaScript">
alert("Diretório removido com sucesso!!!");
</script><?php
   // close the FTP connection
			ftp_close($ftpc);
			$deleteSQL = sprintf("DELETE FROM ftp WHERE id_login = %s",
                    $_POST['diretorio']);
			mysql_select_db($database_pulsar, $pulsar);
			$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
			$deleteSQL = sprintf("DELETE FROM ftp_arquivos WHERE id_ftp = %s",
                    $_POST['diretorio']);
			mysql_select_db($database_pulsar, $pulsar);
			$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
		} ;


mysql_select_db($database_pulsar, $pulsar);
$query_diretorios = "SELECT cadastro.login,   cadastro.id_cadastro, cadastro.nome FROM ftp  INNER JOIN cadastro ON (ftp.id_login=cadastro.id_cadastro) ORDER BY cadastro.nome";
$diretorios = mysql_query($query_diretorios, $pulsar) or die(mysql_error());
$row_diretorios = mysql_fetch_assoc($diretorios);
$totalRows_diretorios = mysql_num_rows($diretorios);

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
//-->
</script>
</head>

<body>
<table width="100%"  border="0" cellpadding="5" cellspacing="0" bgcolor="#FF9900">
   <tr>
     <td><span class="style1">pulsarimagens.com.br<br>
ftp - excluir diret&oacute;rio </span></td>
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
      <td width="110" class="style19"><span class="style27">Login do cliente: </span></td>
      <td class="style28"><select name="diretorio" id="diretorio">
        <?php
do {  
?>
        <option value="<?php echo $row_diretorios['id_cadastro']?>"><?php echo $row_diretorios['nome']?></option>
        <?php
} while ($row_diretorios = mysql_fetch_assoc($diretorios));
  $rows = mysql_num_rows($diretorios);
  if($rows > 0) {
      mysql_data_seek($diretorios, 0);
	  $row_diretorios = mysql_fetch_assoc($diretorios);
  }
?>
      </select>
<input name="Submit" type="submit" value="excluir" onClick="document.form1.MM_Go.value='no_go'"></td>
    </tr>
<?php if ($totalRows_cliente > 0) { // Show if recordset not empty ?>
<?php } // Show if recordset not empty ?>
  </table>
</form>

</body>
</html>
<?php
{
mysql_free_result($diretorios);
}
?>
