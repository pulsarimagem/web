<?php require_once('Connections/pulsar.php'); ?>
<?php 
include("../tool_login-e.php");
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
				<p>When you become a member you will have full access to our collection and are able to use all tools provided, such as saving files into your folder, price calculator and acquire media on-line.</p>
				<input name="" type="button" onclick="location.href='cadastro.php'" value="Register Free" />
			</div>
		</div>
		<div class="logar">
			<h2>Don't worry!</h2>
	  <form name="form1" method="post" action="login-e.php">
				<div class="e">
					<p>Write your registered e-mail address below and we will send you a message with your details.</p>
	                <ul>
	                	<li>
	                    	<label>E-mail:</label>
	                        <input name="email" type="text" value="<?php echo $email?>" class="text<?php if($email_error) {?> error" /> <span><?php echo $email_error_msg?></span><?php }else echo "\"/>"?>
	                        <div class="clear"></div>
	                    </li>
	                    <li><input name="action" type="submit" class="button" value="Go" /></li>
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
