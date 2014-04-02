<?php require_once('Connections/pulsar.php'); ?>
<?php //include("tool_auth.php");?>
<?php include("../tool_enviarporemail.php"); ?>
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

<?php //include("part_grid_left.php")?>

	<div class="grid-center">
		<form name="form1" method="get" action="enviarporemail.php">
			<div class="solicitarcotacao">
				<h2>Enviar por e-mail</h2>
<?php if($has_error) {?>
				<div class="error-msg">Ops! Você precisa corrigir os campos em destaque para continuar.</div>
<?php } ?>
				<label>Nome:</label>
	            <input name="nome" type="text" class="<?php if($nome_error) echo "error";  else echo "nome";?>" value="<?php echo $nome?>" size="" />
				
				<label>Email:</label>
	            <input name="rementente" type="text" class="<?php if($remetente_error) echo "error";  else echo "enviarde";?>" value="<?php echo $remetente?>" size="" />
				
				<label>Enviar para:</label>
	            <input name="email" type="text" class="<?php if($email_error) echo "error";  else echo "enviarpara";?>" value="<?php echo $email?>" size="" />
				
			    <label>Assunto:</label>
				<input name="assunto" type="text" class="<?php if($assunto_error) echo "error";  else echo "assunto";?>" value="<?php echo $assunto?>" />
				
				<label>Sua Mensagem:</label>
				<textarea name="mensagem" cols="" rows="" class="<?php if($mensagem_error) {?>error"><?php }else echo "enviarpara\">"?><?php echo $mensagem?></textarea>
				<h2 style="padding-top: 16px;">Fotos Selecionadas:</h2>
				<ul>
<?php do { ?>
					<li>
						<input name="" type="checkbox" value="" checked disabled/>
						<p class="img">
							<img src="<?php echo "http://www.pulsarimagens.com.br/";//$homeurl; ?>bancoImagens/<?php echo $row_dados_foto['tombo']; ?>p.jpg" style="max-width:75px; max-height:75px;" />
							<span></span>
						</p>
						<div class="clear"></div>
					</li>
<?php } while($row_dados_foto = mysql_fetch_assoc($dados_foto)); ?>					
					<div class="clear"></div>
				</ul>
				<div class="bts">
<?php if(isset($_GET['id_pasta'])) {?>
					<input name="id_pasta" type="hidden" value="<?php echo $_GET['id_pasta']; ?>"/>
<?php }?>
					<input name="tombo" type="hidden" value="<?php echo $_GET['tombo']; ?>"/>
					<input name="action" type="submit" value="Enviar e-mail" class="button" />
					<div class="bt-cancelar"><a href="<?php echo $url_cancel?>"></a></div>
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
