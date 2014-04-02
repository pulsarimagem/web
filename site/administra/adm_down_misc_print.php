<?php require_once('Connections/pulsar.php'); ?>
<?php require_once('Connections/sig.php'); ?>
<?php
$isExcel = isset($_GET["excel"]);
$relTipo = "";
$tribos = "";

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
  `Fotos`.assunto_principal,
  (`Fotos`.assunto_principal regexp '($tribos)') as indio,
	$database_sig.USO_DESC.descricao_br as tamanho_desc, 
	$database_sig.USO_SUBTIPO.subtipo_br as uso_desc	
FROM
  `Fotos`

INNER JOIN `fotografos` ON (`Fotos`.id_autor = `fotografos`.id_fotografo)
  RIGHT OUTER JOIN `log_download2` ON (`Fotos`.tombo = SUBSTRING_INDEX(`log_download2`.arquivo, '.', 1)) 

		LEFT JOIN $database_sig.USO_SUBTIPO ON (log_download2.uso = $database_sig.USO_SUBTIPO.Id)
		LEFT JOIN $database_sig.USO ON (log_download2.formato = $database_sig.USO.Id)
		LEFT JOIN $database_sig.USO_DESC ON ($database_sig.USO.id_descricao = $database_sig.USO_DESC.Id)
		
WHERE id_login = '%s' and EXTRACT(YEAR_MONTH FROM data_hora) like '20%s'
GROUP BY arquivo, EXTRACT(DAY FROM data_hora), projeto
ORDER BY faturado, projeto, indio, data_hora DESC 
 ", $colname_arquivos,$data2);
$arquivos = mysql_query($query_arquivos, $pulsar) or die(mysql_error());
$row_arquivos = mysql_fetch_assoc($arquivos);
$totalRows_arquivos = mysql_num_rows($arquivos);

mysql_select_db($database_pulsar, $pulsar);
$query_cliente = sprintf("SELECT * FROM cadastro WHERE id_cadastro = '%s'", $colname_arquivos);
$cliente = mysql_query($query_cliente, $pulsar) or die(mysql_error());
$row_cliente = mysql_fetch_assoc($cliente);
$totalRows_cliente = mysql_num_rows($cliente);


if($isExcel) {
	require_once ('Classes/PHPExcel.php');
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Pulsar")
	->setLastModifiedBy("Pulsar")
	->setTitle("Relatorio Downloads")
	->setSubject("Relatorio Downloads")
	->setDescription("Relatorio Downloads")
	->setKeywords("relatorio download pulsar")
	->setCategory("Relatorio Downloads");


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', utf8_encode('Código'))
	->setCellValue('B1', 'Data')
	->setCellValue('C1', 'Assunto')
	->setCellValue('D1', utf8_encode('Título'))
	->setCellValue('E1', 'Uso')
	->setCellValue('F1', 'Tamanho')
	->setCellValue('G1', 'Faturado')
	->setCellValue('H1', 'Obs');

	$cnt = 2;
	do {
		if($relTipo != "layout") {
			if(is_numeric($row_arquivos['uso'])) {
				mysql_select_db($database_sig, $sig);
				$row_uso = translate_iduso_array($row_arquivos['uso'], "br", $sig);
			}
		}

		// Add some data
		$data = explode(" ",$row_arquivos['data_hora']);
		if($relTipo != "layout") {
			if(is_numeric($row_arquivos['uso'])) {
				$uso = $row_uso['tipo']." | ".$row_uso['utilizacao'];
				$tamanho = $row_uso['tamanho'];
			} else {
				$uso = $row_arquivos['uso'];
				$tamanho = $row_arquivos['formato'];
			}
		} else {
			$uso = "";
			$tamanho = "";
		}

		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$cnt, str_replace(".JPG","",strtoupper($row_arquivos['arquivo'])))
		->setCellValue('B'.$cnt, date("d/m/Y", strtotime($data[0])))
		->setCellValue('C'.$cnt, utf8_encode($row_arquivos['assunto_principal']))
		->setCellValue('D'.$cnt, utf8_encode($row_arquivos['projeto']))
		->setCellValue('E'.$cnt, utf8_encode($uso))
		->setCellValue('F'.$cnt, utf8_encode($tamanho))
		->setCellValue('G'.$cnt, utf8_encode(($row_arquivos['faturado']==0?"Não":"Sim")))
		->setCellValue('H'.$cnt, utf8_encode(str_replace(array("\\r\\n", "\\r", "\\n"), "<br />", $row_arquivos['obs'])));

		$cnt ++;


	} while ($row_arquivos = mysql_fetch_assoc($arquivos));

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Relatorio');

	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="relatorio.xls"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
}
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
		if(is_numeric($row_arquivos['uso'])) {
			mysql_select_db($database_sig, $sig);
			$row_uso = translate_iduso_array($row_arquivos['uso'], "br", $sig);
		}
?>
  <br><form>
    <table width="600" border="1" cellspacing="0">
      
      <tr>
        <td class="style1 style4"><div align="left"><b>C&oacute;digo: <?php echo str_replace(".jpg","",$row_arquivos['arquivo']); ?></b></div>          <div align="left"></div></td>
        <td class="style1 style4"><div align="left">Data: <?php $data = explode(" ",$row_arquivos['data_hora']); echo date("d/m/Y", strtotime($data[0]));?></div></td>
      </tr>

      <tr>
        <td colspan="2" class="style1 style4"><div align="left">Assunto: <?php echo $row_arquivos['assunto_principal']; ?></td>
      </tr>
      
      <tr>
        <td colspan="2" class="style1 style4"><div align="left">T&iacute;tulo: <?php echo $row_arquivos['projeto']; ?></div>          <div align="left"></div></td>
      </tr>
      <tr>
<?php if(is_numeric($row_arquivos['uso'])) { ?>
<!--          <td width="422" class="style1 style4"><div align="left">Uso: <?php echo $row_arquivos['uso_desc']; ?></div></td>-->
		<td width="422" class="style1 style4"><div align="left">Uso: <?php echo $row_uso['tipo']." | ".$row_uso['utilizacao']; ?></div></td>
<?php } else { ?>
        <td width="422" class="style1 style4"><div align="left">Uso: <?php echo $row_arquivos['uso']; ?></div></td>
<?php } ?>
<?php if(is_numeric($row_arquivos['uso'])) { ?>
        <td width="168" class="style1 style4">Tamanho: <?php echo $row_uso['tamanho']; ?></div></td>
<?php } else { ?>                             
        <td width="168" class="style1 style4">Tamanho: <?php echo $row_arquivos['formato']; ?></div></td>
<?php } ?>        
      </tr>
      <tr>
        <td colspan="2" class="style1 style4"><div align="left">Obs: <?php echo str_replace(array("\\r\\n", "\\r", "\\n"), "<br />", $row_arquivos['obs']); ?></div></td>
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