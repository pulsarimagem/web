<?php
$novaQuery = true;

$currentPage = $_SERVER["PHP_SELF"];

$MMColParam_retorno = "0";
if (isset($_GET['tema'])) {
  $MMColParam_retorno = (get_magic_quotes_gpc()) ? $_GET['tema'] : addslashes($_GET['tema']);
}
mysql_select_db($database_pulsar, $pulsar);

// Alteracao da query dos temas. Se novaQuery estiver true, pesquisa temas depois monta a query principal.
if($novaQuery) {
	
	$novaQuery_temas = sprintf("SELECT  id_tema  FROM    lista_temas WHERE id_pai = %s", $MMColParam_retorno);
	
	$novaTemas_retorno = mysql_query($novaQuery_temas, $pulsar) or die(mysql_error());
	$novaRow_retorno = mysql_fetch_assoc($novaTemas_retorno);
	
	$novaTemas_query = "temas.Id =".$novaRow_retorno['id_tema'];
	
	while ($novaRow_retorno = mysql_fetch_assoc($novaTemas_retorno)) {
		$novaTemas_query .= " or temas.Id =".$novaRow_retorno['id_tema'];
	}  
//	echo $novaTemas_query."<br>";	
}


// include_once($_GET['tipo'].".php");
include_once("inc_temas.php");

// PESQUISA MAPA DO BRASIL

if (isset($_GET['tema2']) && $_GET['tema2'] != 0) {
  $MMColParam_retorno2 = (get_magic_quotes_gpc()) ? $_GET['tema2'] : addslashes($_GET['tema2']);
	if($novaQuery) {
		
		$novaQuery_temas = sprintf("SELECT  id_tema  FROM    lista_temas WHERE id_pai = %s", $MMColParam_retorno2);
		
		$novaTemas_retorno = mysql_query($novaQuery_temas, $pulsar) or die(mysql_error());
		$novaRow_retorno = mysql_fetch_assoc($novaTemas_retorno);
		
		$novaTemas_query2 = "temas.Id =".$novaRow_retorno['id_tema'];
		
		while ($novaRow_retorno = mysql_fetch_assoc($novaTemas_retorno)) {
			$novaTemas_query2 .= " or temas.Id =".$novaRow_retorno['id_tema'];
		}
		$novaQuery_retorno = "
SELECT 
Fotos2.Id_Foto,   Fotos2.tombo, Fotos2.assunto_principal, Fotos2.cidade, Fotos2.id_estado, Fotos2.id_pais, Fotos2.orientacao, Fotos2.data_foto, Fotos2.dim_a, Fotos2.dim_b, Fotos_extra.extra
FROM (".$novaQuery_retorno.") as Fotos2
LEFT JOIN Fotos_extra ON Fotos2.tombo = Fotos_extra.tombo
INNER JOIN rel_fotos_temas ON (Fotos2.Id_Foto=rel_fotos_temas.id_foto)  
INNER JOIN temas ON (rel_fotos_temas.id_tema=temas.Id) 
WHERE ( $novaTemas_query2  ) ORDER BY Fotos2.Id_Foto DESC
		";
		$novaQuery_retorno2 = $novaQuery_retorno;
	}
}

if (isset($_GET['estado']) && $_GET['estado'] != 0) {
  $MMColParam_retorno2 = (get_magic_quotes_gpc()) ? $_GET['estado'] : addslashes($_GET['estado']);
	if($novaQuery) {
		
		$novaQuery_retorno = "
SELECT 
Fotos2.Id_Foto,   Fotos2.tombo, Fotos2.assunto_principal, Fotos2.cidade, Fotos2.id_estado, Fotos2.id_pais, Fotos2.orientacao, Fotos2.data_foto, Fotos2.dim_a, Fotos2.dim_b
FROM (".$novaQuery_retorno.") as Fotos2
LEFT JOIN Fotos_extra ON Fotos2.tombo = Fotos_extra.tombo 
LEFT JOIN Estados ON Fotos2.id_estado = Estados.id_estado
LEFT JOIN paises ON Fotos2.id_pais = paises.id_pais 
WHERE Fotos2.id_estado = $MMColParam_retorno2 ORDER BY Fotos2.Id_Foto DESC
		";
		$novaQuery_retorno2 = $novaQuery_retorno;
	}
}

if($novaQuery) {
	$query_retorno_clean = "DROP TEMPORARY TABLE IF EXISTS tmp;";
	mysql_query($query_retorno_clean, $pulsar) or die(mysql_error());
	$query_retorno_prefix = "CREATE TEMPORARY TABLE tmp ENGINE = MEMORY ";
	$novaQuery_tmp = $query_retorno_prefix.$novaQuery_retorno;

	if($siteDebug) {
		echo "1- ".$novaQuery_tmp."<br><br>";
	}
	
	
	mysql_query($novaQuery_tmp, $pulsar) or die(mysql_error());
/*
	$novaQuery_retorno = "SELECT tmp.Id_Foto,   tmp.tombo, tmp.assunto_principal, tmp.cidade, tmp.Sigla, tmp.nome, tmp.orientacao, tmp.data_foto, tmp.dim_a, tmp.dim_b, Fotos_extra.extra
							FROM tmp
							LEFT JOIN Fotos_extra ON tmp.tombo = Fotos_extra.tombo";
	$novaQuery_retorno2 = $novaQuery_retorno;
	//, Fotos_extra.extra
*/	
}

/*
if($novaQuery) {
	$query_retorno = $novaQuery_retorno;
	$query_retorno2 = $novaQuery_retorno2;
}


$query_limit_retorno = sprintf("%s LIMIT %d, %d", $query_retorno, $startRow_retorno, $maxRows_retorno);
*/

include("tool_filter.php");

include("tool_order.php");

if($siteDebug) {
	echo "2- ".$query_limit_retorno."<br><br>";
	echo "3- ".$query_retorno2."<br>";
}

if($siteDebug) {
	$timeStart = microtime(true);
	$timeBefore = microtime(true);
//	echo "Time Before: ".$timeBefore."<br>";
}

$retorno = mysql_query($query_limit_retorno, $pulsar) or die(mysql_error());
$row_retorno = mysql_fetch_assoc($retorno);

//$retorno_clean = mysql_query("DROP TEMPORARY TABLE IF EXISTS tombitos", $pulsar) or die(mysql_error());

if($siteDebug) {
	$timeAfter = microtime(true);
//	echo "Time After: ".$timeAfter."<br>";
	$diff = $timeAfter - $timeBefore;
	echo "<strong>delay1: </strong>".$diff."</strong><br>";
	$timeBefore = microtime(true);
//	echo "Time Before: ".$timeBefore."<br>";
}

$retorno2 = mysql_query($query_retorno2, $pulsar) or die(mysql_error());
$row_retorno2 = mysql_fetch_assoc($retorno2);

if($siteDebug) {
	$timeAfter = microtime(true);
//	echo "Time After: ".$timeAfter."<br>";
	$diff = $timeAfter - $timeBefore;
	echo "<strong>delay2: </strong>".$diff."</strong><br>";
}

do {
$arry[] = $row_retorno2['tombo'];
} while ($row_retorno2 = mysql_fetch_assoc($retorno2));  
$super_string = implode("|",$arry);  

if (isset($_GET['totalRows_retorno'])) {
  $totalRows_retorno = $_GET['totalRows_retorno'];
} else {
  $all_retorno = mysql_query($query_retorno);
  $totalRows_retorno = mysql_num_rows($all_retorno);
}
$totalPages_retorno = ceil($totalRows_retorno/$maxRows_retorno)-1;

// insere a pesquisa no logger

if($siteDebug) {
  $timeBefore = microtime(true);
//	echo "Time Before: ".$timeBefore."<br>";
}

if (!( (isset($_GET['totalRows_retorno'])) OR (isset($_GET['pageNum_retorno'])) )) {
  $insertSQL = sprintf("INSERT INTO pesquisa_tema (tema, retorno, datahora) VALUES (%s, %s, now())",
                       GetSQLValueString($_GET['tema'], "int"),
                       GetSQLValueString($totalRows_retorno, "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
}

if($siteDebug) {
  $timeAfter = microtime(true);
//  echo "Time After: ".$timeAfter."<br>";
  $diff = $timeAfter - $timeBefore;
  echo "<strong>delay Logger: </strong>".$diff."</strong><br>";
}

?>
<?php
$colname_qual_tema = "1";
if (isset($_GET['tema'])) {
  $colname_qual_tema = (get_magic_quotes_gpc()) ? $_GET['tema'] : addslashes($_GET['tema']);
}

if($siteDebug) {
  $timeBefore = microtime(true);
//  echo "Time Before: ".$timeBefore."<br>";
}

mysql_select_db($database_pulsar, $pulsar);
$query_qual_tema = sprintf("SELECT * FROM ( SELECT   temas.Id, temas.Tema FROM temas WHERE (temas.Pai = 0) UNION SELECT   temas1.Id, CONCAT(temas.Tema,' - ',   temas1.Tema) AS Tema FROM  temas temas1 INNER JOIN temas ON (temas1.Pai=temas.Id) WHERE   (temas.Pai = 0) UNION SELECT temas2.Id, CONCAT(temas.Tema, ' - ', temas1.Tema, ' - ', temas2.Tema)   AS Tema FROM  temas temas1 INNER JOIN temas ON (temas1.Pai=temas.Id) INNER JOIN temas temas2 ON (temas2.Pai=temas1.Id) WHERE   (temas.Pai = 0) UNION SELECT   temas3.Id, CONCAT(temas.Tema, ' - ', temas1.Tema, ' - ', temas2.Tema,   ' - ', temas3.Tema) AS Tema FROM  temas temas1 INNER JOIN temas ON (temas1.Pai=temas.Id) INNER JOIN temas temas2 ON (temas2.Pai=temas1.Id) INNER JOIN temas temas3 ON (temas2.Id=temas3.Pai) WHERE   (temas.Pai = 0) ) as sb WHERE id = %s", $colname_qual_tema);
$qual_tema = mysql_query($query_qual_tema, $pulsar) or die(mysql_error());
$row_qual_tema = mysql_fetch_assoc($qual_tema);
$totalRows_qual_tema = mysql_num_rows($qual_tema);

if($siteDebug) {
  $timeAfter = microtime(true);
//  echo "Time After: ".$timeAfter."<br>";
  $diff = $timeAfter - $timeBefore;
  echo "<strong>delay select foto from union: </strong>".$diff."</strong><br>";
}

$queryString_retorno = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_retorno") == false && 
        stristr($param, "totalRows_retorno") == false &&
		stristr($param, "linhas") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_retorno = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_retorno = sprintf("&totalRows_retorno=%d%s", $totalRows_retorno, $queryString_retorno);
?>