<?php require_once('Connections/sig.php'); ?>
<?php 
$lingua = "br";
$show_price = false;
$sufix = isset($sufix)?$sufix:"";
$contrato = isVideo($MMColParam_dados_foto)?"V":"F";
// $contrato = "V";
?>
<?php include("./tool_details_download_form_script.php");?>
<?php 

// $contrato = "V";

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

if($siteDebug) {
	echo "$sql3<br>";
}

?>
					<form name="form1<?php echo $sufix?>" method="get" action="ecommerce/action.php">
					
						<input type="hidden" id="usuario" name="usuario" value=""/>
						<input type="hidden" id="usuario_ant" name="usuario_ant" value=""/>
						
						
	                    <label>* Tipo de projeto</label>
	                    <select id="tipo<?php echo $sufix?>" name="tipo" class="notChosen uso tipo<?php echo $sufix?><?php if($tipo_error) echo " error"?>">
		                  	<option value="">--- Escolha um tipo de projeto ---</option>
<?php 
while($rowTipo = mysql_fetch_array($rsTipo)) { 
?>
		                  	<option value="<?php echo $rowTipo['Id']?>"><?php echo $rowTipo['tipo']?></option>
<?php 
} 
?>		                  	
	                    </select>
						<input id="tipo_ant<?php echo $sufix?>" name="tipo_ant" type="hidden" value="<?php echo $rowUso['id_tipo']; ?>"/>

						<label class="utilizacao<?php echo $sufix?>">* Utiliza��o</label>
	                    <select id="utilizacao<?php echo $sufix?>" name="utilizacao" class="notChosen uso utilizacao<?php echo $sufix?><?php if($utilizacao_error) echo " error"?>">
		                  	<option value="">--- Escolha um tipo de projeto primeiro ---</option>
	                    </select>
						<input id="utilizacao_ant<?php echo $sufix?>" name="utilizacao_ant" type="hidden" value="<?php echo $rowUso['id_utilizacao']; ?>"/>
	                    
						<label class="formato<?php echo $sufix?>">* Formato</label>
	                    <select id="formato<?php echo $sufix?>" name="formato" class="notChosen uso formato<?php echo $sufix?><?php if($formato_error) echo " error"?>">
		                  	<option value="">--- Escolha a utiliza��o primeiro ---</option>
	                    </select>
						<input id="formato_ant<?php echo $sufix?>" name="formato_ant" type="hidden" value="<?php echo $rowUso['id_formato']; ?>"/>
	                    
						<label class="distribuicao<?php echo $sufix?>">* Distribui��o</label>
	                    <select id="distribuicao<?php echo $sufix?>" name="distribuicao" class="notChosen uso distribuicao<?php echo $sufix?><?php if($distruibuicao_error) echo " error"?>">
		                  	<option value="">--- Escolha o formato primeiro ---</option>
	                    </select>
						<input id="distribuicao_ant<?php echo $sufix?>" name="distribuicao_ant" type="hidden" value="<?php echo $rowUso['id_distribuicao']; ?>"/>
	                    
						<label class="periodicidade<?php echo $sufix?>">* Periodicidade</label>
	                    <select id="periodicidade<?php echo $sufix?>" name="periodicidade" class="notChosen uso periodicidade<?php echo $sufix?><?php if($periodicidade_error) echo " error"?>">
		                  	<option value="">--- Escolha a distribui��o primeiro ---</option>
	                    </select>
						<input id="periodicidade_ant<?php echo $sufix?>" name="periodicidade_ant" type="hidden" value="<?php echo $rowUso['id_periodicidade']; ?>"/>
	                    
						<label class="tamanho<?php echo $sufix?>">* Tamanho</label>
	                    <select id="tamanho<?php echo $sufix?>" name="tamanho" class="notChosen uso tamanho<?php echo $sufix?><?php if($tamanho_error) echo " error"?>">
		                    <option value="">--- Escolha a distribui��o primeiro ---</option>
	                    </select>
	                    <input id="tamanho_ant<?php echo $sufix?>" name="tamanho_ant" type="hidden" value="<?php echo $rowUso['id_tamanho']; ?>"/>
	                    
						<label class="valor<?php echo $sufix?>">Valor:</label>
	                    <textarea id="valor<?php echo $sufix?>" name="valor" cols="" rows="" class="obs valor<?php echo $sufix?><?php if($obs_error) echo " error"?>" disabled="disabled"></textarea>
	                    <input id="uso<?php echo $sufix?>" name="uso" type="hidden" value="0"/>
	                    <input id="uso_ant<?php echo $sufix?>" name="uso_ant" type="hidden" value="<?php echo $rowUso['Id'];?>"/>
	                    <input id="add<?php echo $sufix?>" name="add" type="hidden" value="<?php echo $MMColParam_dados_foto?>"/>
	                    
	                    <input id="addCarrinho" class="valor" name="action" type="submit" value="Adicionar Carrinho" style="display: none"> 
					</form>