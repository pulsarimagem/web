<?php require_once('Connections/pulsar.php'); ?>
<?php 


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

$_SESSION['last_search'] = $_SERVER['REQUEST_URI'];
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
if (isset($_GET['pageNum_retorno'])) {
  $pageNum_retorno = $_GET['pageNum_retorno'];
}

$startRow_retorno = $pageNum_retorno * $maxRows_retorno;
if (isset($_GET['startRow_retorno'])) {
  $startRow_retorno = $_GET['startRow_retorno'];
  $pageNum_retorno = intval($startRow_retorno / $maxRows_retorno);
  $startRow_retorno = $pageNum_retorno * $maxRows_retorno;
}

$ordem = "recente";
if (isset($_GET['ordem'])) {
	$ordem = $_GET['ordem'];
}
else {
	$_GET['ordem'] = "recente";
}
$filtro = "foto";
if (isset($_GET['filtro'])) {
	$filtro = $_GET['filtro'];
}

$pesquisas = array();
include("inc_pesquisa_obj.php");
$engine = new pesquisaPulsar();
$engine->dbConn = $pulsar;
$engine->db = $database_pulsar;

if (isset($_GET['tombo'])&& ($_GET['tombo']!= "")) {
	$_GET['type']="tombo";
	$_GET['tipo']="inc_pc.php";
	$_GET['query']=trim($_GET['tombo']);
	$query = $_GET['query'];
	
	$pesq = new elementoPesquisa();
	$pesq->arrPalavras[] = $_GET['tombo'];
	$pesq->arrCampos['tombo'] = true;
	$pesquisas[] = $pesq;
}
else if (isset($_GET['type'])&& ($_GET['type']== "tombo")) {
	$query = $_GET['query'];
	
	$pesq = new elementoPesquisa();
	$pesq->arrPalavras[] = $_GET['query'];
	$pesq->arrCampos['tombo'] = true;
	$pesquisas[] = $pesq;
}
else if (isset($_GET['tema_action'])) {
	if (isset($_GET['estado']) && $_GET['estado']!="") {
		$pesq = new elementoPesquisa();
		$pesq->arrPalavras[] = $_GET['estado'];
		$pesq->arrCampos['id_estado'] = true;
		$pesquisas[] = $pesq;
	}
	if (isset($_GET['tema']) && $_GET['tema'] != "") {
		$engine->arrFiltros['id_tema'] = $_GET['tema'];
	}
}
else if ((isset($_GET['pc_action']))||(isset($_GET['pa_action']))) {
	if(isset($_GET['pc_arr'])) {
		$query = implode(" ",$_GET['pc_arr']);
		$_GET['query'] = $query;  
	}
	$query = $_GET['query'];

	$query_arr = explode(" ", str_ireplace("-", " ", $query));
	foreach($query_arr as $palavra) {
		if(strlen($palavra)>2) {
			$pesq = new elementoPesquisa();
			$pesq->arrPalavras[] = $palavra;
			$pesq->setAll();
			$pesquisas[] = $pesq;
		}
	}
	
	if(isset($_GET['fracao']) && $_GET['fracao']!="") {
		$pesq = new elementoPesquisa();
		$pesq->arrPalavras[] = $_GET['fracao'];
		$pesq->arrCampos['pc'] = true;
		$pesq->arrCampos['assunto'] = true;
		$pesq->arrCampos['extra'] = true;
		$pesq->arrCampos['temas'] = true;
		$pesq->fracao = true;
		$pesquisas[] = $pesq;
	}
	if(isset($_GET['palavra1']) && $_GET['palavra1']!="") {
		$pesq = new elementoPesquisa();
		$pesq->arrPalavras[] = $_GET['palavra1'];
		$pesq->arrCampos['pc'] = true;
		$pesq->arrCampos['assunto'] = true;
		$pesq->arrCampos['extra'] = true;
		$pesq->arrCampos['temas'] = true;
		$pesquisas[] = $pesq;
	}
	if(isset($_GET['palavra2']) && $_GET['palavra2']!="") {
		$pesq = new elementoPesquisa();
		$pesq->arrPalavras[] = $_GET['palavra2'];
		$pesq->arrCampos['pc'] = true;
		$pesq->arrCampos['assunto'] = true;
		$pesq->arrCampos['extra'] = true;
		$pesq->arrCampos['temas'] = true;
		$pesquisas[] = $pesq;
	}
	if(isset($_GET['palavra3']) && $_GET['palavra3']!="") {
		$pesq = new elementoPesquisa();
		$pesq->arrPalavras[] = $_GET['palavra3'];
		$pesq->arrCampos['pc'] = true;
		$pesq->arrCampos['assunto'] = true;
		$pesq->arrCampos['extra'] = true;
		$pesq->arrCampos['temas'] = true;
		$pesquisas[] = $pesq;
	}
	if (isset($_GET['local']) && $_GET['local']!="") {
		$pesq = new elementoPesquisa();
		$pesq->arrPalavras[] = $_GET['local'];
		$pesq->arrCampos['cidade'] = true;
		$pesquisas[] = $pesq;
	}
	if (isset($_GET['estado']) && $_GET['estado']!="") {
		$pesq = new elementoPesquisa();
		$pesq->arrPalavras = $_GET['estado'];
		$pesq->arrCampos['estado'] = true;
		$pesquisas[] = $pesq;
	}
	if (isset($_GET['pais']) && $_GET['pais']!="") {
		$pesq = new elementoPesquisa();
		$pesq->arrPalavras[] = $_GET['pais'];
		$pesq->arrCampos['pais'] = true;
		$pesquisas[] = $pesq;
	}
	if(isset($_GET['nao_palavra']) && $_GET['nao_palavra']!="") {
		$pesq = new elementoPesquisa();
		$pesq->arrPalavras[] = $_GET['nao_palavra'];
		$pesq->arrCampos['pc'] = true;
		$pesq->not = true;
		$pesquisas[] = $pesq;
		$pesq = new elementoPesquisa();
		$pesq->arrPalavras[] = $_GET['nao_palavra'];
		$pesq->arrCampos['assunto'] = true;
		$pesq->not = true;
		$pesquisas[] = $pesq;
		$pesq = new elementoPesquisa();
	}
	if (isset($_GET['data_tipo']) && $_GET['data_tipo'] != "") {
		$engine->arrFiltros['data'] = $_GET['data_tipo'];
		if (isset($_GET['ano']) && $_GET['ano'] != "") {
			$engine->arrFiltros['ano'] = $_GET['ano'];
		}
		if (isset($_GET['mes']) && $_GET['mes'] != "") {
			$engine->arrFiltros['mes'] = $_GET['mes'];
		}
		if (isset($_GET['dia']) && $_GET['dia'] != "") {
			$engine->arrFiltros['dia'] = $_GET['dia'];
		}
	}
	if ((isset($_GET['horizontal']) && $_GET['horizontal'] != "") &&
			!(isset($_GET['vertical']) && $_GET['vertical'] != "")) {
		$engine->arrFiltros['vertical'] = false;
	}
	if ((isset($_GET['vertical']) && $_GET['vertical'] != "") &&
			!(isset($_GET['horizontal']) && $_GET['horizontal'] != "")) {
		$engine->arrFiltros['horizontal'] = false;
	}
	if (isset($_GET['id_autor']) && $_GET['id_autor'] != "") {
		if(count($_GET['id_autor']) > 0) {
			if($_GET['id_autor'][0] != "")
				$engine->arrFiltros['id_autor'] = $_GET['id_autor'];
		}
	}
	if (isset($_GET['tema']) && $_GET['tema'] != "") {
		$engine->arrFiltros['id_tema'] = $_GET['tema'];
	}
}
if (isset($_GET['busca_action'])) {
	$query = $_GET['pc']." - ".$_GET['tombo'];
}
else if (isset($_GET['email_action'])) {
	$query = "Email ".$_GET['email_id'];
	include("tool_listing_email.php");
}
else {
	if($siteDebug)
		$engine->isdebug = true;
	$engine->pesquisas = $pesquisas;
	$engine->createQuery();
	
	if($filtro == "foto")
		$engine->arrFiltros['video']=false;
	if($filtro == "video")
		$engine->arrFiltros['foto']=false;
	
	$engine->filter();
	$totalRows_retorno = $engine->executeQuery();
	$engine->order($ordem);
	
	$retorno = $engine->getRetorno($startRow_retorno, $maxRows_retorno);
	$row_retorno = mysql_fetch_assoc($retorno);
	$super_string = $engine->getSuperString();
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
	}
}

if ($query == "") {
	$query = "Pesquisa Avançada";
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

$query = stripslashes($query);
//echo $super_string."<br>";
//echo $query."<br>";

if(isset($_GET['show_tombo'])) {
	header("Location: details.php?tombo=".$_GET['show_tombo']."&ordem_foto=".$_GET['ordem_foto']."&total_foto=".$totalRows_retorno);
	$_SESSION['last_search'] = "listing.php?email_action=&email_id=".$_GET['email_id'];
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Imagens</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
</head>
<body>
<?php include("tool_tooltip.php")?>

<?php include("part_topbar.php");?>

<?php 
if (isset($_SESSION['ajustar'])) echo "<div class=\"main size-wide\">";
else echo "<div class=\"main size960\">";
?>

<?php //include("part_grid_left.php");?>
			
<?php 
if ($totalRows_retorno == 0) {
?>
	<div class="grid-right">
		<div class="cadastro">
			<h2>0 Resultados para "<?php echo $query?>"</h2>
			<p class="p">
                Infelizmente, <strong>não encontramos</strong> resultados para sua busca.<br/>
                Talvez alterando os termos ou verificando a ortografia correta você consiga encontrar o que está procurando.
            </p>
<?php 
if(isset($_GET['query'])) {
//	include("tool_similar_word.php");
}
?>            
			<a href="buscaavancada.php" class="back">« Tente uma busca avançada</a>
		</div>
	</div>
<?php }
else {
?>
	<div class="grid-right">
		<div class="resultado">
<?php if (isset($_SESSION['ajustar'])) echo "<div class=\"espaco1\"></div>";?>
			<form name="listing_opts" action="listing.php" method="get">		
				<div class="title">
					<h2>Resultados para "<?php echo $query?>"</h2>
					<div class="p">
<?php include("part_listing_options.php")?>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
			
				<div class="ordenar">
					<p>Ordenar por:</p>
	                <select name="ordem" onChange="listing_opts.submit();">
	                  <option value="recente" <?php if($ordem == "recente") echo "selected"; ?>>Últimas adicionadas</option>
	                  <option value="data" <?php if($ordem == "data") echo "selected"; ?>>Data da foto</option>
 	                  <option value="vistas" <?php if($ordem == "vistas") echo "selected"; ?>>Mais visualizadas</option>
	                  <option value="maior" <?php if($ordem == "maior") echo "selected"; ?>>Tamanho do arquivo</option>  
	                </select>
				</div>
<!--         		<div class="ordenar">
					<p>Filtrar por:</p>
	                <select name="filtro" onChange="listing_opts.submit();">
 	                  <option value="foto" <?php if($filtro == "foto") echo 'selected="selected"'; ?>> Fotos</option>
	                  <option value="video" <?php if($filtro == "video") echo 'selected="selected"'; ?>>Vídeos</option>  
	                </select>
				</div> -->
			</form>

			<div class="nnav">
				<?php echo $startRow_retorno?> de <?php echo $totalRows_retorno ?> imagem(ns) 
			</div>
			<div class="clear"></div>
			
			<div class="nav">
<?php 
echo $nav_bar[0];
echo $nav_bar[1];
echo $nav_bar[2];
?>
				<div class="clear"></div>
			</div>
<?php if (isset($_SESSION['ajustar'])) echo "<div class=\"espaco2\"></div>";?>
		
			<ul id="lista-script">
<?php 
$tot_fotos = 1;
$count_fotos = $startRow_retorno;
do { 
	$isVideo = isVideo($row_retorno['tombo']);
	?>
				<li>
					<a href="details.php?tombo=<?php echo $row_retorno['tombo']."&search=PA&ordem_foto=$count_fotos&total_foto=$totalRows_retorno"; ?>">
						<img <?php if($isVideo) { ?>src="<?php echo $cloud_server?>Videos/thumbs/<?php echo $row_retorno['tombo']; ?>_3s.jpg"<?php } else { ?>src="<?php echo "http://www.pulsarimagens.com.br/" //$homeurl; ?>bancoImagens/<?php echo $row_retorno['tombo']; ?>p.jpg" <?php } ?> title="" onMouseover="ddrivetip('<?php echo addslashes(delQuote($row_retorno['assunto_principal'])); ?><?php if ($row_retorno['extra'] != NULL) echo ' - '.delQuote($row_retorno["extra"]);?><?php echo ' - '.addslashes($row_retorno['cidade']); ?><?php echo ' - '.addslashes($row_retorno['Sigla']!=""?$row_retorno['Sigla']:$row_retorno['nome']); ?><?php 
if (strlen($row_retorno['data_foto']) == 4) {
	echo ' - '.$row_retorno['data_foto'];
} elseif (strlen($row_retorno['data_foto']) == 6) {
	echo ' - '.substr($row_retorno['data_foto'],4,2).'/'.substr($row_retorno['data_foto'],0,4);
} elseif (strlen($row_retorno['data_foto']) == 8) {
	echo ' - '.substr($row_retorno['data_foto'],6,2).'/'.substr($row_retorno['data_foto'],4,2).'/'.substr($row_retorno['data_foto'],0,4);
}
						?>')" onMouseout="hideddrivetip()"/>
						<span><strong><?php //echo $row_retorno['Nome_Fotografo']; ?></strong></span>
					</a>
					<div class="opt">
						<div class="bt-mesadeluz">
							<a href="#" class="icon"></a>
							<div class="box" style="display: none;" id="page_container<?php echo $row_retorno['tombo']?>">
								<p>Adicionar a Minhas Imagens:</p>
								<div class="page_navigation"></div>
								<ul class="content">
<?php 
if($logged) {
	if ($totalRows_pastas > 0)  { 
		do {
?>
									<span><a class="add_mesa" href="tool_addmesadeluz.php?id_pasta=<?php echo $row_pastas['id_pasta']; ?>&tombo=<?php echo $row_retorno['tombo']; ?>" onclick="return false" style="<?php if(check_exist($row_pastas['id_pasta'], $row_retorno['tombo'], $database_pulsar, $pulsar)) echo "color:#bc690f;";?>"><?php echo $row_pastas['nome_pasta']; ?></a></span>
<?php 
		} while ($row_pastas = mysql_fetch_assoc($pastas));
		mysql_data_seek($pastas, 0);
		$row_pastas = mysql_fetch_assoc($pastas);
	}
?>
								</ul>
								<a href="" class="add_pasta" onclick="return false" ><strong>+</strong> Criar nova pasta</a>
								<form name="form1" method="get" action="tool_addmesadeluz.php">
									<div class="form" style="display: none;">
										<input name="nova_pasta" type="text" class="text" />
										<input name="action" type="submit" class="button add_mesa" value="Ok" />
										<input name="tombo" type="hidden" value="<?php echo $row_retorno['tombo']; ?>" />
										<div class="clear"></div>
									</div>
								</form>
<?php } else { ?>
Para adicionar essa foto a Minhas Imagens você deve estar logado.
<?php } ?>
							</div>
						</div>
						<span><?php echo $row_retorno['tombo']; ?></span>
<?php if ($show_preview) { ?>						
						<div class="bt-zoom">
                        	<a href="#"></a>
	                        <div class="mzoom" style="display: none;">
	                        <?php if($isVideo){ ?><div id="mp<?php echo $row_retorno['tombo']; ?>">JW Player goes here</div>
	<script type="text/javascript">
		jwplayer("mp<?php echo $row_retorno['tombo']; ?>").setup({
			flashplayer: "video/player.swf",
			file: "<?php echo $cloud_server?>/Videos/previews/<?php echo $row_retorno['tombo']?>_320x180.flv",
			width: 320,
			height: 180,
			controlbar : "none",
			autostart: true
		});
		//			image: "<?php echo $cloud_server?>/Videos/thumbs/<?php echo $row_retorno['tombo']?>_3s.jpg",
	</script>
	                        <?php }else {?>
	                        <img class="on-demand" src="images/cm_fill.gif" longdesc="<?php echo "http://www.pulsarimagens.com.br/"//$homeurl; ?>bancoImagens/<?php echo $row_retorno['tombo']; ?>.jpg" style="max-width:300px; max-height:300px;" /></div>
	                        <?php }?>
                        </div>
<?php } ?>						
						<div class="clear"></div>
					</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#page_container<?php echo $row_retorno['tombo']?>').pajinate({
		nav_label_first : '<<',
		nav_label_last : '>>',
		nav_label_prev : '<',
		nav_label_next : '>',
        items_per_page : 10,
        start_page : 0,
        num_page_links_to_display : 4,
        show_first_last: false,
		abort_on_small_lists: true
	});
});
</script>					
				</li>
<?php
	$tot_fotos++;
	$count_fotos++;
?>
<?php } while ($row_retorno = mysql_fetch_assoc($retorno)); ?>
				<div class="clear"></div>
			</ul>
			
			<div class="nav">
<?php 
echo $nav_bar[0];
echo $nav_bar[1];
echo $nav_bar[2];
?>
				<div class="clear"></div>
			</div>
			
		</div>
	</div>
<?php }?>
	<div class="clear"></div>
</div>

<?php include("part_footer.php");?>

<?php include("google_details.php");?>

</body>
</html>
<?php
if($siteDebug) {
	$timeEnd = microtime(true);
	$diff = $timeEnd - $timeStart;
	echo "<strong>delay Total: </strong>".$diff."</strong><br>";
}
