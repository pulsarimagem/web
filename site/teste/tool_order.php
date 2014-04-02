<?php
$query_ordem = "ORDER BY Id_Foto DESC";

if(isset($_GET['ordem'])) {
	if($_GET['ordem'] == "recente") {
		$query_ordem = "ORDER BY Id_Foto DESC";
	}
	if($_GET['ordem'] == "data") {
		$query_ordem = "ORDER BY data_foto DESC";
	}
	if($_GET['ordem'] == "vistas") {
		$query_ordem = "ORDER BY log_count_view.contador DESC";
	}
	if($_GET['ordem'] == "maior") {
		$query_ordem = "ORDER BY dim_a * dim_b DESC";
	}
}

if (isset($_GET['totalRows_retorno'])) {
	$totalRows_retorno = $_GET['totalRows_retorno'];
} else {
	  $query_retorno = "
	  SELECT DISTINCT
	  tmp.Id_Foto,
	  tmp.assunto_principal,
	  tmp.cidade,
	  Estados.Sigla,
	  paises.nome,
	  tmp.orientacao,
	  tmp.tombo,
	  tmp.data_foto,
	  tmp.dim_a,
	  tmp.dim_b,
	  Fotos_extra.extra
	  FROM tmp 
	  LEFT JOIN Fotos_extra ON tmp.tombo = Fotos_extra.tombo
	  LEFT JOIN Estados ON tmp.id_estado = Estados.id_estado
	  LEFT JOIN paises ON tmp.id_pais = paises.id_pais
	  LEFT JOIN log_count_view ON tmp.Id_Foto = log_count_view.Id_Foto
	  GROUP BY tmp.Id_Foto
	  ".$query_ordem;
	  
	  if($siteDebug) {
	  	$timeBefore = microtime(true);
	  }
	  $query_tempr = $query_retorno;
	  $query_retorno2 = $query_retorno;
	  $query_limit_retorno = sprintf("%s LIMIT %d, %d;", $query_retorno, $startRow_retorno, $maxRows_retorno);
	  
/*	  $all_retorno = mysql_query($query_limit_retorno);
	  $row_all_retorno = mysql_fetch_assoc($all_retorno);
	  $totalRows_retorno = mysql_num_rows($retorno);
	  
	  $row_retorno = $row_all_retorno;
	  $retorno = $all_retorno;
	  
	  if($siteDebug) {
	  	$timeAfter = microtime(true);
	  	echo $query_limit_retorno."<br>";
	  	$diff = $timeAfter - $timeBefore;
	  	echo "<strong>delay select foto no TMP1: </strong>".$diff."</strong><br>";
	  }*/
}

$totalPages_retorno = ceil($totalRows_retorno/$maxRows_retorno)-1;

?>