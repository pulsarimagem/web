<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php 
$fantasia 	= isset($_GET['fantasia'])?$_GET['fantasia']:"";
$razao	 	= isset($_GET['razao'])?$_GET['razao']:"";
$de			= isset($_GET['de'])?$_GET['de']:"";
$ate		= isset($_GET['ate'])?$_GET['ate']:"";
$redirect 	= $_GET['redirect'];
$title		= $_GET['title'];
$baixa		= isset($_GET['baixa'])?true:false;
$novo		= isset($_GET['novo'])?true:false;
$relatorio 	= isset($_GET['relatorio'])?true:false;

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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $title?> .::SIG - SISTEMA DE INFORMAÇÕES GERENCIAIS PULSAR IMAGENS::.</title>
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
if (!$row_objRS2 = mysql_fetch_assoc($objRS2)) {
	?>
		<table>
			<tr>
				<th colspan="2"><center><font face="Times New Roman"><?php echo $title?></font></center></th>
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
				<th colspan="3"><center><font face="Times New Roman"><?php echo $title?></font></center></th>
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
			if($relatorio) {
				$href = "relatorio_contratos.php?id_cliente=".$row_objRS2['ID']."&amp;de=".$de."&amp;ate=".$ate;
			}
			else {
				$href = "consulta_contrato_busca.php?id_cliente=".$row_objRS2['ID']."&amp;de=".$de."&amp;ate=".$ate;
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
?>		
</body>
</html> 
