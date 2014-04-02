<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php
$isNovo = isset($_GET['novo'])?true:false;
if($isNovo) {
	header("location: edita_autor.php?mens&novo=true");
}
else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AUTORES/CONSULTA .::SIG - SISTEMA DE INFORMAÇÕES GERENCIAIS PULSAR IMAGENS::.</title>
<link href="atributos/global.css" type="text/css" rel="stylesheet" media="screen" />
<link href="atributos/tablecloth.css" type="text/css" rel="stylesheet" media="screen" />
<LINK href="css/style.css" type=text/css rel=STYLESHEET />
<?php include("scripts.php"); ?>
<?php include("part_top.php")?>
</head>
<body>
<?php 
	//'requisitando parâmetros enviados pelo form via método get
	$autor = $_GET["autor"];
	$sigla = $_GET["sigla"];
	//'realizando a consulta no banco
	If($autor != "" && $sigla == "") {
		$sql = "SELECT ID,NOME,SIGLA,TELEFONE,CELULAR,EMAIL FROM AUTORES_OFC WHERE CONVERT(NOME USING UTF8) LIKE('%". $autor. "%') AND STATUS = 'A' ORDER BY NOME";
	}
	Else if ($autor == "" && $sigla != "") {
		$sql = "SELECT ID,NOME,SIGLA,TELEFONE,CELULAR,EMAIL FROM AUTORES_OFC WHERE CONVERT(SIGLA USING UTF8) LIKE('%" .$sigla. "%') AND STATUS = 'A' ORDER BY NOME";
	}
	Else if ($autor == "" && $sigla == "") {	
		$sql = "SELECT ID,NOME,SIGLA,TELEFONE,CELULAR,EMAIL FROM AUTORES_OFC WHERE STATUS = 'A' ORDER BY NOME";
	}	
		
	$objRS	= mysql_query($sql, $sig) or die(mysql_error());
	$totalRS = mysql_num_rows($objRS)
?>
<?php
//'visualizando retorno da consulta
	If ($totalRS == 0) {
?>
<table>
	<tr><th colspan="2"><center><font face="Times New Roman">Consulta de autores</font></center></th></tr>
	<tr></tr>
	<tr><td id="border" colspan="2">Nenhum registro encontrado com as informações digitadas</td></tr>
	<tr><td id="border" width="15%">Autor:</td><td id="border"><b>&nbsp;<?php echo $autor?></b></td></tr>
	<tr><td id="border" width="15%">Sigla:</td><td id="border"><b>&nbsp;<?php echo $sigla?></b></td></tr>
	<tr><td colspan="2"><a href="<?php echo $_SESSION['menu_url']?>"><b>Clique aqui</b></a> para realizar nova consulta</td></tr>
</table>
<?php } Else { ?>
<table width="90%">
	<tr><th colspan="7"><center><font face="Times New Roman">Consulta de autores</font></center>
	<tr><td colspan="7">Foram localizados <b><?php echo $totalRS?></b> registros com esta consulta. <a href="<?php echo $_SESSION['menu_url']?>"><b>Clique aqui</b></a> para realizar nova consulta</td></tr>
	<tr>
		<td id="border"><center><font face="Times New Roman" color="#000000"><b>SIGLA</b></font></center></td>
		<td id="border"><center><font face="Times New Roman" color="#000000"><b>NOME</b></font></center></td>
		<td id="border"><center><font face="Times New Roman" color="#000000"><b>E-MAIL</b></font></center></td>
		<td id="border"><center><font face="Times New Roman" color="#000000"><b>CELULAR</b></font></center></td>
<!--  <td id="border" colspan="3"><center><font face="Times New Roman" color="#000000"><b>AÇÕES</b></font></center></td>-->		
	</tr>
	<?php
	while ($row = mysql_fetch_array($objRS)) {
	?>
		<tr>
			<td id="border"><center><b><?php echo $row["SIGLA"]?></b></center></td>
			<td id="border"><b><a href="edita_autor.php?mens=&id=<?php echo $row["ID"]?>"><?php echo $row["NOME"]?></a></b></td>
			<td id="border"><a href="mailto:<?php echo $row["EMAIL"]?>"><?php echo $row["EMAIL"]?></a>&nbsp;</td>
			<td id="border"><?php echo $row["CELULAR"]?>&nbsp;</td>
<!-- 			<td id="border"><center><a href="visualiza_autor.asp?id=<?php echo $row["ID"]?>"><img src="images/form.gif" border="0"  alt="Visualizar" /></a></center></td>
			<td id="border"><center><a href="edita_autor.asp?id=<?php echo $row["ID"]?>"><img src="images/edit.gif" border="0" alt="Editar" /></a></center></td>
			<td id="border"><center><a href="exclui_autor.asp?id=<?php echo $row["ID"]?>"><img src="images/del.gif" border="0"  alt="Excluir" /></a></center></td>-->
		</tr>
	<?php
	}
	?>
	<tr><td colspan="7">Foram localizados <b><?php echo $totalRS ?></b> registros com esta consulta. <a href="<?php echo $_SESSION['menu_url']?>"><b>Clique aqui</b></a> para realizar nova consulta</td></tr>
</table>
<?php }
} ?>
</body>
</html>