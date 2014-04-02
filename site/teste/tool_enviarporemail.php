<?php
$fullcc = "lauradml@gmail.com";

$url_ok = "emailsucesso.php?anterior=details.php?tombo=".$_GET['tombo']."%26search=PA";

$has_error = false;
$nome_error = false;
$remetente_error = false;
$email_error = false;
$assunto_error = false;
$mensagem_error = false;
$submit = false;

$nome = "";
$remetente = "";
$email = "";
$mensagem = "";
$assunto = "";

if($logged) {
	$nome = $row_top_login["nome"];
	$remetente = $row_top_login["email"];
}

if (isset($_GET['action'])) {
	$submit = true;
	if(($nome = $_GET['nome']) == "") {
		$nome_error = true;
		$nome_error_msg = "O Nome é um campo obrigatório!";
		$has_error = true;
	}
	if(($remetente = $_GET['rementente']) == "") {
		$remetente_error = true;
		$remetente_error_msg = "O Email é um campo obrigatório!";
		$has_error = true;
	}
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
if (isset($_GET['tombo'])) {
	mysql_select_db($database_pulsar, $pulsar);
	$query_dados_foto = sprintf("SELECT 
	  Fotos.Id_Foto,
	  Fotos.tombo,
	  Fotos.id_autor,
	  fotografos.Nome_Fotografo,
	  Fotos.data_foto,
	  Fotos.cidade,
	  Estados.Sigla,
	  Fotos.orientacao,
	  Fotos.assunto_principal,
	  paises.nome as pais
	FROM
	 Fotos
	 INNER JOIN fotografos ON (Fotos.id_autor=fotografos.id_fotografo)
	 LEFT OUTER JOIN Estados ON (Fotos.id_estado=Estados.id_estado)
	 LEFT OUTER JOIN paises ON (paises.id_pais=Fotos.id_pais)
	WHERE
	  (Fotos.tombo LIKE '%s')", $_GET['tombo']);
	$dados_foto = mysql_query($query_dados_foto, $pulsar) or die(mysql_error());
	$row_dados_foto = mysql_fetch_assoc($dados_foto);
	$totalRows_dados_foto = mysql_num_rows($dados_foto);
}

if(!$has_error && $submit) {
	
	$mensagem = str_replace("\\r\\n", "\r\n", $mensagem);
	
$insertSQL = "
INSERT INTO email (nome, email, destino, copia, assunto, texto, data_hora)
VALUES ('".($nome)."', '".($remetente)."', '".$email."', '', '".$assunto."', '".$mensagem."', now())
";
mysql_select_db($database_pulsar, $pulsar);
$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
$email_id = mysql_insert_id();

$email_tombo = $_GET["tombo"]; 

$insertSQL = "
INSERT INTO email_fotos (tombo, id_email)
VALUES ('".($email_tombo)."', ".$email_id.")
";
mysql_select_db($database_pulsar, $pulsar);
$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

/*
$nome = $row_top_login["nome"];
$remetente = $row_top_login["email"];
*/
			$to      = $email. "\n";
			$subject = $assunto. "\n";
			$mensagem = nl2br($mensagem);
				
			include('email_enviarporemail.php');		
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
              <div align="center">
              <table width="520"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="520"  border="0" cellpadding="0" cellspacing="0">
                      <tr bgcolor="#E0E2D8">
                        <td width="486" height="34"></td>
                        <td width="34" height="34"><img src="http://www.pulsarimagens.com.br/images/retorno_07.gif" width="34" height="34"></td>
                      </tr>
                      <tr bgcolor="#E0E2D8">
                        <td width="486"><table width="450"  border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="437" bgcolor="#E0E2D8"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" color="#48493F" size="2">
                              Ola, <br>
                              <em>'.($row_top_login["nome"]).'</em> pesquisou em nosso site e lhe enviou esta imagem.<br><br>
                                <em>'.$_GET['mensagem'].'</em><br>
                                <br>
                                Clicando na foto &eacute; poss&iacute;vel ampli&aacute;-la.<br>
                            </font>
                                <br>                              
                                <table width="235" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="171"><font face="Verdana, Arial, Helvetica, sans-serif" color="#48493F" size="2">Para conhecer nosso site </font></td>
                                    <td width="64"><div align="left"><a href="http://www.pulsarimagens.com.br" target="_blank"><img src="http://www.pulsarimagens.com.br/images/mail_clique_cinza.gif" width="64" height="20" border="0"></a></div></td>
                                  </tr>
                                </table>
                            </div></td>
                            </tr>
                        </table></td>
                        <td width="34">&nbsp;</td>
                      </tr>
                      <tr bgcolor="#E0E2D8">
                        <td width="486">&nbsp;</td>
                        <td width="34">&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="520" border="0" cellpadding="0" cellspacing="0" bgcolor="#E0E2D8">
                    <tr>
                      <td><table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr bgcolor="#E0E2D8">
                          <td height="113" colspan="2">
                            <div align="center"><a href="http://www.pulsarimagens.com.br/pop_email.php?tombo='.($_GET["tombo"]).'" target="_blank"><img src="http://www.pulsarimagens.com.br/bancoImagens/'.($_GET["tombo"]).'p.jpg" hspace="5" border="0" class="imgborder"></a> </div></td>
                        </tr>
                        <tr bgcolor="#E0E2D8" height="5">
                          <td height="3" valign="middle">
                            <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" color="#48493F" size="1"><strong>C&oacute;digo: '.($_GET["tombo"]).'</strong></font></div></td>
                          <td height="3" valign="top">
                            <div align="left">&nbsp;&nbsp;&nbsp;<a href="http://www.pulsarimagens.com.br/pop_email.php?tombo='.($_GET["tombo"]).'" target="_blank"><img src="http://www.pulsarimagens.com.br/images/zoom.gif" width="18" height="18" border="0"></a></div></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF"><table width="520"  border="0" cellpadding="0" cellspacing="0">
                      <tr bgcolor="#E0E2D8">
                        <td width="34" height="34"><img src="http://www.pulsarimagens.com.br/images/retorno_11.gif" width="34" height="34"></td>
                        <td width="484" height="34">&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
              </table>
            </div>
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
<div align="center"><br>
  Caso n&atilde;o consiga visualizar esse e-mail <a href="http://www.pulsarimagens.com.br/ver_email.php?email_id='.$email_id.'" target="_blank">clique aqui</a></div>
</body>
</html>
';
*/
			$headers = "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			$headers .= "From: ".($nome)." <".($remetente).">\n";
			$headers .= "Return-Path: ".($nome)." <".($remetente).">\n";
			$headers .= "bcc: ".$fullcc."\n";

			mail($to,$subject,$corpo_email,$headers);		
/*
			header("Location: ". $url_ok);
			
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
			$mail->AddReplyTo($remetente);
			
			$mail->IsHTML(true);                                  // set email format to HTML
			
			$mail->Subject = $subject;
			$mail->Body    = $corpo_email;
			
			if(!$mail->Send())
			{
				echo "Message could not be sent. <p>";
			}
			
			echo "Message has been sent";
*/			
			header("Location: ". $url_ok);
}
?>