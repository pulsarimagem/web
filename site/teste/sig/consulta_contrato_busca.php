<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>MOVIMENTO/CONTRATO/CONSULTA .::SIG - SISTEMA DE INFORMAÇÕES GERENCIAIS PULSAR IMAGENS::.</title>
<script language="javascript">
	function valida(){
		if (form.baixa.value=='' && form.nf.value=='')
		{alert('Nenhum dado fornecido...');form.baixa.focus();return false;}
		form.action="baixaContrato4.asp";
		form.ENCTYPE = "";
		form.method="get";
		form.submit(); 
	}
	
	function SomenteNumero(e){
    	var tecla=(window.event)?event.keyCode:e.which;
    
		if((tecla > 47 && tecla < 58)) return true;
    	else{
    		if (tecla != 8) return false;
    	else return true;
    		}
	}
	
	function txtBoxFormat(objeto, sMask, evtKeyPress) {
			var i, nCount, sValue, fldLen, mskLen,bolMask, sCod, nTecla;
	
			if(document.all) { // Internet Explorer
			nTecla = evtKeyPress.keyCode;
			} else if(document.layers) { // Nestcape
			nTecla = evtKeyPress.which;
			} else {
			nTecla = evtKeyPress.which;
			if (nTecla == 8) {
			return true;
			}
		}
		sValue = objeto.value;
		// Limpa todos os caracteres de formatação que
		// já estiverem no campo.
		sValue = sValue.toString().replace( "-", "" );
		sValue = sValue.toString().replace( "-", "" );
		sValue = sValue.toString().replace( ".", "" );
		sValue = sValue.toString().replace( ".", "" );
		sValue = sValue.toString().replace( "/", "" );
		sValue = sValue.toString().replace( "/", "" );
		sValue = sValue.toString().replace( ":", "" );
		sValue = sValue.toString().replace( ":", "" );
		sValue = sValue.toString().replace( "(", "" );
		sValue = sValue.toString().replace( "(", "" );
		sValue = sValue.toString().replace( ")", "" );
		sValue = sValue.toString().replace( ")", "" );
		sValue = sValue.toString().replace( " ", "" );
		sValue = sValue.toString().replace( " ", "" );
		fldLen = sValue.length;
		mskLen = sMask.length;
	
		i = 0;
		nCount = 0;
		sCod = "";
		mskLen = fldLen;
	
		while (i <= mskLen) {
		  bolMask = ((sMask.charAt(i) == "-") || (sMask.charAt(i) == ".") || (sMask.charAt(i) == "/") || (sMask.charAt(i) == ":"))
		  bolMask = bolMask || ((sMask.charAt(i) == "(") || (sMask.charAt(i) == ")") || (sMask.charAt(i) == " "))
		  if (bolMask) {
			sCod += sMask.charAt(i);
			mskLen++; }
		  else {
			sCod += sValue.charAt(nCount);
			nCount++;
		  }
		  i++;
		}
		objeto.value = sCod;
		if (nTecla != 8) { // backspace
		  if (sMask.charAt(i-1) == "9") { // apenas números...
			return ((nTecla > 47) && (nTecla < 58)); } 
		  else { // qualquer caracter...
			return true;
		  } 
		}
		else {
		  return true;
		}
	  }
</script>  
<link href="atributos/global.css" type="text/css" rel="stylesheet" media="screen" />
<link href="atributos/tablecloth.css" type="text/css" rel="stylesheet" media="screen" />
<LINK href="css/style.css" type=text/css rel=STYLESHEET />
<style>
#border{
	border-style:solid;
	border-width:thin;
	border-color:#999999;
	padding:5px 5px 5px 5px;
	font-family:Georgia, Times New Roman, Times, serif
	}
</style>
<?php include("part_top.php")?>
</head>

<body>
<?php
//resgatando parâmetros enviados pelo form via método get
$id_contrato = isset($_GET['id_contrato'])?$_GET['id_contrato']:"";
$fantasia 	= isset($_GET['fantasia'])?$_GET['fantasia']:"";
$razao	 	= isset($_GET['razao'])?$_GET['razao']:"";
$codigo 	= isset($_GET['codigo'])?$_GET['codigo']:"";
$de			= isset($_GET['de'])?$_GET['de']:"";
$ate		= isset($_GET['ate'])?$_GET['ate']:"";
$id_cliente	= isset($_GET['id_cliente'])?$_GET['id_cliente']:"";
$baixa	= isset($_GET['baixa'])?true:false;
$novo = isset($_GET['novo'])?true:false;
$relatorio = isset($_GET['relatorio'])?true:false;
$delete = isset($_GET['delete'])?true:false;
$simples = isset($_GET['simples'])?true:false;
$cromos = isset($_GET['cromos'])?true:false;
$cliente = isset($_GET['cliente'])?true:false;


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

$x = 0;
if ($relatorio && $fantasia == "") {
	header("Location: relatorio_contratos.php?de=$de&ate=$ate");
}
else if ($cromos) {
	header("Location: relatorio_cromos.php?de=$de&ate=$ate&codigo=$codigo&id_cliente=$id_cliente");
}
//realizando a consulta por id do contrato
else if ( $id_contrato != "" ) { 
	$strSQL    = "SELECT * FROM CONTRATOS WHERE id='".$id_contrato."' AND FINALIZADO = 'S'";
	$objRS = mysql_query($strSQL, $sig) or die(mysql_error());
	
	if (!$row_objRS = mysql_fetch_assoc($objRS)) {
?>
		<table>
			<tr>
				<th colspan="2"><center><font face="Times New Roman">Consulta de Contratos</font></center></th>
			</tr>
			
			<tr></tr>
	
			<tr>
				<td id="border" colspan="2">Nenhum registro encontrado com as informações digitadas.</td>
			</tr>
		
			<tr>
				<td id="border" width="25%">Nº do contrato:</td>
				<td id="border"><b><?php echo  $id_contrato ?>&nbsp;</b></td>
			</tr>
			
			<tr>
				<td colspan="2"><a href="<?php echo $_SESSION['menu_url'] ?>"><b>Clique aqui</b></a> para realizar nova consulta.</td>
			</tr>
		</table>
	<?php
	} Else {
		header("Location: consulta_contrato_visualiza.php?id_contrato=".$id_contrato.($delete?"&delete=true":""));
	}

//realizando a consulta por nome fantasia e/ou período
} Else if ( $id_cliente == "" ) {
	if($cliente && $novo) {
		header("Location: consulta_cliente.php?mens=&novo=true");
	}
	$add_where = false;
	if($novo) {
		$filter_ativos = " STATUS = 'A'";
		$add_where = true;
	}
	if($razao != "") {
		if($add_where)
			$filter_razao = " AND ";
		$filter_razao .= " RAZAO LIKE ('%$razao%')";
		$add_where = true;
	}
	if($fantasia != "") {
		if($add_where)
			$filter_fantasia = " AND ";
		$filter_fantasia .= " FANTASIA LIKE ('%$fantasia%')";
		$add_where = true;
	}
	$strSQL2		= "SELECT * FROM CLIENTES ";
	if($add_where) {
		$strSQL2		.= " WHERE $filter_ativos $filter_razao $filter_fantasia ";
	}
	$strSQL2		.= " ORDER BY FANTASIA";
	
//	$strSQL2		= "SELECT * FROM CLIENTES WHERE FANTASIA LIKE('%".$fantasia."%') ORDER BY FANTASIA"; 
	$objRS2 = mysql_query($strSQL2, $sig) or die(mysql_error());
	if (!$row_objRS2 = mysql_fetch_assoc($objRS2)) {
?>
		<table>
			<tr>
				<th colspan="2"><center><font face="Times New Roman">Consulta de Contratos</font></center></th>
			</tr>
			
			<tr></tr>
	
			<tr>
				<td id="border" colspan="2">Nenhum registro encontrado com as informações digitadas.</td>
			</tr>
<?php if($fantasia != "") { ?>		
			<tr>
				<td id="border" width="25%">Nome Fantasia:</td>
				<td id="border"><b><?php echo  $fantasia ?>&nbsp;</b></td>
			</tr>
<?php } if($razao != "") { ?>		
			<tr>
				<td id="border" width="25%">Razão Social:</td>
				<td id="border"><b><?php echo  $razao ?>&nbsp;</b></td>
			</tr>
<?php } ?>
			<tr>
				<td colspan="2"><a href="<?php echo $_SESSION['menu_url'] ?>"><b>Clique aqui</b></a> para realizar nova consulta.</td>
			</tr>
		</table>
	<?php
	} ELSE {
	?>
		<table width="95%">
			<tr>
				<th colspan="3"><center><font face="Times New Roman">Consulta de Contratos</font></center></th>
			</tr>
			
			<tr></tr>
			
			<tr>
				<td id="border"><center><font face="Times New Roman" color="#000000"><b>NOME FANTASIA</b></font></center></td>
				<td id="border" width="50%"><center><font face="Times New Roman" color="#000000"><b>RAZÃO SOCIAL</b></font></center></td>
				<td id="border" width="20%"><center><font face="Times New Roman" color="#000000"><b>CNPJ</b></font></center></td>
			</tr>
			
			<?php
			do {
			$x += 1;
			if($novo) {
				$href = "consulta_contrato_visualiza.php?id_cliente=".$row_objRS2['ID']."&novo=true&editaDesCont=sim&editaCromo=sim";
			}
			else if($relatorio) {
				$href = "relatorio_contratos.php?id_cliente=".$row_objRS2['ID']."&amp;de=".$de."&amp;ate=".$ate.($simples?"&simples=true":"");
			}
			else if($cliente) {
				$href = "consulta_cliente.php?mens=&id_cliente=".$row_objRS2['ID'];
			}
			else {
				$href = "consulta_contrato_busca.php?id_cliente=".$row_objRS2['ID']."&amp;de=".$de."&amp;ate=".$ate.($delete?"&delete=true":"");
			}
			?>
			
				<tr>
					<td id="border"><a href="<?php echo $href?>" title="Selecionar Cliente"><b><?php echo  $row_objRS2['FANTASIA']?></b></a></td>
					<td id="border"><?php echo $row_objRS2['RAZAO']?></td>
					<td id="border"><b><?php echo $row_objRS2['CNPJ']?></b></td>
				</tr>
		
			<?php
			} while ($row_objRS2 = mysql_fetch_assoc($objRS2));
			?>
			
			<tr>
				<td colspan="23"> Foram localizados (<b><?php echo $x?></b>) registros com esta consulta. <a href="<?php echo $_SESSION['menu_url'] ?>"><b>Clique aqui</b></a> para nova consulta.</td>
			</tr>
		</table>
	<?php
	}
} else {
	
	//'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
	//'''''''VISUALIZANDO CONTRATOS DO CLIENTE SELECIONADO'''''''''''''''''''''''
	//'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
	if ( $de != "" && $ate != "" ) {
		$strSQL 		= "";
		$strSQL 		.= "SELECT * FROM CONTRATOS WHERE ID_CLIENTE='".$id_cliente."' AND DATA BETWEEN' ".$de_mysql." 'AND' ".$ate_mysql." ' AND FINALIZADO='S' ORDER BY ID DESC";
		$objRS = mysql_query($strSQL, $sig) or die(mysql_error());
	} Else {
		$strSQL 		= "";
		$strSQL 		.= "SELECT * FROM CONTRATOS WHERE ID_CLIENTE='".$id_cliente."' AND FINALIZADO='S' ORDER BY ID DESC";
		$objRS = mysql_query($strSQL, $sig) or die(mysql_error());
	}
	$strSQL2		= "";
	$strSQL2		.= "SELECT * FROM CLIENTES WHERE ID='".$id_cliente."'";
	$objRS2 = mysql_query($strSQL2, $sig) or die(mysql_error());
	$row_objRS2 = mysql_fetch_assoc($objRS2);
	
	if (!$row_objRS = mysql_fetch_assoc($objRS)) {
		?>
		<table>
				<tr>
					<th colspan="2"><center><font face="Times New Roman">Consulta de Contratos</font></center></th>
				</tr>
				
				<tr></tr>
		
				<tr>
					<td id="border" colspan="2">Nenhum registro encontrado com as informações digitadas.</td>
				</tr>
			
				<tr>
					<td id="border" width="25%">CLIENTE:</td>
					<td id="border"><b><?php echo  $row_objRS2['FANTASIA']?>&nbsp;</b></td>
				</tr>
				
				<tr>
					<td id="border" width="25%">PERÍODO:</td>
					<td id="border">de: <b><?php echo $de?></b>&nbsp;&nbsp;&nbsp;até: <b><?php echo $ate?></b></td>
				</tr>
				
				<tr>
					<td colspan="2"><a href="<?php echo $_SESSION['menu_url'] ?>"><b>Clique aqui</b></a> para realizar nova consulta.</td>
				</tr>
		</table>
	<?php } Else { ?>
		<table width="95%">
			<tr>
				<th colspan="4"><center><font face="Times New Roman">Consulta de Contratos</font></center></th>
			</tr>
				
			<tr></tr>
	
			<tr>
				<td id="border" width="10%"><p align="right">Cliente:</td>
				<td id="border"><b><?php echo $row_objRS2['FANTASIA']?></b></td>
				<td id="border" width="10%"><p align="right">CNPJ:</td>
				<td id="border" width="20%"><b><?php echo $row_objRS2['CNPJ']?></b></td>		
			</tr>
			
			<tr>
				<td id="border"><p align="right">Razão Social:</td>
				<td colspan="3" id="border"><b><?php echo $row_objRS2['RAZAO']?></b></td>
			</tr>
		</table>
		
		<table width="95%">
			<tr>
				<td id="border"><center><font face="Times New Roman" color="#000000"><b>CONTRATO</b></font></center></td>
				<td id="border" width="10%"><center><font face="Times New Roman" color="#000000"><b>EMISSÃO</b></font></center></td>
<!-- 				<td id="border" width="10%"><center><font face="Times New Roman" color="#000000"><b>CLIENTE</b></font></center></td> -->
				<td id="border" width="%"><center><font face="Times New Roman" color="#000000"><b>DESCRIÇÃO</b></font></center></td>
				<td id="border" width="10%"><center><font face="Times New Roman" color="#000000"><b>TOTAL</b></font></center></td>
				<td id="border" width="10%"><center><font face="Times New Roman" color="#000000"><b>PAGTO.</b></font></center></td>
				<td id="border" width="10%"><center><font face="Times New Roman" color="#000000"><b>NF</b></font></center></td>
			</tr>
			
			<?php
			do {
				$x += 1;
//				$strSQL 		= "SELECT * FROM CLIENTES WHERE ID = '" . $row_objRS['ID_CLIENTE'] . "'";
//				$objRS3 = mysql_query($strSQL, $sig) or die(mysql_error());
//				$row_objRS3 = mysql_fetch_assoc($objRS3);
			
			?>		
			
				<tr>
					<td id="border"><center><a href="consulta_contrato_visualiza.php?id_contrato=<?php echo $row_objRS['ID'].($delete?"&delete=true":"")?>" title="Visualizar dados do contrato"><b><?php echo $row_objRS['ID']?></b></a></center></td>
					<td id="border"><?php echo formatdate($row_objRS['DATA'])?></td>
<!-- 					<td id="border"><?php echo $row_objRS3['FANTASIA']?></td> -->
					<td id="border"><textarea cols="70" rows="2" readonly="readonly"><?php echo $row_objRS['DESCRICAO']?></textarea></td>
					<td id="border">R$ <?php echo $row_objRS['VALOR_TOTAL']?>&nbsp;</td>
					<td id="border"><?php echo $row_objRS['DATA_PAGTO']?>&nbsp;</td>
					<td id="border"><?php echo $row_objRS['NOTA_FISCAL']?>&nbsp;</td>
				</tr>
	
				<?php
			} while($row_objRS = mysql_fetch_assoc($objRS));
			?>
			
			</tr>
				<tr>
					<td colspan="6"><a href="<?php echo $_SESSION['menu_url'] ?>"><b>Clique aqui</b></a> para nova consulta.</td>
				</tr>
		</table>
		</form>
<?php
}}
?>
</body>
</html> 

<?php //Fechar e eliminar os objetos recordset e de conexao ?>

