<?php
mysql_select_db($database_pulsar, $pulsar);
mysql_select_db($database_sig, $sig);

$msg = isset($_GET['msg'])?$_GET['msg']:"";

$where = "";

$busca = isset($_GET['buscar'])?removeAccent($_GET['buscar']):"";
if($busca != "") {
	$where = "WHERE convert(NOME using utf8) LIKE _utf8 '%$busca%' OR convert(SIGLA using utf8) LIKE _utf8 '%$busca%'";
}

$queryUsers = $sql = "SELECT ID,NOME,SIGLA,TELEFONE,CELULAR,EMAIL,STATUS FROM AUTORES_OFC $where ORDER BY trim(NOME)";
$rsUsers = mysql_query($queryUsers, $pulsar) or die(mysql_error());

if(isset($_GET['excluirUser'])) {
	$queryDelUsers = "UPDATE AUTORES_OFC SET STATUS = 'D' WHERE id = ".$_GET['excluirUser'];
	$rsDelUsers = mysql_query($queryDelUsers, $pulsar) or die(mysql_error());
	if($siteDebug)
		echo $queryDelUsers;
}
?>