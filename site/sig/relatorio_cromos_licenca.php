<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.::SIG - SISTEMA DE INFORMAÇÕES GERENCIAIS PULSAR IMAGENS::.</title>
<link href="atributos/global.css" type="text/css" rel="stylesheet" media="screen" />
<link href="atributos/tablecloth.css" type="text/css" rel="stylesheet" media="screen" />
<LINK href="css/style.css" type=text/css rel=STYLESHEET />
<?php
/*
Function StrData(Str) {
  Dim Ano, Mes
  Ano = Mid(Str, 1, 4)
  Mes = Mid(Str, 5, 2)
  If IsDate(Mes & "/" & Ano) = True Then
     StrData = Mes & "/" & Ano
  End If
}
*/
?>
<style>
#border{
	border-style:solid;
	border-width:thin;
	border-color:#999999;
	padding:5px 5px 5px 5px;
	font-family:Georgia, Times New Roman, Times, serif
	}
</style>
<?php include('scripts.php')?>
<?php if(!$print) include("part_top.php")?>
</head>
<body>
<?php
	$codigo 	= $_GET["codigo"];
	$sql     	= "SELECT * FROM CLIENTES A, CONTRATOS B, CROMOS C WHERE A.ID = B.ID_CLIENTE AND C.ID_CONTRATO = B.ID AND C.CODIGO = '$codigo' AND C.FINALIZADO = 'S' ORDER BY C.ID_CONTRATO DESC"; 
	$objRs = mysql_query($sql, $sig) or die(mysql_error());
	$objTotal = mysql_num_rows($objRs);

if ($objTotal == 0) {
?>
<table>
	<tr>
		<th colspan="2"><center><font face="Times New Roman">Consulta de cromos vendidos</font></center></th>
	</tr>
	<tr></tr>
	<tr>
		<td id="border" colspan="2">Nenhum registro encontrado com as informações digitadas</td>
	</tr>
	<tr>
		<td id="border" width="15%">Código:</td>
		<td id="border"><b>&nbsp;<?php echo $codigo?></b></td>
	</tr>
	<tr>
		<td colspan="2"><a href="<?php echo $_SESSION['menu_url']?>"><b>Clique aqui</b></a> para realizar nova consulta</td>
	</tr>
</table>
<?php } else { ?>
<table width="90%">
	<tr>
		<th colspan="6"><center><font face="Times New Roman"><b>Consulta de cromos vendidos</b></font></center></th>
	</tr>
	
	<tr></tr>
	<tr>
		<td id="border" width="10%"><center><font face="Times New Roman" color="#000000"><b>CONTRATO</b></font></center></td>
		<td id="border" width="10%"><center><font face="Times New Roman" color="#000000"><b>EMISSÃO</b></font></center></td>
		<td id="border"><center><font face="Times New Roman" color="#000000"><b>CLIENTE</b></font></center></td>
		<td id="border" width="50%"><center><font face="Times New Roman" color="#000000"><b>DESCRIÇÃO</b></font></center></td>
	</tr>
<?php WHILE ($row_objRs = mysql_fetch_assoc($objRs)) { ?>
	<tr>
		<td id="border"><center><a href="consulta_contrato_visualiza.php?id_contrato=<?php echo $row_objRs["ID_CONTRATO"]?>" title="Visualizar Contrato"><b><?php echo $row_objRs["ID_CONTRATO"]?></b></a></center></td>
		<td id="border"><center><?php echo $row_objRs["DATA"]?></center>&nbsp;</td>
		<td id="border"><?php echo $row_objRs["FANTASIA"]?>&nbsp;</td>
		<td id="border"><center><textarea cols="60" rows="2" readonly="readonly"><?php echo $row_objRs["DESCRICAO"]?></textarea></center></td>
	</tr>
<?php } ?>
	<tr>
		<td colspan="4">Foram localizados <b><?php echo $objTotal?></b> registros com esta consulta. <a href="<?php echo $_SESSION['menu_url']?>"><b>Clique aqui</b></a> para realizar nova consulta.</td>
	</tr>	
</table>
<?php } ?>
</body>
</html>
<?php
//'fechar e eliminar todos os objetos record set e os objetos de conexão
?>
