<?php
mysql_select_db($database_pulsar, $pulsar);
// mysql_select_db($database_sig, $sig);

$msg = isset($_GET['msg'])?$_GET['msg']:"";

if(isset($_GET['excluirUser'])) {
	$queryDelUsers = "UPDATE cadastro SET STATUS = 'D' WHERE id_cadastro = ".$_GET['excluirUser'];
	$rsDelUsers = mysql_query($queryDelUsers, $pulsar) or die(mysql_error());
	if($siteDebug)
		echo $queryDelUsers;
	$msg = "Excluído com sucesso!";
}

$where = "WHERE data_cadastro > NOW() - INTERVAL 3 MONTH";
$order = "ORDER BY nome ASC LIMIT 20";

$busca = isset($_GET['buscar'])?removeAccent($_GET['buscar']):"";
if($busca != "") {
	$where = "WHERE convert(nome using utf8) LIKE _utf8 '%$busca%' OR convert(empresa using utf8) LIKE _utf8 '%$busca%' OR convert(login using utf8) LIKE _utf8 '%$busca%'";
	$order = "ORDER BY nome ASC";
}

$queryUsers = "SELECT * FROM cadastro $where $order";
$rsUsers = mysql_query($queryUsers, $pulsar) or die(mysql_error());
$totalUsers = mysql_num_rows($rsUsers);

?>