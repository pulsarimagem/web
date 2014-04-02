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
		$nome_error_msg = "O Nome é um campo obrigatório!";
		$has_error = true;
	}
	if($pf) {
		if(($cpf = $_POST['cpf']) == "") {
			$cpf_error = true;
			$cpf_error_msg = "O CPF digitado não é válido!";
			$has_error = true;
		}
	}
	if($pj) {
		if(($empresa = $_POST['empresa']) == "") {
			$empresa_error = true;
			$empresa_error_msg = "A Razão Social é um campo obrigatório!";
			$has_error = true;
		}
		if(($cnpj = $_POST['cnpj']) == "") {
			$cnpj_error = true;
			$cnpj_error_msg = "O CNPJ digitado não é válido!";
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
		$email_error_msg = "O Email é um campo obrigatório!";
		$has_error = true;
	}
	if(($email2 = $_POST['email2']) == "") {
		$email2_error = true;
		$email2_error_msg = "Informe a Confirmação de Email!";
		$has_error = true;
	}
	if($_POST['email'] != $_POST['email2']) {
		$email_error = true;
		$email_error_msg = "Os emails digitados não conferem, favor digitar novamente.";
		$email2_error = true;
		$email2_error_msg = "Os emails digitados não conferem, favor digitar novamente.";
		$has_error = true;
		$email = "";
		$email2 = "";
	}
	if(($login = $_POST['login']) == "") {
		$login_error = true;
		$login_error_msg = "Digite o Login do usuário.";
		$has_error = true;
	}
	if(($senha = $_POST['senha']) == "") {
		$senha_error = true;
		$senha_error_msg = "Informe a Senha!";
		$has_error = true;
	}
	if(($senha2 = $_POST['senha2']) == "") {
		$senha2_error = true;
		$senha2_error_msg = "Informe a Confirmação de Senha!";
		$has_error = true;
	}
	if($_POST['senha'] != $_POST['senha2']) {
		$senha_error = true;
		$senha_error_msg = "As senhas digitadas não conferem, favor digitar novamente.";
		$senha2_error = true;
		$senha2_error_msg = "As senhas digitadas não conferem, favor digitar novamente.";
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

	if(isset($_POST['newsletter']))
	$newsletter = "checked";
	else
	$newsletter = "";
}

if(!$has_error && $submit) {
	
	$_SESSION['show_welcome'] = true;
	$_SESSION['PrevUrl'] = $url_ok;
	$url_ok = "login.php?login=".$login."&senha=".$senha."";
	
	if($pf){

		$data = " now() ";

		$insertSQL = sprintf("INSERT INTO cadastro (nome, cpf_cnpj, endereco, cep, cidade, telefone, email, login, senha, tipo, estado, pais, data_cadastro) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
		GetSQLValueString($_POST['nome'], "text"),
		GetSQLValueString($_POST['cpf'], "text"),
		GetSQLValueString($_POST['endereco'], "text"),
		GetSQLValueString($_POST['cep'], "text"),
		GetSQLValueString($_POST['cidade'], "text"),
		GetSQLValueString($_POST['telefone'], "text"),
		GetSQLValueString($_POST['email'], "text"),
		GetSQLValueString($_POST['login'], "text"),
		GetSQLValueString($_POST['senha'], "text"),
		GetSQLValueString($_POST['tipo'], "text"),
		GetSQLValueString($_POST['estados'], "text"),
		GetSQLValueString($_POST['paises'], "text"),
		$data   );
			
		mysql_select_db($database_pulsar, $pulsar);
		$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

		$to      = $_POST['email'] . "\n";
		$subject = "www.pulsarimagens.com.br - seu cadastro no website\n";
		include('email_cadastro_pf.php');
/*		
		$message = '
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
                  <font face="Verdana, Arial, Helvetica, sans-serif" color="#48493F" size="1">Ola '. $_POST['nome'] .', <br>
                        <br>
                      Seja bem vindo &agrave; Pulsar Imagens.
                      <br>
                      <br>
                      Voc&ecirc; j&aacute; est&aacute; devidamente cadastrado em nosso site.<br>
                    Seu login &eacute;: '. $_POST['login'] .'<br>
                    Sua senha &eacute;: '. $_POST['senha'] .'<br>
                    <br>
                    Nosso site foi desenvolvido para atender as suas necessidades de maneira simples e personalizada.<br>
                    A sess&atilde;o &quot;Minhas Imagens&quot; &eacute; sua &aacute;rea administrativa.<br>
                    Nela voc&ecirc; poder&aacute; alterar os seus dados cadastrais, al&eacute;m de criar suas pastas, envi&aacute;-las a clientes e amigos, entre outras fun&ccedil;&otilde;es. Para obter informa&ccedil;&otilde;es sobre pre&ccedil;os, voc&ecirc; poder&aacute; fazer uma cota&ccedil;&atilde;o das imagens, devendo apenas informar a utiliza&ccedil;&atilde;o da(s) mesma(s).<br>
                    <br>
                    Caso haja alguma d&uacute;vida ou problema durante sua visita leia nossa se&ccedil;&atilde;o de &quot;D&uacute;vidas Freq&uuml;entes&quot; <img src="http://www.pulsarimagens.com.br/images/icone_faq.gif" width="20" height="20"> ou entre em contato com nossa equipe que estar&aacute; pronta para te ajudar.<br>
                  <br>
                  Muito obrigado.
                  <br>
                  <br>
                  Sinta-se em casa.                  <br>
                  <br>
                        Equipe Pulsar Imagens</font><br>
                         <font face="Verdana, Arial, Helvetica, sans-serif" color="#999999" size="1">www.pulsarimagens.com.br<br>
pulsar@pulsarimagens.com.br
</font></div></td>
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
		$headers .= "bcc: Laura <laura@pulsarimagens.com.br>, ".$fullcc."\n";
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

		$insertSQL = sprintf("INSERT INTO cadastro (nome, empresa, cpf_cnpj, endereco, cep, cidade, telefone, email, login, senha, tipo, estado, pais, data_cadastro) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
		GetSQLValueString($_POST['nome'], "text"),
		GetSQLValueString($_POST['empresa'], "text"),
//		GetSQLValueString($_POST['cargo'], "text"),
		GetSQLValueString($_POST['cnpj'], "text"),
		GetSQLValueString($_POST['endereco'], "text"),
		GetSQLValueString($_POST['cep'], "text"),
		GetSQLValueString($_POST['cidade'], "text"),
		GetSQLValueString($_POST['telefone'], "text"),
		GetSQLValueString($_POST['email'], "text"),
		GetSQLValueString($_POST['login'], "text"),
		GetSQLValueString($_POST['senha'], "text"),
		GetSQLValueString($_POST['tipo'], "text"),
		GetSQLValueString($_POST['estados'], "text"),
		GetSQLValueString($_POST['paises'], "text"),
		$data);

		mysql_select_db($database_pulsar, $pulsar);
		$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

		$to      = $_POST['email'];
		$subject = "www.pulsarimagens.com.br - seu cadastro no website";
		include('email_cadastro_pj.php');
		
/*		
		$message = '
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
                  <font face="Verdana, Arial, Helvetica, sans-serif" color="#48493F" size="1">Ola '. $_POST['nome'] .', <br>
                        <br>
                      Seja bem vindo &agrave; Pulsar Imagens.
                      <br>
                      <br>
                      Voc&ecirc; j&aacute; est&aacute; devidamente cadastrado em nosso site.<br>
                    Seu login &eacute;: '. $_POST['login'] .'<br>
                    Sua senha &eacute;: '. $_POST['senha'] .'<br>
                    <br>
                    Nosso site foi desenvolvido para atender as suas necessidades de maneira simples e personalizada.<br>
                    A sess&atilde;o &quot;Minhas Imagens&quot; &eacute; sua &aacute;rea administrativa.<br>
                    Nela voc&ecirc; poder&aacute; alterar os seus dados cadastrais, al&eacute;m de criar suas pastas, envi&aacute;-las a clientes e amigos, entre outras fun&ccedil;&otilde;es. Para obter informa&ccedil;&otilde;es sobre pre&ccedil;os, voc&ecirc; poder&aacute; fazer uma cota&ccedil;&atilde;o das imagens, devendo apenas informar a utiliza&ccedil;&atilde;o da(s) mesma(s).<br>
                    <br>
                    Caso haja alguma d&uacute;vida ou problema durante sua visita leia nossa se&ccedil;&atilde;o de &quot;D&uacute;vidas Freq&uuml;entes&quot; <img src="http://www.pulsarimagens.com.br/images/icone_faq.gif" width="20" height="20"> ou entre em contato com nossa equipe que estar&aacute; pronta para te ajudar.<br>
                  <br>
                  Muito obrigado.
                  <br>
                  <br>
                  Sinta-se em casa.                  <br>
                  <br>
                        Equipe Pulsar Imagens</font><br>
                         <font face="Verdana, Arial, Helvetica, sans-serif" color="#999999" size="1">www.pulsarimagens.com.br<br>
pulsar@pulsarimagens.com.br
</font></div></td>
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
//		$headers .= "bcc: Laura <laura@pulsarimagens.com.br>, ".$fullcc."\n";
		$headers .= "bcc: ".$fullcc."\n";
		
		mail($to,$subject,$message,$headers);
			
		header("Location: ". $url_ok); 
	}
}
?>