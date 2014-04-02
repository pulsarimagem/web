<?php 
$_SESSION['back'] = $_SERVER['REQUEST_URI'];

$de = isset($_GET['de'])?$_GET['de']:date("d/m/Y", strtotime("-1 week"));
$ate = isset($_GET['ate'])?$_GET['ate']:date("d/m/Y");
$idcliente = isset($_GET['id_cliente'])&&$_GET['id_cliente']!="TODOS"?$_GET['id_cliente']:false;
$idContrato = isset($_GET['id_contrato'])&&$_GET['id_contrato']!=""?$_GET['id_contrato']:false;
$simples = (isset($_GET['tipo']))&&$_GET['tipo']=="simples"?true:false;
//formatando a data para consulta no banco mysql
$fantasia = "";

if($de != "" && $ate != "") {
	$data_de = explode("/", $de); 
	$de_ano	  = $data_de[2];
	$de_mes	  = $data_de[1];
	$de_dia	  = $data_de[0];
	$de_mysql = $de_ano."/".$de_mes."/".$de_dia;
	
	$data_ate = explode("/", $ate); 
	$ate_ano  = $data_ate[2];
	$ate_mes  = $data_ate[1];
	$ate_dia  = $data_ate[0];
	$ate_mysql= $ate_ano."/".$ate_mes."/".$ate_dia;
}

$x = 0;
$total = 0;
$total_fotos = 0;

//'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//'''''''''''''''''''''''''''''''BUSCA POR PERÍODO'''''''''''''''''''''''''''
//'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
$query_cliente = "";
$query_data = "";

if($idcliente != "") {
	$query_cliente = " AND ID_CLIENTE = '$idcliente' ";
}
if($de != "" && $ate != "") {
	$query_data = " AND DATA BETWEEN '".$de_mysql."' AND '".$ate_mysql."' ";
}
if($simples) {
	$strSQL 		= "SELECT CONTRATOS.ID,ID_CLIENTE,DATA,VALOR_TOTAL,count(CONTRATOS.ID) as num_fotos FROM CONTRATOS INNER JOIN CROMOS ON CONTRATOS.ID=CROMOS.ID_CONTRATO WHERE CONTRATOS.FINALIZADO='S' $query_cliente $query_data GROUP BY CONTRATOS.ID ORDER BY CONTRATOS.ID DESC";
} else if ($idContrato) {
	$strSQL 		= "SELECT * FROM CONTRATOS WHERE ID = $idContrato";
} else {
	$strSQL 		= "SELECT * FROM CONTRATOS WHERE FINALIZADO='S' $query_cliente $query_data ORDER BY ID DESC";
}
// echo $strSQL;
$objRs = mysql_query($strSQL, $sig) or die(mysql_error());
$row_objRs = mysql_fetch_assoc($objRs);

$query_empresas = sprintf("SELECT ID, RAZAO, FANTASIA FROM CLIENTES WHERE STATUS = 'A' ORDER BY RAZAO");
$empresas = mysql_query($query_empresas, $sig) or die(mysql_error());
$totalRows_empresas = mysql_num_rows($empresas);

if($idcliente){
	$strSQL 		= "SELECT * FROM CLIENTES WHERE ID = '" . $idcliente . "'";
	$objRs2 = mysql_query($strSQL, $sig) or die(mysql_error());
	$row_objRs2 = mysql_fetch_assoc($objRs2);
}
?>

