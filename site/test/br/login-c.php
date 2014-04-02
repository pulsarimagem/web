<?php require_once('Connections/pulsar.php'); ?>
<?php 
//include("tool_login-e.php");
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
			<h2>Email enviado com sucesso</h2>
			<div class="c">
				<p>Dentro de instantes você receberá em sua caixa de entrada um email com sua senha de acesso. </p>
                <input name="" type="button" onclick="location.href='index.php'" value="Voltar" />
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>

<?php include("part_footer.php")?>

</body>
</html>
