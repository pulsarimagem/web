<?php include('video_toolkit.php')?>
<?php
// require_once('excel_reader2.php');
require_once('PHPExcel.php');

$load_file = false;
$insert_cnt = 0;
$lista_files = array();
$lista_missing_files = array();
$autor = $row_top_login['id_fotografo'];
$inicial = $row_top_login['Iniciais_Fotografo'];

$debug = "";

//$planilha = new Spreadsheet_Excel_Reader("indexaVideos.xls");
if(isset($_FILES['excel']) && ($_FILES['excel']['type']=="application/vnd.ms-excel"|| $_FILES['excel']['type']=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"))
	$load_file = true;

// $load_file = true;

if($load_file) {
	$inputFileName = $_FILES['excel']['tmp_name'];
//  	$inputFileName = "C:/videos6.xls";
	/**  Identify the type of $inputFileName  **/
	$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
	/**  Create a new Reader of the type that has been identified  **/
	$objReader = PHPExcel_IOFactory::createReader($inputFileType);
	/**  Load $inputFileName to a PHPExcel Object  **/
// 	$objReader->setReadDataOnly(true);
	$objPHPExcel = $objReader->load($inputFileName);
	$planilha = $objPHPExcel->getActiveSheet();
	
	$excel_row = $planilha->getHighestRow();
	$excel_col = $planilha->getHighestColumn();
	
	$debug .= "Row: $excel_row<br> Column: $excel_col<br>";
	
	for($row = 2; $row <= $excel_row; $row++) {
		$rowcnt = 1;
		$filename = utf8_decode($planilha->getCellByColumnAndRow(0,$row)->getValue());
		$tombo = generate_codigo($inicial,$filename,$pulsar);
		if($filename != "") {		
			$lista_files[$filename] = $tombo;
			$assunto = utf8_decode($planilha->getCellByColumnAndRow(1,$row)->getValue());
			$extra = utf8_decode($planilha->getCellByColumnAndRow(2,$row)->getValue());
		//	$rowcnt++;
			$data = PHPExcel_Style_NumberFormat::toFormattedString($planilha->getCellByColumnAndRow(3,$row)->getValue(),'YYYYMM' );
//			$data_obj = DateTime::createFromFormat("YYYY-MM",PHPExcel_Style_NumberFormat::toFormattedString($planilha->getCellByColumnAndRow(3,$row),'YYYY-MM')); 
//			$data = $data_obj->format("Ym");
		//	echo "**".$data_obj->format("m/Y")."<br>";
			$cidade = utf8_decode($planilha->getCellByColumnAndRow(4,$row)->getValue());
			
			$estado = utf8_decode($planilha->getCellByColumnAndRow(5,$row)->getValue());
			$query_select_estado = sprintf("SELECT * FROM Estados WHERE Sigla like '%s'", $estado);
			$select_estado = mysql_query($query_select_estado, $pulsar) or die(mysql_error());
			$row_select_estado = mysql_fetch_assoc($select_estado);
			$id_estado = $row_select_estado['id_estado'];
			
			$pais = utf8_decode($planilha->getCellByColumnAndRow(6,$row)->getValue());
			$query_select_pais = sprintf("SELECT * FROM paises WHERE nome like '%s'", $pais);
			$select_pais = mysql_query($query_select_pais, $pulsar) or die(mysql_error());
			$row_select_pais = mysql_fetch_assoc($select_pais);
			$id_pais = $row_select_pais['id_pais'];
			
			
	//		$rowcnt++; //temas
			$descritores = utf8_decode($planilha->getCellByColumnAndRow(7,$row)->getValue());
			$descritores .= ";".utf8_decode($planilha->getCellByColumnAndRow(8,$row)->getValue());
		//}
		
		// INSERIR NA TABELA FOTO
		//if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
		
			$orientacao = 'H';
			$width = 0;
			$height = 0;
		/*
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
		*/
	
			$insertSQL = sprintf("INSERT IGNORE INTO Fotos_tmp (tombo, id_autor, data_foto, cidade, id_estado, id_pais, orientacao, assunto_principal, dim_a, dim_b, extra, pal_chave) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					GetSQLValueString($tombo, "text"),
					GetSQLValueString($autor, "int"),
					GetSQLValueString($data, "text"),
					GetSQLValueString($cidade, "text"),
					GetSQLValueString($id_estado, "int"),
					GetSQLValueString($id_pais, "text"),
					GetSQLValueString($orientacao, "text"),
					GetSQLValueString($assunto, "text"),
					GetSQLValueString($width, "int"),
					GetSQLValueString($height, "int"),
					GetSQLValueString($extra, "text"),
					GetSQLValueString($descritores, "text"));
		
			$debug .= "SQL: $insertSQL<br>";
			
			//echo $insertSQL."<br>";
			mysql_select_db($database_pulsar, $pulsar);
			$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
			$insert_cnt++;
			
			$Ultimo_Id = mysql_insert_id();
			
			$user = $row_top_login['Iniciais_Fotografo'];
			$param = array('user'=>$user, 'tombo'=>$filename, 'codigo'=>$tombo);
			//print_r($param);
	
	
	//		$data = curl_request_async($cloud_server.'move_video.php', $param, "GET");
			$data = file_get_contents($cloud_server.'move_video.php?user='.$user.'&tombo='.$filename.'&codigo='.$tombo);
			
			$debug .= "Data: $data<br>";

	//		$data = curl_request_async($cloud_server.'create_thumbs.php', $param, "GET");
	//		$data = curl_request_async($cloud_server.'create_video_thumbpop.php', $param, "GET");
	//		$data = curl_request_async($cloud_server.'copy_thumbs.php', $param, "GET");
	
			if(!json_decode($data)) {
				$lista_missing_files[$filename] = $tombo;
			}
		}		
		$insertGoTo = "adm_import_xls.php";
		//  if (isset($_SERVER['QUERY_STRING'])) {
		//    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		//    $insertGoTo .= $_SERVER['QUERY_STRING'];
		//  }
	
	//	header(sprintf("Location: %s", $insertGoTo));
	
	}
}