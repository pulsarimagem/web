<?php
$contrato_video = 48;
$contrato_foto_padrao = 7;
$contrato_foto_indio = 9;

$retirar = array(".jpg",".JPG");

$colname_arquivos = "-1";
if (isset($_GET['id_login'])) {
	$colname_arquivos = (get_magic_quotes_gpc()) ? $_GET['id_login'] : addslashes($_GET['id_login']);
	$data = $_GET['data'];
	$data2 = substr($data,5,2).substr($data,0,2);
}
$relTipo = "fotos";
$relTable = "log_download2";
$relFiltro = "arquivo RLIKE '^[0-9]'";

$relExtra1 = "`log_download2`.circulacao,
		`log_download2`.tiragem,
		`log_download2`.formato,
		`log_download2`.uso,";
$relExtra2 = ", $database_sig.USO_DESC.descricao_br as tamanho_desc,
		$database_sig.USO_SUBTIPO.subtipo_br as uso_desc";
$relExtra3 = "LEFT JOIN $database_sig.USO_SUBTIPO ON (log_download2.uso = $database_sig.USO_SUBTIPO.Id)
		LEFT JOIN $database_sig.USO ON (log_download2.formato = $database_sig.USO.Id)
		LEFT JOIN $database_sig.USO_DESC ON ($database_sig.USO.id_descricao = $database_sig.USO_DESC.Id)";

if (isset($_GET['tipo']) && $_GET['tipo']!="fotos") {
	$relTipo = $_GET['tipo'];
}

if($relTipo == "layout") {
	$relTable = "log_download_layout";
	$relExtra1 = "";
	$relExtra2 = "";
	$relExtra3 = "";
}
else if($relTipo == "videos") {
	$relFiltro = "arquivo RLIKE '^[A-Z]'";
}



$tribos = implode('|', array_keys(get_tribos()));

mysql_select_db($database_pulsar, $pulsar);
$query_arquivos = sprintf("SELECT
		`$relTable`.id_log,
		`$relTable`.arquivo,
		`$relTable`.data_hora,
		`$relTable`.ip,
		`$relTable`.id_login,
		`$relTable`.usuario,
		`$relTable`.projeto,
		$relExtra1
		`$relTable`.obs,
		`$relTable`.faturado,
		`fotografos`.Nome_Fotografo,
		`Fotos`.assunto_principal,
		(`Fotos`.assunto_principal regexp '($tribos)') as indio,
		(`Fotos`.extra regexp '($tribos)') as indio_extra
		$relExtra2
		FROM
		`Fotos`

		INNER JOIN `fotografos` ON (`Fotos`.id_autor = `fotografos`.id_fotografo)
		RIGHT OUTER JOIN `$relTable` ON (`Fotos`.tombo = SUBSTRING_INDEX(`$relTable`.arquivo, '.', 1))
		$relExtra3
		WHERE $relFiltro AND id_login = '%s' and EXTRACT(YEAR_MONTH FROM data_hora) like '20%s'
		GROUP BY arquivo, EXTRACT(DAY FROM data_hora), projeto
		ORDER BY faturado, projeto, indio, data_hora DESC
		", $colname_arquivos,$data2);
		$arquivos = mysql_query($query_arquivos, $pulsar) or die(mysql_error());
		$row_arquivos = mysql_fetch_assoc($arquivos);
		$totalRows_arquivos = mysql_num_rows($arquivos);


		mysql_select_db($database_pulsar, $pulsar);
		$query_cliente = sprintf("SELECT * FROM cadastro WHERE id_cadastro = '%s'", $colname_arquivos);
		$cliente = mysql_query($query_cliente, $pulsar) or die(mysql_error());
		$row_cliente = mysql_fetch_assoc($cliente);
		$totalRows_cliente = mysql_num_rows($cliente);

		mysql_select_db($database_sig, $sig);

		//$row_uso = translate_iduso($row_arquivos['uso'], "br", $sig);

		$where_query = "";
if(isset($row_cliente['id_cliente_sig']) && ($row_cliente['id_cliente_sig'] != "")) {
	$where_query = "WHERE ID = ".$row_cliente['id_cliente_sig'];
}
$query_empresas = sprintf("SELECT ID, RAZAO, FANTASIA FROM CLIENTES $where_query ORDER BY RAZAO");
$empresas = mysql_query($query_empresas, $sig) or die(mysql_error());
$totalRows_empresas = mysql_num_rows($empresas);
		//$row_empresas = mysql_fetch_assoc($empresas);

if(isset($row_cliente['id_cliente_sig']) && ($row_cliente['id_cliente_sig'] != "")) {
mysql_select_db($database_sig, $sig);
$where_query = "";
	$where_query = "WHERE ID_CLIENTE = ".$row_cliente['id_cliente_sig'];
	$query_contato = sprintf("SELECT ID, CONTATO FROM CONTATOS $where_query ORDER BY CONTATO");
	$contato = mysql_query($query_contato, $sig) or die(mysql_error());
	$totalRows_contato = mysql_num_rows($contato);
//	$row_contato = mysql_fetch_assoc($contato);
}



if (isset($_GET['faturar_todas'])) {
mysql_select_db($database_pulsar, $pulsar);
do {
		$query_faturar = "UPDATE $relTable SET faturado=".'1'." WHERE arquivo = '".$row_arquivos['arquivo']."' AND EXTRACT(DAY FROM data_hora) = EXTRACT(DAY FROM '".$row_arquivos['data_hora']."') AND projeto LIKE '".$row_arquivos['projeto']."' AND id_login = ".$row_arquivos['id_login'];
		$faturar = mysql_query($query_faturar, $pulsar) or die(mysql_error());
} while ($row_arquivos = mysql_fetch_assoc($arquivos));
$arquivos = mysql_query($query_arquivos, $pulsar) or die(mysql_error());
$row_arquivos = mysql_fetch_assoc($arquivos);
	$totalRows_arquivos = mysql_num_rows($arquivos);
}


?>