<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Pulsar Imagens - Menu Principal</title>
<link href="css.css" rel="stylesheet" type="text/css" />
</head>

<body id="menuprincipal">
<div class="main">
<?php include("part_header.php");?> 
	<div class="colA">
    	<h2>Menu Principal</h2>
        <div class="menu">
        	<div class="col">
            	<ul>
                	<li><a href="adm_index.php">1. Indexação</a></li>
                	<li><a href="adm_video_index_inc.php">2. Indexação de Videos</a></li>
                    <li><a href="consulta_comissoes.php">3. Relatório de Comissões</a></li>
	                <li><a href="adm_import_xls.php">4. Importar Excel</a></li>
                    <li><a href="alterar_senha.php">5. Alterar Senha</a></li> 
                    <li><a href="../colaborador/">6. Logout</a></li> 
    	        </ul>
            </div>
          
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php include("part_footer.php");?>
</body>
</html>
