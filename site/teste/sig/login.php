<?php require_once('Connections/pulsar.php'); ?>
<?php require_once('Connections/sig.php'); ?>
<?php 
include("tool_login.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Pulsar Imagens - Login</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<?php include ("scripts.php"); ?>
</head>
<body>
	<div class="box_login">
    	<div class="logo">
        	<img src="images/logo.jpg" width="216" height="34" />
            <p>Área de Administração</p>
            <div class="clear"></div>
        </div>
        <div class="form">
        	<form name="form1" method="post" action="login.php">
	        	<ul>
	            	<li>
	                	<label>Seu Login</label>
	                    <input name="login" type="text"/>
	                	<div class="clear"></div>
	                </li>
	                <li>
	                	<label>Sua Senha</label>
	                    <input name="senha" type="password" id="senha"/>
	                	<div class="clear"></div>
	                </li>
	            </ul>
	            <input name="action" type="submit" id="button" value="Acessar" style="margin-left: 148px;" />
			</form>
        </div>
    </div>
<?php include("part_footer.php");?>
</body>
</html>
