<?php
//resgatando parâmetros passados pela ulr
$novo = isset($_GET['novo'])?true:false;
$novoIntegra = isset($_POST['novoIntegra'])?true:false;
$copiar = isset($_GET['copiar'])?true:false;
$editar = isset($_GET['editar'])?true:false;
$excluir = isset($_GET['excluir'])?true:false;

$finalizar = isset($_POST['finalizar'])?true:false;
$atualizar = isset($_POST['atualizar'])?true:false;

$arr_indios = getTribos($sig);
$has_indios = false;
$has_normal = false;
$is_indios = false;
$is_video = false;
$has_video = false;
$has_foto = false;

if($novo) { 
//	$id_cliente	= $_GET['id_cliente'];	
	$id_cliente	= 123;	
	$strSQL = "INSERT INTO CONTRATOS (DATA, ID_CONTRATO_DESC,id_owner) values (NOW(),7,".$row_login['id'].")";
	if($siteDebug)
		echo $strSQL;
	$objRS = mysql_query($strSQL, $sig) or die(mysql_error());
	$strSQL = "SELECT MAX(ID) as ID FROM CONTRATOS";
	$objRS = mysql_query($strSQL, $sig) or die(mysql_error());
	$row_objRS = mysql_fetch_assoc($objRS);
	$id_contrato = $row_objRS['ID'];
	$editar = true;
}
else if($novoIntegra) { 
//	$id_cliente	= $_GET['id_cliente'];	
	$id_cliente	= $_POST['id_cliente_sig'];	
	$id_contato = $_POST['qcontato'];	
	if($id_contato == "")
		$id_contato = "NULL";
	$idContratoDesc = $_POST['contrato_desc'];
	$descricao = $_POST['descricao'];
	$strSQL = "INSERT INTO CONTRATOS (DATA, ID_CONTRATO_DESC, ID_CLIENTE, ID_CONTATO, DESCRICAO, id_owner) values (NOW(),$idContratoDesc,$id_cliente,$id_contato,'".mysql_real_escape_string($descricao)."',".$row_login['id'].")";
	if($siteDebug)
		echo $strSQL;
	$objRS = mysql_query($strSQL, $sig) or die(mysql_error());
	$strSQL = "SELECT MAX(ID) as ID FROM CONTRATOS";
	$objRS = mysql_query($strSQL, $sig) or die(mysql_error());
	$row_objRS = mysql_fetch_assoc($objRS);
	$id_contrato = $row_objRS['ID'];
	$editar = true;
	$fat_arr = $_POST["fat"];
	foreach($fat_arr as $fat) {
		mysql_select_db($database_pulsar, $pulsar);
		$query = "SELECT * FROM log_download2 WHERE id_log = ".$fat;
		$doQuery = mysql_query($query, $pulsar) or die(mysql_error());
		$row_query = mysql_fetch_assoc($doQuery);
		$query = "UPDATE log_download2 SET faturado=1 WHERE arquivo LIKE '".$row_query['arquivo']."' AND EXTRACT(DAY FROM data_hora) = EXTRACT(DAY FROM '".$row_query['data_hora']."') AND projeto LIKE '".mysql_real_escape_string($row_query['projeto'])."' AND id_login = ".$row_query['id_login'];
		$doQuery = mysql_query($query, $pulsar) or die(mysql_error());
		mysql_select_db($database_sig, $sig);
	}
}else if($copiar) { 
	$strSQL = "SELECT ID, ID_CLIENTE, ID_CONTATO, ID_CONTRATO_DESC, DESCRICAO FROM CONTRATOS WHERE FINALIZADO = 'S' AND id_owner = ".$row_login['id']." ORDER BY ID DESC LIMIT 1";
	$objRS = mysql_query($strSQL, $sig) or die(mysql_error());
	$row_objRS = mysql_fetch_assoc($objRS);
	$total_objRS = mysql_num_rows($objRS);
	if($total_objRS == 0) {
		$strSQL = "SELECT ID, ID_CLIENTE, ID_CONTATO, ID_CONTRATO_DESC, DESCRICAO FROM CONTRATOS WHERE FINALIZADO = 'S' ORDER BY ID DESC LIMIT 1";
		$objRS = mysql_query($strSQL, $sig) or die(mysql_error());
		$row_objRS = mysql_fetch_assoc($objRS);
	}
	$strSQL = "INSERT INTO CONTRATOS (ID_CLIENTE, DATA, ID_CONTATO, ID_CONTRATO_DESC, DESCRICAO, id_owner) values (".$row_objRS['ID_CLIENTE'].",NOW(),".$row_objRS['ID_CONTATO'].",".$row_objRS['ID_CONTRATO_DESC'].",'".$row_objRS['DESCRICAO']."',".$row_login['id'].")";
	$strSQL = str_replace("''","Null",$strSQL);
	$strSQL = str_replace(",,",",0,",$strSQL);
	$strSQL = str_replace("(,","(0,",$strSQL);
	$objRS = mysql_query($strSQL, $sig) or die(mysql_error());
	$strSQL = "SELECT MAX(ID) as ID FROM CONTRATOS";
	$objRS = mysql_query($strSQL, $sig) or die(mysql_error());
	$row_objRS = mysql_fetch_assoc($objRS);
	$id_contrato = $row_objRS['ID'];
	header("location: administrativo_licencas_nova.php?editar=true&id_contrato=$id_contrato");
}
else {
	$id_contrato	= isset($_GET['id_contrato'])?$_GET['id_contrato']:$_POST['id_contrato'];
}
if($editar) {
	$_GET['editaDesCont'] = "sim";
}
$total = 0;

If (isset($_GET['trash'])) {
	$strSQL = "DELETE FROM CROMOS WHERE ID=".$_GET['trash'];
	$objRS6 = mysql_query($strSQL, $sig) or die(mysql_error());
}
If ($excluir) {
	$strSQL      = "DELETE FROM CONTRATOS WHERE ID =" . $id_contrato;
	$objRS_delete 	= mysql_query($strSQL, $sig) or die(mysql_error());
	header("location: administrativo_licencas.php?msg=Excluido com Sucesso!");
}	
	
if($atualizar) {
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
}

If(isset($_POST['salvaDesCont']) && $_POST['salvaDesCont'] == "sim") {

	$strSQL     = "UPDATE CONTRATOS SET DESCRICAO = '" . $_POST['descricao'] . "' WHERE ID =" . $id_contrato;
	$objUpdt	= mysql_query($strSQL, $sig) or die(mysql_error());


	$strSQL 	= "SELECT BAIXADO FROM CONTRATOS WHERE ID=".$id_contrato;
	$objRS		= mysql_query($strSQL, $sig) or die(mysql_error());
	$row_objRS = mysql_fetch_array($objRS);
	$baixado	= $row_objRS['BAIXADO'];
	
	if ($baixado != "N") {
		if(isset($_POST['nota']) && $_POST['nota'] != "0") {
			$strSQL      = "UPDATE CONTRATOS SET NOTA_FISCAL = '" . $_POST['nota'] . "' , DATA_PAGTO = '" . $_POST['data_nota'] . "' WHERE ID =" . $id_contrato;
		} else {
			$strSQL      = "UPDATE CONTRATOS SET NOTA_FISCAL = NULL , DATA_PAGTO = NULL, BAIXADO = 'N' WHERE ID =" . $id_contrato;
		}
		$objUpdt = mysql_query($strSQL, $sig) or die(mysql_error());
		$msg = "Salvo com sucesso!";
	}
}

if($finalizar) {
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
//	echo $strSQL;
	$xxx = mysql_query($strSQL, $sig) or die(mysql_error());

	$strSQL 		= "UPDATE CONTRATOS SET cnpj = '" . $row_objRS['CNPJ'] . "', fantasia = '" . $row_objRS['FANTASIA'] . "', razao = '" . $row_objRS['RAZAO'] . "', contato = '" . $row_objRS['CONTATO'] . "', endereco = '" . $row_objRS['ENDERECO'] ." - ".$row_objRS['CEP'] ." - ".$row_objRS['BAIRRO'] ." - ".$row_objRS['CIDADE'] ." - ".$row_objRS['ESTADO'] . "' WHERE ID = " . $id_contrato;
//	echo $strSQL;
	$xxx = mysql_query($strSQL, $sig) or die(mysql_error());

	//atualizando registros referente ao contrato nas tebelas de cromos
	//	$strSQL 		= "UPDATE CROMOS SET FINALIZADO='S' WHERE ID_CONTRATO=".$id_contrato;
	$strSQL 		= "UPDATE CROMOS,(SELECT USO.Id,USO_TIPO.tipo_br as tipo, USO_SUBTIPO.subtipo_br as subtipo, USO_DESC.descricao_br as descricao, CONCAT(TRIM(USO_TIPO.tipo_br),' - ', TRIM(USO_SUBTIPO.subtipo_br), ' - ', TRIM(USO_DESC.descricao_br)) AS fulldesc FROM USO LEFT JOIN USO_DESC ON USO.id_tamanho = USO_DESC.Id LEFT JOIN USO_TIPO ON USO_TIPO.Id = USO.id_tipo LEFT JOIN USO_SUBTIPO ON USO_SUBTIPO.Id = USO.id_utilizacao) AS fulldesc SET CROMOS.uso = fulldesc.fulldesc, CROMOS.finalizado = 'S' WHERE fulldesc.Id = CROMOS.ID_USO AND ID_CONTRATO=".$id_contrato;
//	echo $strSQL;
	$xxx = mysql_query($strSQL, $sig) or die(mysql_error());

	If (isset($_POST['option']) && $_POST['option']=="print") {
		///header("location: contrato_print.asp?id_contrato=".$id_contrato);
	}
	$editar = false;
	$msg = "Finalizado com sucesso!";
}
if (isset($_POST['editaCromo']) && $_POST['editaCromo'] == "sim") {
	$_GET['editaCromo'] = "sim";
}
$strSQL 		= "SELECT ID_CLIENTE, ID_CONTATO,ID_CONTRATO_DESC, DESCRICAO, DATA, BAIXADO, FINALIZADO, NOTA_FISCAL, DATA_PAGTO FROM CONTRATOS WHERE ID=".$id_contrato;
$objRS	= mysql_query($strSQL, $sig) or die(mysql_error());
$row_objRS = mysql_fetch_assoc($objRS);
$id_cliente	= $row_objRS['ID_CLIENTE'];
$id_contato	= $row_objRS['ID_CONTATO'];
$descricao	= $row_objRS['DESCRICAO'];
$contratoDesc = $row_objRS['ID_CONTRATO_DESC'];
$data		= $row_objRS['DATA'];

$finalizado		= $row_objRS['FINALIZADO'];
$baixado		= $row_objRS['BAIXADO'];
$nota		= $row_objRS['NOTA_FISCAL'];
$data_nota 	= $row_objRS['DATA_PAGTO'];

$isBaixado = $baixado == "S"?true:false;
$isFinalizado = $finalizado == "S"?true:false;


if(isset($_POST['action']) && ($_POST['action'] == "Inserir"||$_POST['action'] == "InserirNew")) {
	//resgatando parâmetros enviados pelo método post
	$id_cliente	= isset($_POST['id_cliente_sig'])?$_POST['id_cliente_sig']:$id_cliente;
//	$data 		= $_POST['data'];
//	$id_contrato	= $_POST['id_contrato'];
//	$id_contato 	= $_POST['qcontato'];
//	$descricao 	= strtoupper($_POST['descricao']);
	$id_uso 		= $_POST['id_uso'];
	$qcodigo_arr		= isset($_POST['qcodigo'])?$_POST['qcodigo']:"";
	$quso_arr			= isset($_POST['quso'])?$_POST['quso']:"";
	$qassunto	= isset($_POST['qassunto'])?strtoupper($_POST['qassunto']):"";
	$qautor		= isset($_POST['qassunto'])?strtoupper($_POST['qautor']):"";
	//$contDesc    = $_POST['contrato_desc'];

	$mens="";
	
	if($id_uso != "") {
		$sql	 	= "SELECT VALOR FROM USO WHERE Id = " . $id_uso;
// 	echo $sql;
		$rs  = mysql_query($sql, $sig) or die(mysql_error());
		$row_rs = mysql_fetch_assoc($rs);
	}
	
	$sql	 	= "SELECT desc_valor, desc_porcento FROM CLIENTES WHERE ID=".$id_cliente;
// 	echo $sql;
	$rs_desc  = mysql_query($sql, $sig) or die(mysql_error());
	$row_rs_desc = mysql_fetch_assoc($rs_desc);
	
	$hasDesconto = false;
	$desc_valor = "0,00";
	if($row_rs_desc['desc_valor'] > 0) {
// 		echo "**".$row_rs_desc['desc_valor']."<br>";
		$hasDesconto = true;
		$desc_valor = $row_rs_desc['desc_valor'];
		$desc_valor = str_replace(".", ",", (string) $desc_valor);
	} else if($row_rs_desc['desc_porcento'] > 0) {
		$hasDesconto = true;
		$desc_valor = (float) $row_rs['VALOR'] * $row_rs_desc['desc_porcento'];
		$desc_valor = str_replace(".", ",", (string) $desc_valor);
	}
	$row_rs['VALOR'] = str_replace(".", ",", (string) $row_rs['VALOR']);
	
	
	if( $_POST['action'] == "InserirNew" ) {
		//		foreach($qcodigo_arr as $qcodigo) {
		//'gravando cromo não cadastrado na tabela de cromos
		$sql = "INSERT INTO CROMOS(ID_CONTRATO, ID_USO, CODIGO, ASSUNTO, AUTOR, VALOR, DESCONTO) VALUES(" . $id_contrato . "," . $id_uso . ",'','" . $qassunto . "','" . $qautor . "','" . $row_rs['VALOR'] . "','$desc_valor')";
		$sql	= str_ireplace("''", "Null", $sql);
		$sql	= str_ireplace(",,", ",0,", $sql);
// 		echo $sql;
		$xxx = mysql_query($sql, $sig) or die(mysql_error());
		///Response.Cookies("cromo_nao_cadastrado") = "";
		///Response.Redirect("contrato-dados-continua.asp?id_contrato=" . $id_contrato);
		//		}
	} else {
// 		echo "***<br>";
// 		print_r($qcodigo_arr);
// 		print_r($quso_arr);
// 		echo "<br>***<br>";
		$qcnt = 0;
		foreach($qcodigo_arr as $qcodigo) {

			//'consultando codigo do cromo digitado
			$strSql = "SELECT * FROM viewFotos WHERE TOMBO='".$qcodigo."'" ;
//			echo $strSql;
			mysql_select_db($database_pulsar, $pulsar);
			$objRS1  = mysql_query($strSql, $pulsar) or die(mysql_error());
			mysql_select_db($database_sig, $sig);

			if($row_objRS1 = mysql_fetch_assoc($objRS1)) {
				$assunto		= $row_objRS1['Assunto_Principal'];
				$sigla_autor	= $row_objRS1['Iniciais_Fotografo'];
				//'gravando código do cromo na tabela de cromos
				
				$id_uso = isset($quso_arr[$qcnt])?$quso_arr[$qcnt]:$id_uso;
				if($id_uso != '') {
					$sql	 	= "SELECT VALOR FROM USO WHERE Id = " . $id_uso;
	// 				echo $sql;
					$rs  = mysql_query($sql, $sig) or die(mysql_error());
					$row_rs = mysql_fetch_assoc($rs);
					
					$sql	 	= "SELECT desc_valor, desc_porcento FROM CLIENTES WHERE ID=".$id_cliente;
					// 	echo $sql;
					$rs_desc  = mysql_query($sql, $sig) or die(mysql_error());
					$row_rs_desc = mysql_fetch_assoc($rs_desc);
					
					$hasDesconto = false;
					$desc_valor = "0,00";
					if($row_rs_desc['desc_valor'] > 0) {
	// 					echo "**".$row_rs_desc['desc_valor']."<br>";
						$hasDesconto = true;
						$desc_valor = $row_rs_desc['desc_valor'];
						$desc_valor = str_replace(".", ",", (string) $desc_valor);
					} else if($row_rs_desc['desc_porcento'] > 0) {
						$hasDesconto = true;
						$desc_valor = (float) $row_rs['VALOR'] * $row_rs_desc['desc_porcento'];
						$desc_valor = str_replace(".", ",", (string) $desc_valor);
					}
					$row_rs['VALOR'] = str_replace(".", ",", (string) $row_rs['VALOR']);
					
					
					$strSQL 	= "INSERT INTO CROMOS(ID_CONTRATO, ID_USO, CODIGO, ASSUNTO, AUTOR, VALOR, DESCONTO) VALUES(".$id_contrato.",".$id_uso.",'".$qcodigo."',\"".$assunto."\",'".$sigla_autor."','".$row_rs['VALOR']."','$desc_valor')";
					$strSQL	= str_ireplace("''", "Null", $strSQL);
					$strSQL	= str_ireplace(",,", ",0,", $strSQL);
	// 				echo $strSQL;
					$xxx  = mysql_query($strSQL, $sig) or die(mysql_error());
					///Response.Redirect("contrato-dados-continua.asp?id_contrato=".$id_contrato);
					//				header("location: consulta_contrato_visualiza.php?editaCromo=sim&id_contrato=" . $id_contrato);
				} else {
					$mens.="<< Uso não selecionado! Verifique cadastro. >>";
				}
			} else {
				$mens.="<< Cromo $qcodigo não existente. Verifique o código digitado. >>";

				///Response.Redirect("contrato-dados-continua.asp?record=s&id_contrato=".$id_contrato."&mens=<< Cromo não existente. Verifique o código digitado. >>");
				//				header("location: consulta_contrato_visualiza.php?editaCromo=sim&record=s&id_contrato=" . $id_contrato."&mens=<< Cromo não existente. Verifique o código digitado. >>");
			}
			$qcnt++;
		}
	}
}



//excluindo um cromo do contrato
If (isset($_GET['trash'])) {
	$strSQL = "DELETE FROM CROMOS WHERE ID=".$_GET['trash'];
	$objRS6 = mysql_query($strSQL, $sig) or die(mysql_error());
}

if(!$isFinalizado&&!$novo) {
/*	$addScript=" 
<script>
	$(window).bind('beforeunload', function() { 
		return 'Contrato ainda não finalizado!!!';
	});
</script>
";*/
}

$is_indios = isIndio($contratoDesc, $sig);
$is_video = isContratoVideo($contratoDesc, $sig);

if ($contratoDesc != 0) {
    $strSQLDESC = "SELECT b.Id, ID_CONTRATO_DESC, titulo, padrao, assinatura, tipo  FROM CONTRATOS a, CONTRATOS_DESC b WHERE a.ID_CONTRATO_DESC = b.Id and a.Id = " . $id_contrato;
}
else {
    $strSQLDESC = "SELECT Id, titulo, padrao, assinatura  FROM CONTRATOS_DESC WHERE padrao = true";
}   
$objContrDesc =  mysql_query($strSQLDESC, $sig) or die(mysql_error());
$row_objContrDesc = mysql_fetch_assoc($objContrDesc); 


if($id_cliente == "")
	$id_cliente = 0;

$strSQL 		= "SELECT CNPJ, FANTASIA, RAZAO, ENDERECO, BAIRRO, CEP, CIDADE, ESTADO, TELEFONE, OBS, desc_valor, desc_porcento FROM CLIENTES WHERE ID=".$id_cliente; 
$objRS1	= mysql_query($strSQL, $sig) or die(mysql_error());
$row_objRS1 = mysql_fetch_assoc($objRS1);
$cnpj		= $row_objRS1['CNPJ'];
$fantasia	= $row_objRS1['FANTASIA'];
$razao		= $row_objRS1['RAZAO'];
$endereco	= $row_objRS1['ENDERECO'];
$cep		= $row_objRS1['CEP'];
$cidade		= $row_objRS1['CIDADE'];
$estado		= $row_objRS1['ESTADO'];
$telefone	= $row_objRS1['TELEFONE'];
$obs		= $row_objRS1['OBS'];

$contato	= "N/A";
If ($id_contato != "") {
$strSQL 		= "SELECT ID, CONTATO FROM CONTATOS WHERE ID_CLIENTE='".$id_cliente."' AND ID=".$id_contato;
$objRS4 	= mysql_query($strSQL, $sig) or die(mysql_error());
$row_objRS4 = mysql_fetch_assoc($objRS4);

	if ($row_objRS4) {
		$contato	= $row_objRS4['CONTATO'];
		$id_contato = $row_objRS4['ID'];
	}
	else {
		$contato	= "N/A";
	}
}
$strSQL 		= "SELECT ID, ID_USO FROM CROMOS WHERE ID_CONTRATO=".$id_contrato." ORDER BY ID DESC LIMIT 1"; 
$objUso	= mysql_query($strSQL, $sig) or die(mysql_error());
if($row_objUso = mysql_fetch_assoc($objUso)) {
	$id_uso = $row_objUso['ID_USO']; 
}

$tipo_contrato = 'F';
if ($contratoDesc != 0) {
	$tipo_contrato = $row_objContrDesc['tipo'];
}

$sqlTipo = "select Id, tipo_br as tipo from USO_TIPO where Id in (select id_tipo from USO) order by tipo";
//$sqlTipo = "select Id, tipo from USO_TIPO where Id in (select id_tipo from USO) order by tipo";
$objTipo = mysql_query($sqlTipo, $sig) or die(mysql_error());


$strSQL = "SELECT ID, ID_CONTRATO, ID_USO, CODIGO, ASSUNTO, AUTOR, VALOR, DESCONTO, reuso FROM CROMOS WHERE ID_CONTRATO=".$id_contrato;
$objRS5 = mysql_query($strSQL, $sig) or die(mysql_error());

$sqlContratosDescs = "select CONTRATOS_DESC.Id, titulo,padrao, assinatura from CONTRATOS_DESC LEFT JOIN rel_contratosdesc_clientes ON rel_contratosdesc_clientes.id_contratodesc = CONTRATOS_DESC.Id where status = true AND (rel_contratosdesc_clientes.id_cliente = $id_cliente OR CONTRATOS_DESC.padrao = true) order by titulo ";
$objContrDescs = mysql_query($sqlContratosDescs, $sig) or die(mysql_error());

$sql 		= "SELECT ID, CONTATO FROM CONTATOS WHERE ID_CLIENTE = " . $id_cliente . " ORDER BY CONTATO";
$rs1 	= mysql_query($sql, $sig) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
if ($row_rs1) { 
	$qcontato = "<select data-placeholder=\"Escolha o contato\" id=\"selectContato\" class=\"span9\">";
	$qcontato .= "<option></option>";
	do { 
	    if ($row_rs1['ID'] == $id_contato) {
		    $qcontato .= "<option selected value=".$row_rs1['ID'].">".$row_rs1['CONTATO']."</option>";
	    }
	    else {
		    $qcontato .= "<option value=".$row_rs1['ID'].">".$row_rs1['CONTATO']."</option>";
	    }
	} while ($row_rs1 = mysql_fetch_assoc($rs1));
	$qcontato .= "</select>";
}
else {
	$qcontato = "<input type=\"hidden\" name=\"qcontato\" value=\"0\" />";
}

$query_empresas = sprintf("SELECT ID, RAZAO, FANTASIA FROM CLIENTES ORDER BY RAZAO");
$empresas = mysql_query($query_empresas, $sig) or die(mysql_error());
$totalRows_empresas = mysql_num_rows($empresas);

?>
