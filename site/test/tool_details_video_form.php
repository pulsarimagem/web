<?php
if(!strstr($row_top_login['download'],'V')) {
	header("Location: index.php?popup_msg=Erro acesso direto à URL restrita!");
}

$url_ok = "cadastro_ok.php";

$tombo = "00000";
$tipo = "download";
$name = ""; 
$resolucao = "";

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
$contrato = "V";
if (isset($_POST['contrato'])) {
	$contrato = (get_magic_quotes_gpc()) ? $_POST['contrato'] : addslashes($_POST['contrato']);
}
if (isset($_GET['contrato'])) {
	$contrato = (get_magic_quotes_gpc()) ? $_GET['contrato'] : addslashes($_GET['contrato']);
}
if (isset($_GET['name'])) {
	$name = (get_magic_quotes_gpc()) ? $_GET['name'] : addslashes($_GET['name']);
}
if (isset($_POST['name'])) {
	$name = (get_magic_quotes_gpc()) ? $_POST['name'] : addslashes($_POST['name']);
}
if (isset($_GET['resolucao'])) {
	$resolucao = (get_magic_quotes_gpc()) ? $_GET['resolucao'] : addslashes($_GET['resolucao']);
}
if (isset($_POST['resolucao'])) {
	$resolucao = (get_magic_quotes_gpc()) ? $_POST['resolucao'] : addslashes($_POST['resolucao']);
}


mysql_select_db($database_sig, $sig);

$query_usos = "SELECT USO_TIPO.tipo,USO_TIPO.Id
				FROM USO_SUBTIPO
				LEFT JOIN USO ON USO.id_subtipo = USO_SUBTIPO.Id
				LEFT JOIN USO_TIPO ON USO_TIPO.Id = USO.id_tipo
				WHERE USO.contrato = '$contrato'
				GROUP BY tipo ORDER BY tipo";
/*
$query_usos = "SELECT USO_TIPO.tipo, USO_SUBTIPO.subtipo, USO_SUBTIPO.Id 
				FROM USO_SUBTIPO 
				LEFT JOIN USO ON USO.id_subtipo = USO_SUBTIPO.Id 
				LEFT JOIN USO_TIPO ON USO_TIPO.Id = USO.id_tipo
				WHERE USO.contrato = '$contrato'
				GROUP BY subtipo ORDER BY tipo,subtipo";
*/
echo $query_usos;
$usos = mysql_query($query_usos, $sig) or die(mysql_error());

$download_ok = false;

$has_error = false;
$nome_error = false;
$circulacao_error = false;
$tiragem_error = false;
$titulo_error = false;
$tamanho_error = false;
$tipo_proj_error = false;
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
	if(($circulacao = $_POST['circulacao']) == "") {
		$circulacao_error = true;
		$circulacao_error_msg = "Este campo é um campo obrigatório!";
		$has_error = true;
	}
	if(($tiragem = $_POST['tiragem']) == "") {
/*		$tiragem_error = true;
		$tiragem_error_msg = "Este campo é um campo obrigatório!";
		$has_error = true;*/
	}
	if(($titulo = $_POST['titulo']) == "") {
		$titulo_error = true;
		$titulo_error_msg = "Este campo é um campo obrigatório!";
		$has_error = true;
	}
	if(($tamanho = $_POST['tamanho']) == "") {
		$tamanho_error = true;
		$tamanho_error_msg = "Este campo é um campo obrigatório!";
		$has_error = true;
	}
	if(($uso = $_POST['uso']) == "") {
		$uso_error = true;
		$uso_error_msg = "Este campo é um campo obrigatório!";
		$has_error = true;
	}
	if(($obs = $_POST['obs']) == "") {
/*		$obs_error = true;
		$obs_error_msg = "Este campo é um campo obrigatório!";
		$has_error = true;*/
	}
}

if(!$has_error && $submit) {

	$tipo = "download";
	if (isset($_POST['tipo'])) {
		  $tipo = (get_magic_quotes_gpc()) ? $_POST['tipo'] : addslashes($_POST['tipo']);
	}
	
	
	if($tipo == "layout") {
// tool_details_layout	
	} else {
		
//		include("./toolkit/inc_IPTC4.php");
		
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
				$file = $tombo_file."_".$resolucao.".mov";
				/*
				
			
				
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
//				$files_arr[] = 'c:\\'.$file;;
*/
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
			//	echo $insertSQL;
				$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
			/*
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
				
*/				
			}
/*			
			if(count($files_arr) > 1) {
				$zipfile = $homeftp."/temp/".$usuario.".zip";
	//			$zipfile = 'c:\\'.$usuario.".zip";
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
			*/
			$download_ok = true;
		}	
	}
}
else {
	$estouro_quota = true;
	
	$usuario= $row_top_login['id_cadastro'];
	
	//verifica se ultrapassou o limite diário:
	
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

	$totalRows_formulario = 0;
	if ( $row_conta1['total'] < $row_conta2['limite'] ) {
		$estouro_quota = false;
		// verifica se tem questionário antigo...
		
		$sql3="
		select * from log_download2 where id_login = ".$usuario." order by id_log desc";
		
		mysql_select_db($database_pulsar, $pulsar);
		$formulario = mysql_query($sql3, $pulsar) or die(mysql_error());
		$row_formulario = mysql_fetch_assoc($formulario);
		$totalRows_formulario = mysql_num_rows($formulario);
		
		$sql4 = "select id_tipo from USO where id = ".$row_formulario['formato'];
		mysql_select_db($database_sig, $sig);
		$tipo_proj = mysql_query($sql4, $sig) or die(mysql_error());
		$row_tipo_proj = mysql_fetch_assoc($tipo_proj);
		$totalRows_tipo_proj = mysql_num_rows($tipo_proj);
	}
	$add_script = "


<script language=\"JavaScript\" type=\"text/JavaScript\">
<!--
function copiar() {

	document.getElementById('usuario').value = document.getElementById('usuario_ant').value;
	document.getElementById('titulo').value = document.getElementById('titulo_ant').value;
	document.getElementById('tipo_proj').value = document.getElementById('tipo_proj_ant').value;
		var dataString = 'action=distribuicao&contrato=V&id_projeto='+ document.getElementById('tipo_proj_ant').value;
		$.ajax({
			type: \"POST\",
			url: \"../tool_ajax.php\",
			data: dataString,
			cache: false,
			success: function(html) {
				$(\"#uso\").html(html);
				$(\".tamanho\").html('<option value=\"\">--- Escolha um uso primeiro ---</option>');
				document.getElementById('uso').value = document.getElementById('uso_ant').value;
			} 
		});
		var dataString = 'action=tamanho&contrato=V&id_uso='+ document.getElementById('uso_ant').value;
		$.ajax({
			type: \"POST\",
			url: \"../tool_ajax.php\",
			data: dataString,
			cache: false,
			success: function(html) {
				$(\".tamanho\").html(html);
				document.getElementById('formato').value = document.getElementById('formato_ant').value;
			} 
		});
//	document.getElementById('formato').value = document.getElementById('formato_ant').value;
//	document.getElementById('tiragem').value = document.getElementById('tiragem_ant').value;
	document.getElementById('obs').value = document.getElementById('obs_ant').value;
	document.getElementById(document.getElementById('circulacao_ant').value).checked = true;

	};
-->
</script>
";
}
?>