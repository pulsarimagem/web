<?php require_once('Connections/pulsar.php'); ?>
<?php 
/*
$sql_create = "CREATE TABLE `pedidos` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`id_cadastro` int(20) unsigned NOT NULL,
`valor` decimal(12,2) unsigned NOT NULL DEFAULT 0,
`id_transacao` varchar(40),		
`status` int(1) NOT NULL DEFAULT 1,		
`creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
KEY `id` (`id`)
)";
if(!mysql_num_rows( mysql_query("SHOW TABLES LIKE 'pedidos'")))
{
	mysql_query($sql_create, $pulsar) or die(mysql_error());
}
$sql_create = "CREATE TABLE `itens_pedido` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`id_pedido` int(11) unsigned NOT NULL,
`codigo` varchar(15) NOT NULL,
`status` int(1) NOT NULL DEFAULT 1,		
`creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
KEY `id` (`id`)
)";
if(!mysql_num_rows( mysql_query("SHOW TABLES LIKE 'itens_pedido'")))
{
	mysql_query($sql_create, $pulsar) or die(mysql_error());
}
*/
$isOk = false;
$pedido = isset($_GET['pedido'])?$_GET['pedido']:"";

if(isset($_GET['check'])){
	switch($_GET['check']){
		case 'true':
			$say = "Transação concluída com sucesso. Um email será enviado para a sua conta com o link para download. Pedido número $pedido.";
			$isOk = true;
			break;
		case 'false':
			$say = 'Transação pendente de pagamento.';
			break;
		case 'cancel':
			$say = 'Transação cancelada cancelada.';
			break;
		case 'check':
			$say = 'Sua transação foi concluída.';
			break;
	}
}

if($isOk) {
	$pedido = $_GET['pedido'];
	$nome = $row_top_login['nome'];
	$linkDownload = "pedido_download_page.php?pedido=$pedido";
	
	$fullcc = "lauradml@gmail.com";
	if($lingua!="br") {
		$fullcc .= ", saulo@pulsarimagens.com.br, icaro@pulsarimagens.com.br";
	}
	$to      = $row_top_login['email'];
	
	$subject = ECOMMERCE_EMAIL_SUBJECT." $pedido";
	$headers = "Content-Type: text/html; charset=iso-8859-15\n";
	$headers .= "From: ".ECOMMERCE_EMAIL_SENDER."\n";
	$headers .= "bcc: ".$fullcc."\n";
	include("email_lr.php");
	mail($to,$subject,$message,$headers);
}

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
<?php include("../tool_tooltip.php")?>

<?php include("part_topbar.php");?>

<div class="main size960">
	<div class="grid-center">
		<div class="cadastro">
			<p class="p" align="center">
                <strong><?php echo $say;?></strong> 
        	</p>
		</div>
	</div>
</div>
<div class="clear"></div>


<?php include("part_footer.php");?>

<?php //include("google_details.php");?>

</body>
</html>
<?php
if($siteDebug) {
	$timeEnd = microtime(true);
	$diff = $timeEnd - $timeStart;
	echo "<strong>delay Total: </strong>".$diff."</strong><br>";
}
