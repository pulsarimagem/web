<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php
$action = "Enviar";
if(isset($_POST['action']))
	$action	= $_POST['action'];
if(isset($_GET['action']))
	$action	= $_GET['action'];

if($action == "Enviar") {
	//'Capturando os valores passados pela tela anterior
	$id = $_POST["id"];
	$nome = mb_strtoupper($_POST["nome"]);
	$nome_completo = mb_strtoupper($_POST["nome_completo"]);
	$sigla = mb_strtoupper($_POST["sigla"]);
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
	
	$isNovo = isset($_POST['novo'])?true:false;
	
	if($isNovo) {
		$strSQL = " SELECT NOME, SIGLA FROM AUTORES_OFC WHERE SIGLA = '".$sigla."'";
		echo $strSQL."<br>";
		$result = mysql_query($strSQL, $sig) or die(mysql_error());
		
		if($objRS = mysql_fetch_array($result)) {
				header("location: edita_autor.php?mens=Autor |".$objRS["NOME"]." | já cadastrado com a sigla | ".$sigla." |. Cadastro não efetuado.");
		} 
	}
	if($isNovo) {
		$strSQL = " INSERT INTO AUTORES_OFC (NOME, SIGLA, NOME_COMPLETO, CPF, CNPJ, ENDERECO, BAIRRO, CIDADE, ESTADO, CEP, ZIPCODE, TELEFONE, CELULAR, EMAIL, COMISSAO, OBS, BANCO, AGENCIA, CONTA) VALUES (' ".$nome."' , '".$sigla."' , '".$nome_completo."' , '".$cpf."' , '".$cnpj."' , '".$edc."' , '".$bairro."' , '".$cid."' , '".$est."' , '".$cep."' , '".$zip ."' , '".$tel."' , '".$cel."' , '".$email."' , '".$com."' , '".$obs."' , '".$bco ."' , '".$ag."' , '".$cc."' )";
	}
	else {
		$strSQL = "UPDATE AUTORES_OFC SET NOME='".$nome."', NOME_COMPLETO='".$nome_completo."', SIGLA='".$sigla."',CPF='".$cpf."', CNPJ='".$cnpj."', ZIPCODE='".$zip."',COMISSAO='".$com."',ENDERECO='".$edc."',BAIRRO='".$bairro."',CEP='".$cep."',CIDADE='".$cid."',ESTADO='".$est."',TELEFONE='".$tel."',CELULAR='".$cel."',EMAIL='".$email."',OBS='".$obs."',BANCO='".$bco."',AGENCIA='".$ag."',CONTA='".$cc."' where ID='".$id."'";
	}
	$strSQL = str_replace("''","Null",$strSQL);
	$strSQL = str_replace(",,",",0,",$strSQL);
	
	echo $strSQL."<br>";
	
	mysql_query($strSQL, $sig) or die(mysql_error());
	if($isNovo) {
		$id = mysql_insert_id($sig);
	}	
	header("location: edita_autor.php?id=$id&mens=<< Cadastro atualizado com sucesso >>");
}
else if ($action == "excluir") {
	$id = $_GET['id'];
	$sql = "UPDATE AUTORES_OFC SET STATUS = 'I' WHERE id='".$id."'";
	echo $sql."<br>";
	mysql_query($sql, $sig) or die(mysql_error());
	header("location: consulta_autor.asp?mens= << autor: ".$nome." sigla: ".$sigla." excluído com sucesso >>");
}
?>

