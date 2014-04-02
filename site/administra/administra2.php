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

mysql_select_db($database_pulsar, $pulsar);
$query_dwn1 = "select count(id_login) as qtd, id_login, cadastro.login, cadastro.empresa
from log_download2
LEFT JOIN cadastro ON log_download2.id_login = cadastro.id_cadastro
WHERE to_days(now())-to_days(log_download2.data_hora) <= 3
group by id_login";
$dwn1 = mysql_query($query_dwn1, $pulsar) or die(mysql_error());
$row_dwn1 = mysql_fetch_assoc($dwn1);
$totalRows_dwn1 = mysql_num_rows($dwn1);

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
.style24 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10pt; color: #666666; }
.style25 {color: #666666}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10pt; color: #666666; font-weight: bold; }
.style28 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10pt; color: #FFFFFF; }
.style29 {color: #FFFFFF}
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
</head>

<body>
<table width="100%"  border="0" cellpadding="5" cellspacing="0" bgcolor="#FF9900">
   <tr>
     <td class="style1">pulsarimagens.com.br<br>
         menu principal </td>
   </tr>
</table>
<br>
<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="340" class="style24"><a href="<?php if (($row_login['index_inc']==1) or ($row_login['index_del']==1) or ($row_login['index_alt']==1)) {?>adm_index.php<?php } else { ?>#<?php } ?>">1. Indexa&ccedil;&atilde;o</a> </td>
    <td width="20" class="style25">&nbsp;</td>
    <td class="style24"><a href="<?php if ($row_login['cotacao']==1) {?>adm_cotacao.php<?php } else { ?>#<?php } ?>">7. Cota&ccedil;&otilde;es</a> </td>
  </tr>
  <tr>
    <td width="340" class="style24"><a href="<?php if (($row_login['index_inc']==1) or ($row_login['index_del']==1) or ($row_login['index_alt']==1)) {?>adm_index_lote.php<?php } else { ?>#<?php } ?>">1b. Altera&ccedil;&atilde;o por Lote </a></td>
    <td width="20" class="style25">&nbsp;</td>
    <td class="style25"><span class="style24"><a href="<?php if ($row_login['cad_clientes']==1) {?>adm_cad_cli.php<?php } else { ?>#<?php } ?>">8. Cadastro de Clientes</a> </span></td>
  </tr>
  <tr>
    <td width="340" class="style24"><a href="<?php if (($row_login['index_inc']==1) or ($row_login['index_del']==1) or ($row_login['index_alt']==1)) {?>adm_index_inc_lote.php<?php } else { ?>#<?php } ?>">1c. Inclus&atilde;o por Lote </a></td>
    <td width="20" class="style25">&nbsp;</td>
    <td class="style25"><span class="style24"></span></td>
  </tr>
  <tr>
    <td width="340" class="style24"><a href="<?php if (($row_login['index_inc']==1) or ($row_login['index_del']==1) or ($row_login['index_alt']==1)) {?>adm_index_tmp.php<?php } else { ?>#<?php } ?>">1d. Inclus&atilde;o Pre-Indexada </a></td>
    <td width="20" class="style25">&nbsp;</td>
    <td class="style25"><span class="style24"></span></td>
  </tr>
  <tr>
    <td width="340" class="style24"><a href="<?php if (($row_login['index_inc']==1) or ($row_login['index_del']==1) or ($row_login['index_alt']==1)) {?>listingvideo.php<?php } else { ?>#<?php } ?>">1e. Edição Videos </a></td>
    <td width="20" class="style25">&nbsp;</td>
    <td class="style25"><span class="style24"></span></td>
  </tr>
  <tr>
    <td width="340" class="style24"><a href="<?php if (($row_login['index_inc']==1) or ($row_login['index_del']==1) or ($row_login['index_alt']==1)) {?>adm_index_video.php<?php } else { ?>#<?php } ?>">1f. Indexação Videos </a></td>
    <td width="20" class="style25">&nbsp;</td>
    <td class="style25"><span class="style24"></span></td>
  </tr>
  <tr>
    <td width="340" class="style24"><a href="<?php if ($row_login['temas']==1) {?>adm_temas.php<?php } else { ?>#<?php } ?>">2. Temas</a> </td>
    <td width="20" class="style25">&nbsp;</td>
    <td class="style24"><a href="<?php if ($row_login['fotografos']==1) {?>adm_fotografo.php<?php } else { ?>#<?php } ?>">9. Fot&oacute;grafos</a> </td>
  </tr>
  <tr>
    <td width="340" class="style24"><a href="<?php if ($row_login['pal_chave']==1) {?>adm_palavras.php<?php } else { ?>#<?php } ?>">3. Palavras-Chave</a></td>
    <td class="style25">&nbsp;</td>
    <td class="style24"><a href="<?php if ($row_login['cad_usuarios']==1) {?>adm_usuarios.php<?php } else { ?>#<?php } ?>">10. Adm. Usu&aacute;rios</a> </td>
  </tr>
  <tr>
    <td width="340" class="style24"><a href="<?php if ($row_login['pal_chave']==1) {?>adm_palavras_pesquisadas.php<?php } else { ?>#<?php } ?>">3a. Palavras-Chave Pesquisadas</a></td>
  	<td class="style25">&nbsp;</td>
    <td class="style24"><a href="<?php if ($row_login['relatorios']==1) {?>adm_relat.php<?php } else { ?>#<?php } ?>">11. Relat&oacute;rios de Pesquisas</a> </td>
  </tr>
  <tr>
    <td width="340" class="style24"><a href="<?php if ($row_login['ftp']==1) {?>adm_ftp2.php<?php } else { ?>#<?php } ?>">4. FTP</a> </td>
  	<td class="style25">&nbsp;</td>
    <td class="style24"><a href="<?php if ($row_login['download']==1) {?>adm_download.php<?php } else { ?>#<?php } ?>">12a. Downloads</a> </td>
  </tr>
  <tr>
    <td width="340" class="style24"><a href="<?php if ($row_login['home']==1) {?>adm_inicial.php<?php } else { ?>#<?php } ?>">5. P&aacute;gina Inicial</a> </td>
    <td class="style25">&nbsp;</td>
    <td class="style24"><a href="<?php if ($row_login['download']==1) {?>adm_layout.php<?php } else { ?>#<?php } ?>">12b. Layouts</a> </td>
  </tr>
  <tr>
    <td width="340" class="style24"></td>
    <td class="style25">&nbsp;</td>
    <td class="style24"><a href="<?php if ($row_login['download']==1) {?>adm_download_video.php<?php } else { ?>#<?php } ?>">12c. Videos</a> </td>
  </tr>
  <tr>
    <td class="style24"><a href="<?php if ($row_login['ensaios']==1) {?>adm_ensaios.php<?php } else { ?>#<?php } ?>">6. Ensaios</a></td>
    <td class="style25">&nbsp;</td>
    <td class="style24"><a href="<?php if ($row_login['fotos_idx']==1) {?>adm_fotos.php<?php } else { ?>#<?php } ?>">13. Fotos sem indexa&ccedil;&atilde;o</a> </td>
  </tr>
  <tr>
    <td width="340" class="style24">&nbsp;</td>
    <td class="style25">&nbsp;</td>
    <td class="style24"><a href="<?php if ($row_login['fotos_idx']==1) {?>adm_fotos2.php<?php } else { ?>#<?php } ?>">14. Indexa&ccedil;&atilde;o sem Fotos Alta</a> </td>
  </tr>
</table>
<br>
<span class="style27"><a href="adm_status_sistema.php">Status do sistema</a></span><br>
<br>
<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#666666">
    <td class="style28">&Uacute;ltimos downloads (3 dias) </td>
    <td class="style28">-</td>
    <td class="style24"><span class="style29"><?php if ($totalRows_dwn1>0) { do { echo $row_dwn1['login']."/".$row_dwn1['empresa']."(".$row_dwn1['qtd']."); ";} while ($row_dwn1 = mysql_fetch_assoc($dwn1)); }; ?>&nbsp;</span></td>
  </tr>
</table>
</body>
</html>
<?php

mysql_free_result($login);
mysql_free_result($dwn1);

?>
