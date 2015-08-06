<?php
mysql_select_db($database_pulsar, $pulsar);
mysql_select_db($database_sig, $sig);

$msg = (isset($_GET['msg'])?$_GET['msg']:"");

if(isset($_GET['excluirUser'])) {
	$queryDelUsers = "UPDATE roles SET status = -1 WHERE id = ".$_GET['excluirUser'];
	$rsDelUsers = mysql_query($queryDelUsers, $pulsar) or die(mysql_error());
	if($siteDebug)
		echo $queryDelUsers;
	$msg = "Excluído com sucesso!";
}

$queryUsers = "select roles.id, roles.nome, roles.status from roles";
$rsUsers = mysql_query($queryUsers, $pulsar) or die(mysql_error());
?>