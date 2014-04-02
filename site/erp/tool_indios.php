<?php
$filtroTribo = "";
$tribo = "";

$action = (isset($_GET['action'])?$_GET['action']:"");

$atualizar = false;
if($action == "salvar") {
	$tribo = $_GET['tribo'];
	$sinonimos = $_GET['sinonimos'];
	$strSQL	= "INSERT INTO indios (tribo,sinonimos) VALUES ('$tribo','$sinonimos');";
	
	
// 	$strSQL	= "UPDATE CONTRATOS SET baixado='S' ";
// 	$strSQL	.= ",data_pagto='" . $baixa . "' ";
// 	$strSQL	.= ",nota_fiscal='" . $nf . "' ";
// 	$strSQL	.= " WHERE id= " . $contrato;
		
	$strSQL = str_replace("''", "null", $strSQL);
	$objRS	= mysql_query($strSQL, $sig) or die(mysql_error());
	$msg = "Inserido com sucesso!";
} 
else if ($action == "atualizar") {
	$id = $_GET['id'];
	$tribo = $_GET['tribo'];
	$sinonimos = $_GET['sinonimos'];
	
	
	$strSQL	= "UPDATE indios SET tribo='$tribo' ";
	$strSQL	.= ",sinonimos='" . $sinonimos . "' ";
	$strSQL	.= " WHERE id = " . $id;
	
	$strSQL = str_replace("''", "null", $strSQL);
	$objRS	= mysql_query($strSQL, $sig) or die(mysql_error());
	$msg = "Atualizado com sucesso!";
}
else if($action == "excluir") {
	$id = $_GET['id'];
	$strSQL	= "DELETE FROM indios WHERE id = " . $id;
	$objRS	= mysql_query($strSQL, $sig) or die(mysql_error());
	$msg = "Excluído com sucesso!";
} 
else if($action == "carregar") {
	$id = $_GET['id'];
	$atualizar = true;
	
	$sqlSingle = "select
	id, tribo, sinonimos
	from
	indios
	WHERE id = $id
	order by id DESC";
	// echo $sqlTotal;
	$objSingle = mysql_query($sqlSingle, $sig) or die(mysql_error());
	$rowSingle = mysql_fetch_array($objSingle);
}

if(isset($_GET['busca']) && $_GET['busca'] != "") {
	$tribo = $_GET['busca'];
	$filtroTribo = " WHERE tribo LIKE '%$tribo%' OR sinonimos LIKE '%$tribo%'";
}

$sqlTotal = "select 
    			id, tribo, sinonimos 
    		from 
    			indios
			$filtroTribo
    		order by id DESC";
// echo $sqlTotal;
$objTotal = mysql_query($sqlTotal, $sig) or die(mysql_error());


?>
