<?php require_once('Connections/pulsar.php'); ?>
<?php require_once('Connections/sig.php'); ?>
<?php
$action = $_POST['action'];

if($action == "salveIPTC") {
	$iptcpal = $_POST['iptcPal'];
	$idFoto = $_POST['idFoto'];
	
	$pal_chave_arr = explode(";",str_replace(",",";",$iptcpal));
	mysql_select_db($database_pulsar, $pulsar);
	
	foreach($pal_chave_arr as $pc) {
		$pc = trim($pc);
		if($pc == "")
			continue;
		$pc = (get_magic_quotes_gpc()) ? $pc : addslashes($pc);
		$query_pal_chave = sprintf("SELECT * FROM pal_chave WHERE Pal_Chave = '%s'", $pc);
		$pal_chave = mysql_query($query_pal_chave, $pulsar) or die(mysql_error());
		$row_pal_chave = mysql_fetch_assoc($pal_chave);
		$totalRows_pal_chave = mysql_num_rows($pal_chave);
		
		$idPc = $row_pal_chave['Id'];
	
		if($totalRows_pal_chave != 0) {
			$querySelectPc = "SELECT * FROM rel_fotos_pal_ch WHERE id_foto = $idFoto and id_palavra_chave = $idPc";
			$selectPc = mysql_query($querySelectPc, $pulsar) or die(mysql_error());
			$totalSelectPc = mysql_num_rows($selectPc);
			if($totalSelectPc == 0) {
				$querySaveIptc = "INSERT INTO rel_fotos_pal_ch (id_foto,id_palavra_chave) VALUES ($idFoto,$idPc)";
				$saveIptc = mysql_query($querySaveIptc, $pulsar) or die(mysql_error());
			}
		}
	}
}
else if($action == "updateCliente") {
	$idContrato = $_POST['idContrato'];
	$idCliente = $_POST['idCliente'];
	$queryUpdateCliente = "UPDATE CONTRATOS SET ID_CLIENTE = $idCliente WHERE ID = $idContrato";
	
	mysql_query($queryUpdateCliente, $pulsar) or die(mysql_error());
}
else if($action == "updateContato") {
	$idContrato = $_POST['idContrato'];
	$idContato = $_POST['idContato'];
	$queryUpdateContato = "UPDATE CONTRATOS SET ID_CONTATO = $idContato WHERE ID = $idContrato";
	
	mysql_query($queryUpdateContato, $pulsar) or die(mysql_error());
}
else if($action == "updateContrato") {
	$idContrato = $_POST['idContrato'];
	$idContratoDesc = $_POST['idContratoDesc'];
	$queryUpdateContrato = "UPDATE CONTRATOS SET ID_CONTRATO_DESC = $idContratoDesc WHERE ID = $idContrato";
	
	mysql_query($queryUpdateContrato, $pulsar) or die(mysql_error());
}
else if($action == "set_id_cliente_sig") {
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
} else if(isset($_GET['reuso'])) {
	$id = $_GET['reuso'];
	$val = $_GET['val'];
	$desc = $_GET['desc'];
	$isReuso = true;
	if(isset($_GET['false'])) {
		$isReuso = false;
	}
	$reusoVal = $isReuso?"1":"-1";
	$query = "UPDATE CROMOS SET reuso = reuso+$reusoVal, VALOR = $val, DESCONTO = $desc WHERE ID = $id";
	echo $query;
	$rs	= mysql_query($query, $sig) or die(mysql_error());
}else if(isset($_GET['chkIndio'])) {
	$id = $_GET['chkIndio'];
	$val = $_GET['val'];
	$desc = $_GET['desc'];
	$isReuso = true;
	if(isset($_GET['false'])) {
		$isReuso = false;
	}
	$reusoVal = $isReuso?"10":"-10";

	$query = "UPDATE CROMOS SET reuso = reuso+$reusoVal, VALOR = $val, DESCONTO = $desc WHERE ID = $id";
	echo $query;
	$rs	= mysql_query($query, $sig) or die(mysql_error());
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
}else if($action == "getAutorFotos") {
	$id_autor = $_POST['id_autor'];
	
	mysql_select_db($database_pulsar, $pulsar);
	$query_fotos_tmp_select = sprintf("SELECT tombo FROM Fotos_tmp WHERE Fotos_tmp.tombo NOT RLIKE '^[a-zA-Z]' AND id_autor=%s LIMIT 20",$id_autor);
	$fotos_tmp_select = mysql_query($query_fotos_tmp_select, $pulsar) or die(mysql_error());
	
	$totalRows_fotos_tmp_select = mysql_num_rows($fotos_tmp_select);
	if($totalRows_fotos_tmp_select > 0) {
		$_SESSION['autor']=$id_autor;
	?>
		<option value="">--- Escolha uma Foto ---</option>
<?php 		
		 while ($row_fotos_tmp_select = mysql_fetch_assoc($fotos_tmp_select)){ ?>
   		<option value="<?php echo $row_fotos_tmp_select['tombo'];?>"><?php echo $row_fotos_tmp_select['tombo'];?></option>
<?php 
		}
	}
	else {
		$_SESSION['autor']="";
?>
		<option value="">--- Nenhuma Foto ---</option>
<?php 			
	}	
}else if($action == "getAutorVideos") {
	$id_autor = $_POST['id_autor'];
	
	mysql_select_db($database_pulsar, $pulsar);
	$query_videos_tmp_select = sprintf("SELECT tombo FROM Fotos_tmp WHERE Fotos_tmp.tombo RLIKE '^[a-zA-Z]' AND Fotos_tmp.status = 2 AND id_autor=%s LIMIT 20",$id_autor);
	$videos_tmp_select = mysql_query($query_videos_tmp_select, $pulsar) or die(mysql_error());
	
	$totalRows_videos_tmp_select = mysql_num_rows($videos_tmp_select);
	if($totalRows_videos_tmp_select > 0) {
		$_SESSION['autor']=$id_autor;
?>
		<option value="">--- Escolha um Video ---</option>
<?php 		
		 while ($row_videos_tmp_select = mysql_fetch_assoc($videos_tmp_select)){ ?>
   		<option value="<?php echo $row_videos_tmp_select['tombo'];?>"><?php echo $row_videos_tmp_select['tombo'];?></option>
<?php 
		}
	}
	else {
		$_SESSION['autor']="";
?>
		<option value="">--- Nenhum Video ---</option>
<?php 				
	}	
}

?>
