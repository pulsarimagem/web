<?php
if($siteDebug) {
	$timeStart = microtime(true);
}

$_SESSION['back'] = $_SERVER['REQUEST_URI'];

$luis = isset($_GET['soLuis'])?true:false;
$showVideos = isset($_GET['showVideos'])?true:false;
$showFotos = isset($_GET['showFotos'])?true:false;

$de = (isset($_GET['de'])?$_GET['de']:"");
$ate = (isset($_GET['ate'])?$_GET['ate']:"");
//$sigla_autor = strtoupper($row_top_login['Iniciais_Fotografo']);
$sigla_autor = isset($_GET['sigla_autor'])?strtoupper($_GET['sigla_autor']):"TODOS";

//formatando a data para consulta no banco mysql

if($de != "") {
	$data_de = explode("/", $de); 
	$de_ano	  = $data_de[2];
	$de_mes	  = $data_de[1];
	$de_dia	  = $data_de[0];
	$de_mysql = $de_ano."/".$de_mes."/".$de_dia;
}
else {
	$de_mysql = date("Y/m/d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month" ) );;
}
if($ate != "") {
	$data_ate = explode("/", $ate); 
	$ate_ano  = $data_ate[2];
	$ate_mes  = $data_ate[1];
	$ate_dia  = $data_ate[0];
	$ate_mysql= $ate_ano."/".$ate_mes."/".$ate_dia;
}
else {
	$ate_mysql = date("Y/m/d");
} 
//consultando aliquota de imposto
$strSQL = "SELECT REFERENCIA FROM TA_ALIQUOTA WHERE DESCRICAO = 'IMPOSTOS'";
mysql_select_db($database_sig, $sig);
$objRsImposto = mysql_query($strSQL, $sig) or die(mysql_error());
$row_objRsImposto = mysql_fetch_assoc($objRsImposto);
$totalRows_objRsImposto = mysql_num_rows($objRsImposto);

$total_indio = 0;
$comissoes_indios = getTribos($sig);// array("Kalapalo" => 0, "Caingangue" => 0, "Bororo" => 0, "Yanomami" => 0, "Kamayurá" => 0, "Xavante" => 0, "Yawalapiti" => 0, "Guarani" => 0, "Kambeba" => 0, "Kolulu" => 0, "Kaingang" => 0);
// print_r($comissoes_indios);
$comissoes_indios_nenhum = 0;
$contrato_indios_nenhum = "";
$comissoes_indios_dois = 0;
$contrato_indios_dois = "";


if($siteDebug) {
	$timeBefore = microtime(true);
}

//consultando contratos baixados no período solicitado 
$strSQL = " SELECT ID, DATA, DATA_PAGTO, ID_CLIENTE, ID_CONTATO, VALOR_TOTAL, ID_CONTRATO_DESC FROM CONTRATOS WHERE CAST(CONCAT(SUBSTR(DATA_PAGTO,7,4),'-',SUBSTR(DATA_PAGTO,4,2),'-',SUBSTR(DATA_PAGTO,1,2)) as DATE) BETWEEN '".$de_mysql."' AND '".$ate_mysql."' AND BAIXADO = 'S' ";
if($luis) 
	$strSQL .= "and ID_CONTATO in (select ID from CONTATOS where CONTATO like 'lu%vila%')";
if(!$showFotos)
	$strSQL .= "AND ID_CONTRATO_DESC IN (SELECT Id FROM CONTRATOS_DESC WHERE tipo LIKE 'V')";
if(!$showVideos)
	$strSQL .= "AND ID_CONTRATO_DESC IN (SELECT Id FROM CONTRATOS_DESC WHERE tipo LIKE 'F')";
mysql_select_db($database_sig, $sig);
$objRsContratos = mysql_query($strSQL, $sig) or die(mysql_error());
//$row_objRsContratos = mysql_fetch_assoc($objRsContratos);
$totalRows_objRsContratos = mysql_num_rows($objRsContratos);
//echo $strSQL;
if($siteDebug) {
	$diff = microtime(true) - $timeBefore;
	echo "<strong>delay Consulta Contrato: </strong>".$diff."</strong><br>";
}

?>






<?php
$filtroCliente = "";
$filtroData = "";
$cliente = "";
$de = isset($_GET['de'])?$_GET['de']:"";
$ate = isset($_GET['ate'])?$_GET['ate']:"";

$action = (isset($_GET['action'])?$_GET['action']:"");

if($action == "baixaLote") {
	$contratos = $_GET['contratos'];
	$nf = $_GET['nf'];
	$baixa = $_GET['baixa'];
	foreach($contratos as $contrato) {
		$strSQL	= "UPDATE CONTRATOS SET baixado='S' ";
		$strSQL	.= ",data_pagto='" . $baixa . "' ";
		$strSQL	.= ",nota_fiscal='" . $nf . "' ";
		$strSQL	.= " WHERE id= " . $contrato;
		
// 		$mens .= $id_contrato;
		$strSQL = str_replace("''", "null", $strSQL);
		$objRS	= mysql_query($strSQL, $sig) or die(mysql_error());
		fixContrato($contrato, $sig);
	}
} 
else if($action == "Baixar") {
	$contratos = $_GET['contratos'];
	foreach($contratos as $contrato) {
		$baixa	= isset($_GET['baixa'.Trim($contrato)])?$_GET['baixa'.Trim($contrato)]:$_POST['baixa'.Trim($contrato)];
		$nf		= isset($_GET['nf'.Trim($contrato)])?$_GET['nf'.Trim($contrato)]:$_POST['nf'.Trim($contrato)];
		
		$strSQL	= "UPDATE CONTRATOS SET baixado='S' ";
		$strSQL	.= ",data_pagto='" . $baixa . "' ";
		$strSQL	.= ",nota_fiscal='" . $nf . "' ";
		$strSQL	.= " WHERE id= " . $contrato;
		
// 		$mens .= $id_contrato;
		$strSQL = str_replace("''", "null", $strSQL);
		$objRS	= mysql_query($strSQL, $sig) or die(mysql_error());
		fixContrato($contrato, $sig);
	}
} 
else if($action == "excluirLote") {
	$contratos = $_GET['contratos'];
	foreach($contratos as $contrato) {
		
	}
} 
 

if($de != "") {
	$data_de = explode("/", $de);
	$de_ano	  = $data_de[2];
	$de_mes	  = $data_de[1];
	$de_dia	  = $data_de[0];
	$de_mysql = $de_ano."/".$de_mes."/".$de_dia;
}

if($ate != "") {
	$data_ate = explode("/", $ate);
	$ate_ano  = $data_ate[2];
	$ate_mes  = $data_ate[1];
	$ate_dia  = $data_ate[0];
	$ate_mysql= $ate_ano."/".$ate_mes."/".$ate_dia;
}
else {
	$ate_mysql = date("y/m/d");
}

if(isset($_GET['cliente'])) {
	$cliente = $_GET['cliente'];
	$filtroCliente = " AND (contratos.fantasia LIKE '%$cliente%' OR contratos.razao LIKE '%$cliente%') ";
}
if ($de != "") {
	$filtroData  = " AND DATA BETWEEN '$de_mysql' AND '$ate_mysql' ";
}
else {
	$filtroData  = " AND DATA > NOW() - INTERVAL 1 MONTH ";
}

$sqlTotal = "select 
    			contratos.cnpj, contratos.DATA, contratos.razao, contratos.ID, contratos.VALOR_TOTAL 
    		from 
    			CONTRATOS as contratos
    		where contratos.FINALIZADO = 'S'
			$filtroCliente
			$filtroData
    		order by ID DESC";
// echo $sqlTotal;
// $objTotal = mysql_query($sqlTotal, $sig) or die(mysql_error());

$query_sigla_autor = ("SELECT trim(NOME) as NOME, SIGLA FROM AUTORES_OFC ORDER BY trim(NOME) ASC");
$objAutor = mysql_query($query_sigla_autor, $sig) or die(mysql_error());
?>
