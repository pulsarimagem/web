<?php
$novaQuery = true;

$currentPage = $_SERVER["PHP_SELF"];

$MMColParam_retorno = "0";
if (isset($_GET['email_id'])) {
  $MMColParam_retorno = (get_magic_quotes_gpc()) ? $_GET['email_id'] : addslashes($_GET['email_id']);
}
mysql_select_db($database_pulsar, $pulsar);

$email_query = sprintf("SELECT tombo
FROM
 email_fotos
WHERE
 id_email = %s
ORDER BY
 tombo", $MMColParam_retorno);

$email_tombo = mysql_query($email_query, $pulsar) or die(mysql_error());
$row_email_tombo = mysql_fetch_assoc($email_tombo);
$totalRows_email_tombo = mysql_num_rows($email_tombo);

$tombos = "'".$row_email_tombo['tombo']."'";

while($row_email_tombo = mysql_fetch_assoc($email_tombo)) {
	$tombos .= ",'".$row_email_tombo['tombo']."'";
} 

$query_retorno = sprintf("
DROP TEMPORARY TABLE IF EXISTS tmp12; CREATE TEMPORARY TABLE tmp12 ENGINE = MEMORY 

SELECT DISTINCT 

Fotos.Id_Foto,   Fotos.tombo, Fotos.assunto_principal, Fotos.orientacao, Fotos.data_foto

FROM 

Fotos  

INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto)  

INNER JOIN temas ON (rel_fotos_temas.id_tema=temas.Id) 

WHERE Fotos.tombo in (%s) ORDER BY Fotos.Id_Foto DESC", $tombos);



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
		SELECT tmp12.Id_Foto, tmp12.assunto_principal, tmp12.orientacao, tmp12.tombo, tmp12.data_foto, Fotos_extra.extra 
		FROM tmp12 
		LEFT JOIN Fotos_extra ON tmp12.tombo = Fotos_extra.tombo 
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

?>