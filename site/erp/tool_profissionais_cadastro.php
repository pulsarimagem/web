<?php
mysql_select_db($database_pulsar, $pulsar);
mysql_select_db($database_sig, $sig);

$isNew = true;
$isEdit = isset($_GET['idUser'])?$_GET['idUser']:-1;
$isUpdate = isset($_POST['updateUser'])?$_POST['updateUser']:-1;
$isSave = isset($_POST['saveUser'])?true:false;
$isDel = isset($_GET['delUser'])?$_GET['delUser']:-1;
$isDelContato = isset($_GET['delContato'])?$_GET['delContato']:-1;


if($isSave || $isUpdate > 0) {
	$id	= $isUpdate;
	$nome = trim(mb_strtoupper($_POST["nome"]));
	$nome_completo = trim(mb_strtoupper($_POST["nome_completo"]));
	$sigla = trim(mb_strtoupper($_POST["sigla"]));
	$senha = $_POST["senha"];
	$cpf = $_POST["cpf"];
	$cnpj = $_POST["cnpj"];
	$zip = $_POST["zip"];
	$com = $_POST["com"];
	$edc = mb_strtoupper($_POST["edc"]);
	$bairro = mb_strtoupper($_POST["bairro"]);
	$cep = $_POST["cep"];
	$cid = mb_strtoupper($_POST["cid"]);
	//'response.Write(cid);
	//'response.End();
	$est = mb_strtoupper($_POST["est"]);
	$tel = $_POST["tel"];
	$cel = $_POST["cel"];
	$email = mb_strtolower($_POST["email"]);
	$obs = mb_strtoupper($_POST["obs"]);
	$bco = $_POST["bco"];
	$ag 	= $_POST["ag"];
	$cc 	= $_POST["cc"];
	
	if($isSave) { 
		$queryUsers = "INSERT INTO AUTORES_OFC (NOME, SIGLA, NOME_COMPLETO, CPF, CNPJ, ENDERECO, BAIRRO, CIDADE, ESTADO, CEP, ZIPCODE, TELEFONE, CELULAR, EMAIL, COMISSAO, OBS, BANCO, AGENCIA, CONTA) VALUES ('".$nome."' , '".$sigla."' , '".$nome_completo."' , '".$cpf."' , '".$cnpj."' , '".$edc."' , '".$bairro."' , '".$cid."' , '".$est."' , '".$cep."' , '".$zip ."' , '".$tel."' , '".$cel."' , '".$email."' , '".$com."' , '".$obs."' , '".$bco ."' , '".$ag."' , '".$cc."' )";
		$queryUsers2 = "INSERT INTO $database_pulsar.fotografos (Nome_Fotografo, Iniciais_Fotografo, senha, trocar_senha, email) VALUES ('".ucwords(strtolower($nome))."' , '".$sigla."' , '".$senha."' , '1' , '".$email."')";
		$data = file_get_contents($cloud_server."create_ftp_user.php?user=$sigla&pass=$senha");
		
		$msg = "Incluido com Sucesso!";
	}
	else if($isUpdate > 0) {
		$queryUsers = "UPDATE AUTORES_OFC SET NOME='".$nome."', NOME_COMPLETO='".$nome_completo."', SIGLA='".$sigla."',CPF='".$cpf."', CNPJ='".$cnpj."', ZIPCODE='".$zip."',COMISSAO='".$com."',ENDERECO='".$edc."',BAIRRO='".$bairro."',CEP='".$cep."',CIDADE='".$cid."',ESTADO='".$est."',TELEFONE='".$tel."',CELULAR='".$cel."',EMAIL='".$email."',OBS='".$obs."',BANCO='".$bco."',AGENCIA='".$ag."',CONTA='".$cc."' where ID='".$id."'";
		$queryUsers2 = "UPDATE $database_pulsar.fotografos SET Nome_Fotografo='".ucwords(strtolower($nome))."', Iniciais_Fotografo='".$sigla."',senha='".$senha."', email='".$email."' WHERE Iniciais_Fotografo='".$sigla."'";
		$data = file_get_contents($cloud_server."create_ftp_user.php?user=$sigla&pass=$senha&change=true");
		$msg = "Atualizado com Sucesso!";
	}
	$sql = str_replace("''","Null",$queryUsers);
	$sql = str_replace(",,",",0,",$queryUsers);
	$sql = str_replace("''","Null",$queryUsers2);
	$sql = str_replace(",,",",0,",$queryUsers2);
	
	if($siteDebug) {
		echo $queryUsers;
		echo $queryUsers2;
	}
	$rsUsers = mysql_query($queryUsers, $pulsar) or die(mysql_error());
	if($isSave) {
		$isEdit = mysql_insert_id();
	}
	else if($isUpdate) {
		$isEdit = $isUpdate;
	}
	$rsUsers = mysql_query($queryUsers2, $pulsar) or die(mysql_error());
}
if($isEdit>0) {
	$isNew = false;
	$queryUsers = "SELECT * FROM AUTORES_OFC LEFT JOIN $database_pulsar.fotografos ON $database_pulsar.fotografos.Iniciais_Fotografo = AUTORES_OFC.SIGLA WHERE ID = $isEdit"; 
	if($siteDebug)
		echo $queryUsers;
	$rsUsers = mysql_query($queryUsers, $pulsar) or die(mysql_error());
	$rowUsers = mysql_fetch_assoc($rsUsers);
}
if($isDel > 0) {
	$isNew = false;
	$queryDelUsers = "UPDATE AUTORES_OFC SET STATUS = 'D' WHERE ID = $isDel";
	$rsDelUsers = mysql_query($queryDelUsers, $pulsar) or die(mysql_error());
	if($siteDebug)
		echo $queryDelUsers;
	header("location: profissionais.php?msg=Excluido com Sucesso!");
}
?>