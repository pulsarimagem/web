<?php
$toLoad = false;
$tomboExists = false;
$action = isset($_GET['action'])?strtolower($_GET['action']):"";
$action = isset($_POST['action'])?strtolower($_POST['action']):$action;

mysql_select_db($database_pulsar, $pulsar);

if($action == "indexar") {
	$sqlUpdate = "";
	if(($assunto_principal = $_GET['assunto_principal']) != "") {
		if($sqlUpdate != "")
			$sqlUpdate .= ",";
		$sqlUpdate .= " assunto_principal = '$assunto_principal' ";
	}
	if(($extra = $_GET['extra']) != "") {
		if($sqlUpdate != "")
			$sqlUpdate .= ",";
		$sqlUpdate .= " extra = '$extra' ";
	}
	if(($autor = $_GET['autor']) != "") {
		if($sqlUpdate != "")
			$sqlUpdate .= ",";
		$sqlUpdate .= " id_autor = '$autor' ";
	}
	if(($data = $_GET['data']) != "") {
		if($sqlUpdate != "")
			$sqlUpdate .= ",";
		$sqlUpdate .= " data_foto = '$data' ";
	}
	if(($cidade = $_GET['cidade']) != "") {
		if($sqlUpdate != "")
			$sqlUpdate .= ",";
		$sqlUpdate .= " cidade = '$cidade' ";
	}
	if(($estado = $_GET['estado']) != "") {
		if($sqlUpdate != "")
			$sqlUpdate .= ",";
		$sqlUpdate .= " id_estado = '$estado' ";
	}
	if(($pais = $_GET['pais']) != "") {
		if($sqlUpdate != "")
			$sqlUpdate .= ",";
		$sqlUpdate .= " id_pais = '$pais' ";
	}
	
	$id_fotosArr = $_GET['indexacao'];
	$id_fotos = implode(",",$id_fotosArr);
	
	$incDescritoresArr = explode(",",$_GET['incDescritores']);
	$excDescritoresArr = explode(",",$_GET['excDescritores']);
	
	mysql_select_db($database_pulsar, $pulsar);
	
	foreach($id_fotosArr as $id_foto) {
		if($_GET['incDescritores']!= "") {
			foreach($incDescritoresArr as $descritor) {
				$sql = "SELECT count(*) as cnt FROM rel_fotos_pal_ch WHERE id_foto = $id_foto AND id_palavra_chave = $descritor";
// 				echo $sql."<br>";
				$rs = mysql_query($sql, $pulsar) or die(mysql_error());
				$row = mysql_fetch_array($rs);
				if($row['cnt'] == 0) {
					$sql = "INSERT INTO rel_fotos_pal_ch (id_foto,id_palavra_chave) VALUES ($id_foto,$descritor)";
// 					echo $sql."<br>";
					mysql_query($sql, $pulsar) or die(mysql_error());
				}
			}
		}
		if($_GET['excDescritores']!= "") {
			$excDescritores = implode(",",$excDescritoresArr);
			$sql = "DELETE FROM rel_fotos_pal_ch WHERE id_foto = $id_foto AND id_palavra_chave IN ($excDescritores)";
// 			echo $sql."<br>";
			mysql_query($sql, $pulsar) or die(mysql_error());
		}
	}
	

	$incTemasArr = isset($_GET['incTemas'])?$_GET['incTemas']:"";
	$excTemasArr= isset($_GET['excTemas'])?$_GET['excTemas']:"";
	
	foreach($id_fotosArr as $id_foto) {
		if(isset($_GET['incTemas'])) {		
			foreach($incTemasArr as $tema) {
				$sql = "SELECT count(*) as cnt FROM rel_fotos_temas WHERE id_foto = $id_foto AND id_tema = $tema";
// 							echo $sql."<br>";
				$rs = mysql_query($sql, $pulsar) or die(mysql_error());
				$row = mysql_fetch_array($rs);
				if($row['cnt'] == 0) {
					$sql = "INSERT INTO rel_fotos_temas (id_foto,id_tema) VALUES ($id_foto,$tema)";
// 									echo $sql."<br>";
					mysql_query($sql, $pulsar) or die(mysql_error());
				}
			}
		}
		if(isset($_GET['excTemas'])) {
			$excTemas = implode(",",$excTemasArr);
			$sql = "DELETE FROM rel_fotos_temas WHERE id_foto = $id_foto AND id_tema IN ($excTemas)";
// 					echo $sql."<br>";
			mysql_query($sql, $pulsar) or die(mysql_error());
		}
	}
	
	if($sqlUpdate != "") {
		$sql = "UPDATE Fotos SET $sqlUpdate WHERE Id_Foto IN ($id_fotos)";
// 		echo $sql;
		mysql_query($sql, $pulsar) or die(mysql_error());
	}
}

if($action == "pesquisar") {
	$lingua = "br";
	include("../inc_pesquisa_obj.php");
	$ordem = "royalt-free";
	$maxRows_retorno = 100;
	$pageNum_retorno = 0;
	if (isset($_GET['pageNum_retorno'])&&$_GET['pageNum_retorno']!="") {
		$pageNum_retorno = $_GET['pageNum_retorno'];
	}
	
	$startRow_retorno = $pageNum_retorno * $maxRows_retorno;
	if (isset($_GET['startRow_retorno'])) {
		$startRow_retorno = $_GET['startRow_retorno'];
		$pageNum_retorno = intval($startRow_retorno / $maxRows_retorno);
		$startRow_retorno = $pageNum_retorno * $maxRows_retorno;
	}
	$totalRows_retorno = 0;
	$filtro = "nada";
	$show_foto = true;
	$show_video = true;
	$posfiltro = "";
	
	$pesquisas = array();
	$engine = new pesquisaPulsar();
	$engine->dbConn = $pulsar;
	$engine->db = $database_pulsar;
	$engine->dbSig = $database_sig;
	
	$engine->connect();
	$engine->idioma = $lingua;
	$engine->isEnable = true;
	
// 	$engine->isdebug = true;
	
	if (isset($_GET['id_temas_ex']) && $_GET['id_temas_ex']!="") {
		if(count($_GET['id_temas_ex']) > 0) {
			if($_GET['id_temas_ex'][0] != "") {
				$engine->royaltfree_param['id_temas_ex'] = $_GET['id_temas_ex'];
			}
		} 
	}
	
	if (isset($_GET['id_autores_ex']) && $_GET['id_autores_ex'] != "") {
		if(count($_GET['id_autores_ex']) > 0) {
			if($_GET['id_autores_ex'][0] != "") {
				$engine->royaltfree_param['id_autores_ex'] = $_GET['id_autores_ex'];
			}
		}
	}
	
	if(isset($_GET['idade']) && $_GET['idade']!="") {
		$engine->royaltfree_param['idade'] = $_GET['idade'];
	}

	if(isset($_GET['indice_vendas']) && $_GET['indice_vendas']!="") {
		$engine->royaltfree_param['indice_vendas'] = $_GET['indice_vendas'];
	}
	
	if(isset($_GET['indice_anos']) && $_GET['indice_anos']!="") {
		$engine->royaltfree_param['indice_anos'] = $_GET['indice_anos'];
	}
	
// 	$engine->isdebug = true;
	$engine->pesquisas = $pesquisas;
	$engine->createQuery();
	
	$engine->filter();
	$engine->executeQuery();
	$engine->order($ordem);
	echo "** $startRow_retorno **";
	$retorno = $engine->getRetorno($startRow_retorno, $maxRows_retorno);
	
	$super_string = $engine->getSuperString();
	$totalRows_retorno = $engine->getTotal();
		
	$posfilters_groups = $engine->posfilter_groups();
	
	$posfilters_data = $engine->posfilter_data();
	
	define("BUILDNAV_ANTERIOR","Anterior");
	define("BUILDNAV_PROXIMA","Proxima");
	
	include("../tool_buildnavigation.php");
	
	$nav_bar = buildNavigation($pageNum_retorno, $maxRows_retorno, $totalRows_retorno);
	
}


if(isset($_POST['tombo']))
	$_POST['tombo'] = strtoupper($_POST['tombo']);
if(isset($_GET['tombo']))
	$_GET['tombo'] = strtoupper($_GET['tombo']);

$colname_dados_foto = "0";
if (isset($_GET['tombo'])) {
	$colname_dados_foto = (get_magic_quotes_gpc()) ? $_GET['tombo'] : addslashes($_GET['tombo']);
	$toLoad = true;
}
if (isset($_POST['tombo'])) {
	$colname_dados_foto = (get_magic_quotes_gpc()) ? $_POST['tombo'] : addslashes($_POST['tombo']);
	$toLoad = true;
}
mysql_select_db($database_pulsar, $pulsar);
$query_dados_foto = sprintf("SELECT * FROM Fotos WHERE tombo = '%s'", $colname_dados_foto);
$dados_foto = mysql_query($query_dados_foto, $pulsar) or die(mysql_error());
$row_dados_foto = mysql_fetch_assoc($dados_foto);
$totalRows_dados_foto = mysql_num_rows($dados_foto);
if($totalRows_dados_foto > 0) {
	$tomboExists = true;
}

mysql_select_db($database_pulsar, $pulsar);
$query_extra_foto = sprintf("SELECT * FROM Fotos_extra WHERE tombo = '%s'", $colname_dados_foto);
$extra_foto = mysql_query($query_extra_foto, $pulsar) or die(mysql_error());
$row_extra_foto = mysql_fetch_assoc($extra_foto);
$totalRows_extra_foto = mysql_num_rows($extra_foto);

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


?>