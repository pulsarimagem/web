<?php
mysql_select_db($database_pulsar, $pulsar);
$query_fotos = "SELECT tombo FROM Fotos";
$fotos = mysql_query($query_fotos, $pulsar) or die(mysql_error());
$row_fotos = mysql_fetch_assoc($fotos);
$totalRows_fotos = mysql_num_rows($fotos);
$fotos_db = array();

do { 

	$fotos_db[] = $row_fotos['tombo'];

} while ($row_fotos = mysql_fetch_assoc($fotos));

$imageDir = $thumbpop; //"/var/www/www.pulsarimagens.com.br/bancoImagens";

$fotos_site = array();
$thumbs_site = array();
$altas_site = array();

$imageDir = $fotosalta; 
if (is_dir($imageDir) && $directoryPointer = @opendir($imageDir)) {
	while ($oneFile = readdir($directoryPointer)) {

//Modificado por Zoca para retirar o ./ e o ../ da lista.

		if (strlen($oneFile) > 5) {
			$altas_site[] = substr($oneFile,0,-4);
		}
	}
} 

$db_sem_altas = array_diff($fotos_db, $altas_site);
?>