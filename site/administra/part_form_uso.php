<?php require_once('Connections/sig.php'); ?>
<?php 
$lingua = "br";
$show_price = false;
$sufix = isset($sufix)?$sufix:"";
$contrato = "V";
?>
<?php include("../tool_details_download_form_script.php");?>
<?php 

$contrato = isVideo($MMColParam_dados_foto)?"V":"F";
$contrato = "V";

$tipo_error = false;
$utilizacao_error = false;
$formato_error = false;
$distruibuicao_error = false;
$periodicidade_error = false;
$tamanho_error = false;
$obs_error = false;

$queryTipo = "SELECT USO_TIPO.tipo_$lingua as tipo,USO_TIPO.Id
				FROM USO_SUBTIPO
				LEFT JOIN USO ON USO.id_utilizacao = USO_SUBTIPO.Id
				LEFT JOIN USO_TIPO ON USO_TIPO.Id = USO.id_tipo
				WHERE USO.contrato = '$contrato'
				GROUP BY tipo ORDER BY tipo";

$rsTipo = mysql_query($queryTipo, $sig) or die(mysql_error());


?>
					<form name="form1<?php echo $sufix?>" method="get" action="ecommerce/action.php">
	                    <label>* Tipo de projeto</label>
	                    <select id="tipo<?php echo $sufix?>" name="tipo" class="uso tipo<?php echo $sufix?><?php if($tipo_error) echo " error"?>">
		                  	<option value="">--- Escolha um tipo de projeto ---</option>
<?php 
while($rowTipo = mysql_fetch_array($rsTipo)) { 
?>
		                  	<option value="<?php echo $rowTipo['Id']?>"><?php echo $rowTipo['tipo']?></option>
<?php 
} 
?>		                  	
	                    </select>
						<input id="tipo_ant" name="tipo_ant" type="hidden" value="<?php //echo $rowUso['id_tipo']; ?>"/>

						<label class="utilizacao<?php echo $sufix?>">* Utilização</label>
	                    <select id="utilizacao<?php echo $sufix?>" name="utilizacao" class="uso utilizacao<?php echo $sufix?><?php if($utilizacao_error) echo " error"?>">
		                  	<option value="">--- Escolha um tipo de projeto primeiro ---</option>
	                    </select>
						<input id="utilizacao_ant" name="utilizacao_ant" type="hidden" value="<?php //echo $rowUso['id_utilizacao']; ?>"/>
	                    
						<label class="formato<?php echo $sufix?>">* Formato</label>
	                    <select id="formato<?php echo $sufix?>" name="formato" class="uso formato<?php echo $sufix?><?php if($formato_error) echo " error"?>">
		                  	<option value="">--- Escolha a utilização primeiro ---</option>
	                    </select>
						<input id="formato_ant" name="formato_ant" type="hidden" value="<?php //echo $rowUso['id_formato']; ?>"/>
	                    
						<label class="distribuicao<?php echo $sufix?>">* Distribuição</label>
	                    <select id="distribuicao<?php echo $sufix?>" name="distribuicao" class="uso distribuicao<?php echo $sufix?><?php if($distruibuicao_error) echo " error"?>">
		                  	<option value="">--- Escolha o formato primeiro ---</option>
	                    </select>
						<input id="distribuicao_ant" name="distribuicao_ant" type="hidden" value="<?php //echo $rowUso['id_distribuicao']; ?>"/>
	                    
						<label class="periodicidade<?php echo $sufix?>">* Periodicidade</label>
	                    <select id="periodicidade<?php echo $sufix?>" name="periodicidade" class="uso periodicidade<?php echo $sufix?><?php if($periodicidade_error) echo " error"?>">
		                  	<option value="">--- Escolha a distribuição primeiro ---</option>
	                    </select>
						<input id="periodicidade_ant" name="periodicidade_ant" type="hidden" value="<?php //echo $rowUso['id_periodicidade']; ?>"/>
	                    
						<label class="tamanho<?php echo $sufix?>">* Tamanho</label>
	                    <select id="tamanho<?php echo $sufix?>" name="tamanho" class="uso tamanho<?php echo $sufix?><?php if($tamanho_error) echo " error"?>">
		                    <option value="">--- Escolha a distribuição primeiro ---</option>
	                    </select>
	                    <input id="tamanho_ant" name="tamanho_ant" type="hidden" value="<?php //echo $rowUso['id_tamanho']; ?>"/>
	                    
						<label class="valor<?php echo $sufix?>">Valor:</label>
	                    <textarea id="valor<?php echo $sufix?>" name="valor" cols="" rows="" class="obs valor<?php echo $sufix?><?php if($obs_error) echo " error"?>" disabled="disabled"></textarea>
	                    <input id="uso<?php echo $sufix?>" name="uso" type="hidden" value="0"/>
	                    <input id="uso_ant" name="uso_ant" type="hidden" value="<?php //echo $rowUso['Id'];?>"/>
	                    <input id="add<?php echo $sufix?>" name="add" type="hidden" value="<?php echo $MMColParam_dados_foto?>"/>
	                    
	                    <input id="addCarrinho" class="valor" name="action" type="submit" value="Adicionar Carrinho"> 
					</form>