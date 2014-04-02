<?php require_once('Connections/pulsar.php'); ?>
<?php require_once('Connections/sig.php'); ?>
<?php include("../tool_details_download_form.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Imagens</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
<?php include("../tool_details_download_form_script.php");?>
</head>
<body>

<?php include("part_topbar.php")?>

<div class="main size960">

<?php //include("part_grid_left.php")?>

	<div class="grid-center">
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
	                    <input id="usuario_ant" name="usuario_ant" type="hidden" value="<?php echo $rowFormulario['usuario']; ?>"/>

	                    <label>* Título do livro/projeto:</label>
	                    <input id="titulo" name="titulo" type="text" class="titulo<?php if($titulo_error) echo " error"?>" value="<?php echo $titulo?>" size="" />
	                    <input id="titulo_ant" name="titulo_ant" type="hidden" value="<?php echo $rowFormulario['projeto']; ?>"/>
	                    
	                    <label>* Tipo de projeto</label>
	                    <select id="tipo" name="tipo" class="uso tipo<?php if($tipo_error) echo " error"?>">
		                  	<option value="">--- Escolha um tipo de projeto ---</option>
<?php 
while($rowTipo = mysql_fetch_array($rsTipo)) { 
	if($rowTipo['tipo']!="ocultar") { 
?>
		                  	<option value="<?php echo $rowTipo['Id']?>"<?php if ($tipo == $rowTipo['Id']) echo " selected";?>><?php echo $rowTipo['tipo']?></option>
<?php 
	}
} 
?>		                  	
	                    </select>
						<input id="tipo_ant" name="tipo_ant" type="hidden" value="<?php echo $rowUso['id_tipo']; ?>"/>

						<label class="utilizacao">* Utilização</label>
	                    <select id="utilizacao" name="utilizacao" class="uso utilizacao<?php if($utilizacao_error) echo " error"?>">
		                  	<option value="">--- Escolha um tipo de projeto primeiro ---</option>
	                    </select>
						<input id="utilizacao_ant" name="utilizacao_ant" type="hidden" value="<?php echo $rowUso['id_utilizacao']; ?>"/>
	                    
						<label class="formato">* Formato</label>
	                    <select id="formato" name="formato" class="uso formato<?php if($formato_error) echo " error"?>">
		                  	<option value="">--- Escolha a utilização primeiro ---</option>
	                    </select>
						<input id="formato_ant" name="formato_ant" type="hidden" value="<?php echo $rowUso['id_formato']; ?>"/>
	                    
						<label class="distribuicao">* Distribuição</label>
	                    <select id="distribuicao" name="distribuicao" class="uso distribuicao<?php if($distruibuicao_error) echo " error"?>">
		                  	<option value="">--- Escolha o formato primeiro ---</option>
	                    </select>
						<input id="distribuicao_ant" name="distribuicao_ant" type="hidden" value="<?php echo $rowUso['id_distribuicao']; ?>"/>
	                    
						<label class="periodicidade">* Periodicidade</label>
	                    <select id="periodicidade" name="periodicidade" class="uso periodicidade<?php if($periodicidade_error) echo " error"?>">
		                  	<option value="">--- Escolha a distribuição primeiro ---</option>
	                    </select>
						<input id="periodicidade_ant" name="periodicidade_ant" type="hidden" value="<?php echo $rowUso['id_periodicidade']; ?>"/>
	                    
						<label class="tamanho">* Tamanho</label>
	                    <select id="tamanho" name="tamanho" class="uso tamanho<?php if($tamanho_error) echo " error"?>">
		                    <option value="">--- Escolha a distribuição primeiro ---</option>
	                    </select>
	                    <input id="tamanho_ant" name="tamanho_ant" type="hidden" value="<?php echo $rowUso['id_tamanho']; ?>"/>
	                    
						<label class="descricao">Descrição:</label>
	                    <textarea id="descricao" name="descricao" cols="" rows="" class="obs descricao<?php if($obs_error) echo " error"?>" disabled="disabled"></textarea>
	                    
	                    <label>Observações:</label>
	                    <textarea id="obs" name="obs" cols="" rows="" class="obs<?php if($obs_error) echo " error"?>""><?php echo $obs?></textarea>
	                    <input id="obs_ant" name="obs_ant" type="hidden" value="<?php //echo $rowFormulario['obs']; ?>"/>
	                    
  	                    <p class="info">Ao clicar o botão "Aceito" você estará gerando uma autorização de cobrança.</p> 
	                    
	                    <div class="bts">
	                        <input name="action" type="submit" value="Aceito" class="button" />
	                        <div class="bt-cancelar"><a href="<?php echo $_SESSION['last_detail'];?>"></a></div>
	                        <div class="clear"></div>
	                        <input id="uso" name="uso" type="hidden" value="0"/>
	                        <input id="uso_ant" name="uso_ant" type="hidden" value="<?php echo $rowUso['Id'];?>"/>
	                        <input name="tombo" type="hidden" value="<?php echo $tombo;?>"/>
<?php foreach($tombos as $tombo) {?>
	                        <input name="tombos[]" type="hidden" value="<?php echo $tombo;?>"/>
<?php } ?>
	                        <input name="contrato" type="hidden" value="<?php echo $contrato;?>"/>
							<input name="resolucao" type="hidden" value="<?php echo $resolucao;?>"/>
							<input name="name" type="hidden" value="<?php echo $name;?>"/>
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
<?php if($contrato=="V") {?>			
				<form name="form1" id="download_form" method="get" action="<?php echo $cloud_server?>download_videos.php">
<?php } else if($contrato=="F") {?>			
				<form name="form1" id="download_form" method="post" action="details_download_page.php">
<?php } ?>
					<div class="form">
	                    <h2>Download</h2>	                    
	                    <div>O seu download irá iniciar automaticamente em alguns segundos. Caso não inicie <input name="action" type="submit" value="clique aqui"/></div>
 						
	                    <div class="bts">
	                        <input name="action" type="hidden" value="Aceito" class="button" />
	                        <a href="<?php echo $_SESSION['last_detail'];?>">Voltar</a>
	                        <div class="clear"></div>
	                        <input name="tombo" type="hidden" value="<?php echo $tombo;?>"/>
<?php foreach($tombos as $tombo) {?>
	                        <input name="tombos[]" type="hidden" value="<?php echo $tombo;?>"/>
<?php } ?>
							<input name="nome" type="hidden" value="<?php echo $_POST['nome']?>"/>
							<input name="titulo" type="hidden" value="<?php echo $_POST['titulo']?>"/>
							<input name="tipo" type="hidden" value="<?php echo $_POST['tipo']?>"/>
							<input name="utilizacao" type="hidden" value="<?php echo $_POST['utilizacao']?>"/>
							<input name="formato" type="hidden" value="<?php echo $_POST['formato']?>"/>
							<input name="distribuicao" type="hidden" value="<?php echo $_POST['distribuicao']?>"/>
							<input name="periodicidade" type="hidden" value="<?php echo $_POST['periodicidade']?>"/>
							<input name="tamanho" type="hidden" value="<?php echo $_POST['tamanho']?>"/>
							<input name="uso" type="hidden" value="<?php echo $_POST['uso']?>"/>
							
							<input name="obs" type="hidden" value="<?php echo $_POST['obs']?>"/>

							<input name="tipo" type="hidden" value="<?php echo $tipo;?>"/>
							<input name="id_cadastro" type="hidden" value="<?php echo $usuario; ?>"/>
							
							<input name="u" type="hidden" value="<?php echo $row_top_login['login']; ?>"/>
							<input name="p" type="hidden" value="<?php echo $row_top_login['senha']; ?>"/>
							<input name="c" type="hidden" value="<?php echo $name; ?>"/>
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
