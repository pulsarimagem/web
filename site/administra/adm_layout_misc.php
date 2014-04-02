<?php require_once('Connections/pulsar.php'); ?>
<?php
$retirar = array(".jpg",".JPG");		
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
$colname_arquivos = "-1";
if (isset($_GET['id_login'])) {
  $colname_arquivos = (get_magic_quotes_gpc()) ? $_GET['id_login'] : addslashes($_GET['id_login']);
  $data = $_GET['data'];
  $data2 = substr($data,5,2).substr($data,0,2);
}
mysql_select_db($database_pulsar, $pulsar);
$query_arquivos = sprintf("SELECT 
  `log_download_layout`.id_log,
  `log_download_layout`.arquivo,
  `log_download_layout`.data_hora,
  `log_download_layout`.ip,
  `log_download_layout`.id_login,
  `log_download_layout`.usuario,
  `log_download_layout`.projeto,
  `log_download_layout`.obs,
  `log_download_layout`.faturado,
  `fotografos`.Nome_Fotografo,
  `Fotos`.assunto_principal
FROM
  `Fotos`
  INNER JOIN `fotografos` ON (`Fotos`.id_autor = `fotografos`.id_fotografo)
  RIGHT OUTER JOIN `log_download_layout` ON (`Fotos`.tombo = SUBSTRING_INDEX(`log_download_layout`.arquivo, '.', 1)) WHERE id_login = '%s' and EXTRACT(YEAR_MONTH FROM data_hora)
 like '20%s'
GROUP BY arquivo, EXTRACT(DAY FROM data_hora) 
ORDER BY faturado, projeto, data_hora DESC 
 ", $colname_arquivos,$data2);
$arquivos = mysql_query($query_arquivos, $pulsar) or die(mysql_error());
$row_arquivos = mysql_fetch_assoc($arquivos);
$totalRows_arquivos = mysql_num_rows($arquivos);

mysql_select_db($database_pulsar, $pulsar);
$query_cliente = sprintf("SELECT * FROM cadastro WHERE id_cadastro = '%s'", $colname_arquivos);
$cliente = mysql_query($query_cliente, $pulsar) or die(mysql_error());
$row_cliente = mysql_fetch_assoc($cliente);
$totalRows_cliente = mysql_num_rows($cliente);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Relatório de Download de Layouts</title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.style4 {font-size: 12px}
.style5 {
	font-size: 14px;
	font-weight: bold;
}
-->
</style>
<script type="text/javascript" src="jquery.js"></script> 
<script type="text/javascript">                                         
$(document).ready(function() {
	$("input:checkbox").click(function() {
//		alert(this.value+' '+this.checked);
		$.get("adm_down_fat.php", { tombo: this.value, marca: this.checked } );
//		$.get("adm_down_fat.php", { tombo: this.value, marca: this.checked } );

	});
});


</script> 
</head>

<body>
<table width="100%" border="0">
  <tr>
    <td bgcolor="#BCBFAE" class="style1 style4"><div align="center"><img src="images/header_03.gif" width="225" height="61" id="logo" /></div></td>
  </tr>
</table>
<div align="center"><br />
  <table width="600" border="1" cellspacing="0">
    <tr>
      <td colspan="2" class="style4 style1"><div align="center" class="style5">RELAT&Oacute;RIO MENSAL DE DOWNLOAD DE LAYOUT</div></td>
    </tr>
    <tr>
      <td class="style1 style4"><div align="left"><strong>M&ecirc;s/Ano: </strong></div></td>
      <td class="style4 style1"><div align="left"><?php echo $data; ?>&nbsp;</div></td>
    </tr>
    <tr>
      <td class="style1 style4"><div align="left"><strong>Cliente:</strong></div></td>
      <td class="style4 style1"><div align="left"><?php echo $row_cliente['nome']; ?> / <?php echo $row_cliente['empresa']; ?>&nbsp;</div></td>
    </tr>
    <tr>
      <td class="style1 style4"><div align="left"><strong>Total de Downloads:</strong></div></td>
      <td class="style4 style1"><div align="left"><?php echo $totalRows_arquivos; ?>&nbsp;</div></td>
    </tr>
    </table>
  <br />
  <?php
  $divisor = false;
  $divisor2 = false;
do {
  if ($divisor2 == false) {
    if($row_arquivos['faturado']==0) {
	  $divisor2 = true;
	  echo "<br><br><h2> Imagem(ns) N&atilde;o Faturada(s) </h2><br><br>";
	}
  }
  if ($divisor == false) {
    if($row_arquivos['faturado']==1) {
	  $divisor = true;
	  echo "<br><br><h2> Imagem(ns) J&aacute; Faturada(s) </h2><br><br>";
	}
  }
?><form>
    <table width="600" border="1" cellspacing="0">
      <tr>
        <td width="150" rowspan="9" valign="top" class="style1 style4"><img src="http://www.pulsarimagens.com.br/bancoImagens/<?php
		 echo str_replace($retirar,"",$row_arquivos['arquivo']); ?>p.jpg" /></td>
        <td colspan="2" class="style1 style4"><div align="left">Assunto: <?php echo $row_arquivos['assunto_principal']; ?></div></td>
      </tr>
      <tr>
        <td class="style1 style4"><div align="left">C&oacute;digo: <?php echo str_replace(".jpg","",$row_arquivos['arquivo']); ?></div></td>
        <td class="style1 style4"><div align="left">Autor: <?php echo $row_arquivos['Nome_Fotografo']; ?></div></td>
      </tr>
      <tr>
        <td class="style1 style4"><div align="left">Data do Download: <?php echo makeDateTime($row_arquivos['data_hora'], 'd/m/y'); ?></div></td>
        <td class="style1 style4"><div align="left">IP: <?php echo $row_arquivos['ip']; ?></div></td>
      </tr>
      <tr>
        <td colspan="2" class="style1 style4"><div align="left">Usu&aacute;rio: <?php echo $row_arquivos['usuario']; ?></div>          <div align="left"></div></td>
      </tr>
      <tr>
        <td colspan="2" class="style1 style4"><div align="left">T&iacute;tulo: <?php echo $row_arquivos['projeto']; ?></div></td>
      </tr>
      <tr>
        <td colspan="2" class="style1 style4"><div align="left">Obs: <?php echo $row_arquivos['obs']; ?></div></td>
      </tr>
    </table>
    </form>
    <?php
} while ($row_arquivos = mysql_fetch_assoc($arquivos));
?>
</div>
</body>
</html>
<?php
mysql_free_result($cliente);

mysql_free_result($arquivos);
?>
