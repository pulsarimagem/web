<?php require_once('Connections/pulsar.php'); ?>
<?php include("../tool_cadastro.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Pulsar Images</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
</head>
<body>

<?php include("part_topbar.php");?>

<div class="main size960">

<?php include("part_cadastro_left.php");?>

	<div class="grid-right">
		<div class="cadastro">
			<h2>Faça seu cadastro no Pulsar Imagens</h2>
			<p class="p">Preencha os campos abaixo para realizar o seu cadastro e ter acesso ao nosso acervo fotográfico composto por mais de um milhão de imagens.</p>
			<p class="p">Para efetuar seu cadastro como pessoa física, <a href="cadastro.php">clique aqui</a>.</p>
<?php if($has_error) {?>
            <div class="alert-message">Ops! Você precisa arrumar os campos em destaque para finalizar o seu cadastro.</div>
<?php }?>
			<form name="form1" method="post" action="cadastro_pj.php">
				<div class="form">
					<ul>
						<li>
							<label>Nome Completo</label>
							<input name="nome" type="text" value="<?php echo $nome?>" class="text<?php if($nome_error) {?> error" /> <span><?php echo $nome_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<li>
							<label>Razão Social</label>
							<input name="empresa" type="text" value="<?php echo $empresa?>" class="text<?php if($empresa_error) {?> error" /> <span><?php echo $empresa_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<li>
							<label>CNPJ</label>
							<input name="cnpj" type="text" value="<?php echo $cnpj?>" class="text<?php if($cnpj_error) {?> error" /> <span><?php echo $cnpj_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<li>
							<label>Endereço</label>
							<input name="endereco" type="text" value="<?php echo $endereco?>" class="text<?php if($endereco_error) {?> error" /> <span><?php echo $endereco_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<li>
							<label>CEP</label>
							<input name="cep" type="text" value="<?php echo $cep?>" class="text<?php if($cep_error) {?> error" /> <span><?php echo $cep_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<li>
							<label>Cidade</label>
							<input name="cidade" type="text" value="<?php echo $cidade?>" class="text<?php if($cidade_error) {?> error" /> <span><?php echo $cidade_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<li>
							<label>Estado</label>
<?php include("estados.php")?>
<!--  <select class="select" name="estados">
 <option value='SP'>Sao Paulo</option>
 </select> -->
							<div class="clear"></div>
						</li>
						<li>
							<label>País</label>
<?php include("paises.php")?> 
							<div class="clear"></div>
						</li>
						<li>
							<label>Telefone de contato</label>
							<input name="telefone" type="text" value="<?php echo $telefone?>" class="text<?php if($telefone_error) {?> error" /> <span><?php echo $telefone_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<li>
							<label>E-mail</label>
							<input name="email" type="text" value="<?php echo $email?>" class="text<?php if($email_error) {?> error" /> <span><?php echo $email_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<li>
							<label>Confirmação de E-mail</label>
							<input name="email2" type="text" value="<?php echo $email2?>" class="text<?php if($email2_error) {?> error" /> <span><?php echo $email2_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
<!-- 						<li>
							<label>Login</label>
							<input name="login" type="text" maxlength="15" value="<?php echo $login?>" class="text<?php if($login_error) {?> error" /> <span><?php echo $login_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li> -->
						<li>
							<label>Senha</label>
							<input name="senha" type="password" value="<?php echo $senha?>" class="text<?php if($senha_error) {?> error" /> <span><?php echo $senha_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<li>
							<label>Confirmação de senha</label>
							<input name="senha2" type="password" value="<?php echo $senha2?>" class="text<?php if($senha2_error) {?> error" /> <span><?php echo $senha2_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<li>
							<label>Receber Newsletter ?</label>
							<input name="newsletter" type="checkbox" value="" <?php echo $newsletter?> class="checkbox" />
							<select name="tipo" class="select">
								<option>Editorial</option>
								<option>Publicitário</option>
							</select>
							<div class="clear"></div>
						</li>

					</ul>
					<div class="declaro<?php if($declaro_error) echo " declaro-error"?>">
						<input name="deacordo" type="checkbox" class="checkbox" value="" <?php echo $deacordo?>/> <label>Sim, declaro que li e concordo com os <a href="faq.php#copyright" target="_blank">Termos e Condições.</a></label>
						<input name="action" type="submit" class="button" value="Continuar" />
						<input name="type" type="hidden" value="PJ" />
						<input name="tipo" type="hidden" value="J" />
						<div class="clear"></div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="clear"></div>
</div>

<?php include("part_footer.php");?>

</body>
</html>
