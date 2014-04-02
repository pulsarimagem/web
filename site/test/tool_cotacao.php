<?php
$fullcc = "lauradml@gmail.com";
$url_ok = "cotacaosucesso.php?anterior=primeirapagina.php";

$has_error = false;
$descricao_error = false;
$submit = false;

$descricao = "";

if (isset($_POST['action'])) {
	$submit = true;
	if(($descricao = $_POST['descricao']) == "") {
		$descricao_error = true;
		$descricao_error_msg = "";
		$has_error = true;
	}
}

if(!$has_error && $submit) {
	# ROTINA PARA ENVIAR COTAÇÕES
	
	$insertSQL = "INSERT INTO cotacao_2 (id_cadastro, distribuicao, descricao_uso, data_hora) VALUES (".$row_top_login['id_cadastro'].", '', '".$_POST['descricao']."', now())";
	
	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
//echo $insertSQL;
	
	# PEGA o id_cotacao2
	mysql_select_db($database_pulsar, $pulsar);
	$query_cotacao2 = "SELECT id_cotacao2 FROM cotacao_2 WHERE id_cadastro = ".$row_top_login['id_cadastro']." ORDER BY id_cotacao2 DESC";
	$cotacao2 = mysql_query($query_cotacao2, $pulsar) or die(mysql_error());
	$row_cotacao2 = mysql_fetch_assoc($cotacao2);
	$totalRows_cotacao2 = mysql_num_rows($cotacao2);
	
	
	$insertSQL = "INSERT INTO cotacao_cromos (tombo, id_pasta, id_cotacao2) SELECT tombo, id_pasta, ".$row_cotacao2['id_cotacao2']." FROM cotacao WHERE id_cadastro = ".$row_top_login['id_cadastro']." AND tombo in ('".implode("','",$_POST['chkbox'])."')";
	
	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
//echo $insertSQL;
	
	# ROTINA PARA LIMPAR AS COTAÇÕES
	
	$deleteSQL = "DELETE FROM cotacao WHERE id_cadastro = ".$row_top_login['id_cadastro']." AND tombo in ('".implode("','",$_POST['chkbox'])."')";
	
	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
//echo $deleteSQL;
	
	# ROTINA PARA AVISAR VIA EMAIL
	
// 	$to      = "Laura <laura@pulsarimagens.com.br>,";
// 	$to      .= "Luis <luis@pulsarimagens.com.br>\n";
	$to = "pulsarimagensltda@gmail.com";
	$subject = "[Cotação] Nova cotação solicitada\n";
	$message = "Foi solicitada uma nova cotação por ".$row_top_login['nome']." em ".date("d-m-Y H:i:s", strtotime('now'))."\n";
	$headers = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "From: Pulsar Imagens <".($row_top_login["email"]).">\n";
// 	$headers .= "Cc: Pulsar Imagens <pulsar@pulsarimagens.com.br>\n";
	$headers .= "bcc: ".$fullcc."\n";
	$headers .= "Return-Path: ".($row_top_login["email"])."\n";
	
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
	$mail->AddAddress($email);
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
	header("Location: ". $url_ok);
}

if (( !empty ( $_POST['chkbox'] ) ) && ($_POST['opcao'] == "delete")) {
	$deleteSQL = "DELETE FROM cotacao WHERE id_cadastro = ".$row_top_login['id_cadastro']." AND tombo IN ('".implode("','",$_POST['chkbox'])."')";
	
	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
}
?>