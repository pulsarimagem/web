<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php 
	$luis = isset($_GET['luis'])?true:false;

	$query_sigla_autor = ("SELECT trim(NOME) as NOME, SIGLA FROM AUTORES_OFC ORDER BY trim(NOME) ASC");
	$sigla_autor = mysql_query($query_sigla_autor, $sig) or die(mysql_error());
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
            <h2>Relatório de Comissões</h2>
            <form name="form1" method="get" action="relatorio_comissoes.php">
				<ul>
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
	            	<li>
	                	<label>Só contratos Luis: </label>
	                	<input name="luis" type="checkbox" value="true" />
	                	<div class="clear"></div>
	                </li>
	                
	                </ul>
<?php if($luis) {?>
	            <input name="luis" type="hidden" value="true" />
<?php }?>	                
	            <input name="action" type="submit" id="button" value="Ok" style="float: left;" />
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
