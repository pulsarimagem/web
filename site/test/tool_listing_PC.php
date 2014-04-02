<?php
$novaQuery_temas = "";
$novaTemas_query = "";
$novaQuery = true;

?>
<?php

if($siteDebug) {
	$timeStart = microtime(true);
	$timeBefore = microtime(true);
//	echo "Time Before: ".$timeBefore."<br>";
}


mysql_select_db($database_pulsar, $pulsar);
$query_temas = "SELECT * FROM temas ORDER BY Pai,Tema ASC";

if($siteDebug) {
	echo $query_temas."<br><br>";
}

$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
$row_temas = mysql_fetch_assoc($temas);
$totalRows_temas = mysql_num_rows($temas);
	

if($siteDebug) {
	$timeAfter = microtime(true);
//	echo "Time After: ".$timeAfter."<br>";
	$diff = $timeAfter - $timeBefore;
	echo "<strong>delay: </strong>".$diff."</strong><br>";
}


$currentPage = $_SERVER["PHP_SELF"];
/*
$maxRows_retorno = 48;
if (isset($_GET['maxRows'])) {
  $maxRows_retorno = (get_magic_quotes_gpc()) ? $_GET['maxRows'] : addslashes($_GET['maxRows']);
}

$pageNum_retorno = 0;
if (isset($_GET['pageNum_retorno'])) {
  $pageNum_retorno = $_GET['pageNum_retorno'];
}
$startRow_retorno = $pageNum_retorno * $maxRows_retorno;
*/

//$MMColParam_retorno = "com_codigo";
$MMColParam_retorno = "";
if (($_GET['type']=="pc")) {
//  $MMColParam_retorno = str_replace("-"," ",(get_magic_quotes_gpc()) ? $_GET['query'] : addslashes($_GET['query']));
  $MMColParam_retorno = str_replace("-"," ",$_GET['query']);
  $MMColParam_retorno2 = str_replace(" ","-",$MMColParam_retorno);
//  $MMColParam_retorno3 = (get_magic_quotes_gpc()) ? $_GET['query'] : addslashes($_GET['query']);
  $MMColParam_retorno3 = $_GET['query'];
  $n_contador = 0;
  $A_palavras = explode(" ",$MMColParam_retorno);
  $MMColParam_uniao = "";
    
  
  $MMColParam22_retorno = "";
if (isset($_GET['local'])) {
//  $MMColParam22_retorno = (get_magic_quotes_gpc()) ? $_GET['local'] : addslashes($_GET['local']);
  $MMColParam22_retorno = $_GET['local'];
}
  
    
  $MMColParam23_retorno = "";
if (isset($_GET['id_autor']) && ($_GET['id_autor'] != "") && ($_GET['id_autor'] != "Array")) {
	if (count($_GET['id_autor']) == 1) {
		foreach ($_GET['id_autor'] as $value) {
			 $MMColParam23_retorno = $value;
		}
	} else {
		foreach ($_GET['id_autor'] as $value) {
			 $MMColParam23_retorno .= $value. ","; 
		}
		$MMColParam23_retorno = substr($MMColParam23_retorno,0,-1);
	}
}
$MMColParam24a_retorno = "";
$MMColParam24b_retorno = "";
$MMColParam24c_retorno = "";
$MMColParam24d_retorno = "";

if (isset($_GET['data_tipo'])) {
	
	if($_GET['data_tipo'] == "exata") {

		if (isset($_GET['mes'])) {
		  $MMColParam24a_retorno = (get_magic_quotes_gpc()) ? $_GET['mes'] : addslashes($_GET['mes']);
		}
	  
		if (isset($_GET['ano'])) {
		  $MMColParam24b_retorno = (get_magic_quotes_gpc()) ? $_GET['ano'] : addslashes($_GET['ano']);
		}
	  
		if (isset($_GET['dia'])) {
		  $MMColParam24c_retorno = (get_magic_quotes_gpc()) ? $_GET['dia'] : addslashes($_GET['dia']);
		}
	}
	else {
		
		$MMColParam24dsinal_retorno = "=";
		if (isset($_GET['ano'])) {
		  $MMColParam24d_retorno = (get_magic_quotes_gpc()) ? $_GET['ano'] : addslashes($_GET['ano']);			
		} else $MMColParam24d_retorno = "0000";
		if (isset($_GET['mes'])) {
		  $MMColParam24d_retorno .= (get_magic_quotes_gpc()) ? $_GET['mes'] : addslashes($_GET['mes']);
		} else $MMColParam24d_retorno .= "00";
		if (isset($_GET['dia'])) {
		  $MMColParam24d_retorno .= (get_magic_quotes_gpc()) ? $_GET['dia'] : addslashes($_GET['dia']);
		} else $MMColParam24d_retorno .= "00";
		if($_GET['data_tipo'] == "antes") {
			$MMColParam24dsinal_retorno = "<";
		}
		else if($_GET['data_tipo'] == "depois") {
			$MMColParam24dsinal_retorno = ">";
		}
	}
}

  
  if($novaQuery) {
  if ( count($A_palavras) > 1 ) {

	  do {

	  		if ( strlen($A_palavras[key($A_palavras)])>2 ) {
			
if($n_contador == 0) {
		$MMColParam_uniao = $MMColParam_uniao . "
		INSERT INTO tmp
		
		SELECT 
			Fotos.Id_Foto, 
			Fotos.assunto_principal, 
			Fotos.cidade, 
			Fotos.id_estado, 
			Fotos.id_pais, 
			Fotos.orientacao, 
			Fotos.tombo, 
		    Fotos.data_foto,
		    Fotos.dim_a,
    		Fotos.dim_b,
			999 as prioridade
		FROM
		pal_chave
		INNER JOIN rel_fotos_pal_ch ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
		INNER JOIN Fotos ON (Fotos.Id_Foto=rel_fotos_pal_ch.id_foto)
		WHERE
		   ((pal_chave.Pal_Chave LIKE '%% " . $A_palavras[key($A_palavras)] . " %%') OR
		   (pal_chave.Pal_Chave LIKE '" . $A_palavras[key($A_palavras)] . "') OR
		   (pal_chave.Pal_Chave LIKE '" . $A_palavras[key($A_palavras)] . " %%') OR
		   (pal_chave.Pal_Chave LIKE '%% " . $A_palavras[key($A_palavras)] . "'));
		
		INSERT INTO tmp
		
		SELECT
			Fotos.Id_Foto, 
			Fotos.assunto_principal,
			Fotos.cidade, 
			Fotos.id_estado, 
			Fotos.id_pais, 
			Fotos.orientacao, 
			Fotos.tombo, 
		    Fotos.data_foto,
    		Fotos.dim_a,
		    Fotos.dim_b,
		    999 as prioridade
		FROM
		Fotos
		WHERE
		   ((Fotos.assunto_principal LIKE '%% " . $A_palavras[key($A_palavras)] . " %%') OR
		   (Fotos.assunto_principal LIKE '" . $A_palavras[key($A_palavras)] . "') OR
		   (Fotos.assunto_principal LIKE '" . $A_palavras[key($A_palavras)] . " %%') OR
		   (Fotos.assunto_principal LIKE '%% " . $A_palavras[key($A_palavras)] . "'));
		   
		   		INSERT INTO tmp
		
		SELECT
			Fotos.Id_Foto, 
			Fotos.assunto_principal,
			Fotos.cidade, 
			Fotos.id_estado, 
			Fotos.id_pais, 
			Fotos.orientacao, 
			Fotos.tombo, 
		    Fotos.data_foto,
		    Fotos.dim_a,
		    Fotos.dim_b,
		    999 as prioridade
		FROM
		Fotos
		LEFT JOIN Fotos_extra ON Fotos_extra.tombo = Fotos.tombo
		WHERE
		   ((Fotos_extra.extra LIKE '%% " . $A_palavras[key($A_palavras)] . " %%') OR
		   (Fotos_extra.extra LIKE '" . $A_palavras[key($A_palavras)] . "') OR
		   (Fotos_extra.extra LIKE '" . $A_palavras[key($A_palavras)] . " %%') OR
		   (Fotos_extra.extra LIKE '%% " . $A_palavras[key($A_palavras)] . "'));

		 ";
	
}
else {
	
	  			$MMColParam_uniao = $MMColParam_uniao . "
			
	DELETE FROM tmp
	WHERE tmp.Id_Foto
	NOT IN (
		SELECT 
	  		Fotos.Id_Foto
		FROM
			pal_chave
		INNER JOIN rel_fotos_pal_ch ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
		INNER JOIN Fotos ON (Fotos.Id_Foto=rel_fotos_pal_ch.id_foto)
		WHERE
		   ((pal_chave.Pal_Chave LIKE '%% " . $A_palavras[key($A_palavras)] . " %%') OR
		   (pal_chave.Pal_Chave LIKE '" . $A_palavras[key($A_palavras)] . "') OR
		   (pal_chave.Pal_Chave LIKE '" . $A_palavras[key($A_palavras)] . " %%') OR
		   (pal_chave.Pal_Chave LIKE '%% " . $A_palavras[key($A_palavras)] . "'))
		   
		 UNION 
		
			SELECT
			  Fotos.Id_Foto
			FROM
			  Fotos
			WHERE
			   ((Fotos.assunto_principal LIKE '%% " . $A_palavras[key($A_palavras)] . " %%') OR
			   (Fotos.assunto_principal LIKE '" . $A_palavras[key($A_palavras)] . "') OR
			   (Fotos.assunto_principal LIKE '" . $A_palavras[key($A_palavras)] . " %%') OR
			   (Fotos.assunto_principal LIKE '%% " . $A_palavras[key($A_palavras)] . "'))

		 UNION 

		 SELECT
			Fotos.Id_Foto
		 FROM
			Fotos
 		 LEFT JOIN Fotos_extra ON Fotos_extra.tombo = Fotos.tombo
		 WHERE
		   ((Fotos_extra.extra LIKE '%% " . $A_palavras[key($A_palavras)] . " %%') OR
		   (Fotos_extra.extra LIKE '" . $A_palavras[key($A_palavras)] . "') OR
		   (Fotos_extra.extra LIKE '" . $A_palavras[key($A_palavras)] . " %%') OR
		   (Fotos_extra.extra LIKE '%% " . $A_palavras[key($A_palavras)] . "'))
		 
);";
}
	  			
/*		
		INSERT INTO tmp

SELECT DISTINCT 
	Fotos.Id_Foto, 
	Fotos.assunto_principal, 
	Fotos.orientacao, 
	Fotos.tombo, 
    Fotos.data_foto,
	10 as prioridade
FROM
	Fotos, 
	pal_chave, 
	rel_fotos_pal_ch
WHERE
	(Fotos.Id_Foto = rel_fotos_pal_ch.id_foto) AND
	(pal_chave.Id = rel_fotos_pal_ch.id_palavra_chave) AND
	((pal_chave.Pal_Chave LIKE '" . $A_palavras[key($A_palavras)] . "') OR
	 (pal_chave.Pal_Chave LIKE '" . $A_palavras[key($A_palavras)] . " %%') OR
	 (pal_chave.Pal_Chave LIKE '%% " . $A_palavras[key($A_palavras)] . "') OR
	 (pal_chave.Pal_Chave LIKE '%% " . $A_palavras[key($A_palavras)] . " %%') OR
	 (Fotos.assunto_principal LIKE '" . $A_palavras[key($A_palavras)] . "') OR
	 (Fotos.assunto_principal LIKE '" . $A_palavras[key($A_palavras)] . " %%') OR
	 (Fotos.assunto_principal LIKE '%% " . $A_palavras[key($A_palavras)] . "') OR
	 (Fotos.assunto_principal LIKE '%% " . $A_palavras[key($A_palavras)] . " %%') OR
	 (pal_chave.Pal_Chave LIKE '" . $A_palavras[key($A_palavras)] . "-%%') OR
	 (pal_chave.Pal_Chave LIKE '%%-" . $A_palavras[key($A_palavras)] . "') OR
	 (pal_chave.Pal_Chave LIKE '%%-" . $A_palavras[key($A_palavras)] . "-%%') OR
	 (Fotos.assunto_principal LIKE '" . $A_palavras[key($A_palavras)] . "-%%') OR
	 (Fotos.assunto_principal LIKE '%%-" . $A_palavras[key($A_palavras)] . "') OR
	 (Fotos.assunto_principal LIKE '%%-" . $A_palavras[key($A_palavras)] . "-%%'));

";*/	
		$n_contador++;		
			}	
	  } while (next($A_palavras));
//	echo "<br><br>".$MMColParam_uniao."<br><br>";
  }}
  else { 
  if ( count($A_palavras) > 1 ) {

	  do {

	  		if ( strlen($A_palavras[key($A_palavras)])>2 ) {
			

	  			$MMColParam_uniao = $MMColParam_uniao . "
			
INSERT INTO tmp

SELECT DISTINCT 
	Fotos.Id_Foto, 
	Fotos.assunto_principal,
	Fotos.cidade, 
	Fotos.id_estado, 
	Fotos.id_pais, 
	Fotos.orientacao, 
	Fotos.tombo, 
    Fotos.data_foto,
	10 as prioridade
FROM
	Fotos, 
	pal_chave, 
	rel_fotos_pal_ch
WHERE
	(Fotos.Id_Foto = rel_fotos_pal_ch.id_foto) AND
	(pal_chave.Id = rel_fotos_pal_ch.id_palavra_chave) AND
	((pal_chave.Pal_Chave LIKE '" . $A_palavras[key($A_palavras)] . "') OR
	 (pal_chave.Pal_Chave LIKE '" . $A_palavras[key($A_palavras)] . " %%') OR
	 (pal_chave.Pal_Chave LIKE '%% " . $A_palavras[key($A_palavras)] . "') OR
	 (pal_chave.Pal_Chave LIKE '%% " . $A_palavras[key($A_palavras)] . " %%') OR
	 (Fotos.assunto_principal LIKE '" . $A_palavras[key($A_palavras)] . "') OR
	 (Fotos.assunto_principal LIKE '" . $A_palavras[key($A_palavras)] . " %%') OR
	 (Fotos.assunto_principal LIKE '%% " . $A_palavras[key($A_palavras)] . "') OR
	 (Fotos.assunto_principal LIKE '%% " . $A_palavras[key($A_palavras)] . " %%') OR
	 (pal_chave.Pal_Chave LIKE '" . $A_palavras[key($A_palavras)] . "-%%') OR
	 (pal_chave.Pal_Chave LIKE '%%-" . $A_palavras[key($A_palavras)] . "') OR
	 (pal_chave.Pal_Chave LIKE '%%-" . $A_palavras[key($A_palavras)] . "-%%') OR
	 (Fotos.assunto_principal LIKE '" . $A_palavras[key($A_palavras)] . "-%%') OR
	 (Fotos.assunto_principal LIKE '%%-" . $A_palavras[key($A_palavras)] . "') OR
	 (Fotos.assunto_principal LIKE '%%-" . $A_palavras[key($A_palavras)] . "-%%'));

";	
		$n_contador++;		
			}	
	  } while (next($A_palavras));

  }}
  
}
$MMColParam2_retorno = "999999999";
if (($_GET['type']=="tombo")) {
  $MMColParam2_retorno = (get_magic_quotes_gpc()) ? $_GET['query'] : addslashes($_GET['query']);
}

// Alteracao da query dos temas. Se novaQuery estiver true, pesquisa temas depois monta a query principal.
if($novaQuery) {
	
	$novaQuery_temas = sprintf("SELECT  id_tema  FROM    lista_temas WHERE id_pai = ( SELECT Id FROM temas WHERE Tema LIKE '%s' LIMIT 0,1 );", $MMColParam_retorno);
	
	$novaTemas_retorno = mysql_query($novaQuery_temas, $pulsar) or die(mysql_error());
	$novaRow_retorno = mysql_fetch_assoc($novaTemas_retorno);
	$novaRow_num = mysql_num_rows($novaTemas_retorno);
	
	if($novaRow_num == 0) {
		$novaTemas_query = "temas.Id = 0";
	}
	else { 
		$novaTemas_query = "temas.Id =".$novaRow_retorno['id_tema'];
	}
		
	while ($novaRow_retorno = mysql_fetch_assoc($novaTemas_retorno)) {
		$novaTemas_query .= " or temas.Id =".$novaRow_retorno['id_tema'];
	}  
//	echo "<br><br>".$novaTemas_query."<br>";	
}


if ((strlen($_GET['tipo']) <= 15) && (substr(($_GET['tipo']),-4) == '.php') ) {
include_once($_GET['tipo']); } else {
  header("Location: http://www.fbi.gov");
}
if($novaQuery) {
	if ($MMColParam_retorno != "") {
//		$novaQuery_retorno = $novaQuery_retorno."(".$novaTemas_query.");".$MMColParam_uniao;
		
//		echo "<br><br>".$MMColParam_uniao."<br><br>";
				
		$query_retorno = $novaQuery_retorno;
		$query_retorno2 = $novaQuery_retorno;
		
//		echo "<br><br>".$novaTemas_query."<br><br>";
//		echo "<br><br>".$MMColParam_uniao."<br><br>";
		
//		echo "<br><br>".$novaQuery_retorno."<br><br>";
	}
		
}

// $query_limit_retorno = sprintf("%s LIMIT %d, %d;", $query_retorno.$query_final, $startRow_retorno, $maxRows_retorno);

if($novaQuery) {
	if ($MMColParam_retorno != "") {
	
//	echo "<br><br>".$novaQuery_retorno."<br><br>";
	
		$query_limit_retorno = $novaQuery_retorno.$novaQuery_final;
	}else  {
		$query_limit_retorno = $query_retorno.$query_final;
	}

}
else  {
	$query_limit_retorno = $query_retorno.$query_final;
}
$A_comandos = explode(";",$query_limit_retorno);

if($siteDebug) {
	echo "<br><br>".$query_limit_retorno."<br><br>";
}

if($siteDebug) {
  $timeBefore = microtime(true);
//	echo "Time Before: ".$timeBefore."<br>";
}

do {

	$retorno = mysql_query($A_comandos[key($A_comandos)], $pulsar) or die(mysql_error());
	
} while (next($A_comandos));

if($siteDebug) {
  $timeAfter = microtime(true);
//  echo "Time After: ".$timeAfter."<br>";
  $diff = $timeAfter - $timeBefore;
  echo "<strong>delay create TMP: </strong>".$diff."</strong><br>";
}

// $row_retorno = mysql_fetch_assoc($retorno);

include("tool_filter.php");

include("tool_order.php");

if($siteDebug) {
	$timeBefore = microtime(true);
//	echo "Time Before: ".$timeBefore."<br>";
}

if($siteDebug) {
	echo "<br><br>".$query_limit_retorno."<br><br>";
}

$retorno = mysql_query($query_limit_retorno, $pulsar) or die(mysql_error());

if($siteDebug) {
  $timeAfter = microtime(true);
  //echo "Time After: ".$timeAfter."<br>";
  $diff = $timeAfter - $timeBefore;
  echo "<strong>delay select query2: </strong>".$diff."</strong><br>";
}

$row_retorno = mysql_fetch_assoc($retorno);
//echo "<meta  name=\"version\" content=\"".$query_limit_retorno."\">";
// **********************************************************************************************************
if (isset($_GET['totalRows_retorno'])) {
  $totalRows_retorno = $_GET['totalRows_retorno'];
} else {
  $all_retorno = mysql_query($query_retorno);
  $totalRows_retorno = mysql_num_rows($all_retorno);
}
$totalPages_retorno = ceil($totalRows_retorno/$maxRows_retorno)-1;

// insere a pesquisa em tabela temporaria no mysql

if($siteDebug) {
	$timeBefore = microtime(true);
	//echo "Time Before: ".$timeBefore."<br>";
}


if ($_GET['type']=="pc") {
  $uid = uniqid(rand(), true);
  $all_tempr = mysql_query($query_tempr);
  $totalRows_tempr = mysql_num_rows($all_tempr);
  
  
  if($siteDebug) {
	  $timeAfter = microtime(true);
	  //echo "Time After: ".$timeAfter."<br>";
	  $diff = $timeAfter - $timeBefore;
	  echo "<strong>delay select foto no TMP2: </strong>".$diff."</strong><br>";
  }
  
  
//  do {
//    $arry[] = $row['tombo'];
//  } while ($row = mysql_fetch_assoc($all_tempr));

  while ($row = mysql_fetch_assoc($all_tempr)) {
    $arry[] = $row['tombo'];
  }  
  if(isset($arry)) {
  	$super_string = implode("|",$arry);
  	
  }  
}

// insere a pesquisa no logger

if($siteDebug) {
	$timeBefore = microtime(true);
	//echo "Time Before: ".$timeBefore."<br>";
}

if (!( (isset($_GET['totalRows_retorno'])) OR (isset($_GET['pageNum_retorno'])) )) {
  $insertSQL = sprintf("INSERT INTO pesquisa_pc (palavra, tombo, retorno, datahora) VALUES (%s, %s, %s, now())",
                       GetSQLValueString($_GET['query'], "text"),
                       GetSQLValueString($_GET['query'], "text"),
                       GetSQLValueString($totalRows_retorno, "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
}

if($siteDebug) {
	$timeAfter = microtime(true);
	//echo "Time After: ".$timeAfter."<br>";
	$diff = $timeAfter - $timeBefore;
	echo "<strong>delay Insert LOG: </strong>".$diff."</strong><br>";
}

?>