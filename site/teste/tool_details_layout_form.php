<?php
if(!strstr($row_top_login['download'],'S') && !strstr($row_top_login['download'],'L')) {
	header("Location: http://www.fbi.gov");
}

$url_ok = "cadastro_ok.php";

$tombo = "00000";
$tipo = "download"; 
if (isset($_GET['layout'])) {
	  $tombo = (get_magic_quotes_gpc()) ? $_GET['layout'] : addslashes($_GET['layout']);
	  $tipo = "layout";
}
if (isset($_GET['layouts'])) {
	  $tombos = $_GET['layouts'];
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

$download_ok = false;

$has_error = false;
$nome_error = false;
$circulacao_error = false;
$tiragem_error = false;
$titulo_error = false;
$tamanho_error = false;
$uso_error = false;
$obs_error = false;
$submit = false;

$nome = "";
$circulacao = "";
$tiragem = "";
$titulo = "";
$tamanho = "";
$uso = "";
$obs = "";

if (isset($_POST['action'])) {
	$submit = true;
	if(($nome = $_POST['nome']) == "") {
		$nome_error = true;
		$nome_error_msg = "O Nome é um campo obrigatório!";
		$has_error = true;
	}
	if(($titulo = $_POST['titulo']) == "") {
		$titulo_error = true;
		$titulo_error_msg = "Este campo é um campo obrigatório!";
		$has_error = true;
	}
	if(($obs = $_POST['obs']) == "") {
		$obs_error = true;
		$obs_error_msg = "Este campo é um campo obrigatório!";
		$has_error = true;
	}
}

if(!$has_error && $submit) {

	$tipo = "download";
	if (isset($_POST['tipo'])) {
		  $tipo = (get_magic_quotes_gpc()) ? $_POST['tipo'] : addslashes($_POST['tipo']);
	}
	
	
	if($tipo == "layout") {
		include("./toolkit/inc_IPTC4.php");
		
		$usuario= $_POST['id_cadastro'];
				
		include("tool_resize.php");
		
		$files_arr = array();
		
		foreach ($_POST['tombos'] as $tombo_file) {
		
			$file = $tombo_file.'.jpg';
//			$source_file = 'c:\\'.$file; 

			$source_file = '/var/fotos_alta/'.$file; 
			
			if(!file_exists($source_file)) {
				if($siteDebug) {
					echo $source_file . " nao encontrado. \n";
				}
				$file = $tombo_file.'.JPG';
			}
			$source_file = '/var/fotos_alta/'.$file;

			if($siteDebug) {
				if(!file_exists($source_file)) {
					echo $source_file . " nao encontrado. \n";
				}
			}
			
			$image = new SimpleImage();
			$image->load($source_file);
		
			if($image->getWidth() > $image->getHeight())
				$image->resizeToWidth(1200);
			else
				$image->resizeToHeight(1200);
		
			$dest_file = $homeftp.'/temp/'.$file;
//			$dest_file = 'c:\\A'.$file;
			
			$image->save($dest_file);
			
			$download_ok = true;
			
			coloca_iptc($tombo_file,$dest_file,$database_pulsar,$pulsar);
			$files_arr[] = $dest_file;
			
	/// CRIAR LOG DE DOWNLOAD DE LAYOUT!!!
/*
 * 
 * 
 
  CREATE TABLE `log_download_layout` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `arquivo` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `data_hora` datetime DEFAULT NULL,
  `ip` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `id_login` int(11) DEFAULT NULL,
  `usuario` varchar(128) DEFAULT NULL,
  `projeto` varchar(128) DEFAULT NULL,
  `obs` text,
  `faturado` tinyint(4) NOT NULL DEFAULT '0',
  `faturado_quem` int(11) DEFAULT NULL,
  `faturado_qdo` datetime DEFAULT NULL,
  `faturado_obs` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_log`),
  UNIQUE KEY `id_log` (`id_log`)
);
  
  
  
  
 * 
 * 
 */	
		
			$insertSQL = sprintf("INSERT INTO log_download_layout (arquivo, data_hora, ip, id_login, usuario, projeto, obs) VALUES ('%s','%s','%s',%s,'%s','%s','%s')",
				$file,
				date("Y-m-d h:i:s", strtotime('now')),
				$_SERVER['REMOTE_ADDR'], 
				$usuario,
				$_POST['nome'],
				$_POST['titulo'],
				$_POST['obs']
			);
			mysql_select_db($database_pulsar, $pulsar);
			//	echo $insertSQL;
			$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
			
		}		
		if(count($files_arr) > 1) {
			$zipfile = $homeftp."/temp/".$usuario.".zip";
	//		$zipfile = 'c:\\'.$usuario.".zip";
			unlink($zipfile);
			if(!create_zip($files_arr,$zipfile,true) && $siteDebug) {
				echo "<br><strong>Erro criando zip $zipfile.<br>";
			}
//			create_zip($files_arr,$zipfile);
			
			Header( "Content-type: application/zip"); 
			header("Content-Disposition: attachment; filename=\"pulsar_ftp.zip\""); 
			header("Content-Length: " . filesize($zipfile));
			ob_clean();
			flush();
			
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
			Header( "Content-type: image"); 
			header("Content-Disposition: attachment; filename=\"$file\""); 
			header("Content-Length: " . filesize($files_arr[0]));
			ob_clean();
			flush();
			readfile($files_arr[0]);
			unlink($files_arr[0]);
		}	
		
		
	} else {
// tools_details_download		
	}
}
else {
	$estouro_quota = true;
	
	$usuario= $row_top_login['id_cadastro'];
	
	//verifica se ultrapassou o limite diário:
	
	$sql1="
	select count(*) as total
	from log_download_layout
	where
	log_download_layout.id_login='".$usuario."'
	AND
	date(log_download_layout.data_hora) = date(now())";
	
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

	$totalRows_formulario = 0;
	if ( $row_conta1['total'] < $row_conta2['limite'] ) {
	
		$estouro_quota = false;
		// verifica se tem questionário antigo...
		
		$sql3="
		select * from log_download_layout where id_login = ".$usuario." order by id_log desc";
		
		mysql_select_db($database_pulsar, $pulsar);
		$formulario = mysql_query($sql3, $pulsar) or die(mysql_error());
		$row_formulario = mysql_fetch_assoc($formulario);
		$totalRows_formulario = mysql_num_rows($formulario);
	}
	$add_script = "


<script language=\"JavaScript\" type=\"text/JavaScript\">
<!--
function copiar() {

	document.getElementById('usuario').value = document.getElementById('usuario_ant').value;
	document.getElementById('titulo').value = document.getElementById('titulo_ant').value;
	document.getElementById('obs').value = document.getElementById('obs_ant').value;

	};
-->
</script>
";
}
?>