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
  `log_download2`.id_log,
  `log_download2`.arquivo,
  `log_download2`.data_hora,
  `log_download2`.ip,
  `log_download2`.id_login,
  `log_download2`.usuario,
  `log_download2`.circulacao,
  `log_download2`.tiragem,
  `log_download2`.projeto,
  `log_download2`.formato,
  `log_download2`.obs,
  `log_download2`.uso,
  `log_download2`.faturado,
  `fotografos`.Nome_Fotografo,
  `Fotos`.assunto_principal
FROM
  `Fotos`
  INNER JOIN `fotografos` ON (`Fotos`.id_autor = `fotografos`.id_fotografo)
  RIGHT OUTER JOIN `log_download2` ON (`Fotos`.tombo = SUBSTRING_INDEX(`log_download2`.arquivo, '.', 1)) WHERE id_login = '%s' and EXTRACT(YEAR_MONTH FROM data_hora)
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Relatório de Download</title>
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
<div align="center"><br />
  <table width="600" border="1" cellspacing="0">
    <tr>
      <td colspan="2" class="style4 style1"><div align="center" class="style5">RELAT&Oacute;RIO MENSAL DE DOWNLOAD DE IMAGENS</div></td>
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
do {
	if($row_arquivos['faturado']==0) {
?>
  <br><form>
    <table width="600" border="1" cellspacing="0">
      
      <tr>
        <td colspan="2" class="style1 style4"><div align="left"><b>C&oacute;digo: <?php echo str_replace(".jpg","",$row_arquivos['arquivo']); ?></b></div>          <div align="left"></div></td>
      </tr>

      <tr>
        <td colspan="2" class="style1 style4"><div align="left">Assunto: <?php echo $row_arquivos['assunto_principal']; ?></td>
      </tr>
      
      <tr>
        <td colspan="2" class="style1 style4"><div align="left">T&iacute;tulo: <?php echo $row_arquivos['projeto']; ?></div>          <div align="left"></div></td>
      </tr>
      <tr>
        <td width="422" class="style1 style4"><div align="left">Uso: <?php echo $row_arquivos['uso']; ?></div></td>
        <td width="168" class="style1 style4">Tamanho: <?php echo $row_arquivos['formato']; ?></div></td>
      </tr>
      <tr>
        <td colspan="2" class="style1 style4"><div align="left">Obs: <?php echo $row_arquivos['obs']; ?></div></td>
      </tr>
    </table>
    </form><br />
<?php
	}
} while ($row_arquivos = mysql_fetch_assoc($arquivos));
?>
</div>
</body>
</html>