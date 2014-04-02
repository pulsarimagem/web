<?php require_once('Connections/pulsar.php'); ?>
<?php require_once('Connections/sig.php'); ?>
<?php 
include("tool_details_video_form.php");
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
		<div class="details">
			<a href="<?php echo $_SESSION['last_detail'];?>" class="voltar">« Voltar</a><br /><br />
<?php 
if(!$download_ok) {
?>
			<div class="tipo-de-download">
				<form name="form1" method="post" action="details_download_form.php">
	                <div class="form">
	                    <h2>Download</h2>
<?php if($has_error) {?>                    
	                    <div class="error-msg">Ops! Você precisa corrigir os campos em destaque para continuar.</div>
<?php }?>                    
<?php if($estouro_quota) {?>                    
	                    <div class="error-msg">Ops! Você estourou o seu limite de download!!!</div>
<?php } else {?>                    
<?php 	if ($totalRows_formulario > 0) {?>
	                    <input name="" type="button" value="Copiar dados do ultimo Download" class="button" onclick="copiar();"/>
<?php 	}?>
	                    <label>* Seu Nome:</label>
	                    <input id="usuario" name="nome" type="text" class="enviarpara<?php if($nome_error) echo " error"?>" value="<?php echo $nome?>" size="" />
	                    <input id="usuario_ant" name="usuario_ant" type="hidden" value="<?php echo $row_formulario['usuario']; ?>"/>
	                    
	                    <label>* Circulação:</label>
	
	                    <div class="circulacao">
	                        <p><input id="circulacao1" name="circulacao" type="radio" value="Nacional" checked /> <label>Nacional</label></p>
	                        <p><input id="circulacao2" name="circulacao" type="radio" value="Internacional" /> <label>Internacional</label></p>
	                        <p><input id="circulacao3" name="circulacao" type="radio" value="Nac/Internacional" /> <label>Ambos</label></p>
						</div>
						<input id="circulacao_ant" name="circulacao_ant" type="hidden" value="<?php
						if ($row_formulario['circulacao'] == "Nacional") {
						 	echo "circulacao1";
						};
						if ($row_formulario['circulacao'] == "Internacional") {
						 	echo "circulacao2";
						};
						if ($row_formulario['circulacao'] == "Nac/Internacional") {
						 	echo "circulacao3";
						}; 
						?>"/>
<!-- 	                    
	                    <label>Tiragem aproximada:</label>
	
	                    <input id="tiragem" name="tiragem" type="text" class="tiragemapro<?php if($tiragem_error) echo " error"?>"" value="<?php echo $tiragem?>" size="" />
	                    <input id="tiragem_ant" name="tiragem_ant" type="hidden" value="<?php echo $row_formulario['tiragem']; ?>"/>
 -->	                    
	                    <label>* Título do livro/projeto:</label>
	                    <input id="titulo" name="titulo" type="text" class="titulo<?php if($titulo_error) echo " error"?>" value="<?php echo $titulo?>" size="" />
	                    <input id="titulo_ant" name="titulo_ant" type="hidden" value="<?php echo $row_formulario['projeto']; ?>"/>
	                    
	                    <label>* Uso</label>
	                    <select id="uso_video" name="uso" class="uso<?php if($uso_error) echo " error"?>">
		                  	<option value="">--- Escolha um Uso ---</option>
<?php 
$last_tipo = "";
while($row_usos = mysql_fetch_array($usos)) { 
	if($row_usos['tipo']!=$last_tipo) {
		$last_tipo = $row_usos['tipo'];
?>
							<option>--- <?php echo $last_tipo?> ---</option>
<?php 
	}		
		
?>
		                  	<option value="<?php echo $row_usos['Id']?>"<?php if ($uso == $row_usos['Id']) echo " selected";?>><?php echo $row_usos['subtipo']?></option>
<?php 
} 
?>		                  	
	                    </select>
						<input id="uso_ant" name="uso_ant" type="hidden" value="<?php echo $row_formulario['uso']; ?>"/>
	                    
	                    <label>* Tamanho</label>
	                    <select id="formato" name="tamanho" class="tamanho<?php if($tamanho_error) echo " error"?>">
		                    <option value="">--- Escolha um uso primeiro ---</option>
	                    </select>
	                    <input id="formato_ant" name="formato_ant" type="hidden" value="<?php echo $row_formulario['formato']; ?>"/>
	                    
						<label>Observações:</label>
	                    <textarea id="obs" name="obs" cols="" rows="" class="obs<?php if($obs_error) echo " error"?>""><?php echo $obs?></textarea>
	                    <input id="obs_ant" name="obs_ant" type="hidden" value="<?php echo $row_formulario['obs']; ?>"/>
	                    
  	                    <p class="info">Ao clicar o botão "Aceito" você estará gerando uma autorização de cobrança.</p> 
	                    
	                    <div class="bts">
	                        <input name="action" type="submit" value="Aceito" class="button" />
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
<?php 
} 
else {
?>
<script>
jQuery(document).ready(function() {
	$('#download_form').submit();
});
</script>	                    
			<div class="tipo-de-download">
				<form name="form1" id="download_form" method="post" action="details_download_page.php">
	                <div class="form">
	                    <h2>Download</h2>	                    
	                    <div>O seu download irá iniciar automaticamente em alguns segundos. Caso não inicie, click <input name="action" type="submit" value="aqui" style="background:none;border:0;color:#ff0000"/>.</div>
 						
	                    <div class="bts">
	                        <input name="action" type="hidden" value="Aceito" class="button" />
	                        <a href="<?php echo $_SESSION['last_detail'];?>">Voltar</a>
	                        <div class="clear"></div>
	                        <input name="tombo" type="hidden" value="<?php echo $tombo;?>"/>
<?php foreach($tombos as $tombo) {?>
	                        <input name="tombos[]" type="hidden" value="<?php echo $tombo;?>"/>
<?php } ?>
							<input name="nome" type="hidden" value="<?php echo $_POST['nome']?>"/>
							<input name="circulacao" type="hidden" value="<?php echo $_POST['circulacao']?>"/>
							<input name="tiragem" type="hidden" value="<?php echo $_POST['tiragem']?>"/>
							<input name="titulo" type="hidden" value="<?php echo $_POST['titulo']?>"/>
							<input name="tamanho" type="hidden" value="<?php echo $_POST['tamanho']?>"/>
							<input name="uso" type="hidden" value="<?php echo $_POST['uso']?>"/>
							<input name="obs" type="hidden" value="<?php echo $_POST['obs']?>"/>

							<input name="tipo" type="hidden" value="<?php echo $tipo;?>"/>
							<input name="id_cadastro" type="hidden" value="<?php echo $usuario; ?>"/>
	                    </div>
	            	</div>
	            </form>
	        </div>

<?php 
}
?>            
		</div>
	</div>
	<div class="clear"></div>
</div>

<?php include("part_footer.php")?>

</body>
</html>
