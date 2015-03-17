<?php
mysql_select_db($database_pulsar, $pulsar);
$database_sig = "sig";

$timeBefore = microtime(true);

$queryTemas = "SELECT $database_pulsar.temas.Tema as tema, $database_pulsar.rel_fotos_temas.id_tema, count(id_tema) as qty FROM $database_pulsar.rel_fotos_temas 
					LEFT JOIN $database_pulsar.temas as temas ON $database_pulsar.temas.Id = rel_fotos_temas.id_tema
					LEFT JOIN $database_pulsar.Fotos as fotos ON $database_pulsar.fotos.Id_Foto = rel_fotos_temas.id_foto 
					LEFT JOIN $database_sig.CROMOS as cromos on $database_pulsar.fotos.tombo = $database_sig.cromos.CODIGO 
					LEFT JOIN $database_sig.CONTRATOS as contratos ON cromos.ID_CONTRATO = contratos.ID 
					WHERE contratos.DATA > NOW() - INTERVAL 3 MONTH
					GROUP BY id_tema
					ORDER BY qty DESC, tema ASC LIMIT 20"; 

// echo $queryTemas;

// "SELECT pesquisa_tema.tema as id_tema,temas.Tema as tema,datahora,COUNT(*) AS qty 
// 				FROM pesquisa_tema 
// 				LEFT JOIN temas ON temas.Id = pesquisa_tema.tema
// 				WHERE datahora > NOW() - INTERVAL 3 MONTH 
// 				GROUP BY id_tema ORDER BY qty DESC LIMIT 20";
$rsTemas = mysql_query($queryTemas, $pulsar) or die(mysql_error());
$totalTemas = mysql_num_rows($rsTemas);

$timeAfter = microtime(true);
$diff = $timeAfter - $timeBefore;
if($siteDebug) {
	echo "<strong>Tempo temas: </strong>".$diff."<br>";	
}

$timeBefore = microtime(true);

$queryPCPesq = "SELECT $database_pulsar.pal_chave.Pal_Chave as palavra, $database_pulsar.rel_fotos_pal_ch.id_palavra_chave, count(id_palavra_chave) as qty FROM $database_pulsar.rel_fotos_pal_ch 
					LEFT JOIN $database_pulsar.pal_chave as pal_chave ON $database_pulsar.pal_chave.Id = rel_fotos_pal_ch.id_palavra_chave 
					LEFT JOIN $database_pulsar.Fotos as fotos ON $database_pulsar.fotos.Id_Foto = rel_fotos_pal_ch.id_foto 
					LEFT JOIN $database_sig.CROMOS as cromos on $database_pulsar.fotos.tombo = $database_sig.cromos.CODIGO 
					LEFT JOIN $database_sig.CONTRATOS as contratos ON cromos.ID_CONTRATO = contratos.ID 
					WHERE contratos.DATA > NOW() - INTERVAL 3 MONTH
					GROUP BY id_palavra_chave
					ORDER BY qty DESC, palavra ASC LIMIT 20";
$rsPCPesq = mysql_query($queryPCPesq, $pulsar) or die(mysql_error());
$totalPCPesq = mysql_num_rows($rsPCPesq);

$timeAfter = microtime(true);
$diff = $timeAfter - $timeBefore;
if($siteDebug) {
	echo "<strong>Tempo PC Pesquisada: </strong>".$diff."<br>";
}

$timeBefore = microtime(true);

$queryFotos = "SELECT CODIGO as tombo,COUNT(CODIGO) as qty FROM CROMOS as cromos 
				LEFT JOIN CONTRATOS as contratos ON cromos.ID_CONTRATO = contratos.ID 
				WHERE contratos.DATA > NOW() - INTERVAL 3 MONTH AND contratos.FINALIZADO = 'S'
				GROUP BY CODIGO 
				ORDER BY qty DESC LIMIT 50";
mysql_select_db($database_sig, $sig);
$rsFotos = mysql_query($queryFotos, $pulsar) or die(mysql_error());
$totalFotos = mysql_num_rows($rsFotos);

$timeAfter = microtime(true);
$diff = $timeAfter - $timeBefore;
if($siteDebug) {
	echo "<strong>Tempo Codigo: </strong>".$diff."<br>";
}
?>