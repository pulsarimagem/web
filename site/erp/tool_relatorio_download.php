<?php
$_SESSION['back'] = $_SERVER['REQUEST_URI'];

$colname_arquivos = "-1";
if (isset($_GET['id_login']) && $_GET['id_login']!="TODOS") {
  $colname_arquivos = (get_magic_quotes_gpc()) ? $_GET['id_login'] : addslashes($_GET['id_login']);
}
if (isset($_GET['periodo']) && $_GET['periodo']!="TODOS") {
  $colname_arquivos = (get_magic_quotes_gpc()) ? $_GET['periodo'] : addslashes($_GET['periodo']);
}

$relTipo = "fotos";
$relTable = "log_download2";
$relFiltro = "arquivo RLIKE '^[0-9]'";
if (isset($_GET['tipo']) && $_GET['tipo']!="fotos") {
	$relTipo = $_GET['tipo'];
}

if($relTipo == "layout") {
	$relTable = "log_download_layout";
}
else if($relTipo == "videos") {
	$relFiltro = "arquivo RLIKE '^[A-Z]'";
}

mysql_select_db($database_pulsar, $pulsar);
if (isset($_GET['periodo']) && $_GET['periodo']!="TODOS") {
	$sqlIdlogin = "";
	if(isset($_GET['id_login']) && $_GET['id_login']!="TODOS") 
		$sqlIdlogin = "AND id_login = ".$_GET['id_login'];
//	$query_arquivos = sprintf("SELECT * FROM log_download2 WHERE date_format(data_hora, '%%m/%%Y') = '%s' GROUP BY arquivo, EXTRACT(DAY FROM data_hora) order by data_hora desc", $colname_arquivos);
//	$query_arquivos = sprintf("SELECT * FROM log_download2,cadastro WHERE date_format(data_hora, '%%m/%%Y') = '%s' and cadastro.id_cadastro = log_download2.id_login GROUP BY arquivo, EXTRACT(DAY FROM data_hora) order by usuario", $colname_arquivos);
// Sem group by
	$query_arquivos = sprintf("SELECT * FROM $relTable,cadastro WHERE $relFiltro AND date_format(data_hora, '%%m/%%Y') = '%s' $sqlIdlogin and cadastro.id_cadastro = $relTable.id_login GROUP BY arquivo,projeto,EXTRACT(DAY FROM data_hora) order by usuario", $colname_arquivos);
} else {
//	$query_arquivos = sprintf("SELECT * FROM log_download2 WHERE id_login = '%s' GROUP BY arquivo, EXTRACT(DAY FROM data_hora) order by data_hora desc", $colname_arquivos);
// Sem group by
	$query_arquivos = sprintf("SELECT * FROM $relTable WHERE $relFiltro AND id_login = '%s' GROUP BY arquivo,projeto,EXTRACT(DAY FROM data_hora) order by data_hora desc", $colname_arquivos);
}

if (isset($_GET['alterando'])) {
$query_altera = "UPDATE cadastro SET limite = '".$_GET['limite']."' WHERE id_cadastro = ".$_GET['id_login'];
$ResultAlt = mysql_query($query_altera, $pulsar) or die(mysql_error());
//echo 'trocou...';
}

$arquivos = mysql_query($query_arquivos, $pulsar) or die(mysql_error());
$row_arquivos = mysql_fetch_assoc($arquivos);
$totalRows_arquivos = mysql_num_rows($arquivos);

$query_periodo = "SELECT date_format(data_hora,'%m/%Y') as mes_ano FROM $relTable WHERE $relFiltro group by mes_ano order by data_hora desc";
$periodo = mysql_query($query_periodo, $pulsar) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

$periodo1 = $row_periodo['mes_ano'];
$row_periodo = mysql_fetch_assoc($periodo);
$periodo2 = $row_periodo['mes_ano'];

$periodo_tabela1 =  substr($periodo1,3,4).substr($periodo1,0,2);
$periodo_tabela2 = substr($periodo2,3,4).substr($periodo2,0,2);

$query_tabela1 = "SELECT
count(data_hora) as total,
sum(faturado) as faturados,
nome,
empresa,
arquivo
 FROM
(SELECT
  cadastro.nome,
  cadastro.empresa,
  $relTable.arquivo,
  $relTable.data_hora,
  $relTable.faturado
FROM
  cadastro
  INNER JOIN $relTable ON (cadastro.id_cadastro = $relTable.id_login)
WHERE
 $relFiltro AND
 EXTRACT(YEAR_MONTH FROM data_hora) = '".$periodo_tabela1."' 
 GROUP BY arquivo,projeto,EXTRACT(DAY FROM data_hora)
) AS TABELAO
GROUP BY nome";
//GROUP BY   arquivo, nome

$tabela1 = mysql_query($query_tabela1, $pulsar) or die(mysql_error());
$row_tabela1 = mysql_fetch_assoc($tabela1);
$totalRows_tabela1 = mysql_num_rows($tabela1);

$query_tabela2 = "SELECT
count(data_hora) as total,
sum(faturado) as faturados,
nome,
empresa,
arquivo
 FROM
(SELECT
  cadastro.nome,
  cadastro.empresa,
  $relTable.arquivo,
  $relTable.data_hora,
  $relTable.faturado
FROM
  cadastro
  INNER JOIN $relTable ON (cadastro.id_cadastro = $relTable.id_login)
WHERE
 $relFiltro AND
 EXTRACT(YEAR_MONTH FROM data_hora) = '".$periodo_tabela2."' 
 GROUP BY arquivo,projeto,EXTRACT(DAY FROM data_hora)
) AS TABELAO
GROUP BY nome";
//GROUP BY   arquivo, nome
$tabela2 = mysql_query($query_tabela2, $pulsar) or die(mysql_error());
$row_tabela2 = mysql_fetch_assoc($tabela2);
$totalRows_tabela2 = mysql_num_rows($tabela2);

mysql_select_db($database_pulsar, $pulsar);
$query_diretorios = "SELECT * FROM cadastro WHERE download RLIKE 'S' ORDER BY cadastro.nome";
$diretorios = mysql_query($query_diretorios, $pulsar) or die(mysql_error());
$totalRows_diretorios = mysql_num_rows($diretorios);

?>