<?php

$url_ok = "primeirapagina.php?msg=cadastro";

$has_error = false;
$nome_error = false;
$empresa_error = false;
$cpf_error = false;
$cnpj_error = false;
$endereco_error = false;
$cep_error = false;
$cidade_error = false;
$estados_error = false;
$paises_error = false;
$telefone_error = false;
$email_error = false;
$email2_error = false;
$login_error = false;
$senha_error = false;
$senha2_error = false;
$declaro_error = false;
$pf = true;
$pj = false;
$submit = false;


mysql_select_db($database_pulsar, $pulsar);
$query_cadastro = sprintf("SELECT * FROM cadastro WHERE id_cadastro = %s", $row_top_login['id_cadastro']);
$cadastro = mysql_query($query_cadastro, $pulsar) or die(mysql_error());
$row_cadastro = mysql_fetch_assoc($cadastro);
$totalRows_cadastro = mysql_num_rows($cadastro);

$type = $row_cadastro['tipo'];
 
$nome = $row_cadastro['nome'];
$empresa = $row_cadastro['empresa'];
$cpf = $row_cadastro['cpf_cnpj'];
$cnpj = $row_cadastro['cpf_cnpj'];
$endereco = $row_cadastro['endereco'];
$cep = $row_cadastro['cep'];
$cidade = $row_cadastro['cidade'];
$estados = $row_cadastro['estado'];
$paises = $row_cadastro['pais'];
$telefone = $row_cadastro['telefone'];
$email = $row_cadastro['email'];
$email2 = $row_cadastro['email'];
$login = $row_cadastro['login'];
$senha = $row_cadastro['senha'];
$senha2 = $row_cadastro['senha'];

if (isset($_POST['action'])) {
	$submit = true;
	if($_POST['type'] == "PF") {
		$type = "F";
		$pf = true;
		$pj = false;
	}
	if($_POST['type'] == "PJ") {
		$type = "J";
		$pf = false;
		$pj = true;
	}

	if(($nome = $_POST['nome']) == "") {
		$nome_error = true;
		$nome_error_msg = "O Nome й um campo obrigatуrio!";
		$has_error = true;
	}
	if($pf) {
		if(($cpf = $_POST['cpf']) == "") {
			$cpf_error = true;
			$cpf_error_msg = "O CPF digitado nгo й vбlido!";
			$has_error = true;
		}
	}
	if($pj) {
		if(($empresa = $_POST['empresa']) == "") {
			$empresa_error = true;
			$empresa_error_msg = "A Razгo Social й um campo obrigatуrio!";
			$has_error = true;
		}
		if(($cnpj = $_POST['cnpj']) == "") {
			$cnpj_error = true;
			$cnpj_error_msg = "O CNPJ digitado nгo й vбlido!";
			$has_error = true;
		}
	}
	if(($endereco = $_POST['endereco']) == "") {
		/*		$endereco_error = true;
		 $endereco_error_msg = "";
		 $has_error = true;*/
	}
	if(($cep = $_POST['cep']) == "") {
		/*		$cep_error = true;
		 $cep_error_msg = "!";
		 $has_error = true;*/
	}
	if(($cidade = $_POST['cidade']) == "") {
		/*		$cidade_error = true;
		 $_msg = "!";
		 $has_error = true;*/
	}
	if(($estados = $_POST['estados']) == "") {
		/*		$estados_error = true;
		 $estados_error_msg = "!";
		 $has_error = true;*/
	}
	if(($paises = $_POST['paises']) == "") {
		/*		$paises_error = true;
		 $paises_error_msg = "!";
		 $has_error = true;*/
	}
	if(($telefone = $_POST['telefone']) == "") {
		/*		$telefone_error = true;
		 $telefone_error_msg = "!";
		 $has_error = true;*/
	}
	if(($email = $_POST['email']) == "") {
		$email_error = true;
		$email_error_msg = "O Email й um campo obrigatуrio!";
		$has_error = true;
	}
	if(($email2 = $_POST['email2']) == "") {
		$email2_error = true;
		$email2_error_msg = "Informe a Confirmaзгo de Email!";
		$has_error = true;
	}
	if($_POST['email'] != $_POST['email2']) {
		$email_error = true;
		$email_error_msg = "Os emails digitados nгo conferem, favor digitar novamente.";
		$email2_error = true;
		$email2_error_msg = "Os emails digitados nгo conferem, favor digitar novamente.";
		$has_error = true;
		$email = "";
		$email2 = "";
	}
	if(($login = $_POST['login']) == "") {
		$login_error = true;
		$login_error_msg = "Digite o Login do usuбrio.";
		$has_error = true;
	}
	if(($senha = $_POST['senha']) == "") {
		$senha_error = true;
		$senha_error_msg = "Informe a Senha!";
		$has_error = true;
	}
	if(($senha2 = $_POST['senha2']) == "") {
		$senha2_error = true;
		$senha2_error_msg = "Informe a Confirmaзгo de Senha!";
		$has_error = true;
	}
	if($_POST['senha'] != $_POST['senha2']) {
		$senha_error = true;
		$senha_error_msg = "As senhas digitadas nгo conferem, favor digitar novamente.";
		$senha2_error = true;
		$senha2_error_msg = "As senhas digitadas nгo conferem, favor digitar novamente.";
		$has_error = true;
		$senha = "";
		$senha2 = "";
	}
	if(isset($_POST['newsletter']))
		$newsletter = "checked";
	else
		$newsletter = "";
}

if(!$has_error && $submit) {
	if($pf){

  $updateSQL = sprintf("UPDATE cadastro SET nome=%s, cpf_cnpj=%s, endereco=%s, cep=%s, cidade=%s, estado=%s, pais=%s, telefone=%s, email=%s, login=%s, senha=%s WHERE id_cadastro=%s",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['cpf'], "text"),
                       GetSQLValueString($_POST['endereco'], "text"),
                       GetSQLValueString($_POST['cep'], "text"),
                       GetSQLValueString($_POST['cidade'], "text"),
                       GetSQLValueString($_POST['estados'], "text"),
                       GetSQLValueString($_POST['paises'], "text"),
                       GetSQLValueString($_POST['telefone'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($_POST['id_cadastro'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());
		header("Location: ". $url_ok); 
	}
	else if($pj) {
  $updateSQL = sprintf("UPDATE cadastro SET nome=%s, empresa=%s, cpf_cnpj=%s, endereco=%s, cep=%s, cidade=%s, estado=%s, pais=%s, telefone=%s, email=%s, login=%s, senha=%s WHERE id_cadastro=%s",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['empresa'], "text"),
//                       GetSQLValueString($_POST['cargo'], "text"),
                       GetSQLValueString($_POST['cpf'], "text"),
                       GetSQLValueString($_POST['endereco'], "text"),
                       GetSQLValueString($_POST['cep'], "text"),
                       GetSQLValueString($_POST['cidade'], "text"),
                       GetSQLValueString($_POST['estados'], "text"),
                       GetSQLValueString($_POST['paises'], "text"),
                       GetSQLValueString($_POST['telefone'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($_POST['id_cadastro'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());
		
			
		header("Location: ". $url_ok); 
	}
}
?>