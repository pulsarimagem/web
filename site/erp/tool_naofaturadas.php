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
mysql_select_db($database_pulsar, $pulsar);
$sqlTotal = "select
				log_download2.id_log, log_download2.arquivo, log_download2.data_hora, log_download2.id_login, log_download2.uso, log_download2.faturado,
				cadastro.nome, cadastro.empresa
			from
				log_download2 
			LEFT JOIN cadastro ON cadastro.id_cadastro = log_download2.id_login
    		WHERE log_download2.data_hora < NOW() - INTERVAL 3 MONTH AND log_download2.data_hora > NOW() - INTERVAL 1 YEAR AND log_download2.faturado = 0 AND log_download2.id_login NOT IN (15,4350,1431,311,459,1043,3314,11,789) 
    		ORDER BY id_log DESC";
// echo $sqlTotal;
$objTotal = mysql_query($sqlTotal, $sig) or die(mysql_error());
$totalTotal = mysql_num_rows($objTotal);
?>
