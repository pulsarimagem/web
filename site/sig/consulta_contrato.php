<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php 
	$query_sigla_autor = ("SELECT trim(NOME) as NOME, SIGLA FROM AUTORES_OFC ORDER BY trim(NOME) ASC");
	$sigla_autor = mysql_query($query_sigla_autor, $sig) or die(mysql_error());
	
	$baixa	= isset($_GET['baixa'])?true:false;
	$novo = isset($_GET['novo'])?true:false;
	$relatorio = isset($_GET['relatorio'])?true:false;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Pulsar Imagens - Administração de Usuários</title>
<link href="css.css" rel="stylesheet" type="text/css" />
</head>

<body id="cadastro_usuarios">
<div class="main">
<?php include("part_header.php");?> 
    <div class="colA">
        <div class="usuarios">
<?php if($baixa) {?>
            <h2>Baixa de Contratos</h2>
			<form name="form1" method="get" action="consulta_contrato_baixa.php"><!-- "consulta_contrato_visualiza.php"> -->
<?php } else if($relatorio) { ?>
            <h2>Relatório de Contratos</h2>
			<form name="form1" method="get" action="consulta_contrato_busca.php"><!-- "consulta_contrato_visualiza.php"> -->
<?php } else if($novo) { ?>
            <h2>Criação de Contratos</h2>
			<form name="form1" method="get" action="consulta_contrato_busca.php"><!-- "consulta_contrato_visualiza.php"> -->
<?php } else { ?>
            <h2>Consulta de Contratos</h2>
			<form name="form1" method="get" action="consulta_contrato_busca.php"><!-- "consulta_contrato_visualiza.php"> -->
<?php }?>            
				<ul>
<?php if(!$novo && !$relatorio) {?>
					<li>
	                	<label>Contrato: </label>
	                    <input name="id_contrato" type="text" />
		                <div class="clear"></div>
	                </li>
<?php } ?>	                
 	            	<li>
	                	<label>Nome Fantasia (ou parte dele): </label>
	                    <input name="fantasia" type="text" />
		                <div class="clear"></div>
	                </li>
<?php if($novo) {?>
 	            	<li>
	                	<label>Razão Social (ou parte dele): </label>
	                    <input name="razao" type="text" />
		                <div class="clear"></div>
	                </li>
<?php }?>	                
<?php if(!$novo) {?>
	                <li>
	                	<label>Período Inicial: </label>
	                    <input name="de" type="text" /><i style="margin-left: 10px; font-size: 10px; color:#CCCCCC">dd/mm/aaaa</i>
		                <div class="clear"></div>
	                </li>
	            	<li>
	                	<label>Período Final: </label>
	                    <input name="ate" type="text"/><i style="margin-left: 10px; font-size: 10px; color:#CCCCCC">dd/mm/aaaa</i>
		                <div class="clear"></div>
	                </li>
<?php } ?>	                
				</ul>
<?php if($baixa) {?>
	            <input name="baixa" type="hidden" value="true" />
<?php } else if($novo) {?>
	            <input name="novo" type="hidden" value="true" />
<?php } else if($relatorio) {?>
	            <input name="relatorio" type="hidden" value="true" />
<?php } ?>
	            <input name="action" type="submit" id="button" value="Consultar >>" style="float: left;" />
	        </form>
            <div class="clear"></div>
        </div>
    </div>
    <div class="colB">
<?php include("part_sidemenu.php");?>
    </div>
    <div class="clear"></div>
</div>
</body>
</html>
