<?php require_once('Connections/sig.php'); ?>
<?php 
//$lingua = "br";
$show_price = true;
$sufix = isset($sufix)?$sufix:"";
$contrato = isVideo($MMColParam_dados_foto)?"V":"F";
?>
<?php include("../tool_details_download_form_script.php");?>
<?php 

$tipo_error = false;
$utilizacao_error = false;
$formato_error = false;
$distruibuicao_error = false;
$periodicidade_error = false;
$tamanho_error = false;
$obs_error = false;

$queryTipo = "SELECT USO_TIPO.tipo_$lingua as tipo,USO_TIPO.Id
				FROM USO
				LEFT JOIN USO_TIPO ON USO_TIPO.Id = USO.id_tipo
				LEFT JOIN USO_SUBTIPO ON USO.id_utilizacao = USO_SUBTIPO.Id
				WHERE USO.contrato = '$contrato' AND tipo_$lingua != ''
				GROUP BY tipo ORDER BY tipo";

$rsTipo = mysql_query($queryTipo, $sig) or die(mysql_error());


?>
			<div class="clear divisor"></div>
            	<div class="usos">    
                    <div class="usos-left">    
                    <form name="form1<?php echo $sufix?>" method="get" action="ecommerce/action.php">
	                
                        <label>Type of project:</label> <br />
	                    <select id="tipo<?php echo $sufix?>" name="tipo" class="select.uso tipo<?php echo $sufix?><?php if($tipo_error) echo " error"?>">
		                  	<option value="">--- Choose a project type ---</option>
<?php 
while($rowTipo = mysql_fetch_array($rsTipo)) { 
	if($rowTipo['tipo']!="ocultar") {
?>
		                  	<option value="<?php echo $rowTipo['Id']?>"><?php echo $rowTipo['tipo']?></option>
<?php 
	}
} 
?>		                  	
	                    </select><br />
						<input id="tipo_ant" name="tipo_ant" type="hidden" value="<?php //echo $rowUso['id_tipo']; ?>"/>

						<label class="utilizacao<?php echo $sufix?>">Usage:</label><br class="utilizacao<?php echo $sufix?>"/>
	                    <select id="utilizacao<?php echo $sufix?>" name="utilizacao" class="uso utilizacao<?php echo $sufix?><?php if($utilizacao_error) echo " error"?>">
		                  	<option value=""></option>
	                    </select><br class="utilizacao<?php echo $sufix?>"/>
						<input id="utilizacao_ant" name="utilizacao_ant" type="hidden" value="<?php //echo $rowUso['id_utilizacao']; ?>"/>
	                    
						<label class="formato<?php echo $sufix?>">Format:</label><br class="formato<?php echo $sufix?>"/>
	                    <select id="formato<?php echo $sufix?>" name="formato" class="uso formato<?php echo $sufix?><?php if($formato_error) echo " error"?>">
		                  	<option value=""></option>
	                    </select><br class="formato<?php echo $sufix?>"/>
						<input id="formato_ant" name="formato_ant" type="hidden" value="<?php //echo $rowUso['id_formato']; ?>"/>
	                    
						<label class="distribuicao<?php echo $sufix?>">Circulation:</label><br class="distribuicao<?php echo $sufix?>"/>
	                    <select id="distribuicao<?php echo $sufix?>" name="distribuicao" class="uso distribuicao<?php echo $sufix?><?php if($distruibuicao_error) echo " error"?>">
		                  	<option value=""></option>
	                    </select><br class="distribuicao<?php echo $sufix?>"/>
						<input id="distribuicao_ant" name="distribuicao_ant" type="hidden" value="<?php //echo $rowUso['id_distribuicao']; ?>"/>
	                    
						<label class="periodicidade<?php echo $sufix?>">Duration:</label><br class="periodicidade<?php echo $sufix?>"/>
	                    <select id="periodicidade<?php echo $sufix?>" name="periodicidade" class="uso periodicidade<?php echo $sufix?><?php if($periodicidade_error) echo " error"?>">
		                  	<option value=""></option>
	                    </select><br class="periodicidade<?php echo $sufix?>"/>
						<input id="periodicidade_ant" name="periodicidade_ant" type="hidden" value="<?php //echo $rowUso['id_periodicidade']; ?>"/>
	                    
						<label class="tamanho<?php echo $sufix?>">Size:</label><br class="tamanho<?php echo $sufix?>"/>
	                    <select id="tamanho<?php echo $sufix?>" name="tamanho" class="uso tamanho<?php echo $sufix?><?php if($tamanho_error) echo " error"?>">
		                    <option value=""></option>
	                    </select><br class="tamanho<?php echo $sufix?>"/>
	                    <input id="tamanho_ant" name="tamanho_ant" type="hidden" value="<?php //echo $rowUso['id_tamanho']; ?>"/>
                        </div>
                        
                        <div class="usos-right">
						<label class="valor<?php echo $sufix?>">Price:</label><br class="valor<?php echo $sufix?>"/>
	                    <textarea id="valor<?php echo $sufix?>" name="valor" cols="" rows="" class="obs valor<?php echo $sufix?><?php if($obs_error) echo " error"?>" disabled="disabled"></textarea>
	                    <input id="uso<?php echo $sufix?>" name="uso" type="hidden" value="0"/>
	                    <input id="uso_ant" name="uso_ant" type="hidden" value="<?php //echo $rowUso['Id'];?>"/>
	                    <input id="add<?php echo $sufix?>" name="add" type="hidden" value="<?php echo $MMColParam_dados_foto?>"/>
	                    <input id="lingua" name="lingua" type="hidden" value="<?php echo $lingua?>"/>
	                    
	                    <input id="addCarrinho" class="valor" name="action" type="submit" value="Add to cart"> 
					</form>
                    	</div>
                    </div>