<?php
$fullcc = "lauradml@gmail.com";
$url_ok = "emailsucesso.php?anterior=primeirapagina.php";

$has_error = false;
$email_error = false;
$assunto_error = false;
$mensagem_error = false;
$submit = false;

$email = "";
$mensagem = "";
$assunto = "";

if (isset($_GET['action'])) {
	$submit = true;
	if(($email = $_GET['email']) == "") {
		$email_error = true;
		$email_error_msg = "O Email é um campo obrigatório!";
		$has_error = true;
	}
	if(($mensagem = $_GET['mensagem']) == "") {
		$mensagem_error = true;
		$mensagem_error_msg = "A Mensagem é um campo obrigatório!";
		$has_error = true;
	}
	if(($assunto = $_GET['assunto']) == "") {
		$assunto_error = true;
		$assunto_error_msg = "O Assunto é um campo obrigatório!";
		$has_error = true;
	}
}
if (isset($_GET['id_pasta'])) {
	mysql_select_db($database_pulsar, $pulsar);
	$query_pastas = sprintf("SELECT pastas.id_pasta,   pastas.id_cadastro,   pastas.nome_pasta,   pastas.data_cria,   pastas.data_mod,   cadastro.login,   pasta_fotos.tombo,   count(pasta_fotos.tombo) as num_fotos FROM cadastro  INNER JOIN pastas ON (cadastro.id_cadastro=pastas.id_cadastro) LEFT JOIN pasta_fotos ON (pasta_fotos.id_pasta=pastas.id_pasta) WHERE (pastas.id_pasta LIKE '%s') GROUP BY pastas.id_pasta ORDER BY pastas.nome_pasta", $_GET['id_pasta']);
	$pastas = mysql_query($query_pastas, $pulsar) or die(mysql_error());
	$row_pastas = mysql_fetch_assoc($pastas);
	$totalRows_pastas = mysql_num_rows($pastas);
}

if(!$has_error && $submit) {
	$colname_fotos = "01";
	if (isset($_GET['id_pasta'])) {
		$colname_fotos = (get_magic_quotes_gpc()) ? $_GET['id_pasta'] : addslashes($_GET['id_pasta']);
	}
	mysql_select_db($database_pulsar, $pulsar);
	$query_fotos = sprintf("SELECT DISTINCT tombo FROM pasta_fotos WHERE id_pasta IN (%s)", $colname_fotos);
	$fotos = mysql_query($query_fotos, $pulsar) or die(mysql_error());
	$row_fotos = mysql_fetch_assoc($fotos);
	$totalRows_fotos = mysql_num_rows($fotos);

	$nome = $row_top_login["nome"];
	$remetente = $row_top_login["email"];
	$mensagem = str_replace("\\r\\n", "\r\n", $mensagem);
	
	$insertSQL = "
	INSERT INTO email (nome, email, destino, copia, assunto, texto, data_hora)
	VALUES ('".($nome)."', '".($remetente)."', '".$email."', '', '".$assunto."', '".$mensagem."', now())
	";
	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
	$email_id = mysql_insert_id();

	$salvar_log = true;
	
	$to      = $email . "\n";
	$subject = $assunto . "\n";
	$mensagem = nl2br($mensagem);
		
	include('email_enviarpastaemail.php');

	$headers = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "From: ".($row_top_login["nome"])." <".($row_top_login["email"]).">\n";
	$headers .= "Return-Path: ".($row_top_login["nome"])." <".($row_top_login["email"]).">\n";
	$headers .= "Reply-to: ".($row_top_login["nome"])." <".($row_top_login["email"]).">\n";
	$headers .= "bcc: ".$fullcc."\n";

	mail($to,$subject,$corpo_email,$headers);
	//print_r("Mail: " + mail($to,$subject,$corpo_email,$headers));
//echo $headers;
/*
require("class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP(); 
$mail->SMTPDebug = 1;                                      // set mailer to use SMTP
//$mail->Host = "ssl://smtp.gmail.com";  // specify main and backup server
$mail->Host = "mail.email.alog.com.br";  // specify main and backup server
$mail->SMTPAuth = true;     // turn on SMTP authentication
//$mail->SMTPSecure = "ssl";
//$mail->Port = 465;
//$mail->Username = "pulsarimagens.mailer@gmail.com";  // SMTP username
//$mail->Password = "pulsar12)("; // SMTP password
$mail->Username = "contato@pulsarimagens.com.br";  // SMTP username
$mail->Password = "123qwe!!"; // SMTP password

$mail->From = "contato@pulsarimagens.com.br";
$mail->FromName = "Pulsar Imagens";
$mail->AddAddress($email);
$mail->AddBCC($fullcc);
$mail->AddReplyTo("pulsar@pulsarimagens.com.br", "Pulsar Imagens");

//$mail->WordWrap = 50;                                 // set word wrap to 50 characters
//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
$mail->IsHTML(true);                                  // set email format to HTML

$mail->Subject = $subject;
$mail->Body    = $corpo_email;
//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

if(!$mail->Send())
{
	echo "Message could not be sent. <p>";
//	echo "Mailer Error: " . $mail->ErrorInfo;
//	exit;
}

echo "Message has been sent";

*/
	header("Location: ". $url_ok);
}
?>