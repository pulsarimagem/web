<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>

<?php
$action = "Enviar";
if(isset($_POST['action']))
	$action	= $_POST['action'];
if(isset($_GET['action']))
	$action	= $_GET['action'];

if($action == "Enviar") {
	$id				= $_POST['id'];
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
	
	$isNovo = isset($_POST['novo'])?true:false;
	
	if($isNovo) {
		$sql = "INSERT INTO CLIENTES (CNPJ, RAZAO, FANTASIA, INSCRICAO, ENDERECO, BAIRRO, CEP, CIDADE, ESTADO, TELEFONE, FAX, ENDERECO_COB, BAIRRO_COB, CEP_COB, CIDADE_COB, ESTADO_COB, DESDE, OBS, desc_valor, desc_porcento) values ('" . $cnpj . "','" . $razao . "','" . $fantasia . "','" . $inscricao . "','" . $endereco . "','" . $bairro . "','" . $cep . "','" . $cidade . "','" . $estado . "','" . $telefone . "','" . $fax . "','" . $endereco_cob . "','" . $bairro_cob . "','" . $cep_cob . "','" . $cidade_cob . "','" . $estado_cob . "','" . $desde . "','" . $obs . "',". $desc_valor .",". $desc_porcento .")";		
	}
	else {
		$sql = "UPDATE CLIENTES SET CNPJ = '" . $cnpj . "', RAZAO = '" . $razao . "', FANTASIA = '" . $fantasia . "', INSCRICAO = '" . $inscricao . "', ENDERECO = '" . $endereco . "', BAIRRO = '" . $bairro . "', CEP = '" . $cep . "', CIDADE = '" . $cidade . "', ESTADO = '" . $estado . "', TELEFONE = '" . $telefone . "', FAX = '" . $fax . "', ENDERECO_COB = '" . $endereco_cob . "', BAIRRO_COB = '" . $bairro_cob . "', CEP_COB = '" . $cep_cob . "', CIDADE_COB = '" . $cidade_cob . "', ESTADO_COB = '" . $estado_cob . "', DESDE= '" . $desde . "',OBS = '" . $obs . "', desc_valor  = ". $desc_valor .", desc_porcento = ". $desc_porcento ." WHERE ID = " . $id;
	}
	echo $sql."<br>";
	$sql = str_replace("''","Null",$sql);
	$sql = str_replace(",,",",0,",$sql);
	
	mysql_query($sql, $sig) or die(mysql_error());
	if($isNovo) {
		$id = mysql_insert_id($sig);
	}
	
	//'atualizando contatos na tabela de contatos
	$sql = "SELECT ID FROM CONTATOS WHERE ID_CLIENTE = '" . $id . "' ORDER BY ID ASC";
	echo $sql."<br>";
	$rs = mysql_query($sql, $sig) or die(mysql_error());
	
	while ($row_rs = mysql_fetch_assoc($rs)) {
		$sql = "UPDATE CONTATOS SET CONTATO = '" . mb_strtoupper($_POST['contato'.$row_rs["ID"]]) . "', DPT = '" . mb_strtoupper($_POST['dpt'.$row_rs["ID"]]) . "', TEL_CONTATO = '" . $_POST['tel_contato'.$row_rs["ID"]] . "', RAMAL = '" . $_POST['ramal'.$row_rs["ID"]] . "', EMAIL = '" . mb_strtolower($_POST['email'.$row_rs["ID"]]) . "', COMISSAO = '" . $_POST['comissao'.$row_rs["ID"]] . "' WHERE ID = " . $row_rs["ID"];
		$sql = str_replace("''","Null",$sql);
		$sql = str_replace(",,",",0,",$sql);
	echo $sql."<br>";
		mysql_query($sql, $sig) or die(mysql_error());
	}
	
	//'inserindo novo contato
	if ($contato != "") {
		$sql = "INSERT INTO CONTATOS(ID_CLIENTE, CONTATO, DPT, EMAIL, TEL_CONTATO, RAMAL, COMISSAO) VALUES(" . $id . ",'" . $contato . "','" . $dpt . "','" . $email . "','" . $tel_contato . "','" . $ramal . "','" . $comissao . "')";
		$sql = str_replace("''","Null",$sql);
		$sql = str_replace(",,",",0,",$sql);
	echo $sql."<br>";
		mysql_query($sql, $sig) or die(mysql_error());
	}
	
	/*
	//'atualizando informações na tabela de clientes
	$sql = "UPDATE CLIENTES SET CNPJ = '" . $cnpj . "', RAZAO = '" . $razao . "', FANTASIA = '" . $fantasia . "', INSCRICAO = '" . $inscricao . "', ENDERECO = '" . $endereco . "', BAIRRO = '" . $bairro . "', CEP = '" . $cep . "', CIDADE = '" . $cidade . "', ESTADO = '" . $estado . "', TELEFONE = '" . $telefone . "', FAX = '" . $fax . "', ENDERECO_COB = '" . $endereco_cob . "', BAIRRO_COB = '" . $bairro_cob . "', CEP_COB = '" . $cep_cob . "', CIDADE_COB = '" . $cidade_cob . "', ESTADO_COB = '" . $estado_cob . "', DESDE= '" . $desde . "',OBS = '" . $obs . "' WHERE ID = " . $id;
	$sql = str_replace("''","Null",$sql);
	$sql = str_replace(",,",",0,",$sql);
	mysql_query($sql, $sig) or die(mysql_error());
	
	*/
}
else if ($action == "excluir_contato") {
	$id_contato = $_GET['id_contato'];
	$id = $_GET['id'];

	$sql = "DELETE FROM CONTATOS WHERE ID = $id_contato";
	$sql = str_replace("''","Null",$sql);
	$sql = str_replace(",,",",0,",$sql);
	echo $sql."<br>";
	mysql_query($sql, $sig) or die(mysql_error());
}
header("location: consulta_cliente.php?id_cliente=" . $id . "&mens=<< cadastro atualizado com sucesso >>");

?>

<?php //'fechar e eliminar todos os objetos recordset e os objetos de conexão?>