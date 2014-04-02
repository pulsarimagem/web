<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_alterar_senha.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Pulsar Imagens - Administração de Usuários</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<?php include ("scripts.php"); ?>
</head>
<body id="cadastro_usuarios">
<div class="main">
<?php include("part_header.php");?>
    <div class="colA">
        <div class="usuarios">
            <h2>Alteração de senha de usuário</h2>
            <form name="form1" method="post" action="alterar_senha.php">
<?php if(isset($msg)) echo $msg;?>	            
				<ul>
	            	<li>
	                	<label>Login: </label>
	                    <input name="login_off" type="text" value="<?php echo $login;?>" disabled="disabled"/>
	                    <input name="login" type="hidden" value="<?php echo $login;?>"/>
		                <div class="clear"></div>
	                </li>
<?php if($first) { ?>
	                <li> 
 	                	<label>Senha: </label>
	                    <input name="senha" type="password" <?php if($first) echo "value=\"".$senha."\""?>/>
		                <div class="clear"></div>
 	                </li>`
<?php } ?> 	                
	            	<li>
	                	<label>Nova Senha: </label>
	                    <input name="nova_senha" type="password" />
		                <div class="clear"></div>
	                </li>
	            	<li>
	                	<label>Endereço de Email: </label>
	                    <input name="email" type="text" value="<?php echo $email;?>"/>
		                <div class="clear"></div>
	                </li>
	            </ul>
<?php if($first) { ?>
				<input name="first" type="hidden" value="true"/>
<?php } ?>

	            <input name="action" type="submit" id="button" value="Alterar" style="float: left;" />
            </form>
            <div class="clear"></div>
        </div>
    </div>
    <div class="colB">
<?php include("part_sidemenu.php");?>
    </div>
    <div class="clear"></div>
</div>
<?php include("part_footer.php");?>
</body>
</html>
    