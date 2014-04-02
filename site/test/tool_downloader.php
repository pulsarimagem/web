<?php require_once('Connections/pulsar.php'); ?>
<?php
	mysql_select_db($database_pulsar, $pulsar);
	$query_tombos = "SELECT tombo FROM Fotos WHERE tombo = '".$_GET['tombo']."'";
	$tombos = mysql_query($query_tombos, $pulsar) or die(mysql_error());
	$row_tombos = mysql_fetch_assoc($tombos);
	
	$file = $row_tombos['tombo'].".jpg";
	
	Header( "Content-type: image"); 
	header("Content-Disposition: attachment; filename=\"$file\""); 
	readfile($homeurl."bancoImagens/".$file);
?>