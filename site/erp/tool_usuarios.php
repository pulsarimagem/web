<?php

$busca = (isset($_GET['busca'])?$_GET['busca']:"");

mysql_select_db($database_pulsar, $pulsar);
mysql_select_db($database_sig, $sig);

$queryBusca = "WHERE USUARIOS.nome LIKE '%$busca%'";
$queryUsers = "select USUARIOS.id, USUARIOS.nome, USUARIOS.usuario, USUARIOS.status, roles.nome as role from USUARIOS LEFT JOIN roles ON roles.id = USUARIOS.role $queryBusca";
$rsUsers = mysql_query($queryUsers, $pulsar) or die(mysql_error());

if(isset($_GET['excluirUser'])) {
	$queryDelUsers = "UPDATE USUARIOS SET status = 'D' WHERE id = ".$_GET['excluirUser'];
	$rsDelUsers = mysql_query($queryDelUsers, $pulsar) or die(mysql_error());
	if($siteDebug)
		echo $queryDelUsers;
}
?>