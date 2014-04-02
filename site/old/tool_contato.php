<?php
$fullcc = "lauradml@gmail.com";
$url_ok = "emailsucesso.php?anterior=index.php";

$has_error = false;
$nome_error = false;
$telefone_error = false;
$email_error = false;
$setor_error = false;
$mensagem_error = false;
$submit = false;

$nome = "";
$telefone = "";
$email = "";
$setor = "";
$mensagem = "";

if (isset($_POST['action'])) {
	$submit = true;
	if(($nome = $_POST['nome']) == "") {
		$nome_error = true;
		$nome_error_msg = "O Nome é um campo obrigatório!";
		$has_error = true;
	}
/*	if(($telefone = $_POST['telefone']) == "") {
		$telefone_error = true;
		$telefone_error_msg = "!";
		$has_error = true;
	}*/
	if(($email = $_POST['email']) == "") {
		$email_error = true;
		$email_error_msg = "O Email é um campo obrigatório!";
		$has_error = true;
	}
	if(($setor = $_POST['setor']) == "") {
		/*		$endereco_error = true;
		 $endereco_error_msg = "";
		 $has_error = true;*/
	}
	if(($mensagem = $_POST['mensagem']) == "") {
		/*		$cep_error = true;
		 $cep_error_msg = "!";
		 $has_error = true;*/
	}
}

if($submit) {
	require_once('./lib/recaptchalib.php');
	$privatekey = "6Lcz2dQSAAAAAATeMeFwYH8IHiByAqdkP77RCxd8";
	$resp = recaptcha_check_answer ($privatekey,
			$_SERVER["REMOTE_ADDR"],
			$_POST["recaptcha_challenge_field"],
			$_POST["recaptcha_response_field"]);
	
	if (!$resp->is_valid) {
		$has_error = true;
		$add_script = "<script>alert('Dado de verificação não foi inserido corretamente.');</script>";
		$mensagem = nl2br($mensagem);
		$mensagem = str_replace("\\r\\n", "\r\n", $mensagem);
		
		// What happens when the CAPTCHA was entered incorrectly
	//	die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
	//			"(reCAPTCHA said: " . $resp->error . ")");
	}
}

if(!$has_error && $submit) {
	$mensagem = str_replace("\\r\\n", "\r\n", $mensagem);
	
if($siteDebug) {
  $timeBefore = microtime(true);
}
	
	$insertSQL = sprintf("INSERT INTO contato (nome, email, setor, mensagem, telefone) VALUES (%s, %s, %s, %s, %s)",
	GetSQLValueString($nome, "text"),
	GetSQLValueString($email, "text"),
	GetSQLValueString($setor, "text"),
	GetSQLValueString($mensagem, "text"),
	GetSQLValueString($telefone, "text"));
		
	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

if($siteDebug) {
  $timeAfter = microtime(true);
  $diff = $timeAfter - $timeBefore;
  echo "<strong>insert na base: </strong>".$diff."</strong><br>";
}		

	$to      = $setor;
	$subject = "Contato do website em " . date("d/m/Y") . " às " . date("H:i");
	$mensagem = nl2br($mensagem);
	
	$message = "Nome: " . $nome . "\r\n<br>Email:" . $email .
			"\r\n<br>Setor: " . $setor . "\r\n<br>Telefone: " . $telefone . 
			"\r\n<br>Mensagem: " . $mensagem  ;
	$headers = "Content-Type: text/html; charset=iso-8859-15\n";
	$headers .= "From: ".($nome)." <".($email).">\n";
	$headers .= "bcc: Laura <laura@pulsarimagens.com.br>, ".$fullcc."\n";	
//	$headers .= "bcc: ".$fullcc."\n";
	
if($siteDebug) {
  $timeBefore = microtime(true);
}		
	
	if (strlen($to) < 16) {
		mail($to."@pulsarimagens.com.br",$subject,$message,$headers);
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
		$mail->AddAddress($to."@pulsarimagens.com.br");
		$mail->AddBCC($fullcc);
		$mail->AddReplyTo($row_top_login["email"]);
		
		$mail->IsHTML(true);                                  // set email format to HTML
		
		$mail->Subject = $subject;
		$mail->Body    = $message;
		
		if(!$mail->Send())
		{
			echo "Message could not be sent. <p>";
		}
		
		echo "Message has been sent";
*/		
	}

if($siteDebug) {
  $timeAfter = microtime(true);
  $diff = $timeAfter - $timeBefore;
  echo "<strong>envio do email: </strong>".$diff."</strong><br>";
}		
	
if(!$siteDebug)	
	header("Location: ". $url_ok);
}
?>