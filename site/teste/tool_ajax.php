<?php require_once('Connections/pulsar.php'); ?>
<?php require_once('Connections/sig.php'); ?>
<?php
$action = $_POST['action'];

if($action == "tamanho") {
	$id_uso = $_POST['id_uso'];
	$tamanho = $_POST['tamanho'];
	$contrato = $_POST['contrato'];
	$query_tamanhos = "select uso.Id, descr.descricao, REPLACE(REPLACE(REPLACE(FORMAT(valor,2),'.','|'),',','.'),'|',',') as valor 
						from USO_DESC as descr, USO as uso 
						WHERE uso.id_descricao = descr.Id and uso.id_subtipo = $id_uso AND uso.contrato = '$contrato'
						GROUP BY descr.descricao ORDER BY descr.descricao";

	$tamanhos = mysql_query($query_tamanhos, $sig) or die('<option value="">--- Uso inv&aacute;lido ---</option>');
	$total_tamanhos = mysql_num_rows($tamanhos);
	if($total_tamanhos > 1) { 
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
?>