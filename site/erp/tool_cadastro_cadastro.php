<?php
mysql_select_db($database_pulsar, $pulsar);

$isNew = true;
$isEdit = isset($_GET['idUser'])?$_GET['idUser']:-1;
$isUpdate = isset($_POST['updateUser'])?$_POST['updateUser']:-1;
$isSave = isset($_POST['saveUser'])?true:false;
$isDel = isset($_GET['delUser'])?$_GET['delUser']:-1;
$isDelContato = isset($_GET['delContato'])?$_GET['delContato']:-1;


if($isSave || $isUpdate > 0) {
	$id				= $isUpdate;
	$login			= $_POST['login'];
	$nome			= $_POST['nome'];
	$email			= $_POST['email'];
	$empresa		= $_POST['empresa'];
	$cargo			= $_POST['cargo'];
	$telefone		= $_POST['telefone'];
	$cpf_cnpj		= $_POST['cpf_cnpj'];
	$endereco		= $_POST['endereco'];
	$cep			= $_POST['cep'];
	$cidade			= $_POST['cidade'];
	$estado			= $_POST['estado'];
	$pais			= $_POST['pais'];
	$tipo 			= $_POST['tipo'];
	$data_cadastro	= $_POST['data_cadastro'];
	$id_cliente_sig	= ($_POST['id_cliente_sig']!=''?$_POST['id_cliente_sig']:0);
	$id_contato_sig	= ($_POST['id_contato_sig']!=''?$_POST['id_contato_sig']:0);
	$download		= $_POST['download'];
	$limite			= ($_POST['limite']!=''?$_POST['limite']:0);
	
	
	if($isSave) { 
		$queryUsers = "INSERT INTO cadastro (login, nome, email, empresa, cargo, telefone, cpf_cnpj, endereco, cep, cidade, estado, pais, tipo, data_cadastro, download, limite, id_cliente_sig, id_contato_sig) values ('" . $login . "','" . $nome . "','" . $email . "','" . $empresa . "','" . $cargo . "','" . $telefone . "','" . $cpf_cnpj . "','" . $endereco . "','" . $cep . "','" . $cidade . "','" . $estado . "','$pais', '$tipo', '" . $data_cadastro . "', '$download', $limite, $id_cliente_sig, $id_contato_sig)";
		$msg = "Inserido com sucesso!";
	}
	else if($isUpdate > 0) {
		$queryUsers = "UPDATE cadastro SET login = '" . $login . "', nome = '" . $nome . "', email = '" . $email . "', empresa = '" . $empresa . "', cargo = '" . $cargo . "', telefone = '" . $telefone . "', cpf_cnpj = '" . $cpf_cnpj . "', endereco = '" . $endereco . "', cep = '" . $cep . "', cidade = '" . $cidade . "', estado = '" . $estado . "', pais = '" . $pais . "', tipo = '$tipo', download = '$download', limite = ".($limite==''?0:$limite).", id_cliente_sig = $id_cliente_sig, id_contato_sig = $id_contato_sig WHERE id_cadastro = " . $isUpdate;
		$msg = "Atualizado com sucesso!";
	}
	$sql = str_replace("''","Null",$queryUsers);
	$sql = str_replace(",,",",0,",$queryUsers);
	
// 	if($siteDebug)
		echo $queryUsers;
	$rsUsers = mysql_query($queryUsers, $pulsar) or die(mysql_error());
	if($isSave) {
		$isEdit = mysql_insert_id();
	}
	else if($isUpdate) {
		$isEdit = $isUpdate;
	}
}
if($isEdit>0) {
	$isNew = false;
	$queryUsers = "SELECT login, nome, email, empresa, cargo, telefone, cpf_cnpj, endereco, cep, cidade, estado, pais, tipo, data_cadastro, download, limite, id_cliente_sig, id_contato_sig FROM cadastro WHERE id_cadastro = $isEdit"; 
	if($siteDebug)
		echo $queryUsers;
	$rsUsers = mysql_query($queryUsers, $pulsar) or die(mysql_error());
	$rowUsers = mysql_fetch_assoc($rsUsers);
}
if($isDel > 0) {
	$isNew = false;
	$queryDelUsers = "UPDATE cadastro SET status = 'D' WHERE id_cadastro = $isDel";
	$rsDelUsers = mysql_query($queryDelUsers, $pulsar) or die(mysql_error());
	if($siteDebug)
		echo $queryDelUsers;
	header("location: cadastro.php?msg=Excluído com sucesso!");
}


mysql_select_db($database_pulsar, $pulsar);
$query_estados = "SELECT * FROM Estados";
$estados = mysql_query($query_estados, $pulsar) or die(mysql_error());
$row_estados = mysql_fetch_assoc($estados);
$totalRows_estados = mysql_num_rows($estados);

mysql_select_db($database_pulsar, $pulsar);
$query_paises = "SELECT * FROM paises ORDER BY nome ASC";
$paises = mysql_query($query_paises, $pulsar) or die(mysql_error());
$row_paises = mysql_fetch_assoc($paises);
$totalRows_paises = mysql_num_rows($paises);

mysql_select_db($database_sig, $sig);

$query_empresas = sprintf("SELECT ID, RAZAO, FANTASIA FROM CLIENTES WHERE STATUS = 'A' ORDER BY RAZAO");
$empresas = mysql_query($query_empresas, $sig) or die(mysql_error());
$totalRows_empresas = mysql_num_rows($empresas);

$query_contatos = sprintf("SELECT ID, CONTATO FROM CONTATOS ORDER BY CONTATO");
$contatos = mysql_query($query_contatos, $sig) or die(mysql_error());
$totalRows_contatos = mysql_num_rows($contatos);
?>