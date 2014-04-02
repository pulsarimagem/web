<?php
if(!strstr($row_top_login['download'],'S')) {
	header("Location: index.php?popup_msg=Erro acesso direto à URL restrita!");
}

$url_ok = "cadastro_ok.php";

$tombo = "00000";
$tipo = "download"; 

$isFoto = false;
$isVideo = false;

if (isset($_GET['download'])) {
	  $tombo = (get_magic_quotes_gpc()) ? $_GET['download'] : addslashes($_GET['download']);
	  $tipo = "download";
	  $isFoto = true;
}
if (isset($_GET['downloads'])) {
	  $tombos = $_GET['downloads'];
	  $tipo = "download";
	  $isFoto = true;
}
if (isset($_GET['layout'])) {
	  $tombo = (get_magic_quotes_gpc()) ? $_GET['layout'] : addslashes($_GET['layout']);
	  $tipo = "layout";
	  $isFoto = true;
}
if (isset($_GET['video'])) {
	  $tombo = (get_magic_quotes_gpc()) ? $_GET['video'] : addslashes($_GET['video']);
	  $tipo = "video";
	  $isVideo = true;
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
$contrato = "F";
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

$default_status = 1;
if($lingua != "br" || $contrato == "V") 
	$default_status = 2;

$queryTipo = "SELECT USO_TIPO.tipo_$lingua as tipo,USO_TIPO.Id 
				FROM USO_SUBTIPO 
				LEFT JOIN USO ON USO.id_utilizacao = USO_SUBTIPO.Id 
				LEFT JOIN USO_TIPO ON USO_TIPO.Id = USO.id_tipo
				WHERE USO.contrato = '$contrato'
				AND USO.status = $default_status
				GROUP BY tipo ORDER BY tipo";

$rsTipo = mysql_query($queryTipo, $sig) or die(mysql_error());

$download_ok = false;

$has_error = false;
$nome_error = false;
$titulo_error = false;
$tipo_error = false;
$utilizacao_error = false;
$formato_error = false;
$distruibuicao_error = false;
$periodicidade_error = false;
$tamanho_error = false;
$obs_error = false;
$submit = false;

$nome = "";
$titulo = "";
$tipo = "";
$utilizacao = "";
$formato = "";
$distribuicao = "";
$periodicidade = "";
$tamanho = "";
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
	if(($utilizacao = $_POST['utilizacao']) == "") {
		$utilizacao_error = true;
		$utilizacao_error_msg = "Este campo é um campo obrigatório!";
		$has_error = true;
	}
	if(($formato = $_POST['formato']) == "") {
		$formato_error = true;
		$formato_error_msg = "Este campo é um campo obrigatório!";
		$has_error = true;
	}
	if(($distribuicao = $_POST['distribuicao']) == "") {
		$distribuicao_error = true;
		$distribuicao_error_msg = "Este campo é um campo obrigatório!";
		$has_error = true;
	}
	if(($periodicidade = $_POST['periodicidade']) == "") {
		$periodicidade_error = true;
		$periodicidade_error_msg = "Este campo é um campo obrigatório!";
		$has_error = true;
	}
	if(($tamanho = $_POST['tamanho']) == "") {
		$tamanho_error = true;
		$tamanho_error_msg = "Este campo é um campo obrigatório!";
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
			$download_ok = true;
			
			if(isset($_POST['tombos'])) {
				foreach ($_POST['tombos'] as $tombo_file) {
					$file = $tombo_file."_".$resolucao.".mov";
					
					if($contrato == "V") {
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
//							echo $insertSQL;
						$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
					}
				}
			}
			else {
				$file = "$name.mov";
					
				if($contrato == "V") {
					$insertSQL = sprintf("INSERT INTO log_download2 (arquivo, data_hora, ip, id_login, usuario, circulacao, tiragem, projeto, formato, uso, obs) VALUES ('%s','%s','%s',%s,'%s','%s','%s','%s','%s','%s','%s')",
							$name,
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
//					echo $insertSQL;
					$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
				}
			}
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
		$rowFormulario = mysql_fetch_assoc($formulario);
		$totalRows_formulario = mysql_num_rows($formulario);
		
/*		if(is_numeric($rowFormulario['formato'])) {
			$sql4 = "select id_tipo from USO where id = ".$rowFormulario['formato'];
			mysql_select_db($database_sig, $sig);
			$tipo_proj = mysql_query($sql4, $sig) or die(mysql_error());
			$row_tipo_proj = mysql_fetch_assoc($tipo_proj);
			$totalRows_tipo_proj = mysql_num_rows($tipo_proj);
		} else */
		if(is_numeric($rowFormulario['uso'])) {
			$sql4 = "select Id, id_tipo, id_utilizacao, id_tamanho, id_formato, id_distribuicao, id_periodicidade, id_descricao from USO where id = ".$rowFormulario['uso'];
			mysql_select_db($database_sig, $sig);
			$rsUso = mysql_query($sql4, $sig) or die(mysql_error());
			$rowUso = mysql_fetch_assoc($rsUso);
			$totalRowsUso = mysql_num_rows($rsUso);
		}
			
	}
//include("tool_details_download_form_script.php");
}
?>