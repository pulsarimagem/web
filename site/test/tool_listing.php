<?php
include("inc_pesquisa_obj.php");

function check_exist($id_pasta, $tombo, $database_pulsar, $pulsar) {
	//echo "*".$id_pasta.$tombo."*";
	mysql_select_db($database_pulsar, $pulsar);
	$query_tombo_pastas = sprintf("SELECT tombo, id_pasta FROM pasta_fotos where id_pasta = %s and tombo like '%s';",$id_pasta, $tombo);
	$tombo_pastas = mysql_query($query_tombo_pastas, $pulsar) or die(mysql_error());
	$totalRows_pastas = mysql_num_rows($tombo_pastas);
	if($totalRows_pastas > 0)
		return true;
	return false;
}

if(isset($_GET['clear'])) {
	$_SESSION['ultima_pesquisa'] = "";
	unset($_SESSION['ultima_pesquisa']);
}

if(isset($_SESSION['ultima_pesquisa_query']) && $_SESSION['ultima_pesquisa_query']!=$_GET['query']) {
	$_SESSION['ultima_pesquisa'] = "";
	unset($_SESSION['ultima_pesquisa']);
}

$totalRows_retorno = 0;
$query = "";

$currentPage = $_SERVER["PHP_SELF"];

$show_preview = true;
//if(isset($_GET['preview']) && $_GET['preview'] != "preview")
//	$show_preview = false;

$maxRows_retorno = 48;
if(isset($_SESSION['maxRows']) && ($_SESSION['maxRows']!= "")) {
	$maxRows_retorno = (get_magic_quotes_gpc()) ? $_SESSION['maxRows'] : addslashes($_SESSION['maxRows']);
}
if(isset($_GET['maxRows']) && ($_GET['maxRows']!= "")) {
	$maxRows_retorno = $_GET['maxRows'];
	//  $maxRows_retorno = (get_magic_quotes_gpc()) ? $_GET['maxRows'] : addslashes($_GET['maxRows']);
	$_SESSION['maxRows'] = $maxRows_retorno;
}

if(isset($_GET['ajustar']) && $_GET['ajustar'] == "ajustar") {
	$_SESSION['ajustar'] = "true";
} else if(isset($_GET['ajustar']) && $_GET['ajustar'] != "ajustar") {
	unset($_SESSION['ajustar']);
}

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

$ordem = "relevancia";
if (isset($_GET['ordem'])) {
	$ordem = $_GET['ordem'];
}
else {
	$_GET['ordem'] = "relevancia";
}

$filtro = "nada";
$show_foto = true;
$show_video = true;
if (isset($_GET['filtro'])) {
	if(is_array($_GET['filtro'])) {
		if(count($_GET['filtro']) > 1) {
			$filtro = "nada";
		}
		else {
			$filtro = $_GET['filtro'][0];
		}
	}
	else {
		$filtro = $_GET['filtro'];
	}
	$_SESSION['filtro']=$filtro;
}
else if(isset($_SESSION['filtro'])) {
	$filtro=$_SESSION['filtro'];
}

$posfiltro = "";
if (isset($_GET['posfilter'])) {
	$posfiltro = $_GET['posfilter'];
}

if(!isset($_SESSION['ultima_pesquisa'])) {
	$last_search = str_ireplace("&clear=true", "", $_SERVER['REQUEST_URI']);
	$last_search_arr = explode("/", $last_search);
	//print_r($last_search_arr);
	$last_search = $last_search_arr[count($last_search_arr)-1];
	//echo "**$last_search<br>";
	
	$_SESSION['last_search'] = $last_search;//str_ireplace("&clear=true", "", $_SERVER['REQUEST_URI']);
/*
	$filtro = "nada";
	$show_foto = true;
	$show_video = true;
	if (isset($_GET['filtro'])) {
		if(is_array($_GET['filtro'])) {
			if(count($_GET['filtro']) > 1) {
				$filtro = "nada";
			}
			else {
				$filtro = $_GET['filtro'][0];
			}
		}
		else {
			$filtro = $_GET['filtro'];
		}
		$_SESSION['filtro']=$filtro;	
	}
	else if(isset($_SESSION['filtro'])) {
		$filtro=$_SESSION['filtro'];
	}
	
	$posfiltro = "";
	if (isset($_GET['posfilter'])) {
		$posfiltro = $_GET['posfilter'];
	}
*/	
	$pesquisas = array();
	$engine = new pesquisaPulsar();
	$engine->dbConn = $pulsar;
	$engine->db = $database_pulsar;
	$engine->connect();
	$engine->idioma = $lingua;
	//$engine->isEnable = true;
	
	if (isset($_GET['tombo'])&& ($_GET['tombo']!= "")) {
		$_GET['type']="tombo";
		$_GET['tipo']="inc_pc.php";
		$_GET['query']=trim($_GET['tombo']);
		$query = $_GET['query'];
	
		$pesq = new elementoPesquisa();
		$pesq->arrPalavras[$_GET['tombo']] = $lingua;
		$pesq->arrCampos['tombo'] = true;
		$pesquisas[] = $pesq;
		$engine->isEnable = true;
	}
	else if (isset($_GET['type'])&& ($_GET['type']== "tombo")) {
		$query = $_GET['query'];
	
		$pesq = new elementoPesquisa();
		$pesq->arrPalavras[$_GET['query']] = $lingua;
		$pesq->arrCampos['tombo'] = true;
		$pesquisas[] = $pesq;
		$engine->isEnable = true;
	}
	else {//if (isset($_GET['tema_action'])) {
		if (isset($_GET['email_id']) && $_GET['email_id']!="") {
			$pesq = new elementoPesquisa();
			$pesq->arrPalavras[$_GET['email_id']] = $lingua;
			$pesq->arrCampos['email_id'] = true;
			$pesquisas[] = $pesq;
			$engine->isEnable = true;
		}
		if (isset($_GET['id_estado']) && $_GET['id_estado']!="") {
			$pesq = new elementoPesquisa();
			$pesq->arrPalavras[$_GET['id_estado']] = $lingua;
			$pesq->arrCampos['id_estado'] = true;
			$pesquisas[] = $pesq;
			$engine->isEnable = true;
		}
		if (isset($_GET['tema']) && $_GET['tema'] != "") {
			$engine->arrFiltros['id_tema'] = $_GET['tema'];
			$engine->isEnable = true;
		}
	//}
	//else if ((isset($_GET['pc_action']))||(isset($_GET['pa_action']))) {
		if(isset($_GET['pc_arr'])) {
			$query = implode(" ",$_GET['pc_arr']);
			$_GET['query'] = $query;
		}
		$query = $_GET['query'];
	
		$query_arr = explode(" ", str_ireplace("-", " ", $query));
		foreach($query_arr as $palavra) {
			if(strlen($palavra)>2) {
				$pesq = new elementoPesquisa();
				$pesq->arrPalavras[$palavra] = $lingua;
				$pesq->setAll();
				$pesquisas[] = $pesq;
				$engine->isEnable = true;
			}
		}
		if(isset($_GET['pc'])&&is_array($_GET['pc'])) {
			foreach($_GET['pc'] as $pc) {
				$pesq = new elementoPesquisa();
				$pesq->arrPalavras[$pc] = $lingua;
				$pesq->setAll();
				$pesquisas[] = $pesq;
				$engine->isEnable = true;
			}
		}
		
		if(isset($_GET['fracao']) && $_GET['fracao']!="") {
			$pesq = new elementoPesquisa();
			$pesq->arrPalavras[$_GET['fracao']] = $lingua;
			$pesq->arrCampos['pc'] = true;
			$pesq->arrCampos['assunto'] = true;
			$pesq->arrCampos['extra'] = true;
			$pesq->arrCampos['temas'] = true;
			$pesq->fracao = true;
			$pesquisas[] = $pesq;
			$engine->isEnable = true;
		}
		if(isset($_GET['palavra1']) && $_GET['palavra1']!="") {
			$pesq = new elementoPesquisa();
			$pesq->arrPalavras[$_GET['palavra1']] = $lingua;
			$pesq->arrCampos['pc'] = true;
			$pesq->arrCampos['assunto'] = true;
			$pesq->arrCampos['extra'] = true;
			$pesq->arrCampos['temas'] = true;
			$pesq->pc = 1;
			$pesquisas[] = $pesq;
			$engine->isEnable = true;
		}
		if(isset($_GET['palavra2']) && $_GET['palavra2']!="") {
			$pesq = new elementoPesquisa();
			$pesq->arrPalavras[$_GET['palavra2']] = $lingua;
			$pesq->arrCampos['pc'] = true;
			$pesq->arrCampos['assunto'] = true;
			$pesq->arrCampos['extra'] = true;
			$pesq->arrCampos['temas'] = true;
			$pesq->pc = 2;
			$pesquisas[] = $pesq;
			$engine->isEnable = true;
		}
		if(isset($_GET['palavra3']) && $_GET['palavra3']!="") {
			$pesq = new elementoPesquisa();
			$pesq->arrPalavras[$_GET['palavra3']] = $lingua;
			$pesq->arrCampos['pc'] = true;
			$pesq->arrCampos['assunto'] = true;
			$pesq->arrCampos['extra'] = true;
			$pesq->arrCampos['temas'] = true;
			$pesq->pc = 3;
			$pesquisas[] = $pesq;
			$engine->isEnable = true;
		}
		if (isset($_GET['local']) && $_GET['local']!="") {
			$pesq = new elementoPesquisa();
			$pesq->arrPalavras[$_GET['local']] = $lingua;
			$pesq->arrCampos['cidade'] = true;
			$pesquisas[] = $pesq;
			$engine->isEnable = true;
		}
		if (isset($_GET['estado']) && $_GET['estado']!="") {
			$pesq = new elementoPesquisa();
			foreach($_GET['estado'] as $estado) {
				$pesq->arrPalavras[$estado] = $lingua;
			}
			$pesq->arrCampos['estado'] = true;
			$pesquisas[] = $pesq;
			$engine->isEnable = true;
		}
		if (isset($_GET['pais']) && $_GET['pais']!="") {
			$pesq = new elementoPesquisa();
			$pesq->arrPalavras[$_GET['pais']] = $lingua;
			$pesq->arrCampos['pais'] = true;
			$pesquisas[] = $pesq;
			$engine->isEnable = true;
		}
		if(isset($_GET['nao_palavra']) && $_GET['nao_palavra']!="") {
			$pesq = new elementoPesquisa();
			$pesq->arrPalavras[$_GET['nao_palavra']] = $lingua;
			$pesq->arrCampos['pc'] = true;
			$pesq->not = true;
			$pesquisas[] = $pesq;
			$pesq = new elementoPesquisa();
			$pesq->arrPalavras[$_GET['nao_palavra']] = $lingua;
			$pesq->arrCampos['extra'] = true;
			$pesq->not = true;
			$pesquisas[] = $pesq;
			$pesq = new elementoPesquisa();
			$pesq->arrPalavras[$_GET['nao_palavra']] = $lingua;
			$pesq->arrCampos['assunto'] = true;
			$pesq->not = true;
			$pesquisas[] = $pesq;
			$pesq = new elementoPesquisa();
			$engine->isEnable = true;
		}
		if (isset($_GET['data_tipo']) && $_GET['data_tipo'] != "") {
			$engine->arrFiltros['data'] = $_GET['data_tipo'];
			if (isset($_GET['ano']) && $_GET['ano'] != "") {
				$engine->arrFiltros['ano'] = $_GET['ano'];
				$engine->isEnable = true;
			}
			if (isset($_GET['mes']) && $_GET['mes'] != "") {
				$engine->arrFiltros['mes'] = $_GET['mes'];
				$engine->isEnable = true;
			}
			if (isset($_GET['dia']) && $_GET['dia'] != "") {
				$engine->arrFiltros['dia'] = $_GET['dia'];
				$engine->isEnable = true;
			}
		}
		if ((isset($_GET['horizontal']) && $_GET['horizontal'] != "") &&
				!(isset($_GET['vertical']) && $_GET['vertical'] != "")) {
			$engine->arrFiltros['vertical'] = false;
			$engine->isEnable = true;
		}
		if ((isset($_GET['vertical']) && $_GET['vertical'] != "") &&
				!(isset($_GET['horizontal']) && $_GET['horizontal'] != "")) {
			$engine->arrFiltros['horizontal'] = false;
			$engine->isEnable = true;
		}
		if (isset($_GET['id_autor']) && $_GET['id_autor'] != "") {
			if(count($_GET['id_autor']) > 0) {
				if($_GET['id_autor'][0] != "") {
					$engine->arrFiltros['id_autor'] = $_GET['id_autor'];
					$engine->isEnable = true;
				}
			}
		}
		if (isset($_GET['tema']) && $_GET['tema'] != "") {
			$engine->arrFiltros['id_tema'] = $_GET['tema'];
			$engine->isEnable = true;
		}
	}
	
	
	if (isset($_GET['busca_action'])) {
		$query = $_GET['pc']." - ".$_GET['tombo'];
	}
// 	else if (isset($_GET['email_action'])) {
// 		$idEmail = $_GET['email_id'];
// 		$query = "Email $idEmail";
// // 		include("tool_listing_email.php");
		
// 		if($siteDebug)
// 			$engine->isdebug = true;
		
// 		$pesq = new elementoPesquisa();
// 		$pesq->arrPalavras[$idEmail] = $lingua;
// 		$pesq->arrCampos['email_id'] = true;
// 		$pesquisas[] = $pesq;
		
// 		$engine->isEnable = true;
// 		$engine->createQuery();
// 		$engine->filter();
// 		$engine->executeQuery();
// 		$engine->order($ordem);
		
// 		$retorno = $engine->getRetorno($startRow_retorno, $maxRows_retorno);
// 		$row_retorno = mysql_fetch_assoc($retorno);
// 		$super_string = $engine->getSuperString();
// 		$totalRows_retorno = $engine->getTotal();
			
// 		$posfilters_groups = $engine->posfilter_groups();
		
// 		$posfilters_data = $engine->posfilter_data();
		
// 	}
	else {
		if($siteDebug)
			$engine->isdebug = true;
		$engine->pesquisas = $pesquisas;
		$engine->createQuery();
		
		if($filtro == "foto") {
			$engine->arrFiltros['video']=false;
			$show_video = false;
		}
		if($filtro == "video") {
			$engine->arrFiltros['foto']=false;
			$show_foto = false;
		}
		if(isset($posfiltro) && is_array($posfiltro)) {
			foreach($posfiltro as $pfiltro) {
				$engine->arrPosFiltros[$pfiltro]=true;
			}
		}
		
		$engine->filter();
		$engine->executeQuery();
	//$ordem="relevancia";
		$engine->order($ordem);
	
		$retorno = $engine->getRetorno($startRow_retorno, $maxRows_retorno);
		$row_retorno = mysql_fetch_assoc($retorno);
		$super_string = $engine->getSuperString();
		$totalRows_retorno = $engine->getTotal();
			
		$posfilters_groups = $engine->posfilter_groups();
		
		$posfilters_data = $engine->posfilter_data();
	}

	if (!( (isset($_GET['totalRows_retorno'])) OR (isset($_GET['pageNum_retorno'])) )) {
		if(isset($_GET['pc_action'])) {
			$insertSQL = sprintf("INSERT INTO pesquisa_pc (palavra, tombo, retorno, datahora) VALUES (%s, %s, %s, now())",
					GetSQLValueString($_GET['query'], "text"),
					GetSQLValueString($_GET['query'], "text"),
					GetSQLValueString($totalRows_retorno, "int"));
	
			mysql_select_db($database_pulsar, $pulsar);
			$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
		} else if(isset($_GET['pa_action'])) {
			if(is_array($_GET['id_autor']))
				$autor = $_GET['id_autor'][0];
			else
				$autor = $_GET['id_autor'];
	
			$insertSQL = sprintf("INSERT INTO pesquisa_pa (fracao, palavra1, palavra2, palavra3, palavranao, cidade, estado, autor, orientacao, retorno, datahora) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s,now())",
					GetSQLValueString($_GET['fracao'], "text"),
					GetSQLValueString($_GET['palavra1'], "text"),
					GetSQLValueString($_GET['palavra2'], "text"),
					GetSQLValueString($_GET['palavra3'], "text"),
					GetSQLValueString($_GET['nao_palavra'], "text"),
					GetSQLValueString($_GET['local'], "text"),
					GetSQLValueString($_GET['estado'], "text"),
					GetSQLValueString($autor, "text"),
					GetSQLValueString($_GET['horizontal'].$_GET['vertical'], "text"),
					GetSQLValueString($totalRows_retorno, "int"));
			$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
		} else if(isset($_GET['tema'])){
			$insertSQL = sprintf("INSERT INTO pesquisa_tema (tema, retorno, datahora) VALUES (%s, %s, now())",
					GetSQLValueString($_GET['tema'], "int"),
					GetSQLValueString($totalRows_retorno, "int"));
			$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
				
		}
	}
	
	if ($query == "") {
		$query = LISTING_PA;
	}
	
	$MMColParam_retorno = "com_codigo";
	if (isset($_GET['palavra'])) {
		//  $MMColParam_retorno = str_replace("-"," ",(get_magic_quotes_gpc()) ? $_GET['palavra'] : addslashes($_GET['palavra']));
		$MMColParam_retorno = str_replace("-"," ",$_GET['palavra']);
		$MMColParam_retorno2 = str_replace(" ","-",$MMColParam_retorno);
		//  $MMColParam_retorno3 = (get_magic_quotes_gpc()) ? $_GET['palavra'] : addslashes($_GET['palavra']);
		$MMColParam_retorno3 = $_GET['palavra'];
		$n_contador = 0;
		$A_palavras = explode(" ",$MMColParam_retorno);
		$MMColParam_uniao = "";
	}
	
	include("tool_buildnavigation.php");
	
	$nav_bar = buildNavigation($pageNum_retorno, $maxRows_retorno, $totalRows_retorno);
	
	/*
	 unset($GLOBALS['ultima_pesquisa']);
	unset($_SESSION['ultima_pesquisa']);
	unset($GLOBALS['ultima_pesquisa_query']);
	unset($_SESSION['ultima_pesquisa_query']);
	$GLOBALS['ultima_pesquisa'] = $super_string;
	session_register("ultima_pesquisa");
	$GLOBALS['ultima_pesquisa_query'] = $query;
	session_register("ultima_pesquisa_query");
	*/
	$_SESSION['ultima_pesquisa'] = $super_string;
	$_SESSION['ultima_pesquisa_query'] = $query;
	$_SESSION['ultima_pesquisa_obj'] = serialize($pesquisas);
	$_SESSION['ultima_pesquisa_engine'] = serialize($engine);
	$_SESSION['ultima_pesquisa_max_row'] = $maxRows_retorno;
	$_SESSION['ultima_pesquisa_page_num'] = $pageNum_retorno;
	$_SESSION['ultima_pesquisa_total_row'] = $totalRows_retorno;
	$_SESSION['ultima_pesquisa_posfilters_groups'] = $posfilters_groups;
	$_SESSION['ultima_pesquisa_posfilters_data'] = $posfilters_data;
	
	
	$query = stripslashes($query);
	//echo $super_string."<br>";
	//echo $query."<br>";
}
$pesquisas = unserialize($_SESSION['ultima_pesquisa_obj']);
$engine = unserialize($_SESSION['ultima_pesquisa_engine']);
$posfilters_groups = $_SESSION['ultima_pesquisa_posfilters_groups'];
$posfilters_data = $_SESSION['ultima_pesquisa_posfilters_data'];
$maxRows_retorno = $_SESSION['ultima_pesquisa_max_row'];
if($pageNum_retorno == 0)
	$pageNum_retorno = $_SESSION['ultima_pesquisa_page_num'];
$totalRows_retorno = $_SESSION['ultima_pesquisa_total_row'];

// Carregar pastas

$colname_pastas = "1";
if (isset($_SESSION['MM_Username'])) {
	$colname_pastas = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_pastas = sprintf("SELECT pastas.id_pasta,   pastas.nome_pasta 	FROM cadastro  INNER JOIN pastas ON (cadastro.id_cadastro=pastas.id_cadastro) WHERE (cadastro.login LIKE '%s') GROUP BY pastas.id_pasta ORDER BY pastas.nome_pasta", $colname_pastas);
$pastas = mysql_query($query_pastas, $pulsar) or die(mysql_error());
$row_pastas = mysql_fetch_assoc($pastas);
$totalRows_pastas = mysql_num_rows($pastas);


if(isset($_GET['show_tombo'])) {
	header("Location: details.php?tombo=".$_GET['show_tombo']."&ordem_foto=".$_GET['ordem_foto']."&total_foto=".$totalRows_retorno);
	$_SESSION['last_search'] = "listing.php?email_action=&email_id=".$_GET['email_id'];
}
?>