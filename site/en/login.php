<?php require_once('Connections/pulsar.php'); ?>
<?php require_once('Connections/sig.php'); ?>
<?php 
include("../tool_login.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Images</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
</head>
<body>

<?php include("part_topbar.php")?>

<div class="main size960">
	<div class="login">
		<div class="vantagem">
			<h2>Advantages of a member</h2>
			<div class="box">
				<dl>
				  <dd>When you become a member you will have full access to our collection and are able to use all tools provided, such as saving files into your folder, price calculator and acquire media on-line.<br />
				  </dd>
		      </dl>
			<input name="" type="button" onclick="location.href='cadastro.php'" value="Register Free" />
			</div>
		</div>
		<div class="logar">
			<h2>Enter your login details:</h2>
			<form name="form1" method="post" action="login.php">
				<div class="box">
					<ul>
						<li class="text">
							<label>Login:</label>
							<input name="login" type="text" value="<?php echo $login?>" class="text<?php if($login_error) {?> error" /> <span><?php echo $login_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<li class="text">
							<label>Password:</label>
							<input name="senha" type="password" value="<?php echo $senha?>" class="text<?php if($senha_error) {?> error" /> <span><?php echo $senha_error_msg?></span><?php }else echo "\"/>"?>
							<div class="clear"></div>
						</li>
						<li>
							<!--<small><a href="login-e.php">Esqueci minha senha</a></small>-->
							<small><a href="login-e.php">Forgot your login/password.</a></small>						</li>
				  <li class="button">
							<input name="action" type="submit" value="Go" />
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
