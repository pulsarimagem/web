<?php require_once('Connections/pulsar.php'); ?>
<?php

// Carregar pastas
if(isset($_GET['tombo']) && $_GET['tombo'] != "") {
	$head = false;
	if (isset($_GET['nova_pasta'])&&($_GET['nova_pasta']!="")) {
		$insertSQL = sprintf("INSERT INTO pastas (id_cadastro, nome_pasta, data_cria, data_mod) VALUES (%s, '%s', now(),now())", $row_top_login['id_cadastro'], $_GET['nova_pasta']);
		mysql_select_db($database_pulsar, $pulsar);
		$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
		
		
		$query_novapasta = sprintf("SELECT pastas.id_pasta from pastas where id_cadastro = %s order by id_pasta desc limit 1",$row_top_login['id_cadastro']);
		mysql_select_db($database_pulsar, $pulsar);
		$novapasta = mysql_query($query_novapasta, $pulsar) or die(mysql_error());
		$row_novapasta = mysql_fetch_assoc($novapasta);
		$totalRows_novapasta = mysql_num_rows($novapasta);
		if($totalRows_novapasta > 0) {
			$id_pasta = $row_novapasta['id_pasta'];
			$_GET['id_pasta'] = $id_pasta;
		} 
		$head = true;
	}
	// que pastas já tem esta foto
	$quem_fecha="sim";
	mysql_select_db($database_pulsar, $pulsar);
	$query_jatem = sprintf("
	SELECT 
	  pasta_fotos.tombo,
	  pastas.nome_pasta
	FROM
	 pasta_fotos
	 INNER JOIN pastas ON (pasta_fotos.id_pasta=pastas.id_pasta)
	WHERE
	  pasta_fotos.tombo = '%s'
	AND
	 (pasta_fotos.id_pasta in (%s))
	ORDER BY 
	 pastas.nome_pasta
	", $_GET['tombo'], $_GET['id_pasta']);
	$jatem = mysql_query($query_jatem, $pulsar) or die(mysql_error());
	$row_jatem = mysql_fetch_assoc($jatem);
	$totalRows_jatem = mysql_num_rows($jatem);
	$quem_jatem = "";
	if ($totalRows_jatem > 0) { // Show if recordset not empty
		do {
			//		$quem_jatem = "&quot;".$row_jatem['nome_pasta']."&quot;, ";
			$quem_jatem .= $row_jatem['nome_pasta'].", ";
		} while ($row_jatem = mysql_fetch_assoc($jatem));
		$quem_jatem = substr($quem_jatem,0,-2) . ".";
	} // Show if recordset not empty

	// inclui a imagem nas pastas

	$stringglue = ",'".$_GET['tombo']."'),(";
	$insertSQL = "INSERT IGNORE INTO pasta_fotos (id_pasta, tombo) VALUES (".$_GET['id_pasta'].",'".$_GET['tombo']."')";

	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
	 
	$insertSQL = "UPDATE pastas SET data_mod = '".date("Y-m-d", strtotime('now'))."' WHERE id_pasta IN (".$_GET['id_pasta'].")";

	$Result2 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
	if($head)
		header("Location: ". $_SESSION['last_search']);
}

?>Success