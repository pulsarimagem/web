<?php require_once('Connections/sig.php'); ?>
<?php 
$lingua = "br";
$show_price = true;
$MMColParam_dados_foto = $id;
$sufix = $id;
$id_uso = 0;

if($subtotal == 0) {
	include("../tool_details_download_form_script.php");

	$contrato = isVideo($MMColParam_dados_foto)?"V":"F";
	
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
	$uso = translate_iduso($id_uso,$lingua,$sig);
}
?>
<script>
$(document).ready(function() {
	$('.calculator<?php echo $sufix?>').click(function() {
		$("#form<?php echo $sufix?>").submit();
	});
});
</script>
					<form id="form<?php echo $sufix?>" name="form1<?php echo $sufix?>" method="get" action="ecommerce/action.php">

									<tbody>
										<tr>
										  <td>
											<div class="imagem">
											  <img src="http://www.pulsarimagens.com.br/bancoImagens/<?php echo $id?>.jpg" />
											  <ul class="acoes-item">
												<li class="adicionar"><a href="#">Adicionar as minhas imagens</a></li>
												<li class="remover last"><a href="ecommerce/action.php?del=<?php echo $id?>">Remover</a></li>
											  </ul>
											</div>
											<div class="details">
											  <ul>
												<li class="autor"><span class="label">Autor:</span> <?php echo $data['Nome_Fotografo']?></li>
												<li class="codigo"><span class="label">C&oacute;digo:</span> <?php echo $id?></li>
												<li class="uso show_uso" id="showuso_<?php echo $id?>"><span class="label">Uso:</span> <?php echo ($subtotal==0?"Clique aqui para adicionar o uso e o pre&ccedil;o nessa imagem":$uso)?></li>
												<li class="" id=""><div id="uso_<?php echo $id?>" style="display:none">
<?php 
if ($subtotal == 0) { 
?>												
	                    <label>* Tipo de projeto</label>
	                    <select id="tipo<?php echo $sufix?>" name="tipo" class="uso tipo<?php echo $sufix?><?php if($tipo_error) echo " error"?>">
		                  	<option value="">--- Escolha um tipo de projeto ---</option>
<?php 
while($rowTipo = mysql_fetch_array($rsTipo)) { 
	if($rowTipo['tipo']!="ocultar") {
?>
		                  	<option value="<?php echo $rowTipo['Id']?>"><?php echo $rowTipo['tipo']?></option>
<?php 
	}
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
	                    
	                    <input id="add<?php echo $sufix?>" name="add" type="hidden" value="<?php echo $MMColParam_dados_foto?>"/>
<?php 
}
?>
	                    <input id="uso<?php echo $sufix?>" name="uso" type="hidden" value="<?php echo $id_uso?>"/>
	                    <input id="uso_ant" name="uso_ant" type="hidden" value="<?php //echo $rowUso['Id'];?>"/>

		                    						</div>
	                    						</li>
											  </ul>
											</div>
										  </td>
										  <td class="acoes">
											<div class="calculo-preco <?php echo ($subtotal==0?"valor$sufix":"")?>">
											  <div id="valor<?php echo $sufix?>" class="preco">R$ <?php echo ($subtotal!=0?number_format($subtotal,2,',','.'):"???")?></div>
<?php if ($subtotal==0) { ?>
											  <div class="calcular"><a href="#" class="calculator<?php echo $sufix?>" id="produto_<?php echo $id?>">Aceitar preço</a></div>
<?php } ?>
											  </div>
										  </td>
										</tr>
									  </tbody>	
					</form>
									  