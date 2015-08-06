<?php
$isExcel = _any("excel");

$retirar = array(".jpg",".JPG");
// function makeStamp($theString) {
//   if (preg_match("/([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/", $theString, $strReg)) {
//     $theStamp = mktime($strReg[4],$strReg[5],$strReg[6],$strReg[2],$strReg[3],$strReg[1]);
//   } else if (preg_match("/([0-9]{4})-([0-9]{2})-([0-9]{2})/", $theString, $strReg)) {
//     $theStamp = mktime(0,0,0,$strReg[2],$strReg[3],$strReg[1]);
//   } else if (preg_match("/([0-9]{2}):([0-9]{2}):([0-9]{2})/", $theString, $strReg)) {
//     $theStamp = mktime($strReg[1],$strReg[2],$strReg[3],0,0,0);
//   }
//   return $theStamp;
// }

// function makeDateTime($theString, $theFormat) {
// 	$theDate=date($theFormat, makeStamp($theString));
// 	return $theDate;
// }
$colname_arquivos = "-1";
if (isset($_GET['id_login'])) {
	$colname_arquivos = (get_magic_quotes_gpc()) ? $_GET['id_login'] : addslashes($_GET['id_login']);
	$data = $_GET['data'];
	$data2 = substr($data,5,2).substr($data,0,2);
}
$relTipo = "fotos";
$relTable = "log_download2";
$relFiltro = "arquivo RLIKE '^[0-9]'";

$relExtra1 = "`log_download2`.circulacao,
		`log_download2`.tiragem,
		`log_download2`.formato,
		`log_download2`.uso,";
$relExtra2 = ", $database_sig.USO_DESC.descricao_br as tamanho_desc,
$database_sig.USO_SUBTIPO.subtipo_br as uso_desc";
$relExtra3 = "LEFT JOIN $database_sig.USO_SUBTIPO ON (log_download2.uso = $database_sig.USO_SUBTIPO.Id)
LEFT JOIN $database_sig.USO ON (log_download2.formato = $database_sig.USO.Id)
LEFT JOIN $database_sig.USO_DESC ON ($database_sig.USO.id_descricao = $database_sig.USO_DESC.Id)";

if (isset($_GET['tipo']) && $_GET['tipo']!="fotos") {
	$relTipo = $_GET['tipo'];
}

if($relTipo == "layout") {
	$relTable = "log_download_layout";
	$relExtra1 = "";
	$relExtra2 = "";
	$relExtra3 = "";
}
else if($relTipo == "videos") {
	$relFiltro = "arquivo RLIKE '^[A-Z]'";
}

$tribos = implode('|', array_keys(get_tribos()));

mysql_select_db($database_pulsar, $pulsar);
$query_arquivos = sprintf("SELECT
		`$relTable`.id_log,
		`$relTable`.arquivo,
		`$relTable`.data_hora,
		`$relTable`.ip,
		`$relTable`.id_login,
		`$relTable`.usuario,
		`$relTable`.projeto,
		$relExtra1
		`$relTable`.obs,
		`$relTable`.faturado,
		`fotografos`.Nome_Fotografo,
		`Fotos`.assunto_principal,
		`Fotos`.direito_img,
		(`Fotos`.assunto_principal regexp '($tribos)') as indio
		$relExtra2
		FROM
		`Fotos`

		INNER JOIN `fotografos` ON (`Fotos`.id_autor = `fotografos`.id_fotografo)
		RIGHT OUTER JOIN `$relTable` ON (`Fotos`.tombo = SUBSTRING_INDEX(`$relTable`.arquivo, '.', 1))
		$relExtra3
		WHERE $relFiltro AND id_login = '%s' and EXTRACT(YEAR_MONTH FROM data_hora) like '20%s'
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