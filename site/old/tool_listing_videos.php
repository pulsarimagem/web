<?php
$novaQuery = true;

$currentPage = $_SERVER["PHP_SELF"];

$MMColParam_retorno = "0";
if (isset($_GET['email_id'])) {
  $MMColParam_retorno = (get_magic_quotes_gpc()) ? $_GET['email_id'] : addslashes($_GET['email_id']);
}
mysql_select_db($database_pulsar, $pulsar);

$query_autor = "";
if(isset($id_autor)) {
	$query_autor = " AND Fotos_tmp.id_autor = $id_autor ";
}

$query_retorno = sprintf("
DROP TEMPORARY TABLE IF EXISTS tmp13; CREATE TEMPORARY TABLE tmp13 ENGINE = MEMORY 

SELECT DISTINCT 

Fotos_tmp.Id_Foto,   Fotos_tmp.tombo, Fotos_tmp.assunto_principal, Fotos_tmp.orientacao, Fotos_tmp.data_foto, Fotos_tmp.status, videos_extra.resolucao 

FROM 

Fotos_tmp  

LEFT JOIN rel_fotos_temas_tmp ON (Fotos_tmp.Id_Foto=rel_fotos_temas_tmp.id_foto)  
LEFT JOIN temas ON (rel_fotos_temas_tmp.id_tema=temas.Id) 
LEFT JOIN videos_extra ON (videos_extra.tombo = Fotos_tmp.tombo) 
		
WHERE Fotos_tmp.tombo RLIKE '^[a-zA-Z]' $query_autor AND (Fotos_tmp.status>=-1 AND Fotos_tmp.status<=1)

ORDER BY Fotos_tmp.Id_Foto DESC");



if($siteDebug) {
	echo $query_retorno."<br>";
}

if($siteDebug) {
	$timeStart = microtime(true);
	$timeBefore = microtime(true);
//	echo "Time Before: ".$timeBefore."<br>";
}


$A_comandos = explode(";",$query_retorno);

do {
	$retorno = mysql_query($A_comandos[key($A_comandos)], $pulsar) or die(mysql_error());
} while (next($A_comandos));


if($siteDebug) {
	$timeAfter = microtime(true);
//	echo "Time After: ".$timeAfter."<br>";
	$diff = $timeAfter - $timeBefore;
	echo "<strong>delay1: </strong>".$diff."</strong><br>";
	$timeBefore = microtime(true);
//	echo "Time Before: ".$timeBefore."<br>";
}


	$query_ordem = "ORDER BY Id_Foto DESC
	";

if(isset($_GET['ordem'])) {
	  if($_GET['ordem'] == "recente") {
	  	$query_ordem = "ORDER BY Id_Foto DESC
	";
	  }
	  if($_GET['ordem'] == "data") {
	  	$query_ordem = "ORDER BY data_foto DESC
	";
	  }
	  if($_GET['ordem'] == "vistas") {
	    $query_tmp_vistas =	
" 
CREATE TEMPORARY TABLE 
	tmp2 
ENGINE = MEMORY 
SELECT
	tombo, count(tombo) as contador 
FROM 
	log_pop 
WHERE 
	datahora > now() - INTERVAL 12 MONTH and  	
	log_pop.tombo IN (select tombo from tmp)  
GROUP BY 
	tombo 
HAVING 
	(count(tombo) > 1) 
ORDER BY
	count(tombo) desc limit 20;
"	  	;
	  	
	  	$query_ordem = "ORDER BY tmp2.contador DESC
	";
	  }
	  if($_GET['ordem'] == "maior") {
	  	$query_ordem = "ORDER BY Id_Foto DESC
	";
	  }
}
	
	$query_retorno2 = sprintf("
		SELECT tmp13.Id_Foto, tmp13.assunto_principal, tmp13.orientacao, tmp13.tombo, tmp13.data_foto, tmp13.status, tmp13.resolucao, Fotos_tmp.extra 
		FROM tmp13  
		LEFT JOIN Fotos_tmp ON tmp13.Id_foto = Fotos_tmp.Id_foto 
		GROUP BY Id_Foto %s",$query_ordem);
	

	$query_limit_retorno = sprintf("%s LIMIT %d, %d", $query_retorno2, $startRow_retorno, $maxRows_retorno);
	
	
if($siteDebug) {
	echo $query_retorno2."<br>";
	echo $query_limit_retorno."<br>";
}
	
	$retorno2 = mysql_query($query_retorno2, $pulsar) or die(mysql_error());
	$row_retorno2 = mysql_fetch_assoc($retorno2);
	$totalRows_retorno2 = mysql_num_rows($retorno2);
	
	
	
	$retorno= mysql_query($query_limit_retorno, $pulsar) or die(mysql_error());
	$row_retorno = mysql_fetch_assoc($retorno);
	$totalRows_retorno = mysql_num_rows($retorno);

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
  $all_retorno = mysql_query($query_retorno2);
  $totalRows_retorno = mysql_num_rows($all_retorno);
}
$totalPages_retorno = ceil($totalRows_retorno/$maxRows_retorno)-1;


$res_lupa = "320x180";
if($row_retorno['resolucao']=="720x480")
	$res_lupa = "270x180";
else if($row_retorno['resolucao']=="720x586")
	$res_lupa = "220x180";
	
?>