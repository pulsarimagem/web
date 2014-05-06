<?php 
$msg = "";
$action = isset($_GET['action'])?$_GET['action']:(isset($_POST['action'])?$_POST['action']:"");
$id = isset($_GET['id_contrato'])?$_GET['id_contrato']:"";

$novo = isset($_GET['novo'])?true:false;
$copiar = isset($_GET['copiar'])?true:false;
$editar = isset($_GET['editar'])?true:false;
$excluir = isset($_GET['excluir'])?true:false;

$clientes_arr = array();

if ($action == 'incluir') {    
// if (isset($_POST['inclui']) ) {    
//print_r($_POST);
//echo "<br>";
	$sqlInsere = "insert into CONTRATOS_DESC (titulo,condicoes,padrao,assinatura, indio, status, tipo) values('" . $_POST['txtTitulo'] . "' , '" . str_ireplace("'", "''", $_POST['FCKeditor1']) . "' ," . $_POST['padrao'] . " ," . $_POST['assinatura'] . " ," . $_POST['indio'] . " ," . $_POST['status'] . ",'" . $_POST['tipo'] . "')";
 echo $sqlInsere."<br>";
	$rs = mysql_query($sqlInsere, $sig) or die(mysql_error());
	$id_gravar = mysql_insert_id($rs);
	$sql = "SELECT LAST_INSERT_ID() as id";
	$rs = mysql_query($sql, $sig) or die(mysql_error());
	$row = mysql_fetch_array($rs);
	$id_gravar = $row['id'];
    $clientes = $_POST['clientes'];
	foreach ($clientes as $cliente) {
		$sqlInsert = "INSERT INTO rel_contratosdesc_clientes (id_contratodesc, id_cliente) VALUES ($id_gravar,$cliente)";
		mysql_query($sqlInsert, $sig) or die(mysql_error());
	}
    $msg = "Incluído com Sucesso!";
}

if ($excluir) {
// if (isset($_GET['delete'])) {
    $sqlDelete = "update CONTRATOS_DESC set status = 0 where Id = $id";
    mysql_query($sqlDelete, $sig) or die(mysql_error());
    $msg = "Desabilitado com Sucesso!";
}

if ($action == 'gravar') {
// if (isset($_POST['gravaedita'])) {
//print_r($_POST);
//echo "<br>";
	$id_gravar = $_POST['id'];
	$sqlEdita = " update CONTRATOS_DESC set titulo = '" . $_POST['txtTitulo'] . "' , condicoes = '" . str_ireplace("'", "''", $_POST['FCKeditor1']) . "' , padrao = " . $_POST['padrao'] . " , assinatura =  " . $_POST['assinatura'] . ", indio = ".$_POST['indio'].", status = ".$_POST['status'].", tipo = '".$_POST['tipo']."' where Id = " . $_POST['id'];
// echo $sqlEdita;
    mysql_query($sqlEdita, $sig) or die(mysql_error());
    $sqlDel = "DELETE FROM rel_contratosdesc_clientes WHERE id_contratodesc = $id_gravar";
    mysql_query($sqlDel, $sig) or die(mysql_error());
    $clientes = isset($_POST['clientes'])?$_POST['clientes']:array();
    foreach ($clientes as $cliente) {
    	$sqlSelect = "SELECT * FROM rel_contratosdesc_clientes WHERE id_contratodesc = $id_gravar AND id_cliente = $cliente";
    	$rsSelect = mysql_query($sqlSelect, $sig) or die(mysql_error());
    	$totSelect = mysql_num_rows($rsSelect);
    	if($totSelect == 0) {
    		$sqlInsert = "INSERT INTO rel_contratosdesc_clientes (id_contratodesc, id_cliente) VALUES ($id_gravar,$cliente)";
    		mysql_query($sqlInsert, $sig) or die(mysql_error());
    	}
    }
    $msg = "Alterado com Sucesso!";
}

if ($editar) {
	// if (isset($_GET['edita'])) {
	$sqlPorId = "select Id, titulo, condicoes, padrao, assinatura, indio, status, tipo, num_contratos from CONTRATOS_DESC LEFT JOIN (select ID_CONTRATO_DESC as id_contrato, count(ID_CONTRATO_DESC) as num_contratos from CONTRATOS group by ID_CONTRATO_DESC) as count on CONTRATOS_DESC.Id = count.id_contrato where Id = $id";
	//    Set objId = connect.execute($sqlPorId)
	$objId = mysql_query($sqlPorId, $sig) or die(mysql_error());
	$row_objId = mysql_fetch_assoc($objId);
	
	$sqlRel = "select id_cliente FROM rel_contratosdesc_clientes WHERE id_contratodesc = $id";
	$rsRel = mysql_query($sqlRel, $sig) or die(mysql_error());
	
	while ($rowRel = mysql_fetch_assoc($rsRel)) {
		$clientes_arr[]=$rowRel['id_cliente'];
	}
}


$sqlTodos = "select Id, titulo, condicoes, padrao, assinatura, indio, status, tipo, num_contratos from CONTRATOS_DESC LEFT JOIN (select ID_CONTRATO_DESC as id_contrato, count(ID_CONTRATO_DESC) as num_contratos from CONTRATOS group by ID_CONTRATO_DESC) as count on CONTRATOS_DESC.Id = count.id_contrato where status = 1 order by titulo asc";
$objTotal = mysql_query($sqlTodos, $sig) or die(mysql_error());

$query_empresas = sprintf("SELECT ID, RAZAO, FANTASIA FROM CLIENTES WHERE STATUS = 'A' ORDER BY RAZAO");
$empresas = mysql_query($query_empresas, $sig) or die(mysql_error());
$totalRows_empresas = mysql_num_rows($empresas);
?>
<?php /*
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
	$filtroCliente = " AND (CONVERT(contratos.fantasia USING UTF8) LIKE _UTF8 '%$cliente%' OR CONVERT(contratos.razao USING UTF8) LIKE _UTF8 '%$cliente%') ";
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
$objTotal = mysql_query($sqlTotal, $sig) or die(mysql_error());

*/?>
