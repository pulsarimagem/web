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
	$print_report = "";
	if(count($lista_missing_files) > 0) {
		$print_report .= "<p><strong>".count($lista_missing_files)." arquivos não encontrados:</strong></p>";
		$print_report .= "<ul>";
		foreach($lista_missing_files as $lista_file=>$lista_tombo) {
			$print_report .= "<li>$lista_tombo: $lista_file</li>";
		}
		$print_report .= "</ul>";
	}
	$print_report .= "<p><strong>".count($lista_files)." linhas importadas:</strong></p>";
	$print_report .= "<ul>";
	foreach($lista_files as $lista_file=>$lista_tombo) {
		$print_report .= "<li>$lista_tombo: $lista_file</li>";
	}
	$print_report .=  "</ul>";
//	echo $planilha->dump(true,true);
	echo $print_report;
	
	$debug .= "<br><br> ** Dump ** <br>".utf8_decode(var_export($planilha->toArray(null,true,true,true),true))."<br>";
	
// 	echo $debug;
	
	$fullcc = "lauradml@gmail.com";
	
	$to      = "Laura <laura@pulsarimagens.com.br>,";
	$to      .= "Saulo <saulo@pulsarimagens.com.br>\n";
	$subject = "[Video] ".count($lista_missing_files)+" novos videos indexados via Excel\n";

	$message = '
<html>
	<head>
		<title>:: Pulsar Imagens ::</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<STYLE type=”text/css”>
			.ReadMsgBody
			{ width: 100%;}
			.ExternalClass
			{width: 100%;}
		</STYLE>
	</head>

	<body style="margin: 0; padding: 0; "marginheight="0" topmargin="0" marginwidth="0" leftmargin="0">
		<p> Foi feita uma nova indexação de video via Excel em '.date("d-m-Y H:i:s", strtotime('now')).'</p>
		'.$print_report.'<br>
		'.$debug.'<br>	
	</body>
</html>
';

	$headers = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "From: Pulsar Imagens <pulsarimagensltda@gmail.com>\n";
	$headers .= "bcc: ".$fullcc."\n";
	
	mail($to,$subject,$message,$headers);
	
// 	echo $message;
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
