<?php require_once('Connections/pulsar.php'); ?>
<?php 
include("tool_contato.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Imagens</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
</head>
<body>

<?php include("part_topbar.php")?>

<div class="main size960">

<?php include("part_grid_left.php")?>

	<div class="grid-right">
		<div class="contato">
			<h2>Entre em Contato</h2>
			<p class="p">Preencha os campos abaixo para entrar em contato conosco. Fique a vontade para enviar suas d�vidas, sugest�es e cr�ticas. Sua opini�o � muito importante para n�s. </p>
			<form name="form1" method="post" action="contato.php">
				<div class="form">
					<ul>
						<li>
						  <label>Nome completo :</label>
							<input name="nome" type="text" value="<?php echo $nome?>" class="text<?php if($nome_error) {?> error" /> <span><?php echo $nome_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
				    </li>
						<li>
							<label>Qual seu e-mail : </label>
							<input name="email" type="text" value="<?php echo $email?>" class="text<?php if($email_error) {?> error" /> <span><?php echo $email_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<li>
							<label>Selecione um setor : </label>
							<select class="select" name="setor">
								<option value="pulsar">D�vidas Gerais</option>
								<option value="pulsar">Pesquisa</option>
								<option value="comunicacao">Comunica��o</option>
								<option value="contabilidade">Contabilidade</option>
<!-- 								<option value="laura">Webmaster</option> -->
							</select>
							<div class="clear"></div>
						</li>
						<li>
							<label>Sua Mensagem:</label>
							<textarea name="mensagem" cols="" rows="" class="textarea"><?php echo $mensagem?></textarea>
							<div class="clear"></div>
						</li>
						<li>
<?php
require_once('./lib/recaptchalib.php');
$privatekey = "6Lcz2dQSAAAAAATeMeFwYH8IHiByAqdkP77RCxd8";
$publickey = "6Lcz2dQSAAAAABk_K-DFQJryIuIGl15TNazx6GNZ"; // you got this from the signup page
echo recaptcha_get_html($publickey);
?>						
							<input name="action" type="submit" class="button" value="Enviar" />
							<p class="limpar">ou <a href="contato.php">Limpar campos</a></p>
							<div class="clear"></div>
						</li>
					</ul>
				</div>
			</form>
		</div>
	</div>
	<div class="clear"></div>
</div>

<?php include("part_footer.php")?>

</body>
</html>
