<?php
mysql_select_db($database_pulsar, $pulsar);
mysql_select_db($database_sig, $sig);

$isNew = true;
$isEdit = isset($_GET['idUser'])?$_GET['idUser']:-1;
$isUpdate = isset($_POST['updateUser'])?$_POST['updateUser']:-1;
$isSave = isset($_POST['saveUser'])?true:false;
$isDel = isset($_GET['delUser'])?$_GET['delUser']:-1;
$isAdd = isset($_GET['addUser'])?$_GET['addUser']:-1;
$isDelContato = isset($_GET['delContato'])?$_GET['delContato']:-1;

if($isSave || $isUpdate > 0) {
	$id				= $isUpdate;
	$cnpj			= $_POST['cnpj'];
	$razao			= mb_strtoupper($_POST['razao']);
	$fantasia		= mb_strtoupper($_POST['fantasia']);
	$inscricao		= $_POST['inscricao'];
	$endereco		= mb_strtoupper($_POST['endereco']);
	$bairro			= mb_strtoupper($_POST['bairro']);
	$cep			= $_POST['cep'];
	$cidade			= mb_strtoupper($_POST['cidade']);
	$estado			= mb_strtoupper($_POST['estado']);
	$telefone		= $_POST['telefone'];
	$fax			= $_POST['fax'];
	$endereco_cob	= mb_strtoupper($_POST['endereco_cob']);
	$bairro_cob		= mb_strtoupper($_POST['bairro_cob']);
	$cep_cob		= $_POST['cep_cob'];
	$cidade_cob		= mb_strtoupper($_POST['cidade_cob']);
	$estado_cob		= mb_strtoupper($_POST['estado_cob']);
	$desde			= $_POST['desde'];
	$obs			= mb_strtoupper($_POST['obs']);
	$contato		= mb_strtoupper($_POST['contato']);
	$tel_contato   	= $_POST['tel_contato'];
	$ramal			= $_POST['ramal'];
	$dpt			= mb_strtoupper($_POST['dpt']);
	$email			= mb_strtolower($_POST['email']);
	$comissao		= $_POST['comissao'];
	$desc_valor		= fixnumber($_POST['desc_valor']);
	$desc_porcento	= fixnumber($_POST['desc_porcento'])/100;

	if($desc_valor == "")
		$desc_valor = 0;
	if($desc_porcento == "")
		$desc_porcento = 0;
	if($isSave) { 
		$queryUsers = "INSERT INTO CLIENTES (CNPJ, RAZAO, FANTASIA, INSCRICAO, ENDERECO, BAIRRO, CEP, CIDADE, ESTADO, TELEFONE, FAX, ENDERECO_COB, BAIRRO_COB, CEP_COB, CIDADE_COB, ESTADO_COB, DESDE, OBS, desc_valor, desc_porcento) values ('" . $cnpj . "','" . $razao . "','" . $fantasia . "','" . $inscricao . "','" . $endereco . "','" . $bairro . "','" . $cep . "','" . $cidade . "','" . $estado . "','" . $telefone . "','" . $fax . "','" . $endereco_cob . "','" . $bairro_cob . "','" . $cep_cob . "','" . $cidade_cob . "','" . $estado_cob . "','" . $desde . "','" . $obs . "',". $desc_valor .",". $desc_porcento .")";
		$msg = "Incluido com Sucesso!";
	}
	else if($isUpdate > 0) {
		$queryUsers = "UPDATE CLIENTES SET CNPJ = '" . $cnpj . "', RAZAO = '" . $razao . "', FANTASIA = '" . $fantasia . "', INSCRICAO = '" . $inscricao . "', ENDERECO = '" . $endereco . "', BAIRRO = '" . $bairro . "', CEP = '" . $cep . "', CIDADE = '" . $cidade . "', ESTADO = '" . $estado . "', TELEFONE = '" . $telefone . "', FAX = '" . $fax . "', ENDERECO_COB = '" . $endereco_cob . "', BAIRRO_COB = '" . $bairro_cob . "', CEP_COB = '" . $cep_cob . "', CIDADE_COB = '" . $cidade_cob . "', ESTADO_COB = '" . $estado_cob . "', DESDE= '" . $desde . "',OBS = '" . $obs . "', desc_valor  = ". $desc_valor .", desc_porcento = ". $desc_porcento ." WHERE ID = " . $isUpdate;
		$msg = "Atualizado com Sucesso!";
	}
	$queryUsers = str_replace("''","Null",$queryUsers);
	$queryUsers = str_replace(",,",",0,",$queryUsers);
	
	if($siteDebug)
		echo $queryUsers;
	$rsUsers = mysql_query($queryUsers, $pulsar) or die(mysql_error());
	if($isSave) {
		$isEdit = mysql_insert_id();
	}
	else if($isUpdate) {
		$isEdit = $isUpdate;
	}
	
	//'atualizando contatos na tabela de contatos
	$sql = "SELECT ID FROM CONTATOS WHERE ID_CLIENTE = '" . $isEdit . "' ORDER BY ID ASC";
	if($siteDebug)
		echo $sql."<br>";
	$rs = mysql_query($sql, $sig) or die(mysql_error());
	
	while ($row_rs = mysql_fetch_assoc($rs)) {
		$sql = "UPDATE CONTATOS SET CONTATO = '" . mb_strtoupper($_POST['contato'.$row_rs["ID"]]) . "', DPT = '" . mb_strtoupper($_POST['dpt'.$row_rs["ID"]]) . "', TEL_CONTATO = '" . $_POST['tel_contato'.$row_rs["ID"]] . "', RAMAL = '" . $_POST['ramal'.$row_rs["ID"]] . "', EMAIL = '" . mb_strtolower($_POST['email'.$row_rs["ID"]]) . "', COMISSAO = '" . $_POST['comissao'.$row_rs["ID"]] . "' WHERE ID = " . $row_rs["ID"];
		$sql = str_replace("''","Null",$sql);
		$sql = str_replace(",,",",0,",$sql);
			if($siteDebug)
				echo $sql."<br>";
		mysql_query($sql, $sig) or die(mysql_error());
	}
	
	//'inserindo novo contato
	if ($contato != "") {
		$sql = "INSERT INTO CONTATOS(ID_CLIENTE, CONTATO, DPT, EMAIL, TEL_CONTATO, RAMAL, COMISSAO) VALUES(" . $isEdit . ",'" . $contato . "','" . $dpt . "','" . $email . "','" . $tel_contato . "','" . $ramal . "','" . $comissao . "')";
		$sql = str_replace("''","Null",$sql);
		$sql = str_replace(",,",",0,",$sql);
			if($siteDebug)
				echo $sql."<br>";
		mysql_query($sql, $sig) or die(mysql_error());
	}
}
// if($isUpdate > 0) {
// 	$nome = $_POST['name'];
// 	$usuario = $_POST['user'];
// 	$senha = $_POST['password'];
// 	$status = $_POST['status'];
// 	$role = $_POST['role'];
	
// 	$queryUsers = "UPDATE USUARIOS SET nome = '$nome', usuario = '$usuario', senha = '$senha', status='$status', role = $role WHERE id = $isUpdate";
// 	if($siteDebug)
// 		echo $queryUsers;
// 	$rsUsers = mysql_query($queryUsers, $pulsar) or die(mysql_error());
// 	$isEdit = $isUpdate;
// }
if($isEdit>0) {
	$isNew = false;
	$queryUsers = "SELECT ID, CNPJ, RAZAO, FANTASIA, INSCRICAO, ENDERECO, BAIRRO, CEP, CIDADE, ESTADO, TELEFONE, FAX, ENDERECO_COB, BAIRRO_COB, CEP_COB, CIDADE_COB, ESTADO_COB, DESDE, OBS, STATUS, desc_valor, desc_porcento FROM CLIENTES WHERE ID = $isEdit"; 
	if($siteDebug)
		echo $queryUsers;
	$rsUsers = mysql_query($queryUsers, $pulsar) or die(mysql_error());
	$rowUsers = mysql_fetch_assoc($rsUsers);
}
if($isDel > 0) {
	$isNew = false;
	$queryDelUsers = "UPDATE CLIENTES SET STATUS = 'D' WHERE ID = $isDel";
	$rsDelUsers = mysql_query($queryDelUsers, $pulsar) or die(mysql_error());
	if($siteDebug)
		echo $queryDelUsers;
	header("location: clientes.php?msg=Excluido com Sucesso!");
}
if($isAdd > 0) {
	$isNew = false;
	$queryDelUsers = "UPDATE CLIENTES SET STATUS = 'A' WHERE ID = $isAdd";
	$rsDelUsers = mysql_query($queryDelUsers, $pulsar) or die(mysql_error());
	if($siteDebug)
		echo $queryDelUsers;
	header("location: clientes.php?msg=Ativado com sucesso!");
}
if($isDelContato > 0) {
	$sql = "DELETE FROM CONTATOS WHERE ID = $isDelContato";
	if($siteDebug)
		echo $sql."<br>";
	mysql_query($sql, $sig) or die(mysql_error());
	$msg = "Contato excluído com sucesso!";

}
?>