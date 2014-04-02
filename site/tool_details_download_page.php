<?php
if(!strstr($row_top_login['download'],'S')) {
	header("Location: index.php?popup_msg=Erro acesso direto à URL restrita!");
}

$url_ok = "cadastro_ok.php";
$download_ok = true;

$tombo = "00000";
$tipo = "download"; 
if (isset($_GET['download'])) {
	  $tombo = (get_magic_quotes_gpc()) ? $_GET['download'] : addslashes($_GET['download']);
	  $tipo = "download";
}
if (isset($_GET['downloads'])) {
	  $tombos = $_GET['downloads'];
	  $tipo = "download";
}
if (isset($_GET['layout'])) {
	  $tombo = (get_magic_quotes_gpc()) ? $_GET['layout'] : addslashes($_GET['layout']);
	  $tipo = "layout";
}
if (isset($_POST['tombo'])) {
	  $tombo = (get_magic_quotes_gpc()) ? $_POST['tombo'] : addslashes($_POST['tombo']);
}
if (isset($_POST['tombos'])) {
	  $tombos = $_POST['tombos'];
}
if (isset($_POST['tipo'])) {
	  $tipo = (get_magic_quotes_gpc()) ? $_POST['tipo'] : addslashes($_POST['tipo']);
}


include("./toolkit/inc_IPTC4.php");

$usuario= $_POST['id_cadastro'];

//verifica se ultrapassou o limite diÃ¡rio:

$sql1="
select count(*) as total
from log_download2
where
log_download2.id_login='".$usuario."'
AND
date(log_download2.data_hora) = date(now())";

$sql2="
select limite
from cadastro
where
id_cadastro=".$usuario;

mysql_select_db($database_pulsar, $pulsar);
$conta1 = mysql_query($sql1, $pulsar) or die(mysql_error());
$row_conta1 = mysql_fetch_assoc($conta1);
$totalRows_conta1 = mysql_num_rows($conta1);

$conta2 = mysql_query($sql2, $pulsar) or die(mysql_error());
$row_conta2 = mysql_fetch_assoc($conta2);
$totalRows_conta2 = mysql_num_rows($conta2);

if ( $row_conta1['total'] < $row_conta2['limite'] ) {
	
	$files_arr = array();

	foreach ($_POST['tombos'] as $tombo_file) {
		
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
?>