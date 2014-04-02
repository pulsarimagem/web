<?php require_once('Connections/pulsar.php'); ?>
<?php 
include("../tool_details_layout_form.php");
if(!$download_ok) {
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

<?php //include("part_grid_left.php")?>

	<div class="grid-center">
		<div class="details">
			<a href="<?php echo $_SESSION['last_detail'];?>" class="voltar">« Voltar</a>

			<div class="tipo-de-download">
				<form name="form1" method="post" action="details_layout_form.php">
	                <div class="form">
	                    <br /><h2>Layout</h2>
<?php if($has_error) {?>                    
	                    <div class="error-msg">Ops! Você precisa corrigir os campos em destaque para continuar.</div>
<?php }?>                    
<?php if($estouro_quota) {?>                    
	                    <div class="error-msg">Ops! Você estourou o seu limite de download!!!</div>
<?php } else {?>                    
<?php 	if ($totalRows_formulario > 0) {?>
	                    <input name="" type="button" value="Copiar dados do ultimo layout" class="button" onclick="copiar();"/>
<?php 	}?>
	                    <label>* Seu Nome:</label>
	                    <input id="usuario" name="nome" type="text" class="enviarpara<?php if($nome_error) echo " error"?>" value="<?php echo $nome?>" size="" />
	                    <input id="usuario_ant" name="usuario_ant" type="hidden" value="<?php echo $row_formulario['usuario']; ?>"/>
	                    
	                    <label>* Título do livro/projeto:</label>
	                    <input id="titulo" name="titulo" type="text" class="titulo<?php if($titulo_error) echo " error"?>" value="<?php echo $titulo?>" size="" />
	                    <input id="titulo_ant" name="titulo_ant" type="hidden" value="<?php echo $row_formulario['projeto']; ?>"/>
	                    
	                    <label>* Observações:</label>
	                    <textarea id="obs" name="obs" cols="" rows="" class="obs<?php if($obs_error) echo " error"?>""><?php echo $obs?></textarea>
	                    <input id="obs_ant" name="obs_ant" type="hidden" value="<?php echo $row_formulario['obs']; ?>"/>
	                    
<!--  	                    <p class="info">Ao clicar o botão "Aceito" você estará gerando uma autorização de cobrança.</p> -->
	                    
	                    <div class="bts">
	                        <input name="action" type="submit" value="Baixar" class="button" />
	                        <div class="bt-cancelar"><a href="<?php echo $_SESSION['last_detail'];?>"></a></div>
	                        <div class="clear"></div>
	                        <input name="tombo" type="hidden" value="<?php echo $tombo;?>"/>
<?php foreach($tombos as $tombo) {?>
	                        <input name="tombos[]" type="hidden" value="<?php echo $tombo;?>"/>
<?php } ?>
	                        <input name="tipo" type="hidden" value="<?php echo $tipo;?>"/>
							<input name="id_cadastro" type="hidden" value="<?php echo $usuario; ?>"/>
	                    </div>
<?php }?>	                    
	                </div>
                </form>
            </div>
		</div>
	</div>
	<div class="clear"></div>
</div>

<?php include("part_footer.php")?>

</body>
</html>
<?php 
} 
?>