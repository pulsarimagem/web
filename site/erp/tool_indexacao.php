<?php
$toLoad = false;
$multiLoad = false;
$tomboExists = false;
$tombos = array();
$isFotoTmp = (isset($_GET['fotoTmp'])?true:false);
$deleteFotoTmp = (isset($_POST['deleteVideoTmp'])?true:false); 
$isCopy = (isset($_GET['copiar'])?true:false);
$isCopyDesc = (isset($_GET['copiar_desc'])?true:false);
$isCopyIptc = (isset($_GET['copy_iptc'])?true:false);
$action = isset($_GET['action'])?strtolower($_GET['action']):"";
$action = isset($_POST['action'])?strtolower($_POST['action']):$action;

$msg = isset($_GET['msg'])?$_GET['msg']:"";

// print_r($_POST);
// print_r($_GET);
mysql_select_db($database_pulsar, $pulsar);

if($action == "copy_btn") {
	$copyURL = $_POST['copy_url'];
	$copyTombo = preg_replace("/[^A-Za-z0-9]/", '', $_POST['copy_tombo']);
	header("location: $copyURL&copiar=true&copy_tombo=$copyTombo");
	die();
}
else if($action == "copy_desc_btn") {
	$add_temas = "";
	if(isset($_POST['temas'])) {
		$add_temas = "temas[]=";
		$temasSubmit = $_POST['temas'];
		$temasAddTmp = implode("&temas[]=",$temasSubmit);
		$add_temas .= $temasAddTmp;
	}
	$add_assunto = "";
	if(isset($_POST['assunto_principal'])) {
		$add_assunto = "&assunto_principal=";
		$add_assunto .= $_POST['assunto_principal'];
	}
	$add_extra = "";
	if(isset($_POST['extra'])) {
		$add_extra = "&extra=";
		$add_extra .= $_POST['extra'];
	}
	$add_data = "";
	if(isset($_POST['data_tela'])) {
		$add_data = "&data_tela=";
		$add_data .= $_POST['data_tela'];
	}
	$add_cidade = "";
	if(isset($_POST['cidade'])) {
		$add_cidade = "&cidade=";
		$add_cidade .= $_POST['cidade'];
	}
	$add_estado = "";
	if(isset($_POST['estado'])) {
		$add_estado = "&estado=";
		$add_estado .= $_POST['estado'];
	}
	$add_pais = "";
	if(isset($_POST['pais'])) {
		$add_pais = "&pais=";
		$add_pais .= $_POST['pais'];
	}
	$add_dir_img = "";
	if(isset($_POST['dir_img'])) {
		$add_dir_img = "&dir_img=";
		$add_dir_img .= $_POST['dir_img'];
	}
	$copyURL = $_POST['copy_url'];
// 	$copyTombo = $_POST['copy_tombo'];
	$copyTombo = preg_replace("/[^A-Za-z0-9]/", '', $_POST['copy_desc']);
	header("location: $copyURL&copiar_desc=true&copy_tombo=$copyTombo&$add_temas$add_assunto$add_extra$add_dir_img$add_data$add_cidade$add_estado$add_pais");
	die();
}
else if($action == "copy_iptc_btn") {
	$add_temas = "";
	if(isset($_POST['temas'])) {
		$add_temas = "temas[]=";
		$temasSubmit = $_POST['temas'];
		$temasAddTmp = implode("&temas[]=",$temasSubmit);
		$add_temas .= $temasAddTmp;
	}
	$add_assunto = "";
	if(isset($_POST['assunto_principal'])) {
		$add_assunto = "&assunto_principal=";
		$add_assunto .= $_POST['assunto_principal'];
	}
	$add_extra = "";
	if(isset($_POST['extra'])) {
		$add_extra = "&extra=";
		$add_extra .= $_POST['extra'];
	}
	$add_data = "";
	if(isset($_POST['data_tela'])) {
		$add_data = "&data_tela=";
		$add_data .= $_POST['data_tela'];
	}
	$add_cidade = "";
	if(isset($_POST['cidade'])) {
		$add_cidade = "&cidade=";
		$add_cidade .= $_POST['cidade'];
	}
	$add_estado = "";
	if(isset($_POST['estado'])) {
		$add_estado = "&estado=";
		$add_estado .= $_POST['estado'];
	}
	$add_pais = "";
	if(isset($_POST['pais'])) {
		$add_pais = "&pais=";
		$add_pais .= $_POST['pais'];
	}
	
	$copyURL = $_POST['copy_url'];
	$iptcPal = $_POST['iptcPal'];
	header("location: $copyURL&copy_iptc=true&iptcPal=$iptcPal&$add_temas$add_assunto$add_extra$add_data$add_cidade$add_estado$add_pais");
	die();
}
else if($action == "criar" || $isFotoTmp) {
	$tombos = $_GET['tombos'];
	foreach($tombos as $tombo) {
		$tombo = preg_replace("/[^A-Za-z0-9]/", '', $tombo);
		$sqlSelect = "SELECT * FROM Fotos WHERE tombo = '$tombo';";
		$rsSelect = mysql_query($sqlSelect, $pulsar) or die(mysql_error());
		if(mysql_num_rows($rsSelect) == 0) {
			$sql = "INSERT INTO Fotos (tombo) VALUES ('$tombo')";
			mysql_query($sql, $pulsar) or die(mysql_error());
			$idFoto = mysql_insert_id();
			if(!isFotoTmp) {
				$data = file_get_contents($cloud_server.'send_photoS3.php?tombo='.$colname_dados_foto);
				
				$msg = "Criado com sucesso! $data";
				header("location: indexacao.php?tombos[]=$tombo&action=consultar&msg=Criado com sucesso!");
			}
		}
		else {
			$rowSelect = mysql_fetch_array($rsSelect);
			$idFoto = $rowSelect['Id_Foto'];
		}
	}
}
else if($action == "gravar") {
	// Insere o IPTC no arquivo
	include('./toolkit/inc_IPTC4.php');
	
	$id_fotos = $_POST['id_fotos'];
	foreach ($id_fotos as $id_foto) {

		$sql = "SELECT tombo FROM Fotos WHERE Id_Foto = $id_foto";
		$rs = mysql_query($sql, $pulsar) or die(mysql_error());
		$row = mysql_fetch_array($rs);
		$tombo = $row['tombo'];
		
		$orientacao = 'H';
		$width = 0;
		$height = 0;
		
		$orig = "/tmp/$tombo.jpg";
		
		if(!isVideo($tombo)) {
			if(!file_exists($orig)) {
				$cmd = "aws --profile pulsar s3 cp s3://pulsar-media/fotos/orig/$tombo.jpg $orig";
				shell_exec($cmd);
			}
			
			// ROTINA DE PEGAR AS DIMENSOES DA FOTO
			
			$file = "/tmp/".$tombo.".jpg";
			
			if (!file_exists($file)) {				// check se o arquivo existe com extensao jpg e JPG
				$msg .= "Arquivo em alta n�o encontrado!";
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
		}
				
		$direito_img = $_POST['dir_img'] + $_POST['dir_prop'] ;
// 		$id_foto = $_POST['id_foto'];
		$extra = $_POST['extra'];
		$assunto_principal = $_POST['assunto_principal'];
		$pais = $_POST['pais'];
		
		$estado = $_POST['estado'];
		
		$cidade = clearInput($_POST['cidade']);
		if(strtolower_br($cidade) == "nenhum" || strtolower_br($cidade) == "nenhuma")
			$cidade = NULL;
		$data = $_POST['data'];
		$autor = $_POST['autor'];
	// 	$tombo = $_POST['tombo'];
		$assunto_principal_en = translateV2($assunto_principal);
		$extra_en = translateV2($extra);
		
		
		$updateSQL = sprintf("UPDATE Fotos SET tombo=%s, id_autor=%s, data_foto=%s, cidade=%s, id_estado=%s, id_pais=%s, orientacao=%s, assunto_principal=%s, assunto_principal_en=%s, dim_a=%s, dim_b=%s, direito_img=%s, extra=%s, extra_en=%s WHERE Id_Foto=%s",
				GetSQLValueString($tombo, "text"),
				GetSQLValueString($autor, "int"),
				GetSQLValueString($data, "text"),
				GetSQLValueString($cidade, "text"),
				GetSQLValueString($estado, "int"),
				GetSQLValueString($pais, "text"),
				GetSQLValueString($orientacao, "text"),
				GetSQLValueString($assunto_principal, "text"),
				GetSQLValueString($assunto_principal_en, "text"),
				GetSQLValueString($width, "int"),
				GetSQLValueString($height, "int"),
				GetSQLValueString($direito_img, "int"),
				GetSQLValueString($extra, "text"),
				GetSQLValueString($extra_en, "text"),
				GetSQLValueString($id_foto, "int"));
		
	// echo $updateSQL;
		mysql_select_db($database_pulsar, $pulsar);
		mysql_query($updateSQL, $pulsar) or die(mysql_error());
	
		$temasSubmit = $_POST['temas'];
		
		mysql_select_db($database_pulsar, $pulsar);
		$query_temas = sprintf("SELECT   Fotos.tombo,  super_temas.Tema_total,  super_temas.Id, group_concat(super_temas.Id separator ',') as temas_arr, rel_fotos_temas.id_rel FROM Fotos INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto) INNER JOIN super_temas ON (rel_fotos_temas.id_tema=super_temas.Id) WHERE   (Fotos.tombo = '%s') ORDER BY  super_temas.Tema_total",$tombo);
		$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
		$row_temas = mysql_fetch_assoc($temas);
		$temasConcat = $row_temas['temas_arr'];
		$temasArr = explode(",",$temasConcat);
	
		
		
		$temasInsert = array_diff($temasSubmit, $temasArr);
		$temasDelete = array_diff($temasArr, $temasSubmit);
		
		foreach($temasInsert as $tema) {
			$queryInsertTema = "INSERT INTO rel_fotos_temas (id_foto,id_tema) values ($id_foto,$tema)";
	// 		echo $queryInsertTema."<br>";
			mysql_query($queryInsertTema, $pulsar) or die(mysql_error());
		}
		foreach($temasDelete as $tema) {
			if(strlen($tema)>0) {
				$queryDeleteTema = "DELETE FROM rel_fotos_temas WHERE id_foto=$id_foto AND id_tema=$tema";
	// 			echo $queryDeleteTema."<br>";
				mysql_query($queryDeleteTema, $pulsar) or die(mysql_error());
			}
		}
		
		$descSubmit = $_POST['descritores'];
		$descSubmit = explode(",",$descSubmit);
	
		mysql_select_db($database_pulsar, $pulsar);
		$query_descritore = sprintf("SELECT    Fotos.tombo,   pal_chave.Id, group_concat(pal_chave.Id separator ',') as desc_arr,  pal_chave.Pal_Chave,  rel_fotos_pal_ch.id_rel FROM  rel_fotos_pal_ch  INNER JOIN Fotos ON (rel_fotos_pal_ch.id_foto=Fotos.Id_Foto)  INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave) WHERE   (Fotos.tombo = '%s') ORDER BY pal_chave.Pal_Chave",$tombo);
		$descritore = mysql_query($query_descritore, $pulsar) or die(mysql_error());
		$row_descritore = mysql_fetch_assoc($descritore);
		$descConcat = $row_descritore['desc_arr'];
		$descArr = explode(",",$descConcat);
		
		$descInsert = array_diff($descSubmit, $descArr);
		$descDelete = array_diff($descArr, $descSubmit);
		
	// 	echo "<br>";
	// 	print_r($descInsert);
	// 	echo "<br>";
	// 	print_r($descDelete);
	// 	echo "<br>";
		
		foreach($descInsert as $desc) {
			if(!is_numeric($desc)) {
				$desc = clearInput($desc);
				$querySelectDesc = "SELECT * FROM pal_chave WHERE Pal_Chave = '$desc'";
				$SelectDesc = mysql_query($querySelectDesc, $pulsar) or die(mysql_error());
				$rowSelectDesc = mysql_fetch_array($SelectDesc);
				$totalSelectDesc = mysql_num_rows($SelectDesc);
				
				if($totalSelectDesc == 0) {
					$queryInsertDesc = "INSERT INTO pal_chave (Pal_Chave) values ('$desc')";
		// 			echo $queryInsertDesc."<br>";
					mysql_query($queryInsertDesc, $pulsar) or die(mysql_error());
					$desc = mysql_insert_id();
				}
				else {
					$desc = $rowSelectDesc['Id'];
				}
			}
			$querySelectDesc = "SELECT * FROM rel_fotos_pal_ch WHERE id_foto = $id_foto AND id_palavra_chave = $desc";
			$SelectDesc = mysql_query($querySelectDesc, $pulsar) or die(mysql_error());
			$rowSelectDesc = mysql_fetch_array($SelectDesc);
			$totalSelectDesc = mysql_num_rows($SelectDesc);
			
			if($totalSelectDesc == 0) {
				$queryInsertDesc = "INSERT INTO rel_fotos_pal_ch (id_foto,id_palavra_chave) values ($id_foto,$desc)";
		// 				echo $queryInsertDesc."<br>";
				mysql_query($queryInsertDesc, $pulsar) or die(mysql_error());
			}
		}
		foreach($descDelete as $desc) {
			if(strlen($desc)>0) {
				$queryDeleteDesc = "DELETE FROM rel_fotos_pal_ch WHERE id_foto=$id_foto AND id_palavra_chave=$desc";
	// 					echo $queryDeleteDesc."<br>";
				mysql_query($queryDeleteDesc, $pulsar) or die(mysql_error());
			}
		}
		
		if(isset($_POST['descritores_inline'])&&$_POST['descritores_inline']!="") {
			$iptcpal = $_POST['descritores_inline'];
			
			$pal_chave_arr = explode(";",str_replace(",",";",$iptcpal));
			mysql_select_db($database_pulsar, $pulsar);
			
			foreach($pal_chave_arr as $pc) {
				$pc = trim($pc);
				if($pc == "")
					continue;
				$pc = (get_magic_quotes_gpc()) ? $pc : addslashes($pc);
				$query_pal_chave = sprintf("SELECT * FROM pal_chave WHERE Pal_Chave = '%s'", $pc);
				$pal_chave = mysql_query($query_pal_chave, $pulsar) or die(mysql_error());
				$row_pal_chave = mysql_fetch_assoc($pal_chave);
				$totalRows_pal_chave = mysql_num_rows($pal_chave);
			
				$idPc = $row_pal_chave['Id'];
			
				if($totalRows_pal_chave != 0) {
					$querySelectPc = "SELECT * FROM rel_fotos_pal_ch WHERE id_foto = $id_foto and id_palavra_chave = $idPc";
					$selectPc = mysql_query($querySelectPc, $pulsar) or die(mysql_error());
					$totalSelectPc = mysql_num_rows($selectPc);
					if($totalSelectPc == 0) {
						$querySaveIptc = "INSERT INTO rel_fotos_pal_ch (id_foto,id_palavra_chave) VALUES ($id_foto,$idPc)";
						$saveIptc = mysql_query($querySaveIptc, $pulsar) or die(mysql_error());
					}
				}
			}
		}
		
		curl_request_async("http://erp.pulsarimagens.com.br/tool_include_iptc.php",["tombo"=>$tombo],"GET");
		
/*		
	// 	$tombo = $_POST['tombo'];
	
		$thumbs = "/tmp/".$tombo."t.jpg";
		$pop = "/tmp/".$tombo."p.jpg";
		
		$cmd = "aws --profile pulsar s3 cp s3://pulsar-media/fotos/previews/$tombo.jpg $thumbs";
		shell_exec($cmd);
		$cmd = "aws --profile pulsar s3 cp s3://pulsar-media/fotos/previews/".$tombo."p.jpg $pop";
		shell_exec($cmd);
		
		$dest_file = $thumbs;
		coloca_iptc($tombo, $dest_file, $database_pulsar, $pulsar);
		$dest_file = $pop;
		coloca_iptc($tombo, $dest_file, $database_pulsar, $pulsar);
		
		$cmd = "aws --profile pulsar s3 rm s3://pulsar-media/fotos/previews/$tombo.jpg";
		shell_exec($cmd);
		$cmd = "aws --profile pulsar s3 rm s3://pulsar-media/fotos/previews/".$tombo."p.jpg";
		shell_exec($cmd);
		
		$cmd = "aws --profile pulsar s3 cp $thumbs s3://pulsar-media/fotos/previews/$tombo.jpg --acl public-read";
		shell_exec($cmd);
		$cmd = "aws --profile pulsar s3 cp $pop s3://pulsar-media/fotos/previews/".$tombo."p.jpg --acl public-read";
		shell_exec($cmd);
*/		
		if($deleteFotoTmp) {
			$deleteSQL = "DELETE FROM Fotos_tmp WHERE tombo='$tombo'";
			$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
		}
		
// 		unlink($thumbs);
// 		unlink($pop);
		unlink($orig);
		$msg .= "Gravado com sucesso!";
	}
}
else if ($action == "excluir") {
	$id_fotos = $_GET['id_fotos'];
	foreach ($id_fotos as $id_foto) {
		$deleteSQL = sprintf("DELETE FROM Fotos WHERE Id_Foto=%s",
				GetSQLValueString($id_foto, "int"));
	
	// 	echo $deleteSQL;
		
		mysql_select_db($database_pulsar, $pulsar);
		$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
	
		$deleteSQL = sprintf("DELETE FROM rel_fotos_temas WHERE id_foto=%s",
				GetSQLValueString($id_foto, "int"));
	
		mysql_select_db($database_pulsar, $pulsar);
		$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
	
		$deleteSQL = sprintf("DELETE FROM rel_fotos_pal_ch WHERE id_foto=%s",
				GetSQLValueString($id_foto, "int"));
	
		mysql_select_db($database_pulsar, $pulsar);
		$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
	}
	header("Location: indexacao.php?msg=Exclu�do com sucesso!");
}


// if(isset($_POST['tombos']))
// 	$_POST['tombos'] = strtoupper($_POST['tombos']);
// if(isset($_GET['tombos']))
// 	$_GET['tombos'] = strtoupper($_GET['tombos']);

$colname_dados_foto = "0";
if (isset($_GET['action'])) {
	if($_GET['action'] == "multi") {
		$tombos = array();
		$id_fotos = array();
		$prefix = preg_replace("/[^A-Za-z0-9]/", '', $_GET['prefix']);
		for ($i = preg_replace("/[^A-Za-z0-9]/", '', $_GET['inicio']); $i <= preg_replace("/[^A-Za-z0-9]/", '', $_GET['fim']); $i++) {
			$sufix = str_pad((int) $i,3,"0",STR_PAD_LEFT);
			$tombo = strtoupper("$prefix$sufix");
			$tombos[] = $tombo;
			
			$sql = "INSERT IGNORE INTO Fotos (tombo) VALUES ('$tombo')";
			mysql_query($sql, $pulsar) or die(mysql_error());
			$sql = "SELECT Id_Foto FROM Fotos WHERE tombo = '$tombo'";
			$rs = mysql_query($sql, $pulsar) or die(mysql_error());
			$row = mysql_fetch_array($rs);
			$id_fotos[] = $row['Id_Foto'];

			$data = file_get_contents($cloud_server.'send_photoS3.php?tombo='.$colname_dados_foto);
		}
		$colname_dados_foto = preg_replace("/[^A-Za-z0-9]/", '', $tombos[0]);
		$multiLoad = true;
		$toLoad = true;
		$tomboExists = true;
	}
	else {
		if (isset($_GET['tombos'])) {
			$colname_dados_foto = strtoupper((get_magic_quotes_gpc()) ? preg_replace("/[^A-Za-z0-9]/", '', $_GET['tombos'][0]) : addslashes(preg_replace("/[^A-Za-z0-9]/", '', $_GET['tombos'][0])));
			$toLoad = true;
			$tombos = array();
			$tombos[] = $colname_dados_foto; 
		}
		if (isset($_POST['tombos'])) {
			$colname_dados_foto = strtoupper((get_magic_quotes_gpc()) ? preg_replace("/[^A-Za-z0-9]/", '', $_POST['tombos'][0]) : addslashes(preg_replace("/[^A-Za-z0-9]/", '', $_POST['tombos'][0])));
			$toLoad = true;
			$tombos = array();
			$tombos[] = $colname_dados_foto; 
		}
	}
}
if($isFotoTmp) {
	$query_dados_foto = sprintf("SELECT * FROM Fotos_tmp LEFT JOIN codigo_video ON Fotos_tmp.tombo = codigo_video.codigo WHERE tombo = '%s'", $colname_dados_foto);
	$dados_foto = mysql_query($query_dados_foto, $pulsar) or die(mysql_error());
	$row_dados_foto = mysql_fetch_assoc($dados_foto);
	$row_dados_foto_tmp = $row_dados_foto; 
	$totalRows_dados_foto = mysql_num_rows($dados_foto);
	if($totalRows_dados_foto > 0) {
		$tomboExists = true;
		$form_tombo = $row_dados_foto['tombo'];
		$form_filename = $row_dados_foto['arquivo'];
// 		$idFoto = $row_dados_foto['Id_Foto'];
		if($isCopy) {
			$copyTombo = $_GET['copy_tombo'];
			$queryCopy = sprintf("SELECT * FROM Fotos WHERE tombo = '%s'", $copyTombo);
			$rsCopy = mysql_query($queryCopy, $pulsar) or die(mysql_error());
			$rowCopy = mysql_fetch_assoc($rsCopy);
			$totalRowsCopy = mysql_num_rows($rsCopy);
			if($totalRowsCopy > 0) {
				$row_dados_foto = $rowCopy;
			}
		}
		if($isCopyDesc) {
			$copyTombo = $_GET['copy_tombo'];
			$queryCopy = sprintf("SELECT * FROM Fotos WHERE tombo = '%s'", $copyTombo);
			$rsCopy = mysql_query($queryCopy, $pulsar) or die(mysql_error());
			$rowCopy = mysql_fetch_assoc($rsCopy);
			$totalRowsCopy = mysql_num_rows($rsCopy);
			if($totalRowsCopy > 0) {
				$row_dados_foto_desc = $rowCopy;
			}
		}
	}
}
else {
	$query_dados_foto = sprintf("SELECT * FROM Fotos WHERE tombo = '%s'", $colname_dados_foto);
	$dados_foto = mysql_query($query_dados_foto, $pulsar) or die(mysql_error());
	$row_dados_foto = mysql_fetch_assoc($dados_foto);
	$totalRows_dados_foto = mysql_num_rows($dados_foto);
	if($totalRows_dados_foto > 0) {
		$tomboExists = true;
		$idFoto = $row_dados_foto['Id_Foto'];
		$form_tombo = $row_dados_foto['tombo'];
		if($isCopy) {
			$copyTombo = $_GET['copy_tombo'];
			$queryCopy = sprintf("SELECT * FROM Fotos WHERE tombo = '%s'", $copyTombo);
			$rsCopy = mysql_query($queryCopy, $pulsar) or die(mysql_error());
			$rowCopy = mysql_fetch_assoc($rsCopy);
			$totalRowsCopy = mysql_num_rows($rsCopy);
			if($totalRowsCopy > 0) {
				$row_dados_foto = $rowCopy;
			}
		}
		else if ($isCopyDesc) {
			$copyTombo = $_GET['copy_tombo'];
		}
	}
}

if(!$tomboExists && $toLoad && !$multiLoad) {
	if($colname_dados_foto != "") { 
		$addScript="<script>
						if(confirm('Tombo $colname_dados_foto n�o existente no banco de dados. Criar novo?')) {
							location.href = 'indexacao.php?action=criar&tombos[]=$colname_dados_foto';
						}
					</script>";
	}
}
mysql_select_db($database_pulsar, $pulsar);
$query_fotografos = "SELECT * FROM fotografos ORDER BY Nome_Fotografo ASC";
$fotografos = mysql_query($query_fotografos, $pulsar) or die(mysql_error());
$row_fotografos = mysql_fetch_assoc($fotografos);
$totalRows_fotografos = mysql_num_rows($fotografos);

mysql_select_db($database_pulsar, $pulsar);
$query_estado = "SELECT * FROM Estados ORDER BY Estado ASC";
$estado = mysql_query($query_estado, $pulsar) or die(mysql_error());
$row_estado = mysql_fetch_assoc($estado);
$totalRows_estado = mysql_num_rows($estado);

mysql_select_db($database_pulsar, $pulsar);
$query_pais = "SELECT * FROM paises ORDER BY nome ASC";
$pais = mysql_query($query_pais, $pulsar) or die(mysql_error());
$row_pais = mysql_fetch_assoc($pais);
$totalRows_pais = mysql_num_rows($pais);

// mysql_select_db($database_pulsar, $pulsar);
// $query_descritore = sprintf("SELECT    Fotos.tombo,   pal_chave.Id,   pal_chave.Pal_Chave,  rel_fotos_pal_ch.id_rel FROM  rel_fotos_pal_ch  INNER JOIN Fotos ON (rel_fotos_pal_ch.id_foto=Fotos.Id_Foto)  INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave) WHERE   (Fotos.tombo = '%s') ORDER BY pal_chave.Pal_Chave",$row_dados_foto['tombo']);
// $descritore = mysql_query($query_descritore, $pulsar) or die(mysql_error());
// $row_descritore = mysql_fetch_assoc($descritore);
// $totalRows_descritore = mysql_num_rows($descritore);
mysql_select_db($database_pulsar, $pulsar);
$query_descritore = sprintf("SELECT    Fotos.tombo,   pal_chave.Id, group_concat(pal_chave.Id separator ',') as desc_arr,  pal_chave.Pal_Chave,  rel_fotos_pal_ch.id_rel FROM  rel_fotos_pal_ch  INNER JOIN Fotos ON (rel_fotos_pal_ch.id_foto=Fotos.Id_Foto)  INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave) WHERE   (Fotos.tombo = '%s') ORDER BY pal_chave.Pal_Chave",$row_dados_foto['tombo']);
$descritore = mysql_query($query_descritore, $pulsar) or die(mysql_error());
$row_descritore = mysql_fetch_assoc($descritore);
$descConcat = $row_descritore['desc_arr'];
if($isCopyDesc) {
	mysql_select_db($database_pulsar, $pulsar);
	$query_descritore = sprintf("SELECT    Fotos.tombo,   pal_chave.Id, group_concat(pal_chave.Id separator ',') as desc_arr,  pal_chave.Pal_Chave,  rel_fotos_pal_ch.id_rel FROM  rel_fotos_pal_ch  INNER JOIN Fotos ON (rel_fotos_pal_ch.id_foto=Fotos.Id_Foto)  INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave) WHERE   (Fotos.tombo = '%s') ORDER BY pal_chave.Pal_Chave",$copyTombo);
	$descritore = mysql_query($query_descritore, $pulsar) or die(mysql_error());
	$row_descritore = mysql_fetch_assoc($descritore);
	$descConcat = $row_descritore['desc_arr'];
}
if($isCopyIptc) {
	$iptcPal = $_GET['iptcPal'];
	$pal_chave_arr = explode(";",str_replace(",",";",$iptcPal));
	mysql_select_db($database_pulsar, $pulsar);
	$descArr = array();

	foreach($pal_chave_arr as $pc) {
		$pc = trim($pc);
		if($pc == "")
			continue;
		$pc = (get_magic_quotes_gpc()) ? $pc : addslashes($pc);
		$query_pal_chave = sprintf("SELECT * FROM pal_chave WHERE Pal_Chave = '%s'", $pc);
		$pal_chave = mysql_query($query_pal_chave, $pulsar) or die(mysql_error());
		$row_pal_chave = mysql_fetch_assoc($pal_chave);
		$totalRows_pal_chave = mysql_num_rows($pal_chave);
	
		$idPc = $row_pal_chave['Id'];
	
		if($totalRows_pal_chave != 0) {
			$descArr[] = $idPc;
		}
	}
	$descConcat = implode(",",$descArr);
}

mysql_select_db($database_pulsar, $pulsar);
$query_temas = sprintf("SELECT   Fotos.tombo,  super_temas.Tema_total,  super_temas.Id, group_concat(super_temas.Id separator ',') as temas_arr, rel_fotos_temas.id_rel FROM Fotos INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto) INNER JOIN super_temas ON (rel_fotos_temas.id_tema=super_temas.Id) WHERE   (Fotos.tombo = '%s') ORDER BY  super_temas.Tema_total",$row_dados_foto['tombo']);
$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
$row_temas = mysql_fetch_assoc($temas);
$temasConcat = $row_temas['temas_arr'];
$temasArr = explode(",",$temasConcat);
if(isset($_GET['temas'])) {
	$temasArr = $_GET['temas'];
}
if($isCopyDesc) {
	mysql_select_db($database_pulsar, $pulsar);
	$query_temas = sprintf("SELECT   Fotos.tombo,  super_temas.Tema_total,  super_temas.Id, group_concat(super_temas.Id separator ',') as temas_arr, rel_fotos_temas.id_rel FROM Fotos INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto) INNER JOIN super_temas ON (rel_fotos_temas.id_tema=super_temas.Id) WHERE   (Fotos.tombo = '%s') ORDER BY  super_temas.Tema_total",$copyTombo);
	$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
	$row_temas = mysql_fetch_assoc($temas);
	$temasConcat = $row_temas['temas_arr'];
	$temasArr = explode(",",$temasConcat);
}

$queryAllTemas = "SELECT   super_temas.Tema_total,  super_temas.Id FROM super_temas ORDER BY  super_temas.Tema_total";
$rsAllTemas = mysql_query($queryAllTemas, $pulsar) or die(mysql_error());
$rowAllTemas = mysql_fetch_assoc($rsAllTemas);


// Deteccao de fotografo
$inicial = strtoupper(preg_replace("/[^A-Za-z]/","", $colname_dados_foto));
mysql_select_db($database_pulsar, $pulsar);
$query_ini_fotografo = sprintf("SELECT * FROM fotografos WHERE Iniciais_Fotografo = '%s'", $inicial);
$ini_fotografo = mysql_query($query_ini_fotografo, $pulsar) or die(mysql_error());
$row_ini_fotografo = mysql_fetch_assoc($ini_fotografo);
$totalRows_ini_fotografo = mysql_num_rows($ini_fotografo);

$autor_encontrado = false;
if($totalRows_ini_fotografo > 0) {
	$autor_encontrado = true;
}

if($toLoad && $tomboExists && !$multiLoad) {
	if(!isVideo($colname_dados_foto)) { 
		if($tomboExists) {
			$orig = "/tmp/$colname_dados_foto.jpg";
			if(!file_exists($orig)) {
				$cmd = "aws --profile pulsar s3 cp s3://pulsar-media/fotos/orig/$colname_dados_foto.jpg $orig";
				shell_exec($cmd);
			}
			if(!file_exists($orig)) {
				$addScript="<script>
								alert('Tombo $colname_dados_foto n�o presente no $orig');
							</script>";
			}
		}
	}
	else if (true) {
		$data = file_get_contents($cloud_server.'get_thumbs.php?&tombo='.$colname_dados_foto);
		$thumbs = json_decode($data);
		
		$data = file_get_contents($cloud_server.'get_video_id3.php?tombo='.$colname_dados_foto);
		$video_info = json_decode($data);
	}
}

mysql_select_db($database_pulsar, $pulsar);

$query_autor_fotos_tmp_select = sprintf("SELECT Fotos_tmp.id_autor, count(Fotos_tmp.id_autor) as total,fotografos.Nome_Fotografo as nome FROM Fotos_tmp, fotografos WHERE Fotos_tmp.tombo NOT RLIKE '^[a-zA-Z]' AND Fotos_tmp.id_autor = fotografos.id_fotografo GROUP BY id_autor");
$autor_fotos_tmp_select = mysql_query($query_autor_fotos_tmp_select, $pulsar) or die(mysql_error());

$query_autor_videos_tmp_select = sprintf("SELECT Fotos_tmp.id_autor, count(Fotos_tmp.id_autor) as total,fotografos.Nome_Fotografo as nome FROM Fotos_tmp, fotografos WHERE Fotos_tmp.tombo RLIKE '^[a-zA-Z]' AND Fotos_tmp.id_autor = fotografos.id_fotografo AND Fotos_tmp.status = 2 GROUP BY id_autor");
$autor_videos_tmp_select = mysql_query($query_autor_videos_tmp_select, $pulsar) or die(mysql_error());

// print_r($_SESSION);
$id_autor = (isset($_SESSION['autor'])&&$_SESSION['autor']!=""?$_SESSION['autor']:"");

if($id_autor != "") {
	$query_fotos_tmp_select = sprintf("SELECT tombo FROM Fotos_tmp WHERE Fotos_tmp.tombo NOT RLIKE '^[a-zA-Z]' AND id_autor=%s LIMIT 20",$id_autor);
	$fotos_tmp_select = mysql_query($query_fotos_tmp_select, $pulsar) or die(mysql_error());
	
	$query_videos_tmp_select = sprintf("SELECT tombo FROM Fotos_tmp WHERE Fotos_tmp.tombo RLIKE '^[a-zA-Z]' AND Fotos_tmp.status = 2 AND id_autor=%s LIMIT 20",$id_autor);
	$videos_tmp_select = mysql_query($query_videos_tmp_select, $pulsar) or die(mysql_error());
}
// se � nova indexa��o vai para outra tela
// if ($totalRows_dados_foto == 0) { 
//   if (($_GET['tombo'] != "") && ($_POST['del_cromo'] == "") && ($row_login['index_inc']==1)) {
// //     header(sprintf("Location: adm_index_inc.php?tombo=%s", $_GET['tombo']));
//   }
// }


$iptc_assunto = "";
$iptc_local = "";
$iptc_pais = "Brasil";
$iptc_estado = "";
$iptc_data = "";
$iptc_pal = "";

if($tomboExists && !isVideo($colname_dados_foto)) {
	$output_str = "";
	$tipo1[0] = "/Assunto/";
	$tipo1[1] = "/Local/";
	$tipo1[2] = "/Pa�s/";
	$tipo1[2] = "/Pais/";
	$tipo1[3] = "/Data/";
	$tipo1[4] = "/Autor/";
	$tipo2[0] = "Assunto";
	$tipo2[1] = "; Local";
	$tipo2[2] = "; Pa�s";
	$tipo2[2] = "; Pais";
	$tipo2[3] = "; Data";
	$tipo2[4] = "; Autor";
	
	$orig = "/tmp/$colname_dados_foto.jpg";
	if(!file_exists($orig)) {
		$cmd = "aws --profile pulsar s3 cp s3://pulsar-media/fotos/orig/$colname_dados_foto.jpg $orig";
		shell_exec($cmd);
	}
	
// 	$exif = exif_read_data ( $fotosalta . $colname_dados_foto . '.jpg', 'IFD0' );
	// $exif = exif_read_data('/var/www/www.pulsarimagens.com.br/bancoImagens/'.$_GET['foto'].'.jpg', 'IFD0');
// 	echo $exif === false ? "No EXIF data found.<br />\n" : "";
	$exif = exif_read_data ( $orig, 0, true );
	// $exif = exif_read_data('/var/www/www.pulsarimagens.com.br/bancoImagens/'.$_GET['foto'].'.jpg', 0, true);
	
	$output_str = $exif ["IFD0"] ["ImageDescription"];
	
	if ($output_str == "" || $output_str == null || strlen($output_str) < 2) {
		$output_str = get_iptc_caption ( $orig );
	}
	else {
		$output_str = mb_convert_encoding ( $output_str, "iso-8859-1", "UTF-8" );
	}
	$fff = preg_replace ( $tipo1, $tipo2, $output_str );
	$array_final = split ( ";", $fff );
	
	$iptc_pal = output_iptc_data($orig);

	foreach ( $array_final as $aa => $bb ) {
		if (valid_utf8($bb)) {
			$bb=mb_convert_encoding($bb,"iso-8859-1","UTF-8");
		}
		if(stripos($bb,"Assunto") !== false) {
			$iptc_assunto = trim(str_replace("??","",substr(strstr($bb, ':'),1)));
		}
		if(stripos($bb,"Local") !== false) {
			$iptc_local = trim(str_replace("??","",substr(strstr($bb, ':'),1)));
			if(stripos($bb,"-") !== false) {
				$local_estado = split("-",$iptc_local);
				$iptc_local = trim(str_replace("??","",$local_estado[0]));
				$iptc_estado = trim(str_replace("??","",$local_estado[1]));
			}
		}
		if(stripos($bb,"Pais") !== false) {
			$iptc_pais = trim(str_replace("??","",substr(strstr($bb, ':'),1)));
		}
		if(stripos($bb,"Pa�s") !== false) {
			$iptc_pais = trim(str_replace("??","",substr(strstr($bb, ':'),1)));
		}
		if(stripos($bb,"Data") !== false) {
			$iptc_data = trim(str_replace("??","",substr(strstr($bb, ':'),1)));
		}
	}
}

//$form_tombo = $row_dados_foto['tombo'];
$form_assunto = $row_dados_foto['assunto_principal'];
$form_extra = $row_dados_foto['extra'];
$form_autor = $row_dados_foto['id_autor'];
if($autor_encontrado) {
	$form_autor = $row_ini_fotografo['id_fotografo'];
}
$form_dirimg = $row_dados_foto['direito_img'];
$form_data = $row_dados_foto['data_foto'];
$form_cidade = $row_dados_foto['cidade'];
$form_estado = $row_dados_foto['id_estado'];
$form_pais = $row_dados_foto['id_pais'];

if($isFotoTmp) {
	$iptc_pal = $row_dados_foto_tmp['pal_chave'];
}
//$form_temas =
//$form_pc =

?>