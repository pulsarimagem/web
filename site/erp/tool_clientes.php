<?php
mysql_select_db($database_pulsar, $pulsar);
mysql_select_db($database_sig, $sig);

$msg = isset($_GET['msg'])?$_GET['msg']:"";

if(isset($_GET['excluirUser'])) {
	$queryDelUsers = "UPDATE USUARIOS SET STATUS = 'D' WHERE id = ".$_GET['excluirUser'];
	$rsDelUsers = mysql_query($queryDelUsers, $pulsar) or die(mysql_error());
	if($siteDebug)
		echo $queryDelUsers;
	$msg = "Excluído com sucesso!";
}
$where = "WHERE ID = 0";
$order = "ORDER BY ID DESC LIMIT 20";

$busca = isset($_GET['buscar'])?removeAccent($_GET['buscar']):"";
if($busca != "") {
	$where = "WHERE convert(RAZAO using utf8) LIKE _utf8 '%$busca%' OR convert(FANTASIA using utf8) LIKE _utf8 '%$busca%'";
	$order = "ORDER BY FANTASIA ASC";
}

$queryUsers = "SELECT ID, CNPJ, RAZAO, FANTASIA, INSCRICAO, ENDERECO, BAIRRO, CEP, CIDADE, ESTADO, TELEFONE, FAX, ENDERECO_COB, BAIRRO_COB, CEP_COB, CIDADE_COB, ESTADO_COB, DESDE, OBS, STATUS, desc_valor, desc_porcento FROM CLIENTES $where $order";
$rsUsers = mysql_query($queryUsers, $pulsar) or die(mysql_error());
$totalUsers = mysql_num_rows($rsUsers);
?>