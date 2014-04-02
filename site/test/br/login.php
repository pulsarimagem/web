<?php require_once('Connections/pulsar.php'); ?>
<?php 
include("../tool_login.php");
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
				<dl>
				  <dd>Ao se tornar um membro do site você passará a ter acesso total ao nosso acervo de imagens composto por milhares de fotos e poderá utilizar as diversas ferramentas que  o site dispõe para facilitar o seu trabalho.<br />
				  </dd>
		      </dl>
			<input name="" type="button" onclick="location.href='cadastro.php'" value="Criar conta gratuita" />
			</div>
		</div>
		<div class="logar">
			<h2>Você precisa ser cadastrado para isso.</h2>
			<form name="form1" method="post" action="login.php">
				<div class="box">
					<ul>
						<li class="text">
							<label>Seu Login:</label>
							<input name="login" type="text" value="<?php echo $login?>" class="text<?php if($login_error) {?> error" /> <span><?php echo $login_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<li class="text">
							<label>Sua Senha:</label>
							<input name="senha" type="password" value="<?php echo $senha?>" class="text<?php if($senha_error) {?> error" /> <span><?php echo $senha_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<li>
							<!--<small><a href="login-e.php">Esqueci minha senha</a></small>-->
							<small><a href="login-e.php">Esqueci meu login/senha</a></small>						</li>
				  <li class="button">
							<input name="action" type="submit" value="Ir" />
						</li>
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
