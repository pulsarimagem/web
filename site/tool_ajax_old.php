<?php require_once('Connections/pulsar.php'); ?>
<?php require_once('Connections/sig.php'); ?>
<?php
header('Content-Type: text/html; charset=ISO-8859-1');

$action = $_POST['action'];

if($action == "tamanho") {
	$id_uso = $_POST['id_uso'];
	$tamanho = isset($_POST['tamanho'])?$_POST['tamanho']:"";
	$contrato = $_POST['contrato'];
	$query_tamanhos = "select uso.Id, descr.descricao, REPLACE(REPLACE(REPLACE(FORMAT(valor,2),'.','|'),',','.'),'|',',') as valor 
						from USO_DESC as descr, USO as uso 
						WHERE uso.id_descricao = descr.Id and uso.id_subtipo = $id_uso AND uso.contrato = '$contrato' AND descr.descricao NOT LIKE '%ÍNDIO%'
						GROUP BY descr.descricao ORDER BY descr.descricao";

	$tamanhos = mysql_query($query_tamanhos, $sig) or die('<option value="">--- Uso inv&aacute;lido ---</option>');
	$total_tamanhos = mysql_num_rows($tamanhos);
	if($total_tamanhos > 0) { 
?>
							<option value="">--- Escolha um tamanho ---</option>
<?php 	
	}
	else if($total_tamanhos == 0) {
?>
							<option value="">--- Uso inv&aacute;lido ---</option>
<?php		
	}
	while($row_tamanhos = mysql_fetch_array($tamanhos)) {
?>
		                  	<option value="<?php echo $row_tamanhos['Id']?>"<?php if ($tamanho == $row_tamanhos['Id']) echo " selected";?>><?php echo htmlentities($row_tamanhos['descricao'])?></option>
<?php 		
	}	
}

else if($action == "distribuicao") {
	$id_projeto = $_POST['id_projeto'];
	$distribuicao = isset($_POST['distribuicao'])?$_POST['distribuicao']:"";
	$contrato = $_POST['contrato'];
	$query_uso = "SELECT USO_TIPO.tipo, USO_SUBTIPO.subtipo, USO_SUBTIPO.Id 
				FROM USO_SUBTIPO 
				LEFT JOIN USO ON USO.id_subtipo = USO_SUBTIPO.Id 
				LEFT JOIN USO_TIPO ON USO_TIPO.Id = USO.id_tipo
				WHERE USO.contrato = '$contrato' AND USO.id_tipo = $id_projeto
				GROUP BY subtipo ORDER BY tipo,subtipo";

	$usos = mysql_query($query_uso, $sig) or die('<option value="">--- Uso inv&aacute;lido ---</option>');
			$total_usos = mysql_num_rows($usos);
			if($total_usos > 0) {
			?>
							<option value="">--- Escolha um tipo de distribui&ccedil;&atilde;o ---</option>
<?php 	
	}
	else if($total_usos == 0) {
?>
							<option value="">--- Tipo de projeto inv&aacute;lido ---</option>
<?php		
	}
	while($row_usos = mysql_fetch_array($usos)) {
?>
		                  	<option value="<?php echo $row_usos['Id']?>"<?php if ($distribuicao == $row_usos['Id']) echo " selected";?>><?php echo htmlentities($row_usos['subtipo'])?></option>
<?php 		
	}	
}
?>