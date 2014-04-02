<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_adm_import_xls.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Pulsar Imagens - Indexação</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
</head>

<body id="indexacao">
<div class="main">
<?php include("part_header.php");?>
    <div class="colA">
    	<h2>Indexação</h2>
        <div class="tombo">
        	<form method="post" name="form0" enctype="multipart/form-data">
	        	<label>Importar Excel:</label>
	            <input name="excel" type="file" />
	            <input name="Submit" type="submit" id="button" value="Importar" class="button" />
	            <div class="clear"></div>
			</form>
        </div>
<?php 
if($load_file) {
	if(count($lista_missing_files) > 0) {
		echo "<p><strong>".count($lista_missing_files)." arquivos nao encontrados:</strong></p>";
		echo "<ul>";
		foreach($lista_missing_files as $lista_file=>$lista_tombo) {
			echo "<li>$lista_tombo: $lista_file</li>";
		}
		echo "</ul>";
	}
	echo "<p><strong>".count($lista_files)." linhas importadas:</strong></p>";
	echo "<ul>";
	foreach($lista_files as $lista_file=>$lista_tombo) {
		echo "<li>$lista_tombo: $lista_file</li>";
	}
	echo "</ul>";
//	echo $planilha->dump(true,true);
}
?>
				<div class="clear"></div>
       			<br />
	        	<ul>
	        	  Para baixar o arquivo de identifica&ccedil;&atilde;o da Pulsar, <a href="identificaVideo.xls"> clique aqui </a>
	        	</ul>
	            
	            <div class="clear"></div>
    </div>
    
    <div class="colB">
<?php include("part_sidemenu.php");?>
    </div>
    <div class="clear"></div>
</div>
<?php include("part_footer.php");?>
</body>
</html>
