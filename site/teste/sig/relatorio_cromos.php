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
$codigo = $_GET['codigo'];
$id_cliente	= isset($_GET['id_cliente'])?$_GET['id_cliente']:"";
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
//'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//'''''''''''''''''''''''''''''''BUSCA POR PERÍODO'''''''''''''''''''''''''''
//'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
	$add_query = "";
	if($id_cliente != "") {
		$add_query = "AND B.ID_CLIENTE = $id_cliente";
	}
	$strSQL = "SELECT A.ID, A.ID_CONTRATO, A.CODIGO, A.ASSUNTO, A.AUTOR, A.VALOR, A.DESCONTO, B.ID_CLIENTE, B.DATA, B.DESCRICAO, C.FANTASIA, D.NOME FROM CROMOS A, CONTRATOS B, CLIENTES C, AUTORES_OFC D WHERE A.ID_CONTRATO = B.ID AND B.ID_CLIENTE = C.ID AND A.AUTOR = D.SIGLA AND A.FINALIZADO = 'S' AND B.DATA BETWEEN '" . $de_mysql . "' AND '" . $ate_mysql . "' AND CODIGO LIKE '%" . $codigo . "%' $add_query ORDER BY B.DATA DESC, B.ID";
	$objRs = mysql_query($strSQL, $sig) or die(mysql_error());
	$row_objRs = mysql_fetch_assoc($objRs);
	
	$cliente = "";
	if($id_cliente != "") {
		$cliente = $row_objRs['FANTASIA'];
	}
	
	if (!$row_objRs) {
?>

		<table>
			<tr>
				<th colspan="2"><center><font face="Times New Roman">Relatório de Venda de Cromos</font></center></th>
			</tr>
			
			<tr></tr>
	
			<tr>
				<td id="border" colspan="2">Nenhum registro encontrado com as informações digitadas.</td>
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
				<td id="border" width="25%">Código:</td>
				<td id="border"><b><?php echo $codigo?>&nbsp;</b></td>
			</tr>

			<tr>
				<td colspan="2"><a href="<?php echo $_SESSION['menu_url'] ?>"><b>Clique aqui</b></a> para realizar nova consulta.</td>
			</tr>
		</table>

	<?php } Else { 	?>
	
		<table width="95%">
			<tr>
				<th colspan="4"><center><font face="Times New Roman">Relatório de Venda de Cromos</font></center></th>
			</tr>

			<tr>
				<td colspan="7">
					<center>
						<table>
							<tr><td id="border" colspan="4"><center>Período Solicitado</center></td></tr>
							<tr>
								<td id="border"><p align="right">de:</p></td>
								<td id="border"><b><?php echo  $de ?></b></td>
								<td id="border"><p align="right">até:</p></td>
								<td id="border"><b><?php echo  $ate ?></b></td>		
							</tr>
							
							<tr>
								<td id="border" colspan="2"><p>Cliente:</p></td>
								<td id="border" colspan="2"><b><?php echo $cliente?>&nbsp;</b></td>
							</tr>
							
							
<?php  If ($codigo != "") {?>
							<tr>
								<td id="border" colspan="4" style="color:#000;font-weight:bold;text-align:center;">Código</td>
							</tr>
							<tr>
								<td id="border" colspan="4" style="text-align:center;"><b><?php echo $codigo ?></b></td>
    						</tr>
<?php } ?>					
						</table>
					</center>
				</td>
			</tr>
		</table>
		<table width=95%>
			<tr>
				<td id="border" width="5%"><center><font face="Times New Roman" color="#000000"><b>CONTRATO</b></font></center></td>
				<td id="border" width="5%"><center><font face="Times New Roman" color="#000000"><b>DATA</b></font></center></td>
				<td id="border" width="15%"><center><font face="Times New Roman" color="#000000"><b>CLIENTE</b></font></center></td>
				<td id="border" width="15%"><center><font face="Times New Roman" color="#000000"><b>DESCRIÇÃO</b></font></center></td>
				<td id="border" width="5%"><center><font face="Times New Roman" color="#000000"><b>VALOR FINAL</b></font></center></td>
			</tr>

			<?php 
			do {
				$x += 1;

			?>		
			
				<tr>
					    <td id="border"><center><?php echo $row_objRs['ID_CONTRATO'] ?></center></td>
					    <td id="border"><?php echo formatdate($row_objRs['DATA']) ?></td>
					    <td id="border"><?php echo $row_objRs['FANTASIA']?></td>
					    <td id="border"><?php echo $row_objRs['DESCRICAO']?></td>
					    <td id="border">R$ <?php echo FormatNumber($row_objRs['VALOR'] - $row_objRs['DESCONTO']) ?></td>
				</tr>
			
			<?php
			} while ($row_objRs = mysql_fetch_assoc($objRs));
			?>

<?php if(!$print) { ?>			
			<tr>
				<td colspan="4"> Foram localizados (<b><?php echo $x?></b>) registros com esta consulta. <a href="<?php echo $_SESSION['menu_url'] ?>"><b>Clique aqui</b></a> para realizar nova consulta.</td>
			</tr>
<?php } ?>
			
		</table>
		<center>
		    <form name="form_imp" target="_blank" method="get">
				<input type="hidden" name="de" value="<?php echo  $de ?>"   />
				<input type="hidden" name="ate" value="<?php echo  $ate ?>" />
				<input type="hidden" name="id_cliente" value="<?php echo  $id_cliente ?>" />
				<input type="hidden" name="codigo" value="<?php echo  $codigo ?>" />
<?php if(!$print) { ?>
				<input class="printBtn" value="Imprimir" style="border:1px solid #333;background-color:#FFF;color:#333;font-weight:bold;background-image:url(images/print.png);background-repeat:no-repeat;padding:2px 2px 2px 10px;background-position:left center;" type="button" />
<?php } ?>				
		</center>

<?php
}
?>
</body>
</html> 

