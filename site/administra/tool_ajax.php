<?php require_once('Connections/pulsar.php'); ?>
<?php require_once('Connections/sig.php'); ?>
<?php
$action = $_POST['action'];

if($action == "set_id_cliente_sig") {
	$id_cliente_sig = $_POST['id_cliente_sig'];
	$id_cadastro = $_POST['id_cadastro'];
	$query_set_id_cliente = "UPDATE cadastro SET id_cliente_sig = $id_cliente_sig WHERE id_cadastro = $id_cadastro";

	mysql_select_db($database_pulsar, $pulsar);
	mysql_query($query_set_id_cliente, $pulsar) or die(mysql_error());
}
else if($action == "clean_id_cliente_sig") {
	$id_cadastro = $_POST['id_cadastro'];
	$query_set_id_cliente = "UPDATE cadastro SET id_cliente_sig = NULL WHERE id_cadastro = $id_cadastro";

	mysql_select_db($database_pulsar, $pulsar);
	mysql_query($query_set_id_cliente, $pulsar) or die(mysql_error());
}
else if($action == "set_id_contato_sig") {
	$id_contato_sig = $_POST['id_contato_sig'];
	$id_cadastro = $_POST['id_cadastro'];
	$query_set_id_contato = "UPDATE cadastro SET id_contato_sig = $id_contato_sig WHERE id_cadastro = $id_cadastro";

	mysql_select_db($database_pulsar, $pulsar);
	mysql_query($query_set_id_contato, $pulsar) or die(mysql_error());
}
else if($action == "clean_id_contato_sig") {
	$id_cadastro = $_POST['id_cadastro'];
	$query_set_id_contato = "UPDATE cadastro SET id_contato_sig = NULL WHERE id_cadastro = $id_cadastro";

	mysql_select_db($database_pulsar, $pulsar);
	mysql_query($query_set_id_contato, $pulsar) or die(mysql_error());
}else if($action == "contato") {
		
	$id_cliente = $_POST['id_cliente'];
	$query_contatos = "SELECT ID, CONTATO FROM CONTATOS WHERE ID_CLIENTE = $id_cliente ORDER BY CONTATO";

	$contatos = mysql_query($query_contatos, $sig) or die('<option value="">--- Uso inv&aacute;lido ---</option>');
			$total_contatos = mysql_num_rows($contatos);
			if($total_contatos > 1) {
			?>
							<option value="">--- Escolha um contato ---</option>
<?php 	
	}
	else if($total_contatos == 0) {
?>
							<option value="">--- Uso inv&aacute;lido ---</option>
<?php		
	}
	while($row_contatos = mysql_fetch_array($contatos)) {
?>
		                  	<option value="<?php echo $row_contatos['ID']?>"><?php echo htmlentities($row_contatos['CONTATO'])?></option>
<?php 		
	}	
}


?>
