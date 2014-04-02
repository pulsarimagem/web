<?php
	$codigo 	= isset($_GET["codigo"])?$_GET["codigo"]:"";
	$sql     	= "SELECT * FROM CLIENTES A, CONTRATOS B, CROMOS C WHERE A.ID = B.ID_CLIENTE AND C.ID_CONTRATO = B.ID AND C.CODIGO = '$codigo' AND C.FINALIZADO = 'S' ORDER BY C.ID_CONTRATO DESC"; 
	$objRs = mysql_query($sql, $sig) or die(mysql_error());
	$objTotal = mysql_num_rows($objRs);
?>
