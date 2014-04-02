<?php require_once('Connections/pulsar.php'); ?>
<?php 
include("../tool_login-e.php");
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
	<div class="login">
		<div class="vantagem">
			<h2>Vantagens de um membro</h2>
			<div class="box">
				<p>Ao se tornar um membro do site você passará a ter acesso total ao nosso acervo de imagens composto por milhares de fotos e poderá utilizar as diversas ferramentas que  o site dispõe para facilitar o seu trabalho.</p>
				<input name="" type="button" onclick="location.href='cadastro.php'" value="Criar conta gratuita" />
			</div>
		</div>
		<div class="logar">
			<h2>Fique tranquilo!</h2>
	  <form name="form1" method="post" action="login-e.php">
				<div class="e">
					<p>Escreva seu e-mail cadastrado abaixo para receber a sua senha de acesso ao nosso site.</p>
	                <ul>
	                	<li>
	                    	<label>Seu Email:</label>
	                        <input name="email" type="text" value="<?php echo $email?>" class="text<?php if($email_error) {?> error" /> <span><?php echo $email_error_msg?></span><?php }else echo "\"/>"?>
	                        <div class="clear"></div>
	                    </li>
	                    <li><input name="action" type="submit" class="button" value="Ir" /></li>
	                </ul>
				</div>
			</form>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>

<?php include("part_footer.php")?>

</body>
</html>
