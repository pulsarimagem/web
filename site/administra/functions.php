<?php

function cleanFotos_tmp($tombo, $pulsar) {
	$query_dados_foto = sprintf("SELECT * FROM Fotos_tmp WHERE tombo = '%s'", $tombo);
	$dados_foto = mysql_query($query_dados_foto, $pulsar) or die(mysql_error());
	
	if($row_dados_foto = mysql_fetch_assoc($dados_foto)) {
		$deleteSQL = sprintf("DELETE FROM Fotos_tmp WHERE Id_Foto=%s", $row_dados_foto['Id_Foto']);
		$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());

		$deleteSQL = sprintf("DELETE FROM rel_fotos_temas_tmp WHERE id_foto=%s", $row_dados_foto['Id_Foto']);
		$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());

		$deleteSQL = sprintf("DELETE FROM rel_fotos_pal_ch_tmp WHERE id_foto=%s", $row_dados_foto['Id_Foto']);
		$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
		
		echo "$tombo deletado do tmp<br>";
	}
}

function cleanTombos_toindex($tombo, $pulsar) {
	$query_dados_foto = sprintf("SELECT * FROM tombos_toindex WHERE tombo = '%s'", $tombo);
	$dados_foto = mysql_query($query_dados_foto, $pulsar) or die(mysql_error());
	
	if($row_dados_foto = mysql_fetch_assoc($dados_foto)) {
		$deleteSQL = sprintf("DELETE FROM tombos_toindex WHERE tombo='%s'", $tombo);
		$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
		
		echo "$tombo deletado do toindex<br>";
	}
}

function p_debug($msg) {
	if($siteDebug)
		echo " -$msg<br>\n";
}

function get_tribos() {
	$indios = array("Kalapalo" => 0,  "Yanomami" => 0, "Kamayur�" => 0, "Xavante" => 0, "Yawalapiti" => 0, "Guarani" => 0, "Kambeba" => 0, "Tukano" => 0, "Kayapo" => 0, "Kayap�" => 0, "Kuikuro" => 0, "Mai�" => 0, "Maturac�" => 0 , "Guarani-Kaiowa" => 0, "Guarani-Kaiowas" => 0, "Surui" => 0, "Suru�" => 0, "Paresi" => 0);
	return $indios;
}
/*
function addQuote($text) {
	return str_replace("'", "\'", $text);
}
*/
function translate_iduso_array ($id_uso, $idioma, $sig) {
	$sql = "select uso.Id, USO_TIPO.tipo_$idioma as tipo, USO_SUBTIPO.subtipo_$idioma as utilizacao, uso_formato.formato_$idioma as formato, uso_distribuicao.distribuicao_$idioma as distribuicao, uso_periodicidade.periodicidade_$idioma as periodicidade, descr.descricao_$idioma as tamanho, REPLACE(REPLACE(REPLACE(FORMAT(valor,2),'.','|'),',','.'),'|',',') as valor
	from USO as uso
	left join USO_TIPO on uso.id_tipo = USO_TIPO.Id
	left join USO_SUBTIPO on uso.id_utilizacao = USO_SUBTIPO.Id
	left join USO_DESC as descr on uso.id_tamanho = descr.Id
	left join uso_formato on uso.id_formato = uso_formato.id
	left join uso_distribuicao on uso.id_distribuicao = uso_distribuicao.id
	left join uso_periodicidade on uso.id_periodicidade = uso_periodicidade.id
	where uso.Id = $id_uso";
	$result = mysql_query($sql, $sig) or die(mysql_error());
	$row = mysql_fetch_array($result);

	$uso = "";
	if($row['tipo']!= "")
		$uso .= $row['tipo'];
	if($row['utilizacao']!= "")
		$uso .= " - ".$row['utilizacao'];
	if($row['formato']!= "")
		$uso .= " - ".$row['formato'];
	if($row['distribuicao']!= "")
		$uso .= " - ".$row['distribuicao'];
	if($row['periodicidade']!= "")
		$uso .= " - ".$row['periodicidade'];
	if($row['tamanho']!= "")
		$uso .= " - ".$row['tamanho'];
		
	return $row;
}

?>