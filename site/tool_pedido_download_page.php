<?php
$url_ok = "cadastro_ok.php";
$download_ok = false;

$tombo = "00000";
$tipo = "download"; 
$contrato = "F";
$pedido = 0;
if (isset($_GET['pedido'])) {
	  $pedido = (get_magic_quotes_gpc()) ? $_GET['pedido'] : addslashes($_GET['pedido']);
}
if (isset($_POST['pedido'])) {
	$pedido = (get_magic_quotes_gpc()) ? $_POST['pedido'] : addslashes($_POST['pedido']);
}

include("./toolkit/inc_IPTC4.php");

$usuario= $row_top_login['id_cadastro'];
$idCadastro = $usuario;

//verifica se ultrapassou o limite diÃ¡rio:

$sqlPedido="select cpf, statustransacao
			from pedidos
			where
			cod_pedido=".$pedido;

mysql_select_db($database_pulsar, $pulsar);
$rsPedido = mysql_query($sqlPedido, $pulsar) or die(mysql_error());
$rowPedido = mysql_fetch_assoc($rsPedido);
$totalPedido = mysql_num_rows($rsPedido);

$sqlCodigos="select tombo
					from itenspedido
					where
					cod_pedido=".$pedido;

$rsCodigos = mysql_query($sqlCodigos, $pulsar) or die(mysql_error());
$rowCodigos = mysql_fetch_assoc($rsCodigos);
$totalCodigos = mysql_num_rows($rsCodigos);
mysql_data_seek($rsCodigos, 0);

if(isVideo($rowCodigos['tombo']))
	$contrato = "V";

if($rowPedido['cpf'] == $idCadastro &&  $rowPedido['statustransacao'] == "Concluida" && $totalCodigos > 0) {
	
	$files_arr = array();

	while($rowCodigos = mysql_fetch_assoc($rsCodigos)) {	
		$tombo_file = $rowCodigos['tombo'];
		$file = $tombo_file.'.jpg';
		$source_file = '/var/fotos_alta/'.$file; 
		if(!file_exists($source_file))
			$file = $tombo_file.'.JPG';
		$source_file = '/var/fotos_alta/'.$file; 
		$dest_file = $homeftp.'/temp/'.$file; 
		
		if (!copy($source_file, $dest_file)) {
			$file = $tombo_file.'.JPG';
			$source_file = '/var/fotos_alta/'.$file; 
			$dest_file = $homeftp.'/temp/'.$file; 
			if (!copy($source_file, $dest_file)) {
				$erro = "nok";
			} else {
				$erro = "ok";
				$fp = fopen($dest_file, "r");
				$s_array=fstat($fp);
				$tamanho = $s_array["size"];
				fclose($fp); 
			}
		} else {
			$erro = "ok";
			$fp = fopen($dest_file, "r");
			$s_array=fstat($fp);
			$tamanho = $s_array["size"];
			fclose($fp); 
		}
		
		if($siteDebug) {
			echo "<strong>file: </strong>".$file."</strong><br>";
		}

		coloca_iptc($tombo_file,$dest_file,$database_pulsar,$pulsar);
		$files_arr[] = $dest_file;
		//$files_arr[] = 'c:\\'.$file;;
/*		
		$insertSQL = sprintf("INSERT INTO log_download2 (arquivo, data_hora, ip, id_login, usuario, circulacao, tiragem, projeto, formato, uso, obs) VALUES ('%s','%s','%s',%s,'%s','%s','%s','%s','%s','%s','%s')",
			$file,
			date("Y-m-d h:i:s", strtotime('now')),
			$_SERVER['REMOTE_ADDR'], 
			$usuario,
			$_POST['nome'],
			$_POST['circulacao'],
			$_POST['tiragem'],
			$_POST['titulo'],
			$_POST['tamanho'],
			$_POST['uso'],
			$_POST['obs']
		);
		mysql_select_db($database_pulsar, $pulsar);
		//echo $insertSQL;
		$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
*/	
		if(file_exists('/var/fotos_alta/'.$tombo_file.'.JPG')) {  //BUG FIX do erro de sumir o conteudo do $file
			$file = $tombo_file.'.JPG';
		}
		elseif (file_exists('/var/fotos_alta/'.$tombo_file.'.jpg')) {
			$file = $tombo_file.'.jpg';
		}
		if($siteDebug) {
			echo "<br><strong>file: </strong>".$file."<br>";
			echo "<br><strong>Readfile param :</strong>".$homeurl."ftp/temp/".$file."<br>";
		}
		$download_ok = true;		
	}
	
	if(count($files_arr) > 1) {
		$zipfile = $homeftp."/temp/".$usuario.".zip";
		//$zipfile = 'c:\\'.$usuario.".zip";
		unlink($zipfile);
		if(!create_zip($files_arr,$zipfile,true) && $siteDebug) {
			echo "<br><strong>Erro criando zip $zipfile.<br>";
		}
		
		Header("Content-type: application/zip"); 
		header("Content-Disposition: attachment; filename=\"pulsar_ftp.zip\""); 
		header("Content-Length: " . filesize($zipfile));
		ob_clean();
		flush();
		
		//	readfile($homeurl."/ftp/temp/".$file); 
		// readfile($zipfile);
		if((readfile($zipfile) == false)&& $siteDebug) {
			echo "<br>Erro lendo zip $zipfile!<br>";
		}
		unlink($zipfile);
		foreach ($files_arr as $file_erase) {
			unlink($file_erase);
		}
	}
	else {
		Header("Content-type: image"); 
		header("Content-Disposition: attachment; filename=\"$file\""); 
		header("Content-Length: " . filesize($files_arr[0]));
		ob_clean();
		flush();

		readfile($files_arr[0]);
		unlink($files_arr[0]);
	}
}
else {
	$error_msg = "Pedido inválido!";	
}	
?>