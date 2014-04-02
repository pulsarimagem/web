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
			<h2>Register at Pulsar Imagens</h2>
			<p class="p">Fill out the fields below to register and have access to our collection of over hundred thousand of images.</p>
			<!--<p class="p">Para efetuar seu cadastro como pessoa jurídica, <a href="cadastro_pj.php">clique aqui</a>.</p>-->
<?php if($has_error) {?>
			<div class="alert-message">You need to fill the highlighted fields to finish you registration.</div>
<?php }?>
			<form name="form1" method="post" action="cadastro.php">
				<div class="form">
					<ul>
						<li>
							<label>Name</label>
							<input name="nome" type="text" value="<?php echo $nome?>" class="text<?php if($nome_error) {?> error" /> <span><?php echo $nome_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<!--<li>
							<label>CPF</label>
							<input name="cpf" type="text" value="<?php echo $cpf?>" class="text<?php if($cpf_error) {?> error" /> <span><?php echo $cpf_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>-->
						<li>
							<label>Address</label>
							<input name="endereco" type="text" value="<?php echo $endereco?>" class="text<?php if($endereco_error) {?> error" /> <span><?php echo $endereco_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<li>
							<label>Postal code</label>
							<input name="cep" type="text" value="<?php echo $cep?>" class="text<?php if($cep_error) {?> error" /> <span><?php echo $cep_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<li>
							<label>City</label>
							<input name="cidade" type="text" value="<?php echo $cidade?>" class="text<?php if($cidade_error) {?> error" /> <span><?php echo $cidade_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
<!-- 						<li>
							<label>State</label>
<?php include("estados.php")?>
 
<select class="select" name="estados">
 <option value='SP'>Sao Paulo</option>
 </select>

							<div class="clear"></div>
						</li>  -->
						<li>
							<label>Country</label>
<?php include("paises.php")?> 
							<div class="clear"></div>
						</li>
						<li>
							<label>Phone</label>
							<input name="telefone" type="text" value="<?php echo $telefone?>" class="text<?php if($telefone_error) {?> error" /> <span><?php echo $telefone_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<li>
							<label>E-mail</label>
							<input name="email" type="text" value="<?php echo $email?>" class="text<?php if($email_error) {?> error" /> <span><?php echo $email_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<li>
							<label>Confirm E-mail</label>
							<input name="email2" type="text" value="<?php echo $email2?>" class="text<?php if($email2_error) {?> error" /> <span><?php echo $email2_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
<!-- 						<li>
							<label>Login</label>
							<input name="login" type="text" maxlength="15" value="<?php echo $login?>" class="text<?php if($login_error) {?> error" /> <span><?php echo $login_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li> -->
						<li>
							<label>Password</label>
							<input name="senha" type="password" value="<?php echo $senha?>" class="text<?php if($senha_error) {?> error" /> <span><?php echo $senha_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<li>
							<label>Confirm password</label>
							<input name="senha2" type="password" value="<?php echo $senha2?>" class="text<?php if($senha2_error) {?> error" /> <span><?php echo $senha2_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<li>
							<label>Sign for newsletter ?</label>
							<input name="newsletter" type="checkbox" value="" <?php echo $newsletter?> class="checkbox" checked/> 				
							<div class="clear"></div>
						</li>
						
					</ul>
					<div class="declaro<?php if($declaro_error) echo " declaro-error"?>">
						<input name="deacordo" type="checkbox" class="checkbox" value="" <?php echo $deacordo?>/> <label>Yes, I read and agreed with the <a href="faq.php#copyright" target="_blank">Term and Conditions.</a></label>
						<input name="action" type="submit" class="button" value="Register" />
						<input name="type" type="hidden" value="PF" />
						<input name="tipo" type="hidden" value="F" />
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
