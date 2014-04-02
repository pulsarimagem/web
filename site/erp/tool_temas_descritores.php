<?php
$timeStart = microtime(true);

mysql_select_db($database_pulsar, $pulsar);
$query_temas = "SELECT * FROM super_temas ORDER BY Tema_total ASC";
$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
$totalRows_temas = mysql_num_rows($temas);

$id = isset($_GET['id'])?$_GET['id']:-1;
$porcento = isset($_GET['porcento'])?$_GET['porcento']:"10";

$queryTotal = "SELECT COUNT(id_foto) as qty FROM rel_fotos_temas
				WHERE id_tema = $id";
$rsTotal = mysql_query($queryTotal, $pulsar) or die(mysql_error());
$rowTotal = mysql_fetch_array($rsTotal);
$totalTotal = mysql_num_rows($rsTotal);
$total = $rowTotal['qty'];

$queryTemas = "SELECT * FROM (SELECT pal_chave.Pal_Chave as palavra, rel_fotos_pal_ch.id_palavra_chave, COUNT(id_palavra_chave) as qty, COUNT(id_palavra_chave)/$total as porcento FROM rel_fotos_temas
					INNER JOIN rel_fotos_pal_ch ON rel_fotos_temas.id_foto = rel_fotos_pal_ch.id_foto
					LEFT JOIN pal_chave on pal_chave.Id = rel_fotos_pal_ch.id_palavra_chave
					WHERE id_tema = $id
					GROUP BY id_palavra_chave
					ORDER BY qty DESC, palavra ASC
					LIMIT 100) as tmp1 
					WHERE porcento > $porcento/100";
							
// echo $queryTemas;
$rsTemas = mysql_query($queryTemas, $pulsar) or die(mysql_error());
$totalTemas = mysql_num_rows($rsTemas);
?>
