<?php //require_once('Connections/pulsar.php'); ?>
<?php
function update_tombos_list() {

	require_once('Connections/pulsar.php');

	$sigla_autor = $row_login['Iniciais_Fotografo'];//$_SESSION['MM_Username'];

	mysql_select_db($database_pulsar, $pulsar);
	$query_fotografo = "SELECT * FROM fotografos WHERE fotografos.Iniciais_Fotografo = '".$sigla_autor."';";
	$fotografo = mysql_query($query_fotografo, $pulsar) or die(mysql_error());
	$row_fotografo = mysql_fetch_assoc($fotografo);
	$totalRows_fotografo = mysql_num_rows($fotografo);

	//echo "Fotografo: ".$row_fotografo['Nome_Fotografo'];
	//echo "<br>$sigla_autor<br>";

	if($totalRows_fotografo < 1)
		return false;

	mysql_select_db($database_pulsar, $pulsar);
	$query_fotos = "SELECT tombo FROM Fotos LEFT JOIN fotografos ON (Fotos.id_autor = fotografos.id_fotografo) WHERE fotografos.Iniciais_Fotografo = '".$sigla_autor."';";
	$fotos = mysql_query($query_fotos, $pulsar) or die(mysql_error());
	//$row_fotos = mysql_fetch_assoc($fotos);
	$totalRows_fotos = mysql_num_rows($fotos);

	//echo "1. ".$totalRows_fotos."<br>";

	$fotos_db = array();

	//do {
	while ($row_fotos = mysql_fetch_assoc($fotos))
		$fotos_db[] = $row_fotos['tombo'];

	//} while ($row_fotos = mysql_fetch_assoc($fotos));

	mysql_select_db($database_pulsar, $pulsar);
	$query_fotos = "SELECT tombo FROM Fotos_tmp LEFT JOIN fotografos ON (Fotos_tmp.id_autor = fotografos.id_fotografo) WHERE fotografos.Iniciais_Fotografo = '".$sigla_autor."';";
	$fotos = mysql_query($query_fotos, $pulsar) or die(mysql_error());
	//$row_fotos = mysql_fetch_assoc($fotos);
	$totalRows_fotos = mysql_num_rows($fotos);

	//echo "2. ".$totalRows_fotos."<br>";

	//do {
	while ($row_fotos = mysql_fetch_assoc($fotos))
		$fotos_db[] = $row_fotos['tombo'];

	//} while ($row_fotos = mysql_fetch_assoc($fotos));

	mysql_select_db($database_pulsar, $pulsar);
	$query_fotos = "SELECT tombo FROM tombos_toindex LEFT JOIN fotografos ON (tombos_toindex.id_autor = fotografos.id_fotografo) WHERE fotografos.Iniciais_Fotografo = '".$sigla_autor."';";
	$fotos = mysql_query($query_fotos, $pulsar) or die(mysql_error());
	//$row_fotos = mysql_fetch_assoc($fotos);
	$totalRows_fotos = mysql_num_rows($fotos);

	//echo "3. ".$totalRows_fotos."<br>";

	//do {
	$tmp_toindex = array();
	while ($row_fotos = mysql_fetch_assoc($fotos)) {
		$tmp_toindex[] = $row_fotos['tombo'];
	}
	$intersect = array_intersect($tmp_toindex, $fotos_db);
	//print_r($intersect);
	if(count($intersect) > 0) {
		$query_delete_toindex = "DELETE FROM tombos_toindex WHERE tombo in ('".implode("','",$intersect)."');";
		echo $query_delete_toindex;
		$delete_toindex = mysql_query($query_delete_toindex, $pulsar) or die(mysql_error());
	}
	$fotos_db = array_merge($tmp_toindex, $fotos_db);

	//} while ($row_fotos = mysql_fetch_assoc($fotos));


	$imageDir = $thumbpop; //"/var/www/www.pulsarimagens.com.br/bancoImagens";

	$fotos_site = array();
	//$thumbs_site = array();
	$altas_site = array();
	$x = 0;

// 	if (is_dir($imageDir) && $directoryPointer = @opendir($imageDir)) {
// 		while ($oneFile = readdir($directoryPointer)) {
// 			$thisFileType = strtolower(substr($oneFile,-5));

// 			//Modificado por Zoca para retirar o ./ e o ../ da lista.
// 			if (strlen($oneFile) > 5) {
// 				if ($thisFileType == "p.jpg") {
// 					$codigo_autor = ereg_replace("[^A-Za-z]","", substr($oneFile,0,-5));
// 					if((strlen($codigo_autor) == strlen($sigla_autor)) && stristr($codigo_autor, $sigla_autor)) {
// 						$fotos_site[] = substr($oneFile,0,-5);
// 					}
// 				}
// 			}
// 		}
// 	}
	for($i = 1; $i < 100; $i++) {
		
		$cmd = "aws --profile pulsar s3 ls s3://pulsar-media/fotos/orig/".str_pad($i,2,"0",STR_PAD_LEFT).$sigla_autor;
//		echo $cmd."<br>";
		$out = shell_exec($cmd);
		$out_arr = explode("\n", $out);
		foreach($out_arr as $line) {
			if(strstr($line, ".jpg")!==false) {
				$words = explode(" ",$line);
				$oneFile = end($words);
				$thisFileType = strtolower(substr($oneFile,-5));
				if (strlen($oneFile) > 5) {
					if ($thisFileType != "p.jpg") {
						$codigo_autor = ereg_replace("[^A-Za-z]","", substr($oneFile,0,-5));
						if((strlen($codigo_autor) == strlen($sigla_autor)) && stristr($codigo_autor, $sigla_autor)) {
							$fotos_site[] = substr($oneFile,0,-4);
						}
					}
				}
			}
		}
	}
	
	$fotos_sem_db = array_diff($fotos_site, $fotos_db);
	asort($fotos_sem_db);

	$fotos_toindex_deleted = array_diff($tmp_toindex,$fotos_site);
	if(count($fotos_toindex_deleted) > 0) {
		$query_delete_toindex_deleted = "DELETE FROM tombos_toindex WHERE tombo in ('".implode("','",$fotos_toindex_deleted)."');";
		echo $query_delete_toindex_deleted;
		$delete_toindex_deleted = mysql_query($query_delete_toindex_deleted, $pulsar) or die(mysql_error());
	}

	//echo "<br>XXX".count($fotos_site)."XXX<br>";
	//echo "<br>YYY".count($fotos_db)."YYY<br>";
	//echo "<br>ZZZ".count($fotos_sem_db)."ZZZ<br>";

	if(count($fotos_sem_db) < 1)
		return false;

	$insert_SQL = "('".implode("',".$row_fotografo['id_fotografo']."),('",$fotos_sem_db)."',".$row_fotografo['id_fotografo'].");";
	mysql_select_db($database_pulsar, $pulsar);
	$query_insert_fotos = "INSERT INTO tombos_toindex (tombo, id_autor)  VALUES ".$insert_SQL;

	//echo $query_insert_fotos;

	$insert_fotos = mysql_query($query_insert_fotos, $pulsar) or die(mysql_error());
	
	$query_delete_videos = "DELETE FROM tombos_toindex WHERE tombo RLIKE '^[a-zA-Z]'";
	$delete_videos = mysql_query($query_delete_videos, $pulsar) or die(mysql_error());
	
}

?>
<?php 
//$sigla = $_GET['sigla'];

update_tombos_list();

header("Location: adm_index.php?updated");
?>