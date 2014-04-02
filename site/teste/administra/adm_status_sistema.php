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
mysql_select_db($database_pulsar, $pulsar);
$query_Indexacoes = "select count(*) from Fotos";
$Indexacoes = mysql_query($query_Indexacoes, $pulsar) or die(mysql_error());
$row_Indexacoes = mysql_fetch_assoc($Indexacoes);
$totalRows_Indexacoes = mysql_num_rows($Indexacoes);

mysql_select_db($database_pulsar, $pulsar);
$query_Pal_chave = "select count(*) from pal_chave";
$Pal_chave = mysql_query($query_Pal_chave, $pulsar) or die(mysql_error());
$row_Pal_chave = mysql_fetch_assoc($Pal_chave);
$totalRows_Pal_chave = mysql_num_rows($Pal_chave);

mysql_select_db($database_pulsar, $pulsar);
$query_Pal_chave_en = "select count(*) from pal_chave where pal_chave_en is not null";
$Pal_chave_en = mysql_query($query_Pal_chave_en, $pulsar) or die(mysql_error());
$row_Pal_chave_en = mysql_fetch_assoc($Pal_chave_en);
$totalRows_Pal_chave_en = mysql_num_rows($Pal_chave_en);

mysql_select_db($database_pulsar, $pulsar);
$query_temas = "select count(*) from temas";
$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
$row_temas = mysql_fetch_assoc($temas);
$totalRows_temas = mysql_num_rows($temas);

mysql_select_db($database_pulsar, $pulsar);
$query_relac_tema = "select count(*) from rel_fotos_temas";
$relac_tema = mysql_query($query_relac_tema, $pulsar) or die(mysql_error());
$row_relac_tema = mysql_fetch_assoc($relac_tema);
$totalRows_relac_tema = mysql_num_rows($relac_tema);

mysql_select_db($database_pulsar, $pulsar);
$query_relac_palavra = "select count(*) from rel_fotos_pal_ch";
$relac_palavra = mysql_query($query_relac_palavra, $pulsar) or die(mysql_error());
$row_relac_palavra = mysql_fetch_assoc($relac_palavra);
$totalRows_relac_palavra = mysql_num_rows($relac_palavra);

mysql_select_db($database_pulsar, $pulsar);
$query_ensaios = "SELECT count(*) FROM ensaios";
$ensaios = mysql_query($query_ensaios, $pulsar) or die(mysql_error());
$row_ensaios = mysql_fetch_assoc($ensaios);
$totalRows_ensaios = mysql_num_rows($ensaios);

mysql_select_db($database_pulsar, $pulsar);
$query_clientes = "SELECT * FROM cadastro";
$clientes = mysql_query($query_clientes, $pulsar) or die(mysql_error());
$row_clientes = mysql_fetch_assoc($clientes);
$totalRows_clientes = mysql_num_rows($clientes);

mysql_select_db($database_pulsar, $pulsar);
$query_mesas_luz = "select count(*) from pastas";
$mesas_luz = mysql_query($query_mesas_luz, $pulsar) or die(mysql_error());
$row_mesas_luz = mysql_fetch_assoc($mesas_luz);
$totalRows_mesas_luz = mysql_num_rows($mesas_luz);

mysql_select_db($database_pulsar, $pulsar);
$query_cromos_mesa = "select count(*) from pasta_fotos";
$cromos_mesa = mysql_query($query_cromos_mesa, $pulsar) or die(mysql_error());
$row_cromos_mesa = mysql_fetch_assoc($cromos_mesa);
$totalRows_cromos_mesa = mysql_num_rows($cromos_mesa);

mysql_select_db($database_pulsar, $pulsar);
$query_diretorios = "SELECT count(*) FROM ftp";
$diretorios = mysql_query($query_diretorios, $pulsar) or die(mysql_error());
$row_diretorios = mysql_fetch_assoc($diretorios);
$totalRows_diretorios = mysql_num_rows($diretorios);

mysql_select_db($database_pulsar, $pulsar);
$query_arquivos = "SELECT DISTINCT    count(ftp_arquivos.id_arquivo),   sum(ftp_arquivos.tamanho)/1024 FROM  ftp_arquivos";
$arquivos = mysql_query($query_arquivos, $pulsar) or die(mysql_error());
$row_arquivos = mysql_fetch_assoc($arquivos);
$totalRows_arquivos = mysql_num_rows($arquivos);

mysql_select_db($database_pulsar, $pulsar);
$query_pops = "select * from log_pop";
$pops = mysql_query($query_pops, $pulsar) or die(mysql_error());
$row_pops = mysql_fetch_assoc($pops);
$totalRows_pops = mysql_num_rows($pops);

mysql_select_db($database_pulsar, $pulsar);
$query_popsd = "SELECT to_days(now())-to_days(log_pop.datahora) as total_dias FROM log_pop ORDER BY log_pop.datahora ASC limit 0,1";
$popsd = mysql_query($query_popsd, $pulsar) or die(mysql_error());
$row_popsd = mysql_fetch_assoc($popsd);
$totalRows_popsd = mysql_num_rows($popsd);

mysql_select_db($database_pulsar, $pulsar);
$query_pops30 = "select * from log_pop WHERE to_days(now())-to_days(log_pop.datahora) <= 30";
$pops30 = mysql_query($query_pops30, $pulsar) or die(mysql_error());
$row_pops30 = mysql_fetch_assoc($pops30);
$totalRows_pops30 = mysql_num_rows($pops30);

mysql_select_db($database_pulsar, $pulsar);
$query_pops7 = "select * from log_pop WHERE to_days(now())-to_days(log_pop.datahora) <= 7";
$pops7 = mysql_query($query_pops7, $pulsar) or die(mysql_error());
$row_pops7 = mysql_fetch_assoc($pops7);
$totalRows_pops7 = mysql_num_rows($pops7);

mysql_select_db($database_pulsar, $pulsar);
$query_pops1 = "select * from log_pop WHERE to_days(now())-to_days(log_pop.datahora) <= 1";
$pops1 = mysql_query($query_pops1, $pulsar) or die(mysql_error());
$row_pops1 = mysql_fetch_assoc($pops1);
$totalRows_pops1 = mysql_num_rows($pops1);

mysql_select_db($database_pulsar, $pulsar);
$query_pcs = "select * from pesquisa_pc";
$pcs = mysql_query($query_pcs, $pulsar) or die(mysql_error());
$row_pcs = mysql_fetch_assoc($pcs);
$totalRows_pcs = mysql_num_rows($pcs);

mysql_select_db($database_pulsar, $pulsar);
$query_pcsd = "SELECT to_days(now())-to_days(pesquisa_pc.datahora) as total_dias FROM pesquisa_pc ORDER BY pesquisa_pc.datahora ASC limit 0,1";
$pcsd = mysql_query($query_pcsd, $pulsar) or die(mysql_error());
$row_pcsd = mysql_fetch_assoc($pcsd);
$totalRows_pcsd = mysql_num_rows($pcsd);

mysql_select_db($database_pulsar, $pulsar);
$query_pcs30 = "select * from pesquisa_pc WHERE to_days(now())-to_days(pesquisa_pc.datahora) <= 30";
$pcs30 = mysql_query($query_pcs30, $pulsar) or die(mysql_error());
$row_pcs30 = mysql_fetch_assoc($pcs30);
$totalRows_pcs30 = mysql_num_rows($pcs30);

mysql_select_db($database_pulsar, $pulsar);
$query_pcs7 = "select * from pesquisa_pc WHERE to_days(now())-to_days(pesquisa_pc.datahora) <= 7";
$pcs7 = mysql_query($query_pcs7, $pulsar) or die(mysql_error());
$row_pcs7 = mysql_fetch_assoc($pcs7);
$totalRows_pcs7 = mysql_num_rows($pcs7);

mysql_select_db($database_pulsar, $pulsar);
$query_pcs1 = "select * from pesquisa_pc WHERE to_days(now())-to_days(pesquisa_pc.datahora) <= 1";
$pcs1 = mysql_query($query_pcs1, $pulsar) or die(mysql_error());
$row_pcs1 = mysql_fetch_assoc($pcs1);
$totalRows_pcs1 = mysql_num_rows($pcs1);

mysql_select_db($database_pulsar, $pulsar);
$query_pas = "select * from pesquisa_pa";
$pas = mysql_query($query_pas, $pulsar) or die(mysql_error());
$row_pas = mysql_fetch_assoc($pas);
$totalRows_pas = mysql_num_rows($pas);

mysql_select_db($database_pulsar, $pulsar);
$query_pasd = "SELECT to_days(now())-to_days(pesquisa_pa.datahora) as total_dias FROM pesquisa_pa ORDER BY pesquisa_pa.datahora ASC limit 0,1";
$pasd = mysql_query($query_pasd, $pulsar) or die(mysql_error());
$row_pasd = mysql_fetch_assoc($pasd);
$totalRows_pasd = mysql_num_rows($pasd);

mysql_select_db($database_pulsar, $pulsar);
$query_pas30 = "select * from pesquisa_pa WHERE to_days(now())-to_days(pesquisa_pa.datahora) <= 30";
$pas30 = mysql_query($query_pas30, $pulsar) or die(mysql_error());
$row_pas30 = mysql_fetch_assoc($pas30);
$totalRows_pas30 = mysql_num_rows($pas30);

mysql_select_db($database_pulsar, $pulsar);
$query_pas7 = "select * from pesquisa_pa WHERE to_days(now())-to_days(pesquisa_pa.datahora) <= 7";
$pas7 = mysql_query($query_pas7, $pulsar) or die(mysql_error());
$row_pas7 = mysql_fetch_assoc($pas7);
$totalRows_pas7 = mysql_num_rows($pas7);

mysql_select_db($database_pulsar, $pulsar);
$query_pas1 = "select * from pesquisa_pa WHERE to_days(now())-to_days(pesquisa_pa.datahora) <= 1";
$pas1 = mysql_query($query_pas1, $pulsar) or die(mysql_error());
$row_pas1 = mysql_fetch_assoc($pas1);
$totalRows_pas1 = mysql_num_rows($pas1);

mysql_select_db($database_pulsar, $pulsar);
$query_tms = "select * from pesquisa_tema";
$tms = mysql_query($query_tms, $pulsar) or die(mysql_error());
$row_tms = mysql_fetch_assoc($tms);
$totalRows_tms = mysql_num_rows($tms);

mysql_select_db($database_pulsar, $pulsar);
$query_tmsd = "SELECT to_days(now())-to_days(pesquisa_tema.datahora) as total_dias FROM pesquisa_tema ORDER BY pesquisa_tema.datahora ASC limit 0,1";
$tmsd = mysql_query($query_tmsd, $pulsar) or die(mysql_error());
$row_tmsd = mysql_fetch_assoc($tmsd);
$totalRows_tmsd = mysql_num_rows($tmsd);

mysql_select_db($database_pulsar, $pulsar);
$query_tms30 = "select * from pesquisa_tema WHERE to_days(now())-to_days(pesquisa_tema.datahora) <= 30";
$tms30 = mysql_query($query_tms30, $pulsar) or die(mysql_error());
$row_tms30 = mysql_fetch_assoc($tms30);
$totalRows_tms30 = mysql_num_rows($tms30);

mysql_select_db($database_pulsar, $pulsar);
$query_tms7 = "select * from pesquisa_tema WHERE to_days(now())-to_days(pesquisa_tema.datahora) <= 7";
$tms7 = mysql_query($query_tms7, $pulsar) or die(mysql_error());
$row_tms7 = mysql_fetch_assoc($tms7);
$totalRows_tms7 = mysql_num_rows($tms7);

mysql_select_db($database_pulsar, $pulsar);
$query_tms1 = "select * from pesquisa_tema WHERE to_days(now())-to_days(pesquisa_tema.datahora) <= 1";
$tms1 = mysql_query($query_tms1, $pulsar) or die(mysql_error());
$row_tms1 = mysql_fetch_assoc($tms1);
$totalRows_tms1 = mysql_num_rows($tms1);

//---

mysql_select_db($database_pulsar, $pulsar);
$query_dwn = "select * from log_download2";
$dwn = mysql_query($query_dwn, $pulsar) or die(mysql_error());
$row_dwn = mysql_fetch_assoc($dwn);
$totalRows_dwn = mysql_num_rows($dwn);

mysql_select_db($database_pulsar, $pulsar);
$query_dwnd = "SELECT to_days(now())-to_days(log_download2.data_hora) as total_dias FROM log_download2 ORDER BY log_download2.data_hora ASC limit 0,1";
$dwnd = mysql_query($query_dwnd, $pulsar) or die(mysql_error());
$row_dwnd = mysql_fetch_assoc($dwnd);
$totalRows_dwnd = mysql_num_rows($dwnd);

mysql_select_db($database_pulsar, $pulsar);
$query_dwn30 = "select * from log_download2 WHERE to_days(now())-to_days(log_download2.data_hora) <= 30";
$dwn30 = mysql_query($query_dwn30, $pulsar) or die(mysql_error());
$row_dwn30 = mysql_fetch_assoc($dwn30);
$totalRows_dwn30 = mysql_num_rows($dwn30);

mysql_select_db($database_pulsar, $pulsar);
$query_dwn7 = "select * from log_download2 WHERE to_days(now())-to_days(log_download2.data_hora) <= 7";
$dwn7 = mysql_query($query_dwn7, $pulsar) or die(mysql_error());
$row_dwn7 = mysql_fetch_assoc($dwn7);
$totalRows_dwn7 = mysql_num_rows($dwn7);

mysql_select_db($database_pulsar, $pulsar);
$query_dwn1 = "select count(id_login) as qtd, id_login, cadastro.login, cadastro.empresa
from log_download2
LEFT JOIN cadastro ON log_download2.id_login = cadastro.id_cadastro
WHERE to_days(now())-to_days(log_download2.data_hora) <= 3
group by id_login";
$dwn1 = mysql_query($query_dwn1, $pulsar) or die(mysql_error());
$row_dwn1 = mysql_fetch_assoc($dwn1);
$totalRows_dwn1 = mysql_num_rows($dwn1);

$imageDir = "/var/www/www.pulsarimagens.com.br/bancoImagens";

$fileCount = 0;
$bigCount = 0;

if (is_dir($imageDir) && $directoryPointer = @opendir($imageDir)) {
	while ($oneFile = readdir($directoryPointer)) {
//		$thisFileType = strtolower(substr(strrchr($oneFile, "."), 1));
//		$thisFileType = strtolower(substr(stristr($oneFile, "p"), 1));

// Modificado por Zoca para retirar o ./ e o ../ da lista.
		
		if (strlen($oneFile) > 5) {
			$thisFileType = strtolower(substr($oneFile,-5));
/*		if ($thisFileType == ".jpg" || $thisFileType == "jpeg") {
			$fileCount++;
		} else {
			if ($thisFileType == "g" || $thisFileType == "jpeg") {
				$bigCount++;
			}
		}
*/
			if ($thisFileType == "p.jpg") {
				$bigCount++;
			} else {
				$fileCount++;
			}
		}
	}
} else {
	$fileCount = -1;
}


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
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>
</head>

<body>
<table width="100%"  border="0" cellpadding="5" cellspacing="0" bgcolor="#FF9900">
   <tr>
     <td class="style1">pulsarimagens.com.br<br>
         status do sistema </td>
               <TD class=style27>
        <DIV align=right>
          <INPUT onclick="MM_goToURL('parent','administra2.php');return document.MM_returnValue" type=button value="Menu Principal" name=Button>
      </DIV></TD>
   </tr>
</table>
<br>

<br>
<span class="style27">Status do sistema:</span><br>
<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#666666">
    <td width="290" class="style28">Total de fotos (thumbs/normal)</td>
    <td width="20" class="style28">-</td>
    <td class="style28"><?php echo DoFormatNumber($bigCount, 0, ',', '.') . " / " . DoFormatNumber($fileCount, 0, ',', '.');?></td>
  </tr>
  <tr bgcolor="#666666">
    <td width="290" class="style28">Total de Indexa&ccedil;&otilde;es </td>
    <td width="20" class="style28">-</td>
    <td class="style24"><span class="style29"><?php echo DoFormatNumber($row_Indexacoes['count(*)'], 0, ',', '.'); ?></span></td>
  </tr>
  <tr bgcolor="#666666">
    <td width="290" class="style28">Total de Palavras-Chave (pt/en) </td>
    <td width="20" class="style28">-</td>
    <td class="style24"><span class="style29"><?php echo DoFormatNumber($row_Pal_chave['count(*)'], 0, ',', '.'); ?> / <?php echo DoFormatNumber($row_Pal_chave_en['count(*)'], 0, ',', '.'); ?> (<?php echo DoFormatNumber(($row_Pal_chave['count(*)']-$row_Pal_chave_en['count(*)']), 0, ',', '.'); ?>)</span></td>
  </tr>
  <tr bgcolor="#666666">
    <td width="290" class="style28">Total de Temas </td>
    <td width="20" class="style28">-</td>
    <td class="style24"><span class="style29"><?php echo $row_temas['count(*)']; ?></span></td>
  </tr>
  <tr bgcolor="#666666">
    <td width="290" class="style28">Relacionamentos Tema x Foto </td>
    <td width="20" class="style28">-</td>
    <td class="style24"><span class="style29"><?php echo DoFormatNumber($row_relac_tema['count(*)'], 0, ',', '.'); ?></span></td>
  </tr>
  <tr bgcolor="#666666">
    <td width="290" class="style28">Relacionamentos Palavras-Chave x Foto </td>
    <td width="20" class="style28">-</td>
    <td class="style24"><span class="style29"><?php echo DoFormatNumber($row_relac_palavra['count(*)'], 0, ',', '.'); ?></span></td>
  </tr>
  <tr bgcolor="#666666">
    <td class="style28">Total de Ensaios </td>
    <td class="style28">-</td>
    <td class="style24"><span class="style29"><?php echo $row_ensaios['count(*)']; ?></span></td>
  </tr>
  <tr bgcolor="#666666">
    <td class="style28">Total de Clientes Cadastrados </td>
    <td class="style28">-</td>
    <td class="style24"><span class="style29"><?php echo $totalRows_clientes ?> </span></td>
  </tr>
  <tr bgcolor="#666666">
    <td class="style28">Total de Mesas de Luz Ativas </td>
    <td class="style28">-</td>
    <td class="style24"><span class="style29"><?php echo $row_mesas_luz['count(*)']; ?></span></td>
  </tr>
  <tr bgcolor="#666666">
    <td class="style28">Total de Cromos nas Mesas de Luz</td>
    <td class="style28">-</td>
    <td class="style24"><span class="style29"><?php echo DoFormatNumber($row_cromos_mesa['count(*)'], 0, ',', '.'); ?></span></td>
  </tr>
  <tr bgcolor="#666666">
    <td class="style28">Diret&oacute;rios FTP </td>
    <td class="style28">-</td>
    <td class="style24"><span class="style29"><?php echo $row_diretorios['count(*)']; ?></span></td>
  </tr>
  <tr bgcolor="#666666">
    <td class="style28">Arquivos FTP </td>
    <td class="style28">-</td>
    <td class="style24"><span class="style29"><?php echo $row_arquivos['count(ftp_arquivos.id_arquivo)']; ?></span></td>
  </tr>
  <tr bgcolor="#666666">
    <td class="style28">Kb FTP </td>
    <td class="style28">-</td>
    <td class="style24"><span class="style29"><?php echo DoFormatNumber($row_arquivos['sum(ftp_arquivos.tamanho)/1024'], 0, ',', '.'); ?></span></td>
  </tr>
  <tr bgcolor="#666666">
    <td class="style28">Total de Pop-ups apresentados </td>
    <td class="style28">-</td>
    <td class="style24"><span class="style29"><?php echo DoFormatNumber($totalRows_pops, 0, ',', '.'); ?> (<?php echo $row_popsd['total_dias']; ?>d) / <?php echo DoFormatNumber($totalRows_pops30, 0, ',', '.'); ?> (30d) / <?php echo DoFormatNumber($totalRows_pops7, 0, ',', '.'); ?> (7d) / <?php echo DoFormatNumber($totalRows_pops1, 0, ',', '.'); ?> (1d)</span></td>
  </tr>
  <tr bgcolor="#666666">
    <td class="style28">Total de Pesquisas por Palav. Chaves </td>
    <td class="style28">-</td>
    <td class="style24"><span class="style29"><?php echo DoFormatNumber($totalRows_pcs, 0, ',', '.'); ?> (<?php echo $row_pcsd['total_dias']; ?>d) / <?php echo DoFormatNumber($totalRows_pcs30, 0, ',', '.'); ?> (30d) / <?php echo DoFormatNumber($totalRows_pcs7, 0, ',', '.'); ?> (7d) / <?php echo DoFormatNumber($totalRows_pcs1, 0, ',', '.'); ?> (1d)</span></td>
  </tr>
  <tr bgcolor="#666666">
    <td class="style28">Total de Pesquisas Avan&ccedil;adas </td>
    <td class="style28">-</td>
    <td class="style24"><span class="style29"><?php echo DoFormatNumber($totalRows_pas, 0, ',', '.'); ?> (<?php echo $row_pasd['total_dias']; ?>d) / <?php echo DoFormatNumber($totalRows_pas30, 0, ',', '.'); ?> (30d) / <?php echo DoFormatNumber($totalRows_pas7, 0, ',', '.'); ?> (7d) / <?php echo DoFormatNumber($totalRows_pas1, 0, ',', '.'); ?> (1d)</span></td>
  </tr>
  <tr bgcolor="#666666">
    <td class="style28">Total de Pesquisas por Temas </td>
    <td class="style28">-</td>
    <td class="style24"><span class="style29"><?php echo DoFormatNumber($totalRows_tms, 0, ',', '.'); ?> (<?php echo $row_tmsd['total_dias']; ?>d) / <?php echo DoFormatNumber($totalRows_tms30, 0, ',', '.'); ?> (30d) / <?php echo DoFormatNumber($totalRows_tms7, 0, ',', '.'); ?> (7d) / <?php echo DoFormatNumber($totalRows_tms1, 0, ',', '.'); ?> (1d)</span></td>
  </tr>
  <tr bgcolor="#666666">
    <td class="style28">Total de Downloads (alta) </td>
    <td class="style28">-</td>
    <td class="style24"><span class="style29"><?php echo DoFormatNumber($totalRows_dwn, 0, ',', '.'); ?> (<?php echo $row_dwnd['total_dias']; ?>d) / <?php echo DoFormatNumber($totalRows_dwn30, 0, ',', '.'); ?> (30d) / <?php echo DoFormatNumber($totalRows_dwn7, 0, ',', '.'); ?> (7d) / <?php echo DoFormatNumber($totalRows_dwn1, 0, ',', '.'); ?> (1d)</span></td>
  </tr>
  <tr bgcolor="#666666">
    <td class="style28">&Uacute;ltimos downloads (3 dias) </td>
    <td class="style28">-</td>
    <td class="style24"><span class="style29"><?php if ($totalRows_dwn1>0) { do { echo $row_dwn1['login']."/".$row_dwn1['empresa']."(".$row_dwn1['qtd']."); ";} while ($row_dwn1 = mysql_fetch_assoc($dwn1)); }; ?>&nbsp;</span></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Indexacoes);

mysql_free_result($Pal_chave);

mysql_free_result($Pal_chave_en);

mysql_free_result($temas);

mysql_free_result($relac_tema);

mysql_free_result($relac_palavra);

mysql_free_result($ensaios);

mysql_free_result($clientes);

mysql_free_result($mesas_luz);

mysql_free_result($cromos_mesa);

mysql_free_result($diretorios);

mysql_free_result($arquivos);

mysql_free_result($login);

mysql_free_result($pops);

mysql_free_result($pops30);

mysql_free_result($pops7);

mysql_free_result($pops1);

mysql_free_result($popsd);

mysql_free_result($pcs);

mysql_free_result($pcsd);

mysql_free_result($pcs30);

mysql_free_result($pcs7);

mysql_free_result($pcs1);

mysql_free_result($pas);

mysql_free_result($pasd);

mysql_free_result($pas30);

mysql_free_result($pas7);

mysql_free_result($pas1);

mysql_free_result($tms);

mysql_free_result($tmsd);

mysql_free_result($tms30);

mysql_free_result($tms7);

mysql_free_result($tms1);

mysql_free_result($dwn);

mysql_free_result($dwnd);

mysql_free_result($dwn30);

mysql_free_result($dwn7);

mysql_free_result($dwn1);


?>
