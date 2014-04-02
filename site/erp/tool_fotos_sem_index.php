<?php
$show = "";
if(isset($_GET["show"])) {
	$show = $_GET['show'];
}

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

if (is_dir($imageDir) && $directoryPointer = @opendir($imageDir)) {
	while ($oneFile = readdir($directoryPointer)) {
//		$thisFileType = strtolower(substr(strrchr($oneFile, "."), 1));
//		$thisFileType = strtolower(substr(stristr($oneFile, "p"), 1));
		$thisFileType = strtolower(substr($oneFile,-5));
/*		if ($thisFileType == ".jpg" || $thisFileType == "jpeg") {
			$fileCount++;
		} else {
			if ($thisFileType == "g" || $thisFileType == "jpeg") {
				$bigCount++;
			}
		}
*/
//Modificado por Zoca para retirar o ./ e o ../ da lista.

		if (strlen($oneFile) > 5 && preg_match('/^[0-9]/',$oneFile)) {
			if ($thisFileType == "p.jpg") {
				$fotos_site[] = substr($oneFile,0,-5);
			} else {
				$thumbs_site[] = substr($oneFile,0,-4);
			}
		}
	}
} 
/*
$imageDir = $fotosalta; 
if (is_dir($imageDir) && $directoryPointer = @opendir($imageDir)) {
	while ($oneFile = readdir($directoryPointer)) {

//Modificado por Zoca para retirar o ./ e o ../ da lista.

		if (strlen($oneFile) > 5) {
			$altas_site[] = substr($oneFile,0,-4);
		}
	}
} 
*/
if($show==1) {
	$fotos_sem_thumb = array_diff($thumbs_site, $fotos_site);
}
else if($show==2) {	
	$thumb_sem_fotos = array_diff($fotos_site, $thumbs_site);
}
//$db_sem_fotos = array_diff($fotos_db, $fotos_site);
//$db_sem_altas = array_diff($fotos_db, $altas_site);
else if($show==3) {	
	$fotos_sem_db = array_diff($fotos_site, $fotos_db);
	asort($fotos_sem_db);
}
?>