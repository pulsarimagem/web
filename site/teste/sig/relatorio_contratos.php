<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>RELATÓRIOS/CONTRATOS .::SIG - SISTEMA DE INFORMAÇÕES GERENCIAIS PULSAR IMAGENS::.</title>
<link href="atributos/global.css" type="text/css" rel="stylesheet" media="screen" />
<link href="atributos/tablecloth.css" type="text/css" rel="stylesheet" media="screen" />
<LINK href="css/style.css" type=text/css rel=STYLESHEET />
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
<?php include('scripts.php')?>
<?php if(!$print) include("part_top.php")?>
</head>

<body>
<?php 
$de = $_GET['de'];
$ate = $_GET['ate'];
$idcliente = $_GET['id_cliente'];
$simples = isset($_GET['simples'])?true:false;

//formatando a data para consulta no banco mysql


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
} else {
	$strSQL 		= "SELECT * FROM CONTRATOS WHERE FINALIZADO='S' $query_cliente $query_data ORDER BY ID DESC";
}
	$objRs = mysql_query($strSQL, $sig) or die(mysql_error());
	$row_objRs = mysql_fetch_assoc($objRs);
	
	
	if (!$row_objRs) {
?>

		<table>
			<tr>
				<th colspan="2"><center><font face="Times New Roman">Relatório de Contratos</font></center></th>
			</tr>
			
			<tr></tr>
	
			<tr>
				<td id="border" colspan="2">Nenhum registro encontrado com as informações digitadas.</td>
			</tr>
		
			<tr>
				<td id="border" width="25%">Nome Fantasia:</td>
				<td id="border"><b><?php echo  $fantasia ?>&nbsp;</b></td>
			</tr>

			<tr>
				<td id="border" width="25%">de:</td>
				<td id="border"><b><?php echo  $de ?>&nbsp;</b></td>
			</tr>

			<tr>
				<td id="border" width="25%">até:</td>
				<td id="border"><b><?php echo  $ate ?>&nbsp;</b></td>
			</tr>
			
			<tr>
				<td colspan="2"><a href="<?php echo $_SESSION['menu_url'] ?>"><b>Clique aqui</b></a> para realizar nova consulta.</td>
			</tr>
		</table>

	<?php } Else { 	?>
	
		<table width="95%">
			<tr>
				<th colspan="4"><center><font face="Times New Roman">Relatório de Contratos</font></center></th>
			</tr>
<?php 
if($idcliente != ""){
	$strSQL 		= "SELECT * FROM CLIENTES WHERE ID = '" . $idcliente . "'";
	$objRs2 = mysql_query($strSQL, $sig) or die(mysql_error());
	$row_objRs2 = mysql_fetch_assoc($objRs2);
?>			
		<tr>
			<td id="border" width="10%"><p align="right">Cliente:</td>
			<td id="border"><b><?php echo $row_objRs2["FANTASIA"]?></b></td>
			<td id="border" width="10%"><p align="right">CNPJ:</td>
			<td id="border" width="20%"><b><?php echo $row_objRs2["CNPJ"]?></b></td>		
		</tr>
		
		<tr>
			<td id="border"><p align="right">Razão Social:</td>
			<td colspan="3" id="border"><b><?php echo $row_objRs2["RAZAO"]?></b></td>
		</tr>
<?php }?>		
			<tr>
				<td colspan="7">
					<center>
						<table>
							<tr><td id="border" colspan="4"><center>Período Solicitado</center></td></tr>
							<tr>
								<td id="border"><p align="right">de:</td>
								<td id="border"><b><?php echo  $de ?></b></td>
								<td id="border"><p align="right">até:</td>
								<td id="border"><b><?php echo  $ate ?></b></td>		
							</tr>
						</table>
					</center/>
				</td>
			</tr>
		</table>
		<table width=95%>
			<tr>
				<td id="border" width="10%"><center><font face="Times New Roman" color="#000000"><b>CONTRATO</b></font></center></td>
				<td id="border" width="10%"><center><font face="Times New Roman" color="#000000"><b>EMISSÃO</b></font></center></td>
<?php if (!$simples) {?>					
<?php 	if ($idcliente=="") { ?>
				<td id="border" width="10%"><center><font face="Times New Roman" color="#000000"><b>CLIENTE</b></font></center></td>
<?php 	} ?>
				<td id="border" width="%"><center><font face="Times New Roman" color="#000000"><b>DESCRIÇÃO</b></font></center></td>
				<td id="border" width="10%"><center><font face="Times New Roman" color="#000000"><b>TOTAL</b></font></center></td>
				<td id="border" width="10%"><center><font face="Times New Roman" color="#000000"><b>PAGTO.</b></font></center></td>
				<td id="border" width="10%"><center><font face="Times New Roman" color="#000000"><b>NF</b></font></center></td>
<?php } else { ?>
				<td id="border" width="10%"><center><font face="Times New Roman" color="#000000"><b>No. FOTOS</b></font></center></td>
				<td id="border" width="10%"><center><font face="Times New Roman" color="#000000"><b>TOTAL</b></font></center></td>
<?php }?>
			</tr>

			<?php 
			do {
				$x += 1;

				$strSQL 		= "SELECT * FROM CLIENTES WHERE ID = '" . $row_objRs["ID_CLIENTE"] . "'";
				$objRs3 = mysql_query($strSQL, $sig) or die(mysql_error());
				$row_objRs3 = mysql_fetch_assoc($objRs3);
			?>		
			
				<tr>
					<input type="hidden" name="id_contrato" value="<?php echo $row_objRs["ID"]?>" />
					<td id="border"><center><a href="consulta_contrato_visualiza.php?id_contrato=<?php echo $row_objRs["ID"]?>" title="Visualizar dados do contrato"><b><?php echo $row_objRs["ID"]?></b></a></center></td>
					<td id="border"><?php echo formatdate($row_objRs["DATA"])?></td>
<?php if (!$simples) {?>					
<?php 	if ($idcliente=="") { ?>
					<?php if ( $row_objRs3) { ?>
						<td id="border"><?php echo  $row_objRs3["FANTASIA"] ?></td>
					<?php } Else { ?>
						<td id="border">&nbsp;</td>
					<?php } ?>
<?php 	} ?>					
					<td id="border"><?php echo $row_objRs["DESCRICAO"]?></td>
					<td id="border">R$ <?php echo  $row_objRs["VALOR_TOTAL"] ?></td>
					<td id="border"><?php echo  $row_objRs["DATA_PAGTO"] ?>&nbsp;</td>
					<td id="border"><?php echo  $row_objRs["NOTA_FISCAL"] ?>&nbsp;</td>
<?php } else {?>
					<td id="border"><?php echo  $row_objRs["num_fotos"] ?></td>
					<td id="border">R$ <?php echo  $row_objRs["VALOR_TOTAL"] ?></td>
<?php }?>			
				</tr>
			
			<?php
				$total += fixnumber($row_objRs["VALOR_TOTAL"]);
				if($simples) $total_fotos += $row_objRs["num_fotos"];
			} while ($row_objRs = mysql_fetch_assoc($objRs));
			?>
			
			<tr>
				<td colspan="<?php echo ($simples?"2":"4")?>"> 
<?php if(!$print) { ?>					Foram localizados (<b><?php echo $x?></b>) registros com esta consulta. <a href="<?php echo $_SESSION['menu_url'] ?>"><b>Clique aqui</b></a> para realizar nova consulta. <?php } ?>
				</td>
<?php if($simples)	{ ?>			<td id="border"><?php echo  $total_fotos ?> fotos</td> <?php }?>
				<td id="border">R$ <?php echo  FormatNumber($total) ?></td>
			</tr>
			
		</table>
		<center>
		    <form name="form_imp" action="relatorio-venda-imp.asp" target="_blank" method="get">
				<input type="hidden" name="de" value="<?php echo  $de ?>"   />
				<input type="hidden" name="ate" value="<?php echo  $ate ?>" />
<?php if(!$print) { ?>
				<input class="printBtn" value="Imprimir" style="border:1px solid #333;background-color:#FFF;color:#333;font-weight:bold;background-image:url(images/print.png);background-repeat:no-repeat;padding:2px 2px 2px 10px;background-position:left center;" type="button" />
<?php } ?>				
		</center>

	<?php
	}
	//'Fechando o objeto Record Set
	//'Eliminando o objeto Record Set
?>
</body>
</html> 

