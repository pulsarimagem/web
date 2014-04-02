<?php
$_SESSION['back'] = $_SERVER['REQUEST_URI'];

$filtroCliente = "";
$filtroData = "";
$cliente = "";
$id_cliente = 0;
$de = isset($_POST['de'])?$_POST['de']:"";
$ate = isset($_POST['ate'])?$_POST['ate']:"";
$lr = isset($_POST['lr'])?$_POST['lr']:"";
$show_baixados = isset($_POST['baixados'])?true:false;
$msg = isset($_POST['msg'])?$_POST['msg']:(isset($_GET['msg'])?$_GET['msg']:"");

$action = (isset($_POST['action'])?$_POST['action']:"");

if($action == "baixaLote") {
	$contratos = $_POST['contratos'];
	$nf = $_POST['nf'];
	$baixa = $_POST['baixa'];
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
	$contratos = $_POST['contratos'];
	foreach($contratos as $contrato) {
		$baixa	= isset($_POST['baixa'.Trim($contrato)])?$_POST['baixa'.Trim($contrato)]:$_POST['baixa'.Trim($contrato)];
		$nf		= isset($_POST['nf'.Trim($contrato)])?$_POST['nf'.Trim($contrato)]:$_POST['nf'.Trim($contrato)];
		
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
else if($action == "excluirLote" && isset($_POST['contratos'])) {
	$contratos = $_POST['contratos'];
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

if(isset($_POST['cliente'])) {
	$cliente = $_POST['cliente'];
	$filtroCliente = " AND (CONVERT(contratos.fantasia USING UTF8) LIKE _UTF8 '%$cliente%' OR CONVERT(contratos.razao USING UTF8) LIKE _UTF8 '%$cliente%') ";
}
if(isset($_POST['id_cliente']) && $_POST['id_cliente']!="") {
	$id_cliente = $_POST['id_cliente'];
	$filtroCliente = " AND contratos.ID_CLIENTE = $id_cliente";
}
if ($de != "") {
	$filtroData  = " AND DATA BETWEEN '$de_mysql' AND '$ate_mysql' ";
}
else if ($lr != "") {
	$filtroData  = " AND contratos.ID = '$lr' ";
}
else {
	$filtroData  = " AND DATA > NOW() - INTERVAL 1 MONTH ";
}
$filterBaixados = "";
if(!$show_baixados && $lr=="") {
	$filterBaixados = "AND contratos.BAIXADO = 'N'";
}

$sqlTotal = "select 
    			contratos.cnpj, contratos.DATA, contratos.DATA_PAGTO, contratos.NOTA_FISCAL, contratos.razao, contratos.ID, contratos.VALOR_TOTAL 
    		from 
    			CONTRATOS as contratos
    		where contratos.FINALIZADO = 'S'
    		$filterBaixados
			$filtroCliente
			$filtroData
    		order by ID DESC";
// echo $sqlTotal;
if($action!="" || $cliente != "" || $lr != "") {
	$objTotal = mysql_query($sqlTotal, $sig) or die(mysql_error());
	$totalTotal = mysql_num_rows($objTotal);
}
else {
	$totalTotal = 0;
}

$query_empresas = sprintf("SELECT ID, RAZAO, FANTASIA FROM CLIENTES ORDER BY RAZAO");
$empresas = mysql_query($query_empresas, $sig) or die(mysql_error());
$totalRows_empresas = mysql_num_rows($empresas);	
?>
