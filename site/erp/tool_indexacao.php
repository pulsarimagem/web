<?php
$toLoad = false;
$multiLoad = false;
$tomboExists = false;
$tombos = array();
$isFotoTmp = (isset($_GET['fotoTmp'])?true:false);
$isCopy = (isset($_GET['copiar'])?true:false);;
$action = isset($_GET['action'])?strtolower($_GET['action']):"";
$action = isset($_POST['action'])?strtolower($_POST['action']):$action;

$msg = isset($_GET['msg'])?$_GET['msg']:"";

// print_r($_POST);
// print_r($_GET);
mysql_select_db($database_pulsar, $pulsar);

if($action == "copy_btn") {
	$copyURL = $_POST['copy_url'];
	$copyTombo = $_POST['copy_tombo'];
	header("location: $copyURL&copiar=true&copy_tombo=$copyTombo");
	die();
}
else if($action == "criar" || $isFotoTmp) {
	$tombos = $_GET['tombos'];
	foreach($tombos as $tombo) {
		$sqlSelect = "SELECT * FROM Fotos WHERE tombo = '$tombo';";
		$rsSelect = mysql_query($sqlSelect, $pulsar) or die(mysql_error());
		if(mysql_num_rows($rsSelect) == 0) {
			$sql = "INSERT INTO Fotos (tombo) VALUES ('$tombo')";
			mysql_query($sql, $pulsar) or die(mysql_error());
			$idFoto = mysql_insert_id();
			if(!isFotoTmp) {
				$msg = "Criado com sucesso!";
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
	include('../toolkit/inc_IPTC4.php');
	
	$id_fotos = $_POST['id_fotos'];
	foreach ($id_fotos as $id_foto) {

		$sql = "SELECT tombo FROM Fotos WHERE Id_Foto = $id_foto";
		$rs = mysql_query($sql, $pulsar) or die(mysql_error());
		$row = mysql_fetch_array($rs);
		$tombo = $row['tombo'];
		
		// ROTINA DE PEGAR AS DIMENSOES DA FOTO
		
		$orientacao = 'H';
		$width = 0;
		$height = 0;
		
		$file = "/var/fotos_alta/".$tombo.".jpg";
		
		if (!file_exists($file)) {				// check se o arquivo existe com extensao jpg e JPG
			$file = "/var/fotos_alta/".$tombo.".JPG";
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
		
		$direito_img = $_POST['dir_img'] + $_POST['dir_prop'] ;
// 		$id_foto = $_POST['id_foto'];
		$extra = $_POST['extra'];
		$assunto_principal = $_POST['assunto_principal'];
		$pais = $_POST['pais'];
		$estado = $_POST['estado'];
		$cidade = $_POST['cidade'];
		$data = $_POST['data'];
		$autor = $_POST['autor'];
	// 	$tombo = $_POST['tombo'];
		$assunto_principal_en = translateText($assunto_principal);
		
		
		$updateSQL = sprintf("UPDATE Fotos SET tombo=%s, id_autor=%s, data_foto=%s, cidade=%s, id_estado=%s, id_pais=%s, orientacao=%s, assunto_principal=%s, assunto_principal_en=%s, dim_a=%s, dim_b=%s, direito_img=%s, extra=%s WHERE Id_Foto=%s",
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
		

	// 	$tombo = $_POST['tombo'];
		$path = $thumbpop;
		$dest_file = $path."/".$tombo.".jpg";
		coloca_iptc($tombo, $dest_file, $database_pulsar, $pulsar);
		$dest_file = $path."/".$tombo."p.jpg";
		coloca_iptc($tombo, $dest_file, $database_pulsar, $pulsar);
		$msg = "Gravado com sucesso!";
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
	header("Location: indexacao.php?msg=Excluído com sucesso!");
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
		$prefix = $_GET['prefix'];
		for ($i = $_GET['inicio']; $i <= $_GET['fim']; $i++) {
			$sufix = str_pad((int) $i,3,"0",STR_PAD_LEFT);
			$tombo = strtoupper("$prefix$sufix");
			$tombos[] = $tombo;
			
			$sql = "INSERT IGNORE INTO Fotos (tombo) VALUES ('$tombo')";
			mysql_query($sql, $pulsar) or die(mysql_error());
			$sql = "SELECT Id_Foto FROM Fotos WHERE tombo = '$tombo'";
			$rs = mysql_query($sql, $pulsar) or die(mysql_error());
			$row = mysql_fetch_array($rs);
			$id_fotos[] = $row['Id_Foto'];
			
		}
		$colname_dados_foto = $tombos[0];
		$multiLoad = true;
		$toLoad = true;
		$tomboExists = true;
	}
	else {
		if (isset($_GET['tombos'])) {
			$colname_dados_foto = strtoupper((get_magic_quotes_gpc()) ? $_GET['tombos'][0] : addslashes($_GET['tombos'][0]));
			$toLoad = true;
			$tombos = array();
			$tombos[] = $colname_dados_foto; 
		}
		if (isset($_POST['tombos'])) {
			$colname_dados_foto = strtoupper((get_magic_quotes_gpc()) ? $_POST['tombos'][0] : addslashes($_POST['tombos'][0]));
			$toLoad = true;
			$tombos = array();
			$tombos[] = $colname_dados_foto; 
		}
	}
}
if($isFotoTmp) {
	$query_dados_foto = sprintf("SELECT * FROM Fotos_tmp WHERE tombo = '%s'", $colname_dados_foto);
	$dados_foto = mysql_query($query_dados_foto, $pulsar) or die(mysql_error());
	$row_dados_foto = mysql_fetch_assoc($dados_foto);
	$row_dados_foto_tmp = $row_dados_foto; 
	$totalRows_dados_foto = mysql_num_rows($dados_foto);
	if($totalRows_dados_foto > 0) {
		$tomboExists = true;
		$form_tombo = $row_dados_foto['tombo'];
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
	}
}

if(!$tomboExists && $toLoad && !$multiLoad) {
	if($colname_dados_foto != "") { 
		$addScript="<script>
						if(confirm('Tombo $colname_dados_foto não existente no banco de dados. Criar novo?')) {
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

mysql_select_db($database_pulsar, $pulsar);
$query_temas = sprintf("SELECT   Fotos.tombo,  super_temas.Tema_total,  super_temas.Id, group_concat(super_temas.Id separator ',') as temas_arr, rel_fotos_temas.id_rel FROM Fotos INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto) INNER JOIN super_temas ON (rel_fotos_temas.id_tema=super_temas.Id) WHERE   (Fotos.tombo = '%s') ORDER BY  super_temas.Tema_total",$row_dados_foto['tombo']);
$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
$row_temas = mysql_fetch_assoc($temas);
$temasConcat = $row_temas['temas_arr'];
$temasArr = explode(",",$temasConcat);

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
			if(!file_exists($fotosalta.$colname_dados_foto.".jpg") && !file_exists($fotosalta.$colname_dados_foto.".JPG")) {
				$addScript="<script>
								alert('Tombo $colname_dados_foto não presente no $fotosalta');
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
// se ï¿½ nova indexaï¿½ï¿½o vai para outra tela
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

if($tomboExists) {
	$output_str = "";
	$tipo1[0] = "/Assunto/";
	$tipo1[1] = "/Local/";
	$tipo1[2] = "/País/";
	$tipo1[2] = "/Pais/";
	$tipo1[3] = "/Data/";
	$tipo1[4] = "/Autor/";
	$tipo2[0] = "Assunto";
	$tipo2[1] = "; Local";
	$tipo2[2] = "; País";
	$tipo2[2] = "; Pais";
	$tipo2[3] = "; Data";
	$tipo2[4] = "; Autor";
	
// 	$exif = exif_read_data ( $fotosalta . $colname_dados_foto . '.jpg', 'IFD0' );
	// $exif = exif_read_data('/var/www/www.pulsarimagens.com.br/bancoImagens/'.$_GET['foto'].'.jpg', 'IFD0');
// 	echo $exif === false ? "No EXIF data found.<br />\n" : "";
	$exif = exif_read_data ( $fotosalta . $colname_dados_foto . '.jpg', 0, true );
	// $exif = exif_read_data('/var/www/www.pulsarimagens.com.br/bancoImagens/'.$_GET['foto'].'.jpg', 0, true);
	
	$output_str = $exif ["IFD0"] ["ImageDescription"];
	
	if ($output_str == "" || $output_str == null) {
		$output_str = output_iptc_caption ( $fotosalta . $colname_dados_foto . '.jpg' );
	}
	$output_str = mb_convert_encoding ( $output_str, "iso-8859-1", "UTF-8" );
	$fff = preg_replace ( $tipo1, $tipo2, $output_str );
	$array_final = split ( ";", $fff );
	
	$iptc_pal = output_iptc_data($fotosalta . $colname_dados_foto . '.jpg');

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
		if(stripos($bb,"País") !== false) {
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