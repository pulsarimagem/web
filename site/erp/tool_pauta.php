<?php
mysql_select_db($database_pulsar, $pulsar);

$timeBefore = microtime(true);

$queryTemas = "SELECT pesquisa_tema.tema as id_tema,temas.Tema as tema,datahora,COUNT(*) AS qty 
				FROM pesquisa_tema 
				LEFT JOIN temas ON temas.Id = pesquisa_tema.tema
				WHERE datahora > NOW() - INTERVAL 3 MONTH 
				GROUP BY id_tema ORDER BY qty DESC LIMIT 20";
$rsTemas = mysql_query($queryTemas, $pulsar) or die(mysql_error());
$totalTemas = mysql_num_rows($rsTemas);

$timeAfter = microtime(true);
$diff = $timeAfter - $timeBefore;
if($siteDebug) {
	echo "<strong>Tempo temas: </strong>".$diff."<br>";	
}

$timeBefore = microtime(true);

$queryPCPesq = "SELECT palavra,datahora,COUNT(*) AS qty
				FROM pesquisa_pc
				WHERE datahora > NOW() - INTERVAL 3 MONTH AND palavra NOT LIKE ''
				GROUP BY palavra ORDER BY qty DESC LIMIT 20";
$rsPCPesq = mysql_query($queryPCPesq, $pulsar) or die(mysql_error());
$totalPCPesq = mysql_num_rows($rsPCPesq);

$timeAfter = microtime(true);
$diff = $timeAfter - $timeBefore;
if($siteDebug) {
	echo "<strong>Tempo PC Pesquisada: </strong>".$diff."<br>";
}

$timeBefore = microtime(true);

$queryPCRetorno = "SELECT palavra,datahora,COUNT(*) AS qty, SUM(retorno) AS soma, retorno
				FROM pesquisa_pc
				WHERE datahora > NOW() - INTERVAL 3 MONTH AND LENGTH(palavra) > 5
				GROUP BY palavra ORDER BY soma ASC, qty DESC, palavra ASC LIMIT 50";
$rsPCRetorno = mysql_query($queryPCRetorno, $pulsar) or die(mysql_error());
$totalPCRetorno = mysql_num_rows($rsPCRetorno);

$timeAfter = microtime(true);
$diff = $timeAfter - $timeBefore;
if($siteDebug) {
	echo "<strong>Tempo PC Retorno 0: </strong>".$diff."<br>";
}

$timeBefore = microtime(true);

$queryFotos = "SELECT tombo,datahora,COUNT(*) AS qty
				FROM log_pop
				WHERE datahora > NOW() - INTERVAL 3 MONTH
				GROUP BY tombo ORDER BY qty DESC LIMIT 50";
$rsFotos = mysql_query($queryFotos, $pulsar) or die(mysql_error());
$totalFotos = mysql_num_rows($rsFotos);

$timeAfter = microtime(true);
$diff = $timeAfter - $timeBefore;
if($siteDebug) {
	echo "<strong>Tempo Codigo: </strong>".$diff."<br>";
}
?>