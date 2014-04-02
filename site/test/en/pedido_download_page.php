<?php require_once('Connections/pulsar.php'); ?>
<?php require_once('Connections/sig.php'); ?>
<?php include("../tool_auth.php");?>
<?php 
include("../tool_pedido_download_page.php");
if(!$download_ok) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Images</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
</head>
<body>

<?php include("part_topbar.php")?>

<div class="main size960">

<?php //include("part_grid_left.php")?>

	<div class="grid-center">
		<div class="details">
			<a href="<?php echo $_SESSION['last_detail'];?>" class="voltar">« Voltar</a><br /><br />
<?php if(!isset($error_msg)) { ?>
<script>
jQuery(document).ready(function() {
	$('#download_form').submit();
});
</script>	
			<div class="tipo-de-download">
<?php if($contrato=="V") {?>			
				<form name="form1" id="download_form" method="get" action="<?php echo $cloud_server?>download_videos.php">
<?php } else if($contrato=="F") {?>			
				<form name="form1" id="download_form" method="post" action="pedido_download_page.php">
<?php } ?>
					<div class="form">
	                    <h2>Download</h2>	                    
	                    <div>O seu download irá iniciar automaticamente em alguns segundos. Caso não inicie <input name="action" type="submit" value="clique aqui"/></div>
 						
	                    <div class="bts">
	                        <input name="action" type="hidden" value="Aceito" class="button" />
	                        <a href="<?php echo $_SESSION['last_detail'];?>">Voltar</a>
	                        <div class="clear"></div>
	                        <input name="pedido" type="hidden" value="<?php echo $pedido;?>"/>
							<input name="u" type="hidden" value="<?php echo $row_top_login['login']; ?>"/>
							<input name="p" type="hidden" value="<?php echo $row_top_login['senha']; ?>"/>
							<input name="c" type="hidden" value="<?php echo $name; ?>"/>
	                    </div>
	            	</div>
	            </form>
	        </div>
<?php } ?>
			<p><?php echo $error_msg?></p>
		</div>
	</div>
	<div class="clear"></div>
</div>

<?php include("part_footer.php")?>

</body>
</html>
</body>
</html>
<?php 
} 
?>