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
  //echo "Time After: ".$timeAfter."<br>";
  $diff = $timeAfter - $timeBefore;
  echo "<strong>delay select temas: </strong>".$diff."</strong><br>";
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

$MMColParam11_retorno = "";
if (isset($_GET['fracao'])) {
//  	$MMColParam11_retorno = (get_magic_quotes_gpc()) ? $_GET['fracao'] : addslashes($_GET['fracao']);
	$MMColParam11_retorno = $_GET['fracao'];
}
$MMColParam12_retorno = "";
if (isset($_GET['palavra1'])) {
//	$MMColParam12_retorno = (get_magic_quotes_gpc()) ? $_GET['palavra1'] : addslashes($_GET['palavra1']);
	$MMColParam12_retorno = $_GET['palavra1'];
}
$MMColParam13_retorno = "";
if (isset($_GET['palavra2'])) {
//	$MMColParam13_retorno = (get_magic_quotes_gpc()) ? $_GET['palavra2'] : addslashes($_GET['palavra2']);
  	$MMColParam13_retorno = $_GET['palavra2'];
}
$MMColParam14_retorno = "";
if (isset($_GET['palavra3'])) {
//	$MMColParam14_retorno = (get_magic_quotes_gpc()) ? $_GET['palavra3'] : addslashes($_GET['palavra3']);
	$MMColParam14_retorno = $_GET['palavra3'];
}
$MMColParam21_retorno = "";
if (isset($_GET['nao_palavra'])) {
//	$MMColParam21_retorno = (get_magic_quotes_gpc()) ? $_GET['nao_palavra'] : addslashes($_GET['nao_palavra']);
	$MMColParam21_retorno = $_GET['nao_palavra'];
}
$MMColParam22_retorno = "";
if (isset($_GET['local'])) {
//	$MMColParam22_retorno = (get_magic_quotes_gpc()) ? $_GET['local'] : addslashes($_GET['local']);
	$MMColParam22_retorno = $_GET['local'];
}
$MMColParam22b_retorno = "";
if (isset($_GET['estado'])) {
//  	$MMColParam22b_retorno = (get_magic_quotes_gpc()) ? $_GET['estado'] : addslashes($_GET['estado']);
	$MMColParam22b_retorno = $_GET['estado'];
}
$MMColParam22c_retorno = "";
if (isset($_GET['pais'])) {
//  	$MMColParam22c_retorno = (get_magic_quotes_gpc()) ? $_GET['pais'] : addslashes($_GET['pais']);
	$MMColParam22c_retorno = $_GET['pais'];
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

$MMColParam31_retorno = "";
if (isset($_GET['horizontal'])) {
  $MMColParam31_retorno = (get_magic_quotes_gpc()) ? $_GET['horizontal'] : addslashes($_GET['horizontal']);
}
$MMColParam32_retorno = "";
if (isset($_GET['vertical'])) {
  $MMColParam32_retorno = (get_magic_quotes_gpc()) ? $_GET['vertical'] : addslashes($_GET['vertical']);
}

mysql_select_db($database_pulsar, $pulsar);
if ((strlen($_GET['tipo']) <= 15) && (substr(($_GET['tipo']),-4) == '.php') ) {
include_once($_GET['tipo']); } else {
  header("Location: http://www.fbi.gov");
}

if($siteDebug) {
	$timeBefore = microtime(true);
//	echo "Time Before: ".$timeBefore."<br>";
}

$query_limit_retorno = $query_retorno2;//.$query_final;

if($siteDebug) {
	echo "<br><br>".$query_limit_retorno."<br><br>";
}

// Caso nao seja colocado nada na rotina de busca
if($query_retornob == "") {
	header("Location: listing.php");
}

//echo $query_limit_retorno;
$A_comandos = explode(";",$query_limit_retorno);
do {

	$retorno = mysql_query($A_comandos[key($A_comandos)], $pulsar) or die(mysql_error());

} while (next($A_comandos));

// $row_retorno = mysql_fetch_assoc($retorno);

if($siteDebug) {
  $timeAfter = microtime(true);
  //echo "Time After: ".$timeAfter."<br>";
  $diff = $timeAfter - $timeBefore;
  echo "<strong>delay select query1: </strong>".$diff."</strong><br>";
}

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

// insere a pesquisa em hidden no form

if (1==1) {
  $all_tempr = mysql_query($query_tempr) or die(mysql_error());
  $totalRows_tempr = mysql_num_rows($all_tempr);
  while ($row = mysql_fetch_assoc($all_tempr)) {
    $arry[] = $row['tombo'];
  };  
  if($totalRows_tempr > 0) {
  	$super_string = implode("|",$arry);
  }  

}

// insere a pesquisa no logger
if (!( (isset($_GET['totalRows_retorno'])) OR (isset($_GET['pageNum_retorno'])) )) {
  $insertSQL = sprintf("INSERT INTO pesquisa_pa (fracao, palavra1, palavra2, palavra3, palavranao, cidade, estado, autor, orientacao, retorno, datahora) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s,now())",
                       GetSQLValueString($_GET['fracao'], "text"),
                       GetSQLValueString($_GET['palavra1'], "text"),
                       GetSQLValueString($_GET['palavra2'], "text"),
                       GetSQLValueString($_GET['palavra3'], "text"),
                       GetSQLValueString($_GET['nao_palavra'], "text"),
                       GetSQLValueString($_GET['local'], "text"),
                       GetSQLValueString($_GET['estado'], "text"),
                       GetSQLValueString($MMColParam23_retorno, "text"),
                       GetSQLValueString($_GET['horizontal'].$_GET['vertical'], "text"),
                       GetSQLValueString($totalRows_retorno, "int"));


  if($siteDebug) {
	$timeBefore = microtime(true);
  //	echo "Time Before: ".$timeBefore."<br>";
  }                       

if($siteDebug) {
	echo "<br><br>".$insertSQL."<br><br>";
}
  
  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
  
  if($siteDebug) {
  	$timeAfter = microtime(true);
  	//echo "Time After: ".$timeAfter."<br>";
  	$diff = $timeAfter - $timeBefore;
  	echo "<strong>delay select query3: </strong>".$diff."</strong><br>";
  }
  
  
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