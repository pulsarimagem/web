<?php require_once('Connections/pulsar.php'); ?>
<?php require_once('Connections/sig.php'); ?>
<?php 
include("tool_details_download_page.php");
if(!$download_ok) {
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
	                    <select id="uso" name="uso" class="uso<?php if($uso_error) echo " error"?>">
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
<!-- 		                  	
		                  	<option>--- EDITORIAL ---</option>
		                  	<option value="Livro did&aacute;tico"<?php if ($uso == "Livro didático") echo " selected";?>>Livro did&aacute;tico</option>
		                  	<option value="Cd ROM did&aacute;tico"<?php if ($uso == "Cd ROM didático") echo " selected";?>>Cd ROM did&aacute;tico</option>
		                  	<option value="Paradid&aacute;tico / Enciclop&eacute;dia"<?php if ($uso == "Paradidático / Enciclopédia") echo " selected";?>>Paradid&aacute;tico / Enciclop&eacute;dia</option>
		                  	<option value="Revista / Jornal / Fasc&iacute;culo / Livro"<?php if ($uso == "Revista / Jornal / Fascículo / Livro") echo " selected";?>>Revista / Jornal / Fasc&iacute;culo / Livro</option>
		                  	<option value="Anu&aacute;rio / Guia editorial"<?php if ($uso == "Anuário / Guia editorial") echo " selected";?>>Anu&aacute;rio / Guia editorial</option>
		                  	<option value="Internet editorial / educacional"<?php if ($uso == "Internet editorial / educacional") echo " selected";?>>Internet editorial / educacional</option>
		                  	<option>--- INSTITUCIONAL ---</option>
		                  	<option value="Agenda"<?php if ($uso == "Agenda") echo " selected";?>>Agenda</option>
		                  	<option value="An&uacute;ncio - Jornal"<?php if ($uso == "Anúncio - Jornal") echo " selected";?>>An&uacute;ncio - Jornal</option>
		                  	<option value="An&uacute;ncio - pequena circula&ccedil;&atilde;o"<?php if ($uso == "Anúncio - pequena circulação") echo " selected";?>>An&uacute;ncio - pequena circula&ccedil;&atilde;o</option>
		                  	<option value="An&uacute;ncio - m&eacute;dia circula&ccedil;&atilde;o"<?php if ($uso == "Anúncio - média circulação") echo " selected";?>>An&uacute;ncio - m&eacute;dia circula&ccedil;&atilde;o</option>
		                  	<option value="An&uacute;ncio - grande circula&ccedil;&atilde;o"<?php if ($uso == "Anúncio - grande circulação") echo " selected";?>>An&uacute;ncio - grande circula&ccedil;&atilde;o</option>
		                  	<option value="Back-light / outdoor"<?php if ($uso == "Back-light / outdoor") echo " selected";?>>Back-light / outdoor</option>
		                  	<option value="Bandeirola / Display / Ponto de venda"<?php if ($uso == "Bandeirola / Display / Ponto de venda") echo " selected";?>>Bandeirola / Display / Ponto de venda</option>
		                  	<option value="Banner (ambiente externo)"<?php if ($uso == "Banner (ambiente externo)") echo " selected";?>>Banner (ambiente externo)</option>
		                  	<option value="Calend&aacute;rio - Mesa"<?php if ($uso == "Calendário - Mesa") echo " selected";?>>Calend&aacute;rio - Mesa</option>
		                  	<option value="Calend&aacute;rio - Parede"<?php if ($uso == "Calendário - Parede") echo " selected";?>>Calend&aacute;rio - Parede</option>
		                  	<option value="Folheto / Cat&aacute;logo / Mala direta"<?php if ($uso == "Folheto / Catálogo / Mala direta") echo " selected";?>>Folheto / Cat&aacute;logo / Mala direta</option>
		                  	<option value="Internet - full banner"<?php if ($uso == "Internet - full banner") echo " selected";?>>Internet - full banner</option>
		                  	<option value="Internet - home page / site"<?php if ($uso == "Internet - home page / site") echo " selected";?>>Internet - home page / site</option>
		                  	<option value="Livro e Cd ROM institucional"<?php if ($uso == "Livro e Cd ROM institucional") echo " selected";?>>Livro e Cd ROM institucional</option>
		                  	<option value="P&ocirc;ster - decorativo"<?php if ($uso == "Pôster - decorativo") echo " selected";?>>P&ocirc;ster - decorativo</option>
		                  	<option value="P&ocirc;ster - promocional"<?php if ($uso == "Pôster - promocional") echo " selected";?>>P&ocirc;ster - promocional</option>
		                  	<option value="Relat&oacute;rio anual"<?php if ($uso == "Relatório anual") echo " selected";?>>Relat&oacute;rio anual</option>
		                  	<option value="V&iacute;deo - cultural"<?php if ($uso == "Vídeo - cultural") echo " selected";?>>V&iacute;deo - cultural</option>
		                  	<option value="V&iacute;deo - institucional"<?php if ($uso == "Vídeo - institucional") echo " selected";?>>V&iacute;deo - institucional</option>
		                  	<option value="Outros usos (especificar no campo abaixo)"<?php if ($uso == "Outros usos (especificar no campo abaixo)") echo " selected";?>>Outros usos (especificar no campo abaixo)</option>
 -->		                  	
	                    </select>
						<input id="uso_ant" name="uso_ant" type="hidden" value="<?php echo $row_formulario['uso']; ?>"/>
	                    
	                    <label>* Tamanho</label>
	                    <select id="formato" name="tamanho" class="tamanho<?php if($tamanho_error) echo " error"?>">
		                    <option value="">--- Escolha um uso primeiro ---</option>
<!-- 		                    
		                  	<option value="Capa"<?php if ($tamanho == "Capa") echo " selected";?>>Capa</option>
		                  	<option value="4&ordf; Capa"<?php if ($tamanho == "4ª Capa") echo " selected";?>>4&ordf; Capa</option>
		                  	<option value="P&aacute;gina inteira"<?php if ($tamanho == "Página inteira") echo " selected";?>>P&aacute;gina inteira</option>
		                  	<option value="P&aacute;gina dupla"<?php if ($tamanho == "Página dupla") echo " selected";?>>P&aacute;gina dupla</option>
		                  	<option value="At&eacute; 1/2 P&aacute;gina"<?php if ($tamanho == "Até 1/2 Página") echo " selected";?>>At&eacute; 1/2 P&aacute;gina</option>
		                  	<option value="Outro tamanho (especificar nas Observa&ccedil;&otilde;es)"<?php if ($tamanho == "Outro tamanho (especificar nas Observações)") echo " selected";?>>Outro tamanho (especificar nas Observa&ccedil;&otilde;es)</option>
 -->		                  	
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