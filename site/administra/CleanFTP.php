<?php require_once('Connections/pulsar.php'); ?>
<?php
$val_extra = 30;

mysql_select_db($database_pulsar, $pulsar);
$query_vencidos = sprintf("
SELECT 
  id_arquivo, id_ftp, nome, data_cria, validade, (addDate(data_cria, validade)) as vencimento
FROM 
  ftp_arquivos 
WHERE 
  TO_DAYS(addDate(data_cria, validade+%s)) < TO_DAYS(NOW());
", $val_extra);
$vencidos = mysql_query($query_vencidos, $pulsar) or die(mysql_error());
$row_vencidos = mysql_fetch_assoc($vencidos);
$totalRows_vencidos = mysql_num_rows($vencidos);

$cntok = 0;
$cntnok = 0;

do {
	$isok = false;
	
	$file = $homeftp.$row_vencidos['id_ftp']."/".$row_vencidos['nome'];
	
	if (file_exists($file)) {
		if(unlink($file)) {
			$cntok++;
			
			mysql_select_db($database_pulsar, $pulsar);
			$query_delete = sprintf("
			DELETE FROM 
			  ftp_arquivos 
			WHERE 
			  id_arquivo = %s;
			", $row_vencidos['id_arquivo']);
			$delete = mysql_query($query_delete, $pulsar) or die(mysql_error());
		}
		else {
			echo "   ->  Erro ".$row_vencidos['id_ftp']."/".$row_vencidos['nome']."!<br>";
			$cntnok++;
		}
	}
	else {
		echo "   ->  Nao encontrado: ".$row_vencidos['id_ftp']."/".$row_vencidos['nome']."<br>";
		$cntnok++;
	}
	
} while ($row_vencidos = mysql_fetch_assoc($vencidos));
echo "<br><br>OK: $cntok    NOK: $cntnok <br>";
?>