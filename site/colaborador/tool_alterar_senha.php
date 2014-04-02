<?php
$url_ok = "menu.php";

$has_error = false;
$login_error = false;
$senha_error = false;
$nova_senha_error = false;
$nova_senha2_error = false;
$email_error = false;
$submit = false;

mysql_select_db($database_pulsar, $pulsar);
$query_cadastro = sprintf("SELECT * FROM fotografos WHERE Iniciais_Fotografo='%s'", $row_top_login['Iniciais_Fotografo']);
$cadastro = mysql_query($query_cadastro, $pulsar) or die(mysql_error());
$row_cadastro = mysql_fetch_assoc($cadastro);
$totalRows_cadastro = mysql_num_rows($cadastro);


$login = $row_cadastro['Iniciais_Fotografo'];
$senha = $row_cadastro['senha'];
$nova_senha = "";
$nova_senha2 = "";
$email = $row_cadastro['email'];

$first = false;
if(isset($_GET['first']) || isset($_POST['first'])) {
	$first = true;
}

if (isset($_POST['action'])) {
	$submit = true;
	if(($login = $_POST['login']) == "") {
		$login_error = true;
		$msg = $login_error_msg = "O Login é um campo obrigatório!";
		$has_error = true;
	}
// 	if(($senha = $_POST['senha']) == "") {
// 		$senha_error = true;
// 		$msg = $senha_error_msg = "A Senha é um campo obrigatório!";
// 		$has_error = true;
// 	}
	if(($nova_senha = $_POST['nova_senha']) == "") {
		$nova_senha_error = true;
		$msg = $nova_senha_error_msg = "A Nova Senha é um campo obrigatório!";
		$has_error = true;
	}
	if(($email = $_POST['email']) == "") {
		$email_error = true;
		$msg = "O endereço de email é um campo obrigatório!";
		$has_error = true;
	}
/*	if(($nova_senha2 = $_POST['nova_senha2']) == "") {
		$nova_senha2_error = true;
		$msg = $nova_senha2_error_msg = "A Nova Senha é um campo obrigatório!";
		$has_error = true;
	}*/
/*	if($_POST['nova_senha'] != $_POST['nova_senha2']) {
		$nova_senha_error = true;
		$msg = $nova_senha_error_msg = "As senhas digitadas não conferem, favor digitar novamente.";
		$nova_senha2_error = true;
		$nova_senha2_error_msg = "As senhas digitadas não conferem, favor digitar novamente.";
		$has_error = true;
		$nova_senha = "";
		$nova_senha2 = "";
	}*/
}

if(!$has_error && $submit) {
	$loginUsername=$login;
	$password=$senha;
	$MM_fldUserAuthorization = "tipo";
	$MM_redirectLoginSuccess = $_SESSION['last_uri'];
	$MM_redirectLoginFailed = "login.php";
	$MM_redirecttoReferrer = false;
	mysql_select_db($database_pulsar, $pulsar);
	 
  	$LoginRS__query=sprintf("SELECT Iniciais_Fotografo FROM fotografos WHERE Iniciais_Fotografo='%s'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername)); 
		 
	$LoginRS = mysql_query($LoginRS__query, $pulsar) or die(mysql_error());
	$loginDataUser = mysql_fetch_assoc($LoginRS);
	$loginFoundUser = mysql_num_rows($LoginRS);
	if ($loginFoundUser) {
// 	  	$LoginRS__query=sprintf("SELECT * FROM fotografos WHERE Iniciais_Fotografo='%s' AND senha='%s'",
//     	get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
		    	
// 		$LoginRS = mysql_query($LoginRS__query, $pulsar) or die(mysql_error());
// 		$loginDataUser = mysql_fetch_assoc($LoginRS);
// 		$loginFoundPass = mysql_num_rows($LoginRS);
		$loginFoundPass = true;
		if ($loginFoundPass) {
			
			$updateSQL = sprintf("UPDATE fotografos SET senha=%s, email=%s, trocar_senha=0 WHERE Iniciais_Fotografo=%s",
                       GetSQLValueString($_POST['nova_senha'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
					   GetSQLValueString($loginUsername, "text"));

			mysql_select_db($database_pulsar, $pulsar);
			$Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());
			 
			$data = file_get_contents($cloud_server.'create_ftp_user.php?user='.$loginUsername.'&pass='.$_POST['nova_senha'].'&change=true');
			
			$ok_msg = "Senha alterada com sucesso!";
			$msg = $ok_msg;
			if($first) {
				header("Location: menu.php");
			}
		}
		else {
			$has_error = true;
			$senha_error = true;
			$senha_error_msg = "Senha incorreta!";
		}
	}
	else {
		$has_error = true;
		$login_error = true;
		$login_error_msg = "Usuário não encontrado!";
	}
}

if($has_error) {
	if(isset($_SESSION['last_uri'])) {
		$_SESSION['this_uri'] = $_SESSION['last_uri'];
	}
}
?>