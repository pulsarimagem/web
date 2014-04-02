<?php
$url_ok = "login-c.php";

$has_error = false;
$email_error = false;
$submit = false;

$email = "";

if (isset($_POST['action'])) {
	$submit = true;
	if(($email = $_POST['email']) == "") {
		$email_error = true;
		$email_error_msg = LOGIN_EMAIL_ERROR;
		$has_error = true;
	}
}

if(!$has_error && $submit) {
	mysql_select_db($database_pulsar, $pulsar);
	$query_email = "SELECT * FROM cadastro WHERE email = '".$_POST["email"]."'";
	$retorno_email = mysql_query($query_email, $pulsar) or die(mysql_error());
	$row_email = mysql_fetch_assoc($retorno_email);
	$totalRows_email = mysql_num_rows($retorno_email);

	if ($totalRows_email > 0) { // Se achou o email...

		$to      = $_POST['email'] . "\n";
		$subject = "www.pulsarimagens.com.br - login/senha no website\n";
		include('email_login-e.php');
/*		
		$message ='
<html>
<head>
<title>:: Pulsar Imagens ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body topmargin="0">
<table width="534" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="1" background="http://www.pulsarimagens.com.br/images/mail_pontilhado_03.gif"><img src="images/spacer.gif" width="1" align="absmiddle"> </td>
    <td width="532"><table width="530" border="0" align="center" cellpadding="0" cellspacing="0" class="borda_tabela">
      <tr>
        <td colspan="3">
          <table width="520"  border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td background="http://www.pulsarimagens.com.br/images/mail_barra_logo.gif"><a href="http://www.pulsarimagens.com.br/" target="_blank"><img src="http://www.pulsarimagens.com.br/images/header_03.gif" width="225" height="61" border="0"></a></td>
            </tr>
            <tr>
              <td width="540" height="10"><img src="http://www.pulsarimagens.com.br/images/mail_barra_escura.gif" width="100%" height="10"></td>
            </tr>
          </table>
          <br>
          <div align="center">
            <table width="500" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><div align="left">
                  <p><font face="Verdana, Arial, Helvetica, sans-serif" color="#48493F" size="1">Ola '. $row_email['nome'] .', <br>
                        <br>
                        a sua senha para acesso ao site &eacute;:<br>
                        <strong>Login:</strong> '. $row_email['login'] .'<br>
                        <strong>Senha:</strong> '. $row_email['senha'] .'<br>
                  Caso haja alguma d&uacute;vida ou problema leia nossa se&ccedil;&atilde;o de &quot;D&uacute;vidas Freq&uuml;entes&quot; <img src="http://www.pulsarimagens.com.br/images/icone_faq.gif" width="20" height="20"><br>
                        Estamos a disposi&ccedil;&atilde;o para auxili&aacute;-lo. <br>
                        <br>
                        Obrigado e volte sempre <br>
                        <br>
                      Equipe Pulsar Imagens<br></font>
                      <font face="Verdana, Arial, Helvetica, sans-serif" color="#999999" size="1">www.pulsarimagens.com.br<br>
                      pulsar@pulsarimagens.com.br</font></p>
                  </div></td>
              </tr>
            </table>
          </div>
          <br>
          <table width="530" align="center" cellpadding="00" cellspacing="0">
            <tr>
              <td width="430" height="41" background="http://www.pulsarimagens.com.br/images/mail_copyright_44.gif" >
			  
			    <table width="400" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="200" nowrap><font face="Verdana, Arial, Helvetica, sans-serif" color="#ffffff" size="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contato: 55 (11) 3875-0101 </font></td>
                  <td width="200"><font face="Verdana, Arial, Helvetica, sans-serif" color="#ffffff" size="1"><a href="mailto:pulsar@pulsarimagens.com.br"><img src="http://www.pulsarimagens.com.br/images/mail_endereco.gif" width="176" height="20" border="0"></a></font></td>
                </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="1" background="http://www.pulsarimagens.com.br/images/mail_pontilhado_03.gif"><img src="images/spacer.gif" width="1" align="absmiddle"></td>
  </tr>
</table>
<br>
</body>
</html>
';
*/
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: Pulsar Imagens <pulsar@pulsarimagens.com.br>\n";
		$headers .= "Return-Path: Pulsar Imagens <pulsar@pulsarimagens.com.br>\n";

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
	else {
		$email_error = true;
		$email_error_msg = "E-mail não encontrado! Tente novamente!";
		$has_error = true;
	}
}
?>