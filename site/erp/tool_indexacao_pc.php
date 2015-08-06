<?php
$isShow = false;
$isTotal = false;
$isEdit = false;
$action = isset($_GET['action'])?$_GET['action']:false;

mysql_select_db($database_pulsar, $pulsar);

if ($action == "del") {
	$pcid = $_GET['pcid'];
	$deleteSQL = "DELETE FROM pal_chave WHERE Id=$pcid";
// 	echo $deleteSQL;
	$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());

	$deleteSQL = "DELETE FROM rel_fotos_pal_ch WHERE id_palavra_chave=$pcid";
// 	echo $deleteSQL;
	$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
}
else if ($action == "edit") {
	$pcid = $_GET['pcid'];

	$sql = "SELECT * FROM pal_chave WHERE Id = $pcid";
	$rs = mysql_query($sql, $pulsar) or die(mysql_error());
	$row = mysql_fetch_array($rs);
	$isEdit = true;
}
else if ($action == "criar") {
	$pc = $_GET['pc'];
	$pcEn = $_GET['pcEn'];
	
	$sql = "INSERT INTO pal_chave (Pal_Chave,Pal_Chave_en) VALUES ('$pc','$pcEn')";
// 	echo $sql;
	$rs = mysql_query($sql, $pulsar) or die(mysql_error());
}
else if ($action == "alterar") {
	$pcid = $_GET['pcId'];
	$pc = $_GET['pc'];
	$pcEn = $_GET['pcEn'];
	
	$sql = "UPDATE pal_chave SET Pal_Chave = '$pc',Pal_Chave_en = '$pcEn' WHERE Id = $pcid";
	$rs = mysql_query($sql, $pulsar) or die(mysql_error());
}
	

$maxRows_palavra_chave = 100;
$pageNum_palavra_chave = 0;
if (isset($_GET['pageNum_palavra_chave'])) {
	$pageNum_palavra_chave = $_GET['pageNum_palavra_chave'];
}
$startRow_palavra_chave = $pageNum_palavra_chave * $maxRows_palavra_chave;

$colname_palavra_chave = "0-9";
if (isset($_GET['inicial'])) {
	$colname_palavra_chave = (get_magic_quotes_gpc()) ? $_GET['inicial'] : addslashes($_GET['inicial']);
	$isShow = true;
}

$query_palavra_chave = sprintf("SELECT pal_chave.Id, pal_chave.Pal_Chave, pal_chave.Pal_Chave_en, count(rel_fotos_pal_ch.id_rel) AS total FROM pal_chave LEFT JOIN rel_fotos_pal_ch ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave) WHERE (pal_chave regexp('^[%s]')) GROUP BY pal_chave.Id, pal_chave.Pal_Chave ORDER BY pal_chave.Pal_Chave", $colname_palavra_chave);

// Modificacao Aislan - Busca de palavras chaves
if (isset($_GET['busca'])) {
	$colname_palavra_chave = (get_magic_quotes_gpc()) ? $_GET['busca'] : addslashes($_GET['busca']);
	$query_palavra_chave = sprintf("SELECT pal_chave.Id, pal_chave.Pal_Chave, pal_chave.Pal_Chave_en, count(rel_fotos_pal_ch.id_rel) AS total FROM pal_chave LEFT JOIN rel_fotos_pal_ch ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave) WHERE pal_chave LIKE '%s' GROUP BY pal_chave.Id, pal_chave.Pal_Chave ORDER BY pal_chave.Pal_Chave", $colname_palavra_chave);
	$isShow = true;
}
if (isset($_GET['fracao'])) {
	$colname_palavra_chave = (get_magic_quotes_gpc()) ? $_GET['fracao'] : addslashes($_GET['fracao']);
	$colname_palavra_chave = "%$colname_palavra_chave%";
	$query_palavra_chave = sprintf("SELECT pal_chave.Id, pal_chave.Pal_Chave, pal_chave.Pal_Chave_en, count(rel_fotos_pal_ch.id_rel) AS total FROM pal_chave LEFT JOIN rel_fotos_pal_ch ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave) WHERE pal_chave LIKE '%s' GROUP BY pal_chave.Id, pal_chave.Pal_Chave ORDER BY pal_chave.Pal_Chave", $colname_palavra_chave);
	$isShow = true;
}

if (isset($_GET['todas'])) {
	$query_palavra_chave = sprintf("SELECT pal_chave.Id, pal_chave.Pal_Chave, pal_chave.Pal_Chave_en, Id AS total  FROM pal_chave ORDER BY pal_chave.Pal_Chave");
// 	echo $query_palavra_chave;
	$palavra_chave = mysql_query($query_palavra_chave, $pulsar) or die(mysql_error());
	$row_palavra_chave = mysql_fetch_assoc($palavra_chave);
	$isShow = true;
}
if (isset($_GET['todas_total'])) {
	$query_palavra_chave = sprintf("SELECT pal_chave.Id, pal_chave.Pal_Chave, pal_chave.Pal_Chave_en, count(rel_fotos_pal_ch.id_rel) AS total FROM pal_chave LEFT JOIN rel_fotos_pal_ch ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave) GROUP BY pal_chave.Id, pal_chave.Pal_Chave ORDER BY pal_chave.Pal_Chave");
// 	echo $query_palavra_chave;
	$palavra_chave = mysql_query($query_palavra_chave, $pulsar) or die(mysql_error());
	$row_palavra_chave = mysql_fetch_assoc($palavra_chave);
	$isShow = true;
	$isTotal = true;
}

if ($isShow && !$isTotal) {
	mysql_select_db($database_pulsar, $pulsar);
	$query_limit_palavra_chave = sprintf("%s LIMIT %d, %d", $query_palavra_chave, $startRow_palavra_chave, $maxRows_palavra_chave);
// 	echo $query_limit_palavra_chave;
	$palavra_chave = mysql_query($query_limit_palavra_chave, $pulsar) or die(mysql_error());
// 	$row_palavra_chave = mysql_fetch_assoc($palavra_chave);

	if (isset($_GET['totalRows_palavra_chave'])) {
		$totalRows_palavra_chave = $_GET['totalRows_palavra_chave'];
	} else {
		$all_palavra_chave = mysql_query($query_palavra_chave);
		$totalRows_palavra_chave = mysql_num_rows($all_palavra_chave);
	}
	$totalPages_palavra_chave = ceil($totalRows_palavra_chave/$maxRows_palavra_chave)-1;
}
?>