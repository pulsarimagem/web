<?php
if($logged) {
	header("Location: dadoscadastrais.php"); 
}
$fullcc = "lauradml@gmail.com";

$url_ok = "cadastro_ok.php";

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

$nome = "";
$empresa = "";
$cpf = "";
$cnpj = "";
$endereco = "";
$cep = "";
$cidade = "";
$estados = "";
$paises = "";
$telefone = "";
$email = "";
$email2 = "";
$login = "";
$senha = "";
$senha2 = "";
$newsletter = "";
$deacordo = "";

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
		$nome_error_msg = CADASTRO_NOME_ERROR;
		$has_error = true;
	}
	if($pf) {
		if(($cpf = $_POST['cpf']) == "") {
			if($lingua == "br") { 
				$cpf_error = true;
				$cpf_error_msg = CADASTRO_CPF_ERROR;
				$has_error = true;
			}
		}
	}
	if($pj) {
		if(($empresa = $_POST['empresa']) == "") {
			$empresa_error = true;
			$empresa_error_msg = CADASTRO_CNPJ_ERROR;
			$has_error = true;
		}
		if(($cnpj = $_POST['cnpj']) == "") {
			if($lingua == "br") { 
				$cnpj_error = true;
				$cnpj_error_msg = CADASTRO_CNPJ_INVALIDO;
				$has_error = true;
			}
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
		$email_error_msg = CADASTRO_EMAIL_ERROR;
		$has_error = true;
	}
	if(($email2 = $_POST['email2']) == "") {
		$email2_error = true;
		$email2_error_msg = CADASTRO_EMAIL_CONFIRM;
		$has_error = true;
	}
	if($_POST['email'] != $_POST['email2']) {
		$email_error = true;
		$email_error_msg = CADASTRO_EMAIL_DIFF;
		$email2_error = true;
		$email2_error_msg = CADASTRO_EMAIL_DIFF;
		$has_error = true;
		$email = "";
		$email2 = "";
	}
	if(($login = $_POST['login']) == "") {
		if(!$email_error && !$email2_error) {
			$login = $email;
		}
		else {
			$login_error = true;
			$login_error_msg = CADASTRO_LOGIN_ERROR;
			$has_error = true;
		}
	}
	
	$sql = "SELECT login FROM cadastro WHERE login = '$login'";
	$result = mysql_query($sql, $pulsar);
	if($row = mysql_fetch_array($result)) {
		$login_error = true;
		$login_error_msg = CADASTRO_DUP_LOGIN_ERROR;
		$has_error = true;
		if($login == $email) {
			$email_error = true;
			$email_error_msg = CADASTRO_DUP_EMAIL_ERROR;
			$email2_error = true;
			$email2_error_msg = CADASTRO_DUP_EMAIL_ERROR;
			$has_error = true;
		}
	}
	
	if(($senha = $_POST['senha']) == "") {
		$senha_error = true;
		$senha_error_msg = CADASTRO_SENHA_ERROR;
		$has_error = true;
	}
	if(($senha2 = $_POST['senha2']) == "") {
		$senha2_error = true;
		$senha2_error_msg = CADASTRO_SENHA2_ERROR;
		$has_error = true;
	}
	if($_POST['senha'] != $_POST['senha2']) {
		$senha_error = true;
		$senha_error_msg = CADASTRO_SENHA_DIFF;
		$senha2_error = true;
		$senha2_error_msg = CADASTRO_SENHA_DIFF;
		$has_error = true;
		$senha = "";
		$senha2 = "";
	}
	if(!isset($_POST['deacordo'])) {
		$declaro_error = true;
		//		$declaro_error_msg = "!";
		$has_error = true;
		$deacordo = "";
	}
	else
	$deacordo = "checked";

	if(isset($_POST['newsletter'])) {
		$newsletter = true;
		$tipo = "Padr�o";
		if(isset($_POST['tipo'])) {
			$tipo = $_POST['tipo'];
		}
	}
	else {
		$newsletter = false;
	}
}

if(!$has_error && $submit) {
	
	$_SESSION['show_welcome'] = true;
	$_SESSION['PrevUrl'] = $url_ok;
	$url_ok = "login.php?login=".$login."&senha=".$senha."";
	
	if($newsletter) {
		$fullcc = "";
		if($lingua!="br") {
			$fullcc .= ", saulo@pulsarimagens.com.br, icaro@pulsarimagens.com.br";
		}
		$to      = "pulsarimagensltda@gmail.com";//$laura;
		$subject = "[Newsletter] Pedido de inscri��o no Newsletter $lingua em " . date("d/m/Y") . " �s " . date("H:i");
		$message = "Email:" . $email . "\r\n<br>
				Newsletter: " . $tipo  ;
		$headers = "Content-Type: text/html; charset=iso-8859-15\n";
// 		$headers .= "From: <".($email).">\n";
		$headers .= "From: <pulsarimagensltda@gmail.com>\n";
		if (strlen($to) < 16) {
			mail($to.$fullcc,$subject,$message,$headers);
		}
	}
		
	if($pf){

		$data = " now() ";

		$insertSQL = sprintf("INSERT INTO cadastro (nome, cpf_cnpj, endereco, cep, cidade, telefone, email, login, senha, tipo, estado, pais, idioma, data_cadastro) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
		GetSQLValueString($_POST['nome'], "text"),
		GetSQLValueString($_POST['cpf'], "text"),
		GetSQLValueString($_POST['endereco'], "text"),
		GetSQLValueString($_POST['cep'], "text"),
		GetSQLValueString($_POST['cidade'], "text"),
		GetSQLValueString($_POST['telefone'], "text"),
		GetSQLValueString($_POST['email'], "text"),
		GetSQLValueString($login, "text"),
		GetSQLValueString($_POST['senha'], "text"),
		GetSQLValueString($_POST['tipo'], "text"),
		GetSQLValueString($_POST['estados'], "text"),
		GetSQLValueString($_POST['paises'], "text"),
		GetSQLValueString($lingua, "text"),
		$data   );
			
		mysql_select_db($database_pulsar, $pulsar);
		$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

		$to      = $_POST['email'] . "\n";
		$subject = "www.pulsarimagens.com.br - seu cadastro no website\n";
		include('email_cadastro_pf.php');

		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: Pulsar Imagens <pulsar@pulsarimagens.com.br>\n";
		$headers .= "Return-Path: Pulsar Imagens <pulsar@pulsarimagens.com.br>\n";
		$headers .= "bcc: pulsarimagensltda@gmail.com, ".$fullcc."\n";
//		$headers .= "bcc: ".$fullcc."\n";
		
		mail($to,$subject,$message,$headers);
/*
		require("class.phpmailer.php");
		
		$mail = new PHPMailer();
		
		$mail->IsSMTP();
		$mail->SMTPDebug = 1;                                      // set mailer to use SMTP
		$mail->Host = "mail.email.alog.com.br";  // specify main and backup server
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Username = "contato@pulsarimagens.com.br";  // SMTP username
		$mail->Password = "123qwe!!"; // SMTP password
		
		$mail->From = "contato@pulsarimagens.com.br";
		$mail->FromName = "Pulsar Imagens";
		$mail->AddAddress($_POST['email']);
		$mail->AddBCC($fullcc);
		$mail->AddReplyTo("pulsar@pulsarimagens.com.br", "Pulsar Imagens");
		
		$mail->IsHTML(true);                                  // set email format to HTML
		
		$mail->Subject = $subject;
		$mail->Body    = $message;
		
		if(!$mail->Send())
		{
			echo "Message could not be sent. <p>";
		}
		
		echo "Message has been sent";
		
*/
		header("Location: ". $url_ok); 
	}
	else if($pj) {
		$data = " now() ";

		$insertSQL = sprintf("INSERT INTO cadastro (nome, empresa, cpf_cnpj, endereco, cep, cidade, telefone, email, login, senha, tipo, estado, pais, idioma, data_cadastro) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
		GetSQLValueString($_POST['nome'], "text"),
		GetSQLValueString($_POST['empresa'], "text"),
//		GetSQLValueString($_POST['cargo'], "text"),
		GetSQLValueString($_POST['cnpj'], "text"),
		GetSQLValueString($_POST['endereco'], "text"),
		GetSQLValueString($_POST['cep'], "text"),
		GetSQLValueString($_POST['cidade'], "text"),
		GetSQLValueString($_POST['telefone'], "text"),
		GetSQLValueString($_POST['email'], "text"),
		GetSQLValueString($login, "text"),
		GetSQLValueString($_POST['senha'], "text"),
		GetSQLValueString($_POST['tipo'], "text"),
		GetSQLValueString($_POST['estados'], "text"),
		GetSQLValueString($_POST['paises'], "text"),
		GetSQLValueString($lingua, "text"),
		$data);

		mysql_select_db($database_pulsar, $pulsar);
		$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

		$to      = $_POST['email'];
		$subject = "www.pulsarimagens.com.br - seu cadastro no website";
		include('email_cadastro_pj.php');
		
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: Pulsar Imagens <pulsar@pulsarimagens.com.br>\n";
		$headers .= "Return-Path: Pulsar Imagens <pulsar@pulsarimagens.com.br>\n";
//		$headers .= "bcc: Laura <laura@pulsarimagens.com.br>, ".$fullcc."\n";
		$headers .= "bcc: ".$fullcc."\n";
		
		mail($to,$subject,$message,$headers);
			
		header("Location: ". $url_ok); 
	}
}
?>