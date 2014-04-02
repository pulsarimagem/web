<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php 
	$query_sigla_autor = ("SELECT trim(NOME) as NOME, SIGLA FROM AUTORES_OFC ORDER BY trim(NOME) ASC");
	$sigla_autor = mysql_query($query_sigla_autor, $sig) or die(mysql_error());

	$query_empresas = sprintf("SELECT ID, RAZAO, FANTASIA FROM CLIENTES ORDER BY RAZAO");
	$empresas = mysql_query($query_empresas, $sig) or die(mysql_error());
	$totalRows_empresas = mysql_num_rows($empresas);	
	
	$baixa	= isset($_GET['baixa'])?true:false;
	$novo = isset($_GET['novo'])?true:false;
	$btnNovo = isset($_GET['btnNovo'])?true:false;
	$delete = isset($_GET['delete'])?true:false;
	$cromos = isset($_GET['cromos'])?true:false;
	$relatorio = isset($_GET['relatorio'])?true:false;
	$cliente = isset($_GET['cliente'])?true:false;
	
	$title		= $_GET['title'];
	$redirect = $_GET['redirect'];

	$has_autor = isset($_GET['has_autor'])?true:false;
	$has_sigla = isset($_GET['has_sigla'])?true:false;
	$has_contrato = isset($_GET['has_contrato'])?true:false;
	$has_codigo = isset($_GET['has_codigo'])?true:false;
	$has_autores = isset($_GET['has_autores'])?true:false;
	$has_fantasia = isset($_GET['has_fantasia'])?true:false;
	$has_razao = isset($_GET['has_razao'])?true:false;
	$has_combobox = isset($_GET['has_combobox'])?true:false;	
	$has_deate = isset($_GET['has_deate'])?true:false;
	$has_luis = isset($_GET['has_luis'])?true:false;
	$has_lote = isset($_GET['has_lote'])?true:false;
	$has_simples = isset($_GET['has_simples'])?true:false;
	$has_copy = isset($_GET['has_simples'])?true:false;
	
	$_SESSION['menu_url'] = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Pulsar Imagens - Administração de Usuários</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<?php include('scripts.php')?>
</head>

<body id="cadastro_usuarios">
<div class="main">
<?php include("part_header.php");?> 
    <div class="colA">
        <div class="usuarios">
            <h2><?php echo $title?></h2>
<?php if($baixa) {?>
			<form name="form1" method="get" action="consulta_contrato_baixa.php"><!-- "consulta_contrato_visualiza.php"> -->
<?php } else if($relatorio) { ?>
			<form name="form1" method="get" action="consulta_contrato_busca.php"><!-- "consulta_contrato_visualiza.php"> -->
<?php } else if($novo) { ?>
			<form name="form1" method="get" action="consulta_contrato_busca.php"><!-- "consulta_contrato_visualiza.php"> -->
<?php } else { ?>
			<form name="form1" method="get" action="<?php echo $redirect?>">
<?php }?>            
				<ul>
<?php if($has_contrato) {?>
					<li>
	                	<label>Contrato: </label>
	                    <input name="id_contrato" type="text" />
		                <div class="clear"></div>
	                </li>
<?php } ?>	          
<?php if($has_fantasia) {?>
 	            	<li>
	                	<label>Nome Fantasia (ou parte dele): </label>
	                    <input name="fantasia" type="text" />
		                <div class="clear"></div>
	                </li>
<?php } ?>	          
<?php if($has_razao) {?>
	               	<li>
	                	<label>Razão Social (ou parte dele): </label>
	                    <input name="razao" type="text" />
		                <div class="clear"></div>
	                </li>
<?php }?>	         
<?php if($has_combobox) {?>
	               	<li>
	                	<label>Cliente: </label>
	                    <select name="id_cliente" id="combobox">
							<option></option>
<?php 	while($row_empresas = mysql_fetch_assoc($empresas)) { ?>
							<option value="<?php echo $row_empresas['ID']?>"><?php echo $row_empresas['RAZAO']." / ".$row_empresas['FANTASIA']?></option>
<?php 	} ?>
						</select>
		                <div class="clear"></div>
	                </li>
<?php }?>	         
<?php if($has_deate) {?>
	                <li>
	                	<label>Período Inicial: </label>
	                    <input name="de" type="text" class="calendar"/><i style="margin-left: 10px; font-size: 10px; color:#CCCCCC">dd/mm/aaaa</i>
		                <div class="clear"></div>
	                </li>
	            	<li>
	                	<label>Período Final: </label>
	                    <input name="ate" type="text" class="calendar"/><i style="margin-left: 10px; font-size: 10px; color:#CCCCCC">dd/mm/aaaa</i>
		                <div class="clear"></div>
	                </li>
<?php } ?>
<?php if($has_codigo) {?>
					<li>
	                	<label>Código: </label>
	                    <input name="codigo" type="text" />
		                <div class="clear"></div>
	                </li>
<?php } ?>	          
<?php if($has_autores) {?>
<li>
	                	<label>Autor: </label>
	                    <select name="sigla_autor">
	                    	<option value="TODOS">-- Todos os Autores --</option>
<?php while ($row_sigla_autor = mysql_fetch_assoc($sigla_autor)) { ?>
							<option value="<?php echo $row_sigla_autor['SIGLA'];?>"><?php echo $row_sigla_autor['NOME']?></option>
<?php }?>
						</select>	                    
		                <div class="clear"></div>
	                </li>
<?php }?>
<?php if($has_autor) {?>
					<li>
	                	<label>Nome Autor: </label>
	                    <input name="autor" type="text" />
		                <div class="clear"></div>
	                </li>
<?php }?>
<?php if($has_sigla) {?>
					<li>
	                	<label>Sigla: </label>
	                    <input name="sigla" type="text" />
		                <div class="clear"></div>
	                </li>
<?php }?>
<?php if($has_luis) {?>
					<li>
	                	<label>Só contratos Luis: </label>
	                	<input name="luis" type="checkbox" value="true" <?php if(isset($_GET['luis'])) echo "checked"?>/>
	                	<div class="clear"></div>
	                </li>
<?php } ?>
<?php if($has_lote) {?>
<li>
	                	<label>Baixa Lote: </label>
	                	<input name="lote" type="checkbox" value="true" <?php if(isset($_GET['lote'])) echo "checked"?>/>
	                	<div class="clear"></div>
	                </li>
<?php } ?>
<?php if($has_simples) {?>
<li>
	                	<label>Simplificado: </label>
	                	<input name="simples" type="checkbox" value="true" <?php if(isset($_GET['simples'])) echo "checked"?>/>
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
<?php } else if($delete) {?>
	            <input name="delete" type="hidden" value="true" />
<?php } else if($cromos) {?>
	            <input name="cromos" type="hidden" value="true" />
<?php } else if($cliente) {?>
	            <input name="cliente" type="hidden" value="true" />
<?php } ?>
				<input name="action" type="submit" id="button" value="Consultar >>" style="float: left;" />
<?php if($novo) {?>
				<input name="copy" type="button" id="button" class="copyBtn" value="Copiar Ultimo >>" style="float: left;" />
<?php } ?>
<?php if($btnNovo) {?>
				<input name="novo" type="submit" id="button" class="copyBtn" value="Criar Novo >>" style="float: left;" />
<?php } ?>

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
