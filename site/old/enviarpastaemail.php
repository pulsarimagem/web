<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php");?>
<?php 
include("tool_enviarpastaemail.php");
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
    	<form name="form1" method="get" action="enviarpastaemail.php">
<?php if($has_error) {?>
			<div class="alert-message">Ops! Você precisa arrumar os campos em destaque para enviar a pasta.</div>
<?php }?>
			<div class="solicitarcotacao">
				<h2>Enviar por e-mail</h2>
				<label>Enviar para:</label>
				<input name="email" type="text" class="assunto <?php if($email_error) echo "error";?>" value="<?php echo $email?>"/>
<!-- 				<textarea name="email" cols="" rows="1" class="<?php if($email_error) {?>error"><?php }else echo "enviarpara\">"?><?php echo $email?></textarea> -->
				
				<label>Assunto:</label>
				<input name="assunto" type="text" class="assunto <?php if($assunto_error) echo "error";?>" value="<?php echo $assunto?>"/>
				
				<label>Sua Mensagem</label>
				<textarea name="mensagem" cols="" rows="" class="<?php if($mensagem_error) {?>error"><?php }else echo "enviarpara\">"?><?php echo $mensagem?></textarea>
				<h2 style="padding-top: 16px;">Pasta Selecionada</h2>
				<ul>
<?php if($totalRows_pastas > 0) {?>				
					<li>
						<input name="chkbox[]" type="checkbox" value="<?php echo $row_pastas['id_pasta']; ?>" checked disabled/>
						<p class="img">
		                    <span class="folder"><img src="<?php echo "http://www.pulsarimagens.com.br/";//$homeurl; ?>bancoImagens/<?php echo $row_pastas['tombo']; ?>p.jpg" alt="<?php echo $row_pastas['tombo']; ?>" style="max-width:77px; max-height:77px;" /></span>
						</p>
						<span><?php echo $row_pastas['nome_pasta']; ?></span>
						<div class="clear"></div>
					</li>
<?php } ?>					
					<div class="clear"></div>
				</ul>
				<div class="bts">
					<input name="action" type="submit" value="Enviar e-mail" class="button" />
					<input name="id_pasta" type="hidden" value="<?php echo $row_pastas['id_pasta']; ?>"/>
					<div class="bt-cancelar"><a href="primeirapagina.php"></a></div>
					<div class="clear"></div>
				</div>
			</div>
		</form>
	</div>
	<div class="clear"></div>
</div>

<?php include("part_footer.php")?>

</body>
</html>
