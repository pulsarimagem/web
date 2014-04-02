<?php require_once('Connections/sig.php'); ?>
<?php 
//$lingua = "br";
$show_price = true;
$MMColParam_dados_foto = $id;
$sufix = $id;
$id_uso = 0;
$contrato = isVideo($MMColParam_dados_foto)?"V":"F";

if($subtotal == 0) {
	include("../tool_details_download_form_script.php");

	
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
}
else {
	$id_uso = $_SESSION['produto'.$id]['uso'];
}
?>
<script>
$(document).ready(function() {
	$('.calculator<?php echo $sufix?>').click(function() {
		$("#form<?php echo $sufix?>").submit();
	});
	$('.copiar<?php echo $sufix?>').click(function() {
		$("#uso<?php echo $sufix?>").val($("#uso_ant").val());
		$("#form<?php echo $sufix?>").submit();
	});
	
});
</script>
					<form id="form<?php echo $sufix?>" name="form1<?php echo $sufix?>" method="get" action="ecommerce/action.php">

									<tbody>
										<tr>
										  <td>
											<div class="imagem">
											  <img src="http://www.pulsarimagens.com.br/bancoImagens/<?php echo $id?>p.jpg" />
											  <ul class="acoes-item">
<!-- 												<li class="adicionar"><a href="#">Add to my images</a></li> -->
												<li class="remover last"><a href="ecommerce/action.php?del=<?php echo $id?>">Remove</a></li>
											  </ul>
											</div>
											<div class="descricao">
											  <ul>
												<li class="autor"><span class="label">Author:</span> <?php echo $data['Nome_Fotografo']?></li>
												<li class="codigo"><span class="label">Code:</span> <?php echo $id?></li>
												<li class="uso show_uso" id="showuso_<?php echo $id?>"><span class="label">Usage description:</span> <?php echo ($subtotal==0?"":translate_iduso($id_uso,$lingua,$sig))?></li>
												<li class="" id=""><div id="uso_<?php echo $id?>" <?php echo ($subtotal==0?"":"style=\"display:none\"")?>>
<?php 
if ($subtotal == 0) { 
?>												
	                    <label>Type of project:</label> <br />
	                    <select id="tipo<?php echo $sufix?>" name="tipo" class="uso tipo<?php echo $sufix?><?php if($tipo_error) echo " error"?>">
		                  	<option value="">Select one option below</option>
<?php 
while($rowTipo = mysql_fetch_array($rsTipo)) { 
?>
		                  	<option value="<?php echo $rowTipo['Id']?>"><?php echo $rowTipo['tipo']?></option>
<?php 
} 
?>		                  	
	                    </select><br />
						<input id="tipo_ant" name="tipo_ant" type="hidden" value="<?php //echo $rowUso['id_tipo']; ?>"/>

						<label class="utilizacao<?php echo $sufix?>">Usage:</label><br class="utilizacao<?php echo $sufix?>"/>
	                    <select id="utilizacao<?php echo $sufix?>" name="utilizacao" class="uso utilizacao<?php echo $sufix?><?php if($utilizacao_error) echo " error"?>">
		                  	<option value="">Escolha um tipo de projeto primeiro</option>
	                    </select><br class="utilizacao<?php echo $sufix?>"/>
						<input id="utilizacao_ant" name="utilizacao_ant" type="hidden" value="<?php //echo $rowUso['id_utilizacao']; ?>"/>
	                    
						<label class="formato<?php echo $sufix?>">Format:</label><br class="formato<?php echo $sufix?>"/>
	                    <select id="formato<?php echo $sufix?>" name="formato" class="uso formato<?php echo $sufix?><?php if($formato_error) echo " error"?>">
		                  	<option value="">--- Escolha a utilização primeiro ---</option>
	                    </select><br class="formato<?php echo $sufix?>"/>
						<input id="formato_ant" name="formato_ant" type="hidden" value="<?php //echo $rowUso['id_formato']; ?>"/>
	                    
						<label class="distribuicao<?php echo $sufix?>">Circulation:</label><br class="distribuicao<?php echo $sufix?>"/>
	                    <select id="distribuicao<?php echo $sufix?>" name="distribuicao" class="uso distribuicao<?php echo $sufix?><?php if($distruibuicao_error) echo " error"?>">
		                  	<option value="">--- Escolha o formato primeiro ---</option>
	                    </select><br class="distribuicao<?php echo $sufix?>"/>
						<input id="distribuicao_ant" name="distribuicao_ant" type="hidden" value="<?php //echo $rowUso['id_distribuicao']; ?>"/>
	                    
						<label class="periodicidade<?php echo $sufix?>">Duration:</label><br class="periodicidade<?php echo $sufix?>"/>
	                    <select id="periodicidade<?php echo $sufix?>" name="periodicidade" class="uso periodicidade<?php echo $sufix?><?php if($periodicidade_error) echo " error"?>">
		                  	<option value="">--- Escolha a distribuição primeiro ---</option>
	                    </select><br class="periodicidade<?php echo $sufix?>"/>
						<input id="periodicidade_ant" name="periodicidade_ant" type="hidden" value="<?php //echo $rowUso['id_periodicidade']; ?>"/>
	                    
						<label class="tamanho<?php echo $sufix?>">Size:</label><br class="tamanho<?php echo $sufix?>"/>
	                    <select id="tamanho<?php echo $sufix?>" name="tamanho" class="uso tamanho<?php echo $sufix?><?php if($tamanho_error) echo " error"?>">
		                    <option value="">--- Escolha a distribuição primeiro ---</option>
	                    </select><br class="tamanho<?php echo $sufix?>"/>
	                    <input id="tamanho_ant" name="tamanho_ant" type="hidden" value="<?php //echo $rowUso['id_tamanho']; ?>"/>
	                    
	                    <input id="add<?php echo $sufix?>" name="add" type="hidden" value="<?php echo $MMColParam_dados_foto?>"/>
<?php 
}
?>
	                    <input id="uso<?php echo $sufix?>" name="uso" type="hidden" value="<?php echo $id_uso?>"/>
	                    <input id="uso_ant" name="uso_ant" type="hidden" value="<?php echo isset($_SESSION['lastUso'])?$_SESSION['lastUso']:"0"?>"/>
	                    
		                    						</div>
	                    						</li>
											  </ul>
											</div>
										  </td>
										  <td class="acoes">
<?php if ($subtotal==0 && isset($_SESSION['lastUso'])) { ?>
										    <div class="copiar"><a href="#" class="copiar<?php echo $sufix?>" id="copiar_produto_<?php echo $id?>">Copiar ultimo uso</a></div>
<?php } ?>
										    <div class="calculo-preco <?php echo ($subtotal==0?"valor$sufix":"")?>">
											  <div id="valor<?php echo $sufix?>" class="preco"><?php echo CARRINHO_MOEDA?> <?php echo ($subtotal!=0?number_format($subtotal,2,'.',','):"???")?></div>
<?php if ($subtotal==0) { ?>
											  <div class="calcular"><a href="#" class="calculator<?php echo $sufix?>" id="produto_<?php echo $id?>">Aceitar preço</a></div>
<?php } ?>
											  </div>
										  </td>
										</tr>
									  </tbody>	
					</form>
									  