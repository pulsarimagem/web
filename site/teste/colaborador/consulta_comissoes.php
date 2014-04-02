<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Pulsar Imagens - Administração de Usuários</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php")?>
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
	                    <input name="de" type="text" class="calendar"/><i style="margin-left: 10px; font-size: 10px; color:#CCCCCC">dd/mm/aaaa</i>
		                <div class="clear"></div>
	                </li>
	            	<li>
	                	<label>Período Final: </label>
	                    <input name="ate" type="text" class="calendar"/><i style="margin-left: 10px; font-size: 10px; color:#CCCCCC">dd/mm/aaaa</i>
		                <div class="clear"></div>
	                </li>
	            </ul>
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
