<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>

<?php

$id_contrato	= $_POST['id_contrato'];


If(isset($_POST['salvaDesCont']) && $_POST['salvaDesCont'] == "sim") {

	$strSQL     = "UPDATE CONTRATOS SET DESCRICAO = '" . $_POST['descricao'] . "' , ID_CONTRATO_DESC = " . $_POST['contrato_desc'] . ", ID_CONTATO = " . $_POST['qcontato'] . " WHERE ID =" . $id_contrato;
	$objUpdt	= mysql_query($strSQL, $sig) or die(mysql_error());


	$strSQL 	= "SELECT BAIXADO FROM CONTRATOS WHERE ID=".$id_contrato;
	$objRS		= mysql_query($strSQL, $sig) or die(mysql_error());
	$row_objRS = mysql_fetch_array($objRS);
	$baixado	= $row_objRS['BAIXADO'];

	if ($baixado != "N") {
		if($_POST['nota'] == "0") {
			$strSQL      = "UPDATE CONTRATOS SET NOTA_FISCAL = NULL , DATA_PAGTO = NULL, BAIXADO = 'N' WHERE ID =" . $id_contrato;
		} else {
			$strSQL      = "UPDATE CONTRATOS SET NOTA_FISCAL = '" . $_POST['nota'] . "' , DATA_PAGTO = '" . $_POST['data_nota'] . "' WHERE ID =" . $id_contrato;
		}
		$objUpdt = mysql_query($strSQL, $sig) or die(mysql_error());
	}
}

if($_POST['exec'] == "cromo") {
//resgatando parâmetros enviados pelo método post
$id_cliente	= $_POST['id'];
$data 		= $_POST['data'];
$id_contrato	= $_POST['id_contrato'];
$id_contato 	= $_POST['qcontato'];
$descricao 	= strtoupper($_POST['descricao']);
$id_uso 		= $_POST['id_uso'];
$qcodigo_arr		= $_POST['qcodigo'];
$qassunto	= strtoupper($_POST['qassunto']);
$qautor		= strtoupper($_POST['qautor']);
$contDesc    = $_POST['contrato_desc'];

$sql	 	= "SELECT VALOR FROM USO WHERE Id = " . $id_uso;
echo $sql;
$rs  = mysql_query($sql, $sig) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);

$sql	 	= "SELECT desc_valor, desc_porcento FROM CLIENTES WHERE ID=".$id_cliente;
echo $sql;
$rs_desc  = mysql_query($sql, $sig) or die(mysql_error());
$row_rs_desc = mysql_fetch_assoc($rs_desc);

$hasDesconto = false;
$desc_valor = "0,00";
if($row_rs_desc['desc_valor'] > 0) {
	echo "**".$row_rs_desc['desc_valor']."<br>";
	$hasDesconto = true;
	$desc_valor = $row_rs_desc['desc_valor'];
	$desc_valor = str_replace(".", ",", (string) $desc_valor);
} else if($row_rs_desc['desc_porcento'] > 0) {
	$hasDesconto = true;
	$desc_valor = (float) $row_rs['VALOR'] * $row_rs_desc['desc_porcento'];
	$desc_valor = str_replace(".", ",", (string) $desc_valor);
}
$row_rs['VALOR'] = str_replace(".", ",", (string) $row_rs['VALOR']);

//formatando a data para gravação no banco mysql
//$data_ano	= Year($data);
//$data_mes	= Month($data);
//$data_dia	= Day($data);
//$data_mysql	= $data_ano."/".$data_mes."/".$data_dia;	
$data_mysql	= $data;
//''''''''ROTINA PARA GRAVAÇÃO DE DADOS DE NOVO CONTRATO'''''''''
//'gravando informações na tabela de contratos
if( $id_contrato == "" ) { 
	$sql	= "INSERT INTO CONTRATOS(ID_CLIENTE, ID_CONTATO, DESCRICAO, DATA, ID_CONTRATO_DESC) VALUES('" . $id_cliente . "','" . $id_contato . "','" . $descricao . "','" . $data_mysql . "', " . $contDesc . ")";
	$sql	= str_ireplace("''", "Null", $sql);
	$sql	= str_ireplace(",,", ",0,", $sql);
	$sql	= str_ireplace("'-- selecione --'", "Null", $sql);
echo $sql;
	$xxx  = mysql_query($sql, $sig) or die(mysql_error());
	
	$sql		= "SELECT MAX(ID) FROM CONTRATOS";
	$rs1	 = mysql_query($sql, $sig) or die(mysql_error());
	$row_rs1 = mysql_fetch_assoc($rs1);
	$id_contrato = $row_rs1['MAX(ID)'];
	//'Response.Cookies("cliente")("id_contrato")= id_contrato

	if( $qcodigo_arr == "" ) {
		foreach($qcodigo_arr as $qcodigo) {
			//'gravando cromo não cadastrado na tabela de cromos
			$sql = "INSERT INTO CROMOS(ID_CONTRATO, ID_USO, CODIGO, ASSUNTO, AUTOR, VALOR, DESCONTO) VALUES(" . $row_rs1['MAX(ID)'] . "," . $id_uso . ",'" . $qcodigo . "',\"" . $qassunto . "\",'" . $qautor . "','" . $row_rs0['valor'] . "','$desc_valor')";
			$sql	= str_ireplace("''", "Null", $sql);
			$sql	= str_ireplace(",,", ",0,", $sql);
			$xxx  = mysql_query($sql, $sig) or die(mysql_error());
			echo $sql;
			///Response.Cookies("cromo_nao_cadastrado") = "";
			///Response.Redirect("contrato-dados-continua.asp?id_contrato=" . rs1("MAX(id)"));
		}	
	} else {
		foreach($qcodigo_arr as $qcodigo) {
		
			//'consultando codigo do cromo digitado
			$sql 	= "SELECT * FROM viewFotos WHERE TOMBO = '" . $qcodigo . "'"; 
			mysql_select_db($database_pulsar, $pulsar);
			$rs2  = mysql_query($sql, $pulsar) or die(mysql_error());
			mysql_select_db($database_sig, $sig);
			
			if(isset($_POST['uso_'.$qcodigo])) {
				$id_uso=$_POST['uso_'.$qcodigo];
				
				$sql	 	= "SELECT VALOR FROM USO WHERE Id = " . $id_uso;
				echo $sql;
				$rs  = mysql_query($sql, $sig) or die(mysql_error());
				$row_rs = mysql_fetch_assoc($rs);
				
				if($hasDesconto) {
					$desc_valor = (float) $row_rs['VALOR'] * $row_rs_desc['desc_porcento'];
					$desc_valor = str_replace(".", ",", (string) $desc_valor);
				}
				$row_rs['VALOR'] = str_replace(".", ",", (string) $row_rs['VALOR']);
			}
				
			if(!$row_rs2 = mysql_fetch_assoc($rs2)) {
				///response.Redirect("contrato-dados-continua.asp?record=s&id_contrato=".$row_rs1['MAX(id)']."&mens=<< Cromo(".$qcodigo.") não existente. Verifique o código digitado. >>");
	
			} else {
				$assunto		= $row_rs2['Assunto_Principal'];
				$sigla_autor	= $row_rs2['Iniciais_Fotografo'];		
				//'gravando código do cromo na tabela de cromos		
				$sql 		= "INSERT INTO CROMOS(ID_CONTRATO, ID_USO, CODIGO, ASSUNTO, AUTOR, VALOR, DESCONTO) VALUES(" . $row_rs1['MAX(ID)'] . "," .$id_uso . ",'" . $qcodigo . "',\"" . $assunto . "\",'" . $sigla_autor . "','" . $row_rs['VALOR'] . "','$desc_valor')";
				$sql	= str_ireplace("''", "Null", $sql);
				$sql	= str_ireplace(",,", ",0,", $sql);
				echo $sql;
				$xxx  = mysql_query($sql, $sig) or die(mysql_error());
				///Response.Redirect("contrato-dados-continua.asp?id_contrato=".rs1("MAX(id)"));
			}	
		}
	}
	
} else {

//''''''''ROTINA PARA GRAVAÇÃO DE DADOS DE CONTRATO EXISTENTE'''''''''
	if( $qcodigo_arr == "" ) {
//		foreach($qcodigo_arr as $qcodigo) {
			//'gravando cromo não cadastrado na tabela de cromos
			$sql = "INSERT INTO CROMOS(ID_CONTRATO, ID_USO, CODIGO, ASSUNTO, AUTOR, VALOR, DESCONTO) VALUES(" . $id_contrato . "," . $id_uso . ",'" . $qcodigo . "','" . $qassunto . "','" . $qautor . "','" . $row_rs['VALOR'] . "','$desc_valor')";
			$sql	= str_ireplace("''", "Null", $sql);
			$sql	= str_ireplace(",,", ",0,", $sql);
			echo $sql;
			$xxx = mysql_query($sql, $sig) or die(mysql_error());
			///Response.Cookies("cromo_nao_cadastrado") = "";
			///Response.Redirect("contrato-dados-continua.asp?id_contrato=" . $id_contrato);
//		}
		header("location: consulta_contrato_visualiza.php?editaCromo=sim&id_contrato=" . $id_contrato);
	} else {
		foreach($qcodigo_arr as $qcodigo) {
		
			//'consultando codigo do cromo digitado
			$strSql = "SELECT * FROM viewFotos WHERE TOMBO='".$qcodigo."'" ;
			echo $strSql;
			mysql_select_db($database_pulsar, $pulsar);
			$objRS1  = mysql_query($strSql, $pulsar) or die(mysql_error());
			mysql_select_db($database_sig, $sig);
			
			if($row_objRS1 = mysql_fetch_assoc($objRS1)) {
				$assunto		= $row_objRS1['Assunto_Principal'];
				$sigla_autor	= $row_objRS1['Iniciais_Fotografo'];	
				//'gravando código do cromo na tabela de cromos		
				$strSQL 	= "INSERT INTO CROMOS(ID_CONTRATO, ID_USO, CODIGO, ASSUNTO, AUTOR, VALOR, DESCONTO) VALUES(".$id_contrato.",".$id_uso.",'".$qcodigo."',\"".$assunto."\",'".$sigla_autor."','".$row_rs['VALOR']."','$desc_valor')";
				$strSQL	= str_ireplace("''", "Null", $strSQL);
				$strSQL	= str_ireplace(",,", ",0,", $strSQL);
				echo $strSQL;
				$xxx  = mysql_query($strSQL, $sig) or die(mysql_error());
				///Response.Redirect("contrato-dados-continua.asp?id_contrato=".$id_contrato);
				header("location: consulta_contrato_visualiza.php?editaCromo=sim&id_contrato=" . $id_contrato);
			} else {
				///Response.Redirect("contrato-dados-continua.asp?record=s&id_contrato=".$id_contrato."&mens=<< Cromo não existente. Verifique o código digitado. >>");
				header("location: consulta_contrato_visualiza.php?editaCromo=sim&record=s&id_contrato=" . $id_contrato."&mens=<< Cromo não existente. Verifique o código digitado. >>");
			}
		}
	}
}
}
else if($_POST['exec'] == "atualiza_valor") {
	//resgatando parâmetros enviados pelo form via método post
	$id_contrato		= $_POST['id_contrato'];
	
	//atualizando múltiplos registros no banco de dados
	$contador1 = 0;
	While ($contador1 < $_POST['contador'] - 0) {
		$strSQL = "UPDATE CROMOS SET VALOR='" . $_POST['valor'.$contador1] . "',DESCONTO='" . $_POST['desconto'.$contador1] . "' WHERE ID=" . $_POST['id'.$contador1];
		//RESPONSE.Write(STRSQL)
		//RESPONSE.End()
		$xxx = mysql_query($strSQL, $sig) or die(mysql_error());
		$contador1 = $contador1 + 1;
	}
	
	//redirecionando para a página de visualização do contrato
	header("location: consulta_contrato_visualiza.php?editaCromo=sim&id_contrato=".$id_contrato);	
}
else if($_POST['exec'] == "finaliza") {
	//resgatando parâmetros enviados pelo método post
	$id_contrato = $_POST['id_contrato'];
	$valor_total = $_POST['valor_total'];
	
	$strSQL 	= "SELECT CONTRATOS.BAIXADO, CONTATOS.CONTATO, CLIENTES.CNPJ, CLIENTES.RAZAO, CLIENTES.FANTASIA, CLIENTES.ENDERECO, CLIENTES.BAIRRO, CLIENTES.CEP, CLIENTES.CIDADE, CLIENTES.ESTADO FROM CONTRATOS LEFT JOIN CLIENTES ON CLIENTES.ID = CONTRATOS.ID_CLIENTE LEFT JOIN CONTATOS ON CONTATOS.ID = CONTRATOS.ID_CONTATO WHERE CONTRATOS.ID=".$id_contrato;
	$objRS		= mysql_query($strSQL, $sig) or die(mysql_error());
	$row_objRS = mysql_fetch_array($objRS);
	$baixado	= $row_objRS['BAIXADO'];
	
	if ($baixado != "S") {
		$baixado = "N";
	}
	
	//atualizando registros referente ao contrato nas tebelas de contratos
	$strSQL 		= "UPDATE CONTRATOS SET VALOR_TOTAL = '" . $valor_total . "', FINALIZADO = 'S', BAIXADO = '$baixado' WHERE ID = " . $id_contrato;
echo $strSQL;
	$xxx = mysql_query($strSQL, $sig) or die(mysql_error());

	$strSQL 		= "UPDATE CONTRATOS SET cnpj = '" . $row_objRS['CNPJ'] . "', fantasia = '" . $row_objRS['FANTASIA'] . "', razao = '" . $row_objRS['RAZAO'] . "', contato = '" . $row_objRS['CONTATO'] . "', endereco = '" . $row_objRS['ENDERECO'] ." - ".$row_objRS['CEP'] ." - ".$row_objRS['BAIRRO'] ." - ".$row_objRS['CIDADE'] ." - ".$row_objRS['ESTADO'] . "' WHERE ID = " . $id_contrato;
echo $strSQL;
	$xxx = mysql_query($strSQL, $sig) or die(mysql_error());
	
	//atualizando registros referente ao contrato nas tebelas de cromos
//	$strSQL 		= "UPDATE CROMOS SET FINALIZADO='S' WHERE ID_CONTRATO=".$id_contrato;
	$strSQL 		= "UPDATE CROMOS,(SELECT USO.Id,USO_TIPO.tipo_br as tipo, USO_SUBTIPO.subtipo_br as subtipo, USO_DESC.descricao_br as descricao, CONCAT(TRIM(USO_TIPO.tipo_br),' - ', TRIM(USO_SUBTIPO.subtipo_br), ' - ', TRIM(USO_DESC.descricao_br)) AS fulldesc FROM USO LEFT JOIN USO_DESC ON USO.id_tamanho = USO_DESC.Id LEFT JOIN USO_TIPO ON USO_TIPO.Id = USO.id_tipo LEFT JOIN USO_SUBTIPO ON USO_SUBTIPO.Id = USO.id_utilizacao) AS fulldesc SET CROMOS.uso = fulldesc.fulldesc, CROMOS.finalizado = 'S' WHERE fulldesc.Id = CROMOS.ID_USO AND ID_CONTRATO=".$id_contrato;
echo $strSQL;
	$xxx = mysql_query($strSQL, $sig) or die(mysql_error());
		
	If ($_POST['option']=="print") {
		///header("location: contrato_print.asp?id_contrato=".$id_contrato);
	}
	
	header("location: consulta_contrato_visualiza.php?id_contrato=$id_contrato");//?mens=Contrato nº".id_contrato." registrado com sucesso.");
}
else {
	header("location: consulta_contrato_visualiza.php?editaCromo=sim&id_contrato=".$id_contrato);
}
if($_POST['cromo_nao_cadastrado'] == "s") {
	header("location: consulta_contrato_visualiza.php?editaCromo=sim&cromo_nao_cadastrado=s&id_contrato=" . $id_contrato);
}
else if($_POST['exec'] == "finaliza") {
	header("location: consulta_contrato_visualiza.php?id_contrato=$id_contrato");//?mens=Contrato nº".id_contrato." registrado com sucesso.");	
}
else 
	header("location: consulta_contrato_visualiza.php?editaCromo=sim&id_contrato=".$id_contrato);
?>
</body>
</html>